<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Partida;
use App\Time;
use App\UserTime;
use App\Temporada;
use App\Gol;
use App\Cartao;
use App\Lesao;
use App\Financeiro;
use App\Jogador;
use App\Artilheiro;
use App\Amistoso;
use Log;
use DB;
use Auth;
use File;
use Storage;
use Session;
use Illuminate\Http\Request;

class PartidaController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request)
	{
		$rodada = Partida::where('resultado1',null)->min('rodada');
		if(isset($request->temporada))
		$temporada = Temporada::where('era_id',Session::get('era')->id)->where('numero',$request->temporada)->first();
		else
		$temporada = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('numero DESC')->first();
		if(isset($request->rodada))
		$rodada = $request->rodada;
		if(blank($rodada))
		$rodada = 1;
		if($request->tipo == "liga"){
			$partidas = Partida::where('temporada_id',@$temporada->id)->where('rodada',$rodada)->where('campeonato','Liga')->get();
			$partidas_id = Partida::where('temporada_id',@$temporada->id)->where('rodada',$rodada)->where('campeonato','Liga')->pluck('id');
		} else {
			$partidas = Partida::where('temporada_id',@$temporada->id)->where('campeonato',ucfirst($request->tipo))->get()->keyBy(function($item){return $item['ordem']."|".$item['rodada'];});
			$partidas_id = Partida::where('temporada_id',@$temporada->id)->where('campeonato',ucfirst($request->tipo))->pluck('id');
		}
		$indisponiveis = [];
		foreach(DB::table('cartaos')->join('jogadors','cartaos.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('jogadors.id, jogadors.nome as jogador,times.nome as time,COUNT(*) as qtd')->where('temporada_id',@$temporada->id)->where('campeonato',ucfirst($request->tipo))->where('cumprido',0)->where('cor',0)->where('jogadors.time_id','!=',11)->groupBy('jogadors.id','cartaos.time_id','times.nome')->having(DB::raw('COUNT(*)'),'=',2)->get() as $suspenso){
			if(!isset($indisponiveis[$suspenso->time]))
			$indisponiveis[$suspenso->time] = [];
			$indisponiveis[$suspenso->time][$suspenso->id] = $suspenso->jogador;
		}
		foreach(DB::table('cartaos')->join('jogadors','cartaos.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('jogadors.id, jogadors.nome as jogador,times.nome as time')->where('temporada_id',@$temporada->id)->where('campeonato',ucfirst($request->tipo))->where('cumprido',0)->where('cor',1)->where('jogadors.time_id','!=',11)->get() as $suspenso){
			if(!isset($indisponiveis[$suspenso->time]))
			$indisponiveis[$suspenso->time] = [];
			$indisponiveis[$suspenso->time][$suspenso->id] = $suspenso->jogador;
		}
		foreach(DB::table('lesaos')->join('jogadors','lesaos.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('jogadors.id, jogadors.nome as jogador,times.nome as time')->where('temporada_id',@$temporada->id)->where('restantes','>','0')->where('jogadors.time_id','!=',11)->get() as $lesionado){
			if(!isset($indisponiveis[$lesionado->time]))
			$indisponiveis[$lesionado->time] = [];
			$indisponiveis[$lesionado->time][$lesionado->id] = $lesionado->jogador;
		}
		$jogadores = [];
		foreach (Jogador::all() as $key => $value) {
			if(empty($jogadores[$value->time_id]))
			$jogadores[$value->time_id] = [];
			$jogadores[$value->time_id][] = $value;
		}
		$mvps = [];
		foreach ($partidas as $value){
			if(isset($value->mvp_id))
			$mvps[$value->id] = $value->mvp()->nome;
		}
		$gols = Gol::whereIn('partida_id',$partidas_id)->get();
		$cartoes = Cartao::whereIn('partida_id',$partidas_id)->get();
		$lesoes = Lesao::whereIn('partida_id',$partidas_id)->get();
		return view('partidas.index', ["partidas" => $partidas, "temporada" => $temporada, "rodada" => $rodada, "indisponiveis" => $indisponiveis, "lesionados" => $request->lesionados, "tipo" => $request->tipo, 'jogadores' => $jogadores, 'mvps' => $mvps, 'gols' => $gols, 'cartoes' => $cartoes, 'lesoes' => $lesoes]);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param Request $request
	* @return Response
	*/
	public function store(Request $request)
	{
		$partida = Partida::findOrFail($request->partida_id);
		$partida->resultado1 = $request->input("resultado1");
		$partida->resultado2 = $request->input("resultado2");
		if(!blank($request->penalti1) || !blank($request->penalti2)){
			$partida->penalti1 = $request->penalti1;
			$partida->penalti2 = $request->penalti2;
		}
		if($request->mvp !== "")
			$partida->mvp_id = $request->mvp;
		$partida->save();
		$lesionados = [];
		$time1 = Time::findOrFail($partida->time1_id);
		$time2 = Time::findOrFail($partida->time2_id);
		$temporada = Temporada::findOrFail($partida->temporada_id);

		// Finalizar suspensões e lesões
		Cartao::whereRaw("time_id IN ($partida->time1_id,$partida->time2_id) and cumprido = 0 and cor = '1' and campeonato = '$partida->campeonato' and temporada_id = $temporada->id")->update(['cumprido' => 1]);
		$acumulados = Cartao::selectRaw("array_to_string(array_agg(id), ',') as ids, COUNT(*) as qtd")->whereRaw("time_id IN ($partida->time1_id,$partida->time2_id) and cumprido = 0 and cor = '0' and campeonato = '$partida->campeonato' and temporada_id = $temporada->id")->groupBy('jogador_id')->having(DB::raw('COUNT(*)'), '=', 2)->get();
		// $acumulados = Cartao::selectRaw("GROUP_CONCAT(id SEPARATOR ',') as ids, COUNT(*) as qtd")->whereRaw("time_id IN ($partida->time1_id,$partida->time2_id) and cumprido = 0 and cor = '0' and campeonato = '$partida->campeonato'")->groupBy('jogador_id')->having(DB::raw('COUNT(*)'), '=', 2)->get();
		if(!blank($acumulados)){
			foreach ($acumulados as $key => $value)
			Cartao::whereRaw("id IN ($value->ids)")->update(['cumprido' => 1]);
		}
		Lesao::whereRaw("time_id IN ($partida->time1_id,$partida->time2_id)")->where('restantes','>',0)->decrement('restantes');
		foreach ($request->gols_jogador1 as $key => $value) {
			if($value == '') continue;
			$gol = new Gol();
			$gol->jogador_id = $value;
			$gol->quantidade = $request->gols_qtd1[$key];
			$gol->campeonato = $request->campeonato;
			$gol->temporada_id = $temporada->id;
			$gol->time_id = $partida->time1_id;
			$gol->partida_id = $partida->id;
			$gol->save();
		}
		foreach ($request->gols_jogador2 as $key => $value) {
			if($value == '') continue;
			$gol = new Gol();
			$gol->jogador_id = $value;
			$gol->quantidade = $request->gols_qtd2[$key];
			$gol->campeonato = $request->campeonato;
			$gol->temporada_id = $temporada->id;
			$gol->time_id = $partida->time2_id;
			$gol->partida_id = $partida->id;
			$gol->save();
		}
		foreach ($request->cartoes_jogador1 as $key => $value) {
			if($value == '') continue;
			$cartao = new Cartao();
			$cartao->jogador_id = $value;
			$cartao->cor = $request->cartoes_cor1[$key];
			if($cartao->cor == "1"){
				$time1->dinheiro -= 500000;
				$time1->save();
				Financeiro::create(['valor' => 500000, 'operacao' => 1, 'descricao' => 'Multa por expulsão', 'time_id' => $time1->id]);
			}
			$cartao->campeonato = $request->campeonato;
			$cartao->cumprido = 0;
			$cartao->temporada_id = $temporada->id;
			$cartao->time_id = $partida->time1_id;
			$cartao->partida_id = $partida->id;
			$cartao->save();
		}
		foreach ($request->cartoes_jogador2 as $key => $value) {
			if($value == '') continue;
			$cartao = new Cartao();
			$cartao->jogador_id = $value;
			$cartao->cor = $request->cartoes_cor2[$key];
			if($cartao->cor == "1"){
				$time2->dinheiro -= 500000;
				$time2->save();
				Financeiro::create(['valor' => 500000, 'operacao' => 1, 'descricao' => 'Multa por expulsão', 'time_id' => $time2->id]);
			}
			$cartao->campeonato = $request->campeonato;
			$cartao->temporada_id = $temporada->id;
			$cartao->cumprido = 0;
			$cartao->time_id = $partida->time2_id;
			$cartao->partida_id = $partida->id;
			$cartao->save();
		}
		foreach ($request->lesoes_jogador1 as $key => $value) {
			if($value == '') continue;
			$lesao = new Lesao();
			$lesao->jogador_id = $value;
			if($request->lesoes_tipo1[$key] == 0) $rodadas = rand(1,2);
			elseif ($request->lesoes_tipo1[$key] == 1) $rodadas = rand(0,2);
			else $rodadas = rand(3,7);
			$jogador = Jogador::findOrFail($value);
			$lesionados[$jogador->nome] = $rodadas;
			$lesao->rodadas = $rodadas;
			$lesao->restantes = $rodadas;
			$lesao->temporada_id = $temporada->id;
			$lesao->time_id = $partida->time1_id;
			$lesao->partida_id = $partida->id;
			$lesao->save();
		}
		foreach ($request->lesoes_jogador2 as $key => $value) {
			if($value == '') continue;
			$lesao = new Lesao();
			$lesao->jogador_id = $value;
			if($request->lesoes_tipo2[$key] == 0) $rodadas = rand(1,2);
			elseif ($request->lesoes_tipo2[$key] == 1) $rodadas = rand(0,2);
			else $rodadas = rand(3,7);
			$jogador = Jogador::findOrFail($value);
			$lesionados[$jogador->nome] = $rodadas;
			$lesao->rodadas = $rodadas;
			$lesao->restantes = $rodadas;
			$lesao->temporada_id = $temporada->id;
			$lesao->time_id = $partida->time2_id;
			$lesao->partida_id = $partida->id;
			$lesao->save();
		}

		// Premiação final da Liga
		if($partida->campeonato == "Liga"){
			if(!Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Liga' and resultado1 IS NULL and resultado2 IS NULL")->count()){
				$p = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Liga'")->get();
				$classificacao = $this->classificacao($p);

				$v1 = Time::findOrFail($classificacao[0]['id']);
				$v1->dinheiro += 32000000;
				$v1->save();
				Financeiro::create(['valor' => 32000000, 'operacao' => 0, 'descricao' => 'Campeão da Liga FEDIA', 'time_id' => $v1->id]);
				$v2 = Time::findOrFail($classificacao[1]['id']);
				$v2->dinheiro += 30000000;
				$v2->save();
				Financeiro::create(['valor' => 30000000, 'operacao' => 0, 'descricao' => 'Vice Campeão da Liga FEDIA', 'time_id' => $v2->id]);
				$v3 = Time::findOrFail($classificacao[2]['id']);
				$v3->dinheiro += 29000000;
				$v3->save();
				Financeiro::create(['valor' => 29000000, 'operacao' => 0, 'descricao' => 'Terceiro Lugar da Liga FEDIA', 'time_id' => $v3->id]);
				$v4 = Time::findOrFail($classificacao[3]['id']);
				$v4->dinheiro += 28000000;
				$v4->save();
				Financeiro::create(['valor' => 28000000, 'operacao' => 0, 'descricao' => 'Quarto Lugar da Liga FEDIA', 'time_id' => $v4->id]);
				$v5 = Time::findOrFail($classificacao[4]['id']);
				$v5->dinheiro += 27000000;
				$v5->save();
				Financeiro::create(['valor' => 27000000, 'operacao' => 0, 'descricao' => 'Quinto Lugar da Liga FEDIA', 'time_id' => $v5->id]);
				$v6 = Time::findOrFail($classificacao[5]['id']);
				$v6->dinheiro += 26000000;
				$v6->save();
				Financeiro::create(['valor' => 26000000, 'operacao' => 0, 'descricao' => 'Sexto Lugar da Liga FEDIA', 'time_id' => $v6->id]);
				$v7 = Time::findOrFail($classificacao[6]['id']);
				$v7->dinheiro += 25000000;
				$v7->save();
				Financeiro::create(['valor' => 25000000, 'operacao' => 0, 'descricao' => 'Sétimo Lugar da Liga FEDIA', 'time_id' => $v7->id]);
				$v8 = Time::findOrFail($classificacao[7]['id']);
				$v8->dinheiro += 24000000;
				$v8->save();
				Financeiro::create(['valor' => 24000000, 'operacao' => 0, 'descricao' => 'Oitavo Lugar da Liga FEDIA', 'time_id' => $v8->id]);
				$v9 = Time::findOrFail($classificacao[8]['id']);
				$v9->dinheiro += 23000000;
				$v9->save();
				Financeiro::create(['valor' => 23000000, 'operacao' => 0, 'descricao' => 'Nono Lugar da Liga FEDIA', 'time_id' => $v9->id]);
				$v10 = Time::findOrFail($classificacao[9]['id']);
				$v10->dinheiro += 22000000;
				$v10->save();
				Financeiro::create(['valor' => 22000000, 'operacao' => 0, 'descricao' => 'Décimo Lugar da Liga FEDIA', 'time_id' => $v10->id]);
				$v11 = Time::findOrFail($classificacao[10]['id']);
				$v11->dinheiro += 21000000;
				$v11->save();
				Financeiro::create(['valor' => 21000000, 'operacao' => 0, 'descricao' => 'Décimo Primeiro Lugar da Liga FEDIA', 'time_id' => $v11->id]);
				$v12 = Time::findOrFail($classificacao[11]['id']);
				$v12->dinheiro += 20000000;
				$v12->save();
				Financeiro::create(['valor' => 20000000, 'operacao' => 0, 'descricao' => 'Décimo Segundo Lugar da Liga FEDIA', 'time_id' => $v12->id]);

				$temporada->liga1_id = $v1->id;
				$temporada->liga2_id = $v2->id;

				// MVPs
				$mvps = Partida::selectRaw("COUNT(*) as qtd, mvp_id")->where('temporada_id',$temporada->id)->where('campeonato','Liga')->whereRaw('mvp_id IS NOT NULL')->groupBy("mvp_id")->get();
				$max = 0;
				foreach ($mvps as $value) {
					if($value->qtd > $max)
					$max = $value->qtd;
				}
				$mvps = Partida::select("mvp_id")->where('temporada_id',$temporada->id)->where('campeonato','Liga')->whereRaw('mvp_id IS NOT NULL')->groupBy("mvp_id")->having(DB::raw('COUNT(*)'),'=',$max)->get();
				$time = null;
				$mvp_id = null;
				if($mvps->count() > 1){
					// Se o MVP for do time melhor colocado
					if(is_null($time)){
						for ($i=0; $i < 12; $i++) {
							foreach ($mvps as $mvp) {
								$time = $mvp->mvp()->time();
								if($classificacao[$i]['id'] == $time->id){
									$time->dinheiro += 2000000;
									$time->save();
									$mvp_id = $mvp->mvp_id;
									break;
								}
							}
							if(!is_null($mvp_id))
							break;
						}
					}
				} else {
					$time = $mvps->first()->mvp()->time();
					$time->dinheiro += 2000000;
					$time->save();
					$mvp_id = $mvps->first()->mvp_id;
				}
				Financeiro::create(['valor' => 2000000, 'operacao' => 0, 'descricao' => 'MVP da Liga FEDIA', 'time_id' => $time->id]);
				$temporada->mvp = Jogador::findOrFail($mvp_id)->nome;
				$temporada->save();

				// Artilheiros
				$artilheiro = DB::table('gols')->join('jogadors','gols.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.id,times.nome,times.escudo,jogador_id,jogadors.nome as jogador,SUM(quantidade) as qtd')->where('temporada_id',$temporada->id)->where('campeonato','Liga')->groupBy('jogador_id','jogadors.nome','times.id')->orderBy('qtd','DESC')->get();
				$t = [];
				$gols = null;
				foreach ($artilheiro as $key => $value) {
					if(is_null($gols))
					$gols = $value->qtd;
					if($gols != $value->qtd)
					break;
					$a = new Artilheiro();
					$a->jogador = $value->jogador;
					$a->campeonato = 'Liga';
					$a->temporada_id = $temporada->id;
					$a->save();
					$t[] = $value->id;
				}
				foreach ($t as $key => $value) {
					$time = Time::findOrFail($value);
					$time->dinheiro += (2000000/count($t));
					$time->save();
					Financeiro::create(['valor' => (2000000/count($t)), 'operacao' => 0, 'descricao' => 'Artilheiro da Liga FEDIA', 'time_id' => $value]);
				}

				// Criar SuperCopa
				if(Amistoso::where('temporada_id',$temporada->id)->where('tipo',2)->count()){
					$supercopa = Amistoso::where('temporada_id',$temporada->id)->where('tipo',2)->get()->first();
					if($supercopa->time21_id == $v1->id) {
						$partidas = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Liga' and resultado1 IS NOT NULL and resultado2 IS NOT NULL")->get();
						$classificacao = $this->classificacao($partidas);
						if($classificacao[0]['id'] == $supercopa->time21_id) $supercopa->time11_id = $classificacao[1]['id'];
						else $supercopa->time11_id = $classificacao[0]['id'];
					} else {
						$supercopa->time11_id = $v1->id;
					}
					$supercopa->save();
				} else {
					$supercopa = new Amistoso();
					$supercopa->temporada_id = $temporada->id;
					$supercopa->time11_id = $v1->id;
					$supercopa->valor = 2000000;
					$supercopa->tipo = 2;
					$supercopa->save();
				}
			}
		}

		// Premiação Final da Copa
		if($partida->campeonato == "Copa" && $partida->ordem == 6){
			if((isset($request->penalti1) && $request->penalti1 != '') && (isset($request->penalti2) && $request->penalti2 != '')){
				if($request->penalti1 > $request->penalti2){
					$v = Time::findOrFail($partida->time1_id);
					$d = Time::findOrFail($partida->time2_id);
					$temporada->copa1_id = $partida->time1_id;
					$temporada->copa2_id = $partida->time2_id;
				} else {
					$v = Time::findOrFail($partida->time2_id);
					$d = Time::findOrFail($partida->time1_id);
					$temporada->copa1_id = $partida->time2_id;
					$temporada->copa2_id = $partida->time1_id;
				}
			} else {
				if($request->resultado1 > $request->resultado2) {
					$v = Time::findOrFail($partida->time1_id);
					$d = Time::findOrFail($partida->time2_id);
					$temporada->copa1_id = $partida->time1_id;
					$temporada->copa2_id = $partida->time2_id;
				} else {
					$v = Time::findOrFail($partida->time2_id);
					$d = Time::findOrFail($partida->time1_id);
					$temporada->copa1_id = $partida->time2_id;
					$temporada->copa2_id = $partida->time1_id;
				}
			}
			$campeao = $v;
			$v->dinheiro += 3000000;
			$v->save();
			Financeiro::create(['valor' => 3000000, 'operacao' => 0, 'descricao' => 'Campeão da Copa FEDIA', 'time_id' => $v->id]);

			// Artilheiros
			$artilheiro = DB::table('gols')->join('jogadors','gols.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.id,times.nome,times.escudo,jogador_id,jogadors.nome as jogador,SUM(quantidade) as qtd')->where('temporada_id',$temporada->id)->where('campeonato','Copa')->groupBy('jogador_id','jogadors.nome','times.id')->orderBy('qtd','DESC')->get();
			$t = [];
			$gols = null;
			foreach ($artilheiro as $key => $value) {
				if(is_null($gols))
				$gols = $value->qtd;
				if($gols != $value->qtd)
				break;
				$a = new Artilheiro();
				$a->jogador = $value->jogador;
				$a->campeonato = 'Copa';
				$a->temporada_id = $temporada->id;
				$a->save();
				$t[] = $value->id;
			}
			foreach ($t as $key => $value) {
				$v = Time::findOrFail($value);
				$v->dinheiro += (2000000/count($t));
				$v->save();
				Financeiro::create(['valor' => (2000000/count($t)), 'operacao' => 0, 'descricao' => 'Artilheiro da Copa FEDIA', 'time_id' => $value]);
			}
			$temporada->save();

			// Criar SuperCopa
			if(Amistoso::where('temporada_id',$temporada->id)->where('tipo',2)->count()){
				$supercopa = Amistoso::where('temporada_id',$temporada->id)->where('tipo',2)->get()->first();
				if($supercopa->time11_id == $campeao->id) {
					$partidas = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Liga' and resultado1 IS NOT NULL and resultado2 IS NOT NULL")->get();
					$classificacao = $this->classificacao($partidas);
					if($classificacao[0]['id'] == $supercopa->time21_id) $supercopa->time11_id = $classificacao[1]['id'];
					else $supercopa->time11_id = $classificacao[0]['id'];
				}
				$supercopa->time21_id = $campeao->id;
				$supercopa->save();
			} else {
				$supercopa = new Amistoso();
				$supercopa->temporada_id = $temporada->id;
				$supercopa->time21_id = $campeao->id;
				$supercopa->valor = 2000000;
				$supercopa->tipo = 2;
				$supercopa->save();
			}
		}

		// Criar próxima fase das partidas de Copa
		if($partida->campeonato == "Copa" && $partida->rodada == 2){
			$anterior = Partida::where('temporada_id',$temporada->id)->where('ordem',$partida->ordem)->where('campeonato', $partida->campeonato)->where('rodada',1)->first();
			if((isset($request->penalti1) && $request->penalti1 != '') && (isset($request->penalti2) && $request->penalti2 != '')){
				if($request->penalti1 > $request->penalti2){
					$vencedor = $partida->time1_id;
					$perdedor = $partida->time2_id;
				} else {
					$vencedor = $partida->time2_id;
					$perdedor = $partida->time1_id;
				}
			} else {

				if(($partida->resultado1 + $anterior->resultado2) == ($partida->resultado2 + $anterior->resultado1)){
					if($anterior->resultado2 > $partida->resultado2){
						$vencedor = $partida->time1_id;
						$perdedor = $partida->time2_id;
					} else {
						$vencedor = $partida->time2_id;
						$perdedor = $partida->time1_id;
					}
				} else {
					if(($partida->resultado1 + $anterior->resultado2) > ($partida->resultado2 + $anterior->resultado1)){
						$vencedor = $partida->time1_id;
						$perdedor = $partida->time2_id;
					} else {
						$vencedor = $partida->time2_id;
						$perdedor = $partida->time1_id;
					}
				}
			}
			//  Colocar o vencedor na próxima fase
			$v = Time::findOrFail($vencedor);
			if(in_array($partida->ordem, [0,1])){
				$ordem = 4;
				$v->dinheiro += 8000000;
				Financeiro::create(['valor' => 8000000, 'operacao' => 0, 'descricao' => 'Passou das Quartas de Finais da Copa FEDIA', 'time_id' => $v->id]);
			} elseif(in_array($partida->ordem, [2,3])){
				$ordem = 5;
				$v->dinheiro += 8000000;
				Financeiro::create(['valor' => 8000000, 'operacao' => 0, 'descricao' => 'Passou das Quartas de Finais da Copa FEDIA', 'time_id' => $v->id]);
			} elseif(in_array($partida->ordem, [4,5])){
				$ordem = 6;
				$v->dinheiro += 4000000;
				Financeiro::create(['valor' => 4000000, 'operacao' => 0, 'descricao' => 'Passou das Semi Finais da Copa FEDIA', 'time_id' => $v->id]);
			}
			$v->save();
			if($partida->rodada == 2){
				$pendente = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Copa' and ordem = $ordem and (time1_id IS NULL or time2_id IS NULL)")->get();
				if($pendente->count()){
					foreach ($pendente as $key => $value) {
						if(is_null($value->time1_id))
						$value->time1_id = $vencedor;
						else
						$value->time2_id = $vencedor;
						$value->save();
					}
				} else {
					// Ida
					$ida = new Partida();
					$ida->campeonato = "Copa";
					$ida->rodada = 1;
					$ida->temporada_id = $temporada->id;
					$ida->ordem = $ordem;
					if($partida->ordem % 2 == 0)
					$ida->time1_id = $vencedor;
					else
					$ida->time2_id = $vencedor;
					$ida->save();
					// Volta
					if(!in_array($partida->ordem, [4,5])){
						$volta = new Partida();
						$volta->campeonato = "Copa";
						$volta->rodada = 2;
						$volta->temporada_id = $temporada->id;
						$volta->ordem = $ordem;
						if($partida->ordem % 2 == 1)
						$volta->time1_id = $vencedor;
						else
						$volta->time2_id = $vencedor;
						$volta->save();
					}
				}
			}

			//  Colocar o perdedor na taça
			if(in_array($partida->ordem, [0,1,2,3])){
				$partida_taca = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Taca' and ordem IN (0,1,2,3) and (time1_id IS NULL or time2_id IS NULL) and rodada = 1")->inRandomOrder()->first();

				if(is_null($partida_taca->time1_id)){
					$partida_taca->time1_id = $perdedor;
					$segunda_rodada = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Taca' and ordem = $partida_taca->ordem and rodada = 2")->first();
					$segunda_rodada->time2_id = $perdedor;
					$partida_taca->save();
					$segunda_rodada->save();
				} else {
					$partida_taca->time2_id = $perdedor;
					$segunda_rodada = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Taca' and ordem = $partida_taca->ordem and rodada = 2")->first();
					$segunda_rodada->time1_id = $perdedor;
					$partida_taca->save();
					$segunda_rodada->save();
				}
			}
		}

		// Premiação Final da Taça
		if($partida->campeonato == "Taca" && $partida->ordem == 6){
			if((isset($request->penalti1) && $request->penalti1 != '') && (isset($request->penalti2) && $request->penalti2 != '')){
				if($request->penalti1 > $request->penalti2){
					$v = Time::findOrFail($partida->time1_id);
					$d = Time::findOrFail($partida->time2_id);
					$temporada->taca1_id = $partida->time1_id;
					$temporada->taca2_id = $partida->time2_id;
				} else {
					$v = Time::findOrFail($partida->time2_id);
					$d = Time::findOrFail($partida->time1_id);
					$temporada->taca1_id = $partida->time2_id;
					$temporada->taca2_id = $partida->time1_id;
				}
			} else {
				if($request->resultado1 > $request->resultado2) {
					$v = Time::findOrFail($partida->time1_id);
					$d = Time::findOrFail($partida->time2_id);
					$temporada->taca1_id = $partida->time1_id;
					$temporada->taca2_id = $partida->time2_id;
				} else {
					$v = Time::findOrFail($partida->time2_id);
					$d = Time::findOrFail($partida->time1_id);
					$temporada->taca1_id = $partida->time2_id;
					$temporada->taca2_id = $partida->time1_id;
				}
			}
			$campeao = $v;
			$v->dinheiro += 1500000;
			$v->save();
			Financeiro::create(['valor' => 1500000, 'operacao' => 0, 'descricao' => 'Campeão da Taça FEDIA', 'time_id' => $v->id]);

			// Artilheiros
			$artilheiro = DB::table('gols')->join('jogadors','gols.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.id,times.nome,times.escudo,jogador_id,jogadors.nome as jogador,SUM(quantidade) as qtd')->where('temporada_id',$temporada->id)->where('campeonato','Taca')->groupBy('jogador_id','jogadors.nome','times.id')->orderBy('qtd','DESC')->get();
			$t = [];
			$gols = null;
			foreach ($artilheiro as $key => $value) {
				if(is_null($gols))
				$gols = $value->qtd;
				if($gols != $value->qtd)
				break;
				$a = new Artilheiro();
				$a->jogador = $value->jogador;
				$a->campeonato = 'Taca';
				$a->temporada_id = $temporada->id;
				$a->save();
				$t[] = $value->id;
			}
			foreach ($t as $key => $value) {
				$v = Time::findOrFail($value);
				$v->dinheiro += (1000000/count($t));
				$v->save();
				Financeiro::create(['valor' => (1000000/count($t)), 'operacao' => 0, 'descricao' => 'Artilheiro da Taça FEDIA', 'time_id' => $value]);
			}
			$temporada->save();
		}

		// Criar próxima fase das partidas de Taça
		if($partida->campeonato == "Taca" && $partida->rodada == 2){
			$anterior = Partida::where('temporada_id',$temporada->id)->where('ordem',$partida->ordem)->where('campeonato', $partida->campeonato)->where('rodada',1)->first();
			if((isset($request->penalti1) && $request->penalti1 != '') && (isset($request->penalti2) && $request->penalti2 != '')){
				if($request->penalti1 > $request->penalti2)
				$vencedor = $partida->time1_id;
				else
				$vencedor = $partida->time2_id;
			} else {
				if(($partida->resultado1 + $anterior->resultado2) == ($partida->resultado2 + $anterior->resultado1)){
					if($anterior->resultado2 > $partida->resultado2)
					$vencedor = $partida->time1_id;
					else
					$vencedor = $partida->time2_id;
				} else {
					if(($partida->resultado1 + $anterior->resultado2) > ($partida->resultado2 + $anterior->resultado1))
					$vencedor = $partida->time1_id;
					else
					$vencedor = $partida->time2_id;
				}
			}
			$v = Time::findOrFail($vencedor);
			if(in_array($partida->ordem, [0,1])){
				$ordem = 4;
				$v->dinheiro += 4000000;
				Financeiro::create(['valor' => 4000000, 'operacao' => 0, 'descricao' => 'Passou das Quartas de Finais da Taça FEDIA', 'time_id' => $v->id]);
			} elseif(in_array($partida->ordem, [2,3])){
				$ordem = 5;
				$v->dinheiro += 4000000;
				Financeiro::create(['valor' => 4000000, 'operacao' => 0, 'descricao' => 'Passou das Quartas de Finais da Taça FEDIA', 'time_id' => $v->id]);
			} elseif(in_array($partida->ordem, [4,5])){
				$ordem = 6;
				$v->dinheiro += 2000000;
				Financeiro::create(['valor' => 2000000, 'operacao' => 0, 'descricao' => 'Passou das Semi Finais da Taça FEDIA', 'time_id' => $v->id]);
			}
			$v->save();
			if($partida->rodada == 2){
				$pendente = Partida::whereRaw("temporada_id = $temporada->id and campeonato = 'Taca' and ordem = $ordem and (time1_id IS NULL or time2_id IS NULL)")->get();
				if($pendente->count()){
					foreach ($pendente as $key => $value) {
						if(is_null($value->time1_id))
						$value->time1_id = $vencedor;
						else
						$value->time2_id = $vencedor;
						$value->save();
					}
				} else {
					// Ida
					$ida = new Partida();
					$ida->campeonato = "Taca";
					$ida->rodada = 1;
					$ida->temporada_id = $temporada->id;
					$ida->ordem = $ordem;
					if($partida->ordem % 2 == 0)
					$ida->time1_id = $vencedor;
					else
					$ida->time2_id = $vencedor;
					$ida->save();
					// Volta
					if(!in_array($partida->ordem, [4,5])){
						$volta = new Partida();
						$volta->campeonato = "Taca";
						$volta->rodada = 2;
						$volta->temporada_id = $temporada->id;
						$volta->ordem = $ordem;
						if($partida->ordem % 2 == 1)
						$volta->time1_id = $vencedor;
						else
						$volta->time2_id = $vencedor;
						$volta->save();
					}
				}
			}
		}

		if($request->view == 'partidas.partidas')
		$time = $request->time_id;
		else
		$time = null;
		return redirect()->route($request->view, ['tipo' => strtolower($request->campeonato), 'temporada' => $temporada->id, 'rodada' => $request->rodada, 'lesionados' => $lesionados, 'time_id' => $time])->with('message', 'Resultado cadastrado com sucesso!');
	}

	/**
	* List all Temporadas.
	*
	* @return Response
	*/
	public function temporadas(Request $request)
	{
		$temporadas = Temporada::where('era_id',Session::get('era')->id)->orderBy('numero')->get();
		(strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
		(strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
		(strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
		(isset($request->order)) ? $order = $request->order : $order = "numero desc";
		$times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		$times = Time::whereIn('id',$times_id)->lists('nome','id');
		return view('partidas.temporada', ["temporadas" => $temporadas, "times" => $times, "filtro" => $request->filtro, "valor" => $request->valor, "caret" => $caret, "param" => $param, "signal" => $signal]);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param Request $request
	* @return Response
	*/
	public function temporada_store(Request $request)
	{
		$temporada = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('numero DESC')->first();
		// $temporadas = Temporada::where('era_id',Session::get('era')->id)->get();
		// $temporada = new Temporada();
		// $temporada->numero = $temporadas->count()+1;
		// $temporada->era_id = Session::get('era')->id;
		// $temporada->save();
		// // Sorteio da liga
		// $times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		// $times = Time::whereIn('id',$times_id)->inRandomOrder()->get();
		// $linha1 = [];
		// $linha2 = [];
		// $last1 = null;
		// foreach ($times as $index => $time)
		// $linha1[] = $time->id;
		// foreach ($times->reverse() as $index => $time)
		// $linha2[] = $time->id;
		// for ($turno=0; $turno <= 1; $turno++) {
		// 	for ($r=1; $r < $times->count(); $r++) {
		// 		if($turno == 0)
		// 		$rodada = $r;
		// 		else
		// 		$rodada = $r+$times->count()-1;
		// 		for ($i=0; $i < $times->count()/2; $i++) {
		// 			$partida = new Partida();
		// 			$partida->campeonato = "Liga";
		// 			$partida->temporada_id = $temporada->id;
		// 			if($rodada % 2 == 0){
		// 				$partida->rodada = $rodada;
		// 				$partida->time1_id = $linha1[$i];
		// 				$partida->time2_id = $linha2[$i];
		// 			} else {
		// 				$partida->rodada = $rodada;
		// 				$partida->time1_id = $linha2[$i];
		// 				$partida->time2_id = $linha1[$i];
		// 			}
		// 			$partida->save();
		// 		}
		// 		// Gira as linhas no sentido horário
		// 		$last1 = $linha1[($times->count()/2)-1];
		// 		for ($i2=($times->count()/2)-1; $i2 >= 0; $i2--) {
		// 			if($i2 == 1)
		// 			$linha1[$i2] = $linha2[0];
		// 			elseif ($i2 != 0)
		// 			$linha1[$i2] = $linha1[$i2-1];
		// 		}
		// 		for ($i2=0; $i2 < $times->count()/2; $i2++) {
		// 			if ($i2 == ($times->count()/2)-1)
		// 			$linha2[$i2] = $last1;
		// 			else
		// 			$linha2[$i2] = $linha2[$i2+1];
		// 		}
		// 	}
		// }

		// // Sorteio da copa
		// $temporada_anterior = $temporada->id - 1;
		// $p = Partida::whereRaw("temporada_id = $temporada_anterior and campeonato = 'Liga'")->get();
		// $classificacao = $this->classificacao($p);
		$classificacao = []
		$times_id = [11,8,3,1,12,4,7,5,2,6,14,15];
		foreach ([0,1,2,3,4,5,6,7] as $index) {
			array_push($times_id, $classificacao[$index]);
		}
		$times = Time::whereIn('id', $times_id)->inRandomOrder()->get();
		foreach ([0,2,4,6] as $ordem => $index) {
			// Ida
			$partida = new Partida();
			$partida->campeonato = "Copa";
			$partida->temporada_id = $temporada->id;
			$partida->rodada = 1;
			$partida->ordem = $ordem;
			$partida->time1_id = @$times[$index]->id;
			$partida->time2_id = @$times[$index+1]->id;
			$partida->save();
			// Volta
			$partida = new Partida();
			$partida->campeonato = "Copa";
			$partida->temporada_id = $temporada->id;
			$partida->rodada = 2;
			$partida->ordem = $ordem;
			$partida->time1_id = @$times[$index+1]->id;
			$partida->time2_id = @$times[$index]->id;
			$partida->save();
		}

		// Sorteio da taça
		$times_id = [];
		foreach ([8,9,10,11] as $index) {
			array_push($times_id, $classificacao[$index]);
		}
		$times = Time::whereIn('id', $times_id)->inRandomOrder()->get();
		$indexes = [0,1,2,3,100,100,100,100];
		shuffle($indexes);
		for ($i = 0; $i < 8; $i += 2) {
		// for ($indexes as $ordem => $index) {
			// Ida
			$partida = new Partida();
			$partida->campeonato = "Taca";
			$partida->temporada_id = $temporada->id;
			$partida->rodada = 1;
			$partida->ordem = $i / 2;
			$partida->time1_id = @$times[$indexes[$i]]->id;
			$partida->time2_id = @$times[$indexes[$i+1]]->id;
			$partida->save();
			// Volta
			$partida = new Partida();
			$partida->campeonato = "Taca";
			$partida->temporada_id = $temporada->id;
			$partida->rodada = 2;
			$partida->ordem = $i / 2;
			$partida->time1_id = @$times[$indexes[$i+1]]->id;
			$partida->time2_id = @$times[$indexes[$i]]->id;
			$partida->save();
		}

		// Dinheiro do patrocínio
		foreach (Time::where('nome','!=','Mercado Externo')->get() as $key => $time) {
			$valor = 20000000 + (($temporada->numero - 1) * 2500000);
			$time->dinheiro += $valor;
			$time->save();
			Financeiro::create(['valor' => $valor, 'operacao' => 0, 'descricao' => 'Patrocício da Temporada '.$temporada->numero, 'time_id' => $time->id]);
		}

		return redirect()->route('partidas.temporadas')->with('message', 'Temporada '.$temporada->numero.' cadastrada com sucesso!');
	}

	/**
	* Importa as fotos da temporada
	*
	* @return Response
	*/
	public function temporada_fotos(Request $request)
	{
		$temporada = Temporada::findOrFail($request->id);
		$path = public_path()."/images/temporadas/$request->id";
		if(!File::exists($path))
		File::makeDirectory($path);

		$nomes = [];
		$files = $request->file('images');
		if($request->hasFile('images')){
			foreach ($files as $file){
				$nomes[] = $file->getClientOriginalName();
				Storage::disk('public_temporadas')->put("$request->id/".$file->getClientOriginalName(), file_get_contents($file->getRealPath()));
			}
		}
		if(blank($temporada->fotos))
		$fotos = join('|',$nomes);
		else
		$fotos = $temporada->fotos."|".join('|',$nomes);
		$temporada->fotos = $fotos;
		$temporada->save();

		return redirect()->route('partidas.temporadas')->with('message', 'Fotos importadas com sucesso!');
	}

	/**
	* Lista todos os status (cartão e lesão) dos jogadores.
	*
	* @return Response
	*/
	public function indisponiveis(Request $request)
	{
		if(isset($request->temporada))
		$temporada = Temporada::where('era_id',Session::get('era')->id)->where('numero',$request->temporada)->first();
		else
		$temporada = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('numero DESC')->first();
		if(!Auth::user()->isAdmin())
		$request->time = Auth::user()->time(Session::get('era')->id)->id;
		if(isset($request->time) && $request->time != "Todos"){
			$times = Time::where('id',$request->time)->get()->keyBy('id');
			$clausures = "time_id = $request->time";
		} else {
			$times = Time::where('nome','!=','Mercado Externo')->get()->keyBy('id');
			$clausures = "1 = 1";
		}
		if(isset($request->time))
		$time = $request->time;
		else
		$time = null;
		$indisponiveis = [];
		foreach (Cartao::selectRaw('jogador_id,cor,time_id,campeonato,COUNT(*) as qtd')->where('temporada_id',@$temporada->id)->where('cumprido',0)->whereRaw($clausures)->groupBy('jogador_id','cor','campeonato','time_id')->get() as $value) {
			if(empty($indisponiveis[$value->time_id]))
			$indisponiveis[$value->time_id] = ['amarelo' => [], 'vermelho' => [], 'lesao' => [], 'nome' => $times[$value->time_id]->nome, 'escudo' => $times[$value->time_id]->escudo];
			if($value->qtd == 1)
			$palavra = 'cartão';
			else
			$palavra = 'cartões';
			if($value->cor == 0)
			$indisponiveis[$value->time_id]['amarelo'][] = $value->jogador()->nome.": $value->qtd $palavra amarelo pela $value->campeonato FEDIA.";
			else
			$indisponiveis[$value->time_id]['vermelho'][] = $value->jogador()->nome.": $value->qtd $palavra vermelho pela $value->campeonato FEDIA.";
		}
		foreach (Lesao::where('temporada_id',@$temporada->id)->where('restantes','>',0)->whereRaw($clausures)->get() as $value){
			if(empty($indisponiveis[$value->time_id]))
			$indisponiveis[$value->time_id] = ['amarelo' => [], 'vermelho' => [], 'lesao' => [], 'nome' => $times[$value->time_id]->nome, 'escudo' => $times[$value->time_id]->escudo];
			$indisponiveis[$value->time_id]['lesao'][] = $value->jogador()->nome.": Lesionado por $value->restantes rodadas restantes.";
		}
		$times = Time::whereIn('id',UserTime::where('era_id',Session::get('era')->id)->pluck('time_id')->toArray())->get();
		$temporadas = Temporada::where('era_id',Session::get('era')->id)->get();

		return view('partidas.indisponivel', ["indisponiveis" => $indisponiveis, "times" => $times, "temporadas" => $temporadas, "time" => $time, "temporada" => $temporada]);
	}

	/**
	* Lista todos os status (cartão e lesão) dos jogadores.
	*
	* @return Response
	*/
	public function partidas(Request $request)
	{
		if(!blank($request->temporada))
		$temporada = Temporada::where('era_id',Session::get('era')->id)->where('numero',@$request->temporada)->first();
		else
		$temporada = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('numero DESC')->first();
		if(!blank($request->time_id))
		$time = Time::findOrFail($request->time_id);
		else
		$time = Auth::user()->time(Session::get('era')->id);
		$times = Time::whereIn('id',UserTime::where('era_id',Session::get('era')->id)->pluck('time_id')->toArray())->lists('nome','id')->all();
		$partidas = ['Liga' => [], 'Copa' => [], 'Taca' => []];
		$partidas_id = [];
		foreach (Partida::whereRaw("(time1_id = $time->id or time2_id = $time->id)")->where("temporada_id",@$temporada->id)->orderByRaw('ordem,rodada')->get() as $value){
			$partidas[$value->campeonato][] = $value;
			$partidas_id[] = $value->id;
		}
		$jogadores = [];
		foreach (Jogador::all() as $key => $value) {
			if(empty($jogadores[$value->time_id]))
			$jogadores[$value->time_id] = [];
			$jogadores[$value->time_id][] = $value;
		}
		$indisponiveis = [];
		foreach(DB::table('cartaos')->join('jogadors','cartaos.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('jogadors.nome as jogador,cartaos.campeonato,times.nome as time,COUNT(*) as qtd')->where('temporada_id',@$temporada->id)->where('cumprido',0)->where('campeonato','!=','Amistoso')->where('cor',0)->where('jogadors.time_id','!=',11)->groupBy('jogadors.nome','campeonato','times.nome')->having(DB::raw('COUNT(*)'),'=',2)->get() as $suspenso){
			if(!isset($indisponiveis[$suspenso->campeonato]))
			$indisponiveis[$suspenso->campeonato] = [];
			if(!isset($indisponiveis[$suspenso->campeonato][$suspenso->time]))
			$indisponiveis[$suspenso->campeonato][$suspenso->time] = [];
			$indisponiveis[$suspenso->campeonato][$suspenso->time][] = $suspenso->jogador;
		}
		foreach(DB::table('cartaos')->join('jogadors','cartaos.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('jogadors.nome as jogador,cartaos.campeonato,times.nome as time')->where('temporada_id',@$temporada->id)->where('cumprido',0)->where('campeonato','!=','Amistoso')->where('cor',1)->where('jogadors.time_id','!=',11)->get() as $suspenso){
			if(!isset($indisponiveis[$suspenso->campeonato]))
			$indisponiveis[$suspenso->campeonato] = [];
			if(!isset($indisponiveis[$suspenso->campeonato][$suspenso->time]))
			$indisponiveis[$suspenso->campeonato][$suspenso->time] = [];
			$indisponiveis[$suspenso->campeonato][$suspenso->time][] = $suspenso->jogador;
		}
		foreach(DB::table('lesaos')->join('jogadors','lesaos.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('jogadors.nome as jogador,times.nome as time')->where('temporada_id',@$temporada->id)->where('restantes','>','0')->where('jogadors.time_id','!=',11)->get() as $lesionado){
			if(!isset($indisponiveis['Copa']))
			$indisponiveis['Copa'] = [];
			if(!isset($indisponiveis['Copa'][$lesionado->time]))
			$indisponiveis['Copa'][$lesionado->time] = [];
			$indisponiveis['Copa'][$lesionado->time][] = $lesionado->jogador;
			if(!isset($indisponiveis['Liga']))
			$indisponiveis['Liga'] = [];
			if(!isset($indisponiveis['Liga'][$lesionado->time]))
			$indisponiveis['Liga'][$lesionado->time] = [];
			$indisponiveis['Liga'][$lesionado->time][] = $lesionado->jogador;
		}
		$mvps = [];
		foreach (Partida::where('temporada_id',@$temporada->id)->whereRaw("time1_id = $time->id or time2_id = $time->id")->get() as $value){
			$mvps[$value->id] = @$value->mvp()->nome;
		}
		$gols = Gol::whereIn('partida_id',$partidas_id)->get();
		$cartoes = Cartao::whereIn('partida_id',$partidas_id)->get();
		$lesoes = Lesao::whereIn('partida_id',$partidas_id)->get();
		return view('partidas.partidas', ["partidas" => $partidas, "temporada" => $temporada, "time" => $time, "times" => $times, "jogadores" => $jogadores, "mvps" => $mvps, "gols" => $gols, "cartoes" => $cartoes, "lesoes" => $lesoes, "indisponiveis" => $indisponiveis, "lesionados" => $request->lesionados]);
	}

	/**
	* Obtém a classificação da Liga
	*
	* @param $partidas
	* @return Response
	*/
	public function classificacao($partidas)
	{
		$times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		$t = Time::whereIn('id',$times_id)->get()->keyBy('id');
		$classificacao = [];
		foreach ($t as $key => $value) {
			$classificacao[$value->id] = ['P' => 0, 'J' => 0, 'V' => 0, 'E' => 0, 'D' => 0, 'GP' => 0, 'GC' => 0, 'SG' => 0, 'id' => $value->id, 'nome' => $t[$value->id]->nome];
		}
		foreach ($partidas as $key => $value) {
			$classificacao[$value->time1_id]["J"] += 1;
			$classificacao[$value->time2_id]["J"] += 1;
			$classificacao[$value->time1_id]["GP"] += $value->resultado1;
			$classificacao[$value->time2_id]["GP"] += $value->resultado2;
			$classificacao[$value->time1_id]["GC"] += $value->resultado2;
			$classificacao[$value->time2_id]["GC"] += $value->resultado1;
			$classificacao[$value->time1_id]["SG"] += $value->resultado1;
			$classificacao[$value->time1_id]["SG"] -= $value->resultado2;
			$classificacao[$value->time2_id]["SG"] += $value->resultado2;
			$classificacao[$value->time2_id]["SG"] -= $value->resultado1;
			if($value->resultado1 > $value->resultado2){
				$classificacao[$value->time1_id]["P"] += 3;
				$classificacao[$value->time1_id]["V"] += 1;
				$classificacao[$value->time2_id]["D"] += 1;
			} elseif ($value->resultado1 == $value->resultado2) {
				$classificacao[$value->time1_id]["P"] += 1;
				$classificacao[$value->time2_id]["P"] += 1;
				$classificacao[$value->time1_id]["E"] += 1;
				$classificacao[$value->time2_id]["E"] += 1;
			} else {
				$classificacao[$value->time2_id]["P"] += 3;
				$classificacao[$value->time2_id]["V"] += 1;
				$classificacao[$value->time1_id]["D"] += 1;
			}
		}

		$sort = array();
		foreach ($classificacao as $k => $c){
			$sort['P'][$k] = $c['P'];
			$sort['V'][$k] = $c['V'];
			$sort['SG'][$k] = $c['SG'];
			$sort['GP'][$k] = $c['GP'];
		}
		array_multisort($sort['P'], SORT_DESC, $sort['V'], SORT_DESC, $sort['SG'], SORT_DESC, $sort['GP'], SORT_DESC, $classificacao);
		return $classificacao;
	}
}
