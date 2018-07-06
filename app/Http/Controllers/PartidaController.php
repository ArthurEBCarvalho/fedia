<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Partida;
use App\Time;
use App\Temporada;
use App\Gol;
use App\Cartao;
use App\Lesao;
use Log;
use DB;
use Illuminate\Http\Request;

class PartidaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$temporada = Partida::all()->max('temporada');
		$rodada = Partida::where('resultado1',null)->min('rodada');
		if(isset($request->temporada))
			$temporada = $request->temporada;
		if(isset($request->rodada))
			$rodada = $request->rodada;
		if(is_null($rodada))
			$rodada = 1;
		if($request->tipo == "liga")
			$partidas = Partida::where('temporada',$temporada)->where('rodada',$rodada)->where('campeonato','liga')->get();
		else
			$partidas = Partida::where('temporada',$temporada)->where('campeonato','copa')->get()->keyBy(function($item){return $item['ordem']."|".$item['rodada'];});
		return view('administracao.partidas.index', ["partidas" => $partidas, "temporada" => $temporada, "rodada" => $rodada, "tipo" => $request->tipo]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$partida = new Partida();
		$times = Time::lists('nome','id')->all();
		return view('administracao.partidas.form', ["partida" => $partida, "url" => "administracao.partidas.store", "method" => "post", "times" => $times]);
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
		$partida->save();

		// Finalizar suspensões e lesões
		Cartao::whereRaw("time_id IN ('$partida->time1_id','$partida->time2_id')")->where('cumprido',0)->where('cor',1)->update(['cumprido' => 1]);
		$acumulados = Cartao::selectRaw("GROUP_CONCAT(id SEPARATOR ',') as ids, COUNT(*) as qtd")->whereRaw("time_id IN ('$partida->time1_id','$partida->time2_id')")->where('cumprido',0)->where('cor',0)->groupBy('jogador')->having('qtd', '>', 2);
		if(!blank($acumulados)){
			foreach ($acumulados as $key => $value)
				Cartao::whereRaw("id IN ($value->ids)")->update(['cumprido' => 1]);
		}
		Lesao::whereRaw("time_id IN ('$partida->time1_id','$partida->time2_id')")->where('restantes','>',0)->decrement('restantes');
		foreach ($request->gols_jogador1 as $key => $value) {
			if($value == '')
				continue;
			$gol = new Gol();
			$gol->jogador = $value;
			$gol->quantidade = $request->gols_qtd1[$key];
			$gol->campeonato = $request->campeonato;
			$gol->temporada = $partida->temporada;
			$gol->time_id = $partida->time1_id;
			$gol->partida_id = $partida->id;
			$gol->save();
		}
		foreach ($request->gols_jogador2 as $key => $value) {
			if($value == '')
				continue;
			$gol = new Gol();
			$gol->jogador = $value;
			$gol->quantidade = $request->gols_qtd2[$key];
			$gol->campeonato = $request->campeonato;
			$gol->temporada = $partida->temporada;
			$gol->time_id = $partida->time2_id;
			$gol->partida_id = $partida->id;
			$gol->save();
		}
		foreach ($request->cartoes_jogador1 as $key => $value) {
			if($value == '')
				continue;
			$cartao = new Cartao();
			$cartao->jogador = $value;
			$cartao->cor = $request->cartoes_cor1[$key];
			$cartao->campeonato = $request->campeonato;
			$cartao->cumprido = 0;
			$cartao->temporada = $partida->temporada;
			$cartao->time_id = $partida->time1_id;
			$cartao->partida_id = $partida->id;
			$cartao->save();
		}
		foreach ($request->cartoes_jogador2 as $key => $value) {
			if($value == '')
				continue;
			$cartao = new Cartao();
			$cartao->jogador = $value;
			$cartao->cor = $request->cartoes_cor2[$key];
			$cartao->campeonato = $request->campeonato;
			$cartao->temporada = $partida->temporada;
			$cartao->cumprido = 0;
			$cartao->time_id = $partida->time2_id;
			$cartao->partida_id = $partida->id;
			$cartao->save();
		}
		foreach ($request->lesoes_jogador1 as $key => $value) {
			if($value == '')
				continue;
			$lesao = new Lesao();
			$lesao->jogador = $value;
			$rodadas = rand(1,7);
			$lesao->rodadas = $rodadas;
			$lesao->restantes = $rodadas;
			$lesao->temporada = $partida->temporada;
			$lesao->time_id = $partida->time1_id;
			$lesao->partida_id = $partida->id;
			$lesao->save();
		}
		foreach ($request->lesoes_jogador2 as $key => $value) {
			if($value == '')
				continue;
			$lesao = new Lesao();
			$lesao->jogador = $value;
			$rodadas = rand(1,7);
			$lesao->rodadas = $rodadas;
			$lesao->restantes = $rodadas;
			$lesao->temporada = $partida->temporada;
			$lesao->time_id = $partida->time2_id;
			$lesao->partida_id = $partida->id;
			$lesao->save();
		}

		$temporada = Temporada::findOrFail($partida->temporada);

		// Premiação por partida da liga
		if($partida->campeonato == "Liga"){
			$time1 = Time::findOrFail($partida->time1_id);
			$time2 = Time::findOrFail($partida->time2_id);
			if($partida->resultado1 > $partida->resultado2){
				$time1->dinheiro += 3000000;
			} elseif ($partida->resultado1 == $partida->resultado2) {
				$time1->dinheiro += 1000000;
				$time2->dinheiro += 1000000;
			} else {
				$time2->dinheiro += 3000000;
			}
			$time1->save();
			$time2->save();

			// Premiação Final da Liga
			if(!Partida::where('temporada',$partida->temporada)->where('campeonato','Liga')->whereRaw("resultado1 IS NULL and resultado2 IS NULL")->count()){
				$p = Partida::where('temporada',$partida->temporada)->where('campeonato','Liga')->whereRaw("resultado1 IS NOT NULL && resultado2 IS NOT NULL")->get();
				$t = Time::all()->keyBy('id');
				$classificacao = [];
				foreach ($t as $key => $value) {
					$classificacao[$value->id] = ['P' => 0, 'J' => 0, 'V' => 0, 'E' => 0, 'D' => 0, 'GP' => 0, 'GC' => 0, 'SG' => 0, 'id' => $value->id, 'nome' => $t[$value->id]->nome];
				}
				foreach ($p as $key => $value) {
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
				reset($classificacao);
				$v1 = Time::findOrFail($classificacao[0]['id']);
				$v1->dinheiro += 20000000;
				$v1->save();
				$v2 = Time::findOrFail($classificacao[1]['id']);
				$v2->dinheiro += 10000000;
				$v2->save();
				$v3 = Time::findOrFail($classificacao[2]['id']);
				$v3->dinheiro += 5000000;
				$v3->save();
				$artilheiro = DB::table('gols')->join('times','gols.time_id','=','times.id')->selectRaw('times.id,times.nome,times.escudo,jogador,SUM(quantidade) as qtd')->where('temporada',$temporada->id)->where('campeonato','Liga')->groupBy('jogador')->orderBy('qtd','DESC')->get();
				$a = [];
				$t = [];
				$gols = null;
				foreach ($artilheiro as $key => $value) {
					if(is_null($gols))
						$gols = $value->qtd;
					if($gols != $value->qtd)
						break;
					Log::info("GOL ($value->jogador): $value->qtd");
					$a[] = $value->jogador;
					$t[] = $value->id;
				}
				foreach ($t as $key => $value) {
					$v = Time::findOrFail($value);
					$v->dinheiro += (5000000/count($t));
					$v->save();
				}
				$temporada->artilheiro_liga = join(', ',$a);
				$temporada->liga1_id = $classificacao[0]['id'];
				$temporada->liga2_id = $classificacao[1]['id'];
				$temporada->liga3_id = $classificacao[2]['id'];
				$temporada->save();
			}
		}

		// Premiação Final da Copa
		if($partida->campeonato == "Copa" && $partida->ordem == 6){
			if(!blank($request->penalti1) || !blank($request->penalti2)){
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
					$d = Time::findOrFail($partida->time2_id);
					$temporada->copa1_id = $partida->time2_id;
					$temporada->copa2_id = $partida->time1_id;
				}
			}
			$v->dinheiro += 20000000;
			$v->save();
			$d->dinheiro += 10000000;
			$d->save();

			$artilheiro = DB::table('gols')->join('times','gols.time_id','=','times.id')->selectRaw('times.id,times.nome,times.escudo,jogador,SUM(quantidade) as qtd')->where('temporada',$temporada->id)->where('campeonato','Copa')->groupBy('jogador')->orderBy('qtd','DESC')->get();
			$a = [];
			$t = [];
			$gols = null;
			foreach ($artilheiro as $key => $value) {
				if(is_null($gols))
					$gols = $value->qtd;
				if($gols != $value->qtd)
					break;
				$a[] = $value->jogador;
				$t[] = $value->id;
			}
			foreach ($t as $key => $value) {
				$v = Time::findOrFail($value);
				$v->dinheiro += (5000000/count($t));
				$v->save();
			}
			$temporada->artilheiro_copa = join(', ',$a);
			$temporada->save();
		}

		// Criar próxima fase das partidas de Copa
		if($partida->campeonato == "Copa" && $partida->rodada == 2){
			$anterior = Partida::where('temporada',$partida->temporada)->where('ordem',$partida->ordem)->first();
			if(!blank($request->penalti1) || !blank($request->penalti2)){
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
			switch ($partida->ordem) {
				case 0:
				case 1:
				$ordem = 4;
				$v->dinheiro += 6000000;
				break;
				case 2:
				case 3:
				$ordem = 5;
				$v->dinheiro += 6000000;
				break;
				case 4:
				case 5:
				$ordem = 6;
				$v->dinheiro += 10000000;
				break;
			}
			$v->save();
			if($partida->rodada == 2){
				$pendente = Partida::where('temporada',$partida->temporada)->where('campeonato','Copa')->where('ordem',$ordem)->whereRaw("time1_id IS NULL or time2_id IS NULL")->get();
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
					$ida->temporada = $partida->temporada;
					$ida->ordem = $ordem;
					if($partida->ordem % 2 == 0)
						$ida->time1_id = $vencedor;
					else
						$ida->time2_id = $vencedor;
					$ida->save();
				// Volta
					if(!in_array($partida->ordem, [5,6])){
						$volta = new Partida();
						$volta->campeonato = "Copa";
						$volta->rodada = 2;
						$volta->temporada = $partida->temporada;
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
		
		return redirect()->route('administracao.partidas.index', ['tipo' => strtolower($request->campeonato), 'temporada' => $request->temporada, 'rodada' => $request->rodada])->with('message', 'Resultado cadastrado com sucesso!');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$partida = Partida::findOrFail($id);
		$times = Time::lists('nome','id')->all();
		return view('administracao.partidas.form', ["partida" => $partida, "url" => "administracao.partidas.update", "method" => "put", "times" => $times]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$partida = Partida::findOrFail($id);
		$partida->campeonato = $request->input("campeonato");
		$partida->rodada = $request->input("rodada");
		$partida->temporada = $request->input("temporada");
		$partida->time1_id = $request->input("time1_id");
		$partida->time2_id = $request->input("time2_id");
		$partida->resultado1 = $request->input("resultado1");
		$partida->resultado2 = $request->input("resultado2");
		$partida->penalti1 = $request->input("penalti1");
		$partida->penalti2 = $request->input("penalti2");
		$partida->save();
		return redirect()->route('administracao.partidas.index')->with('message', 'Partida atualizado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$partida = Partida::findOrFail($id);
		$partida->delete();
		return redirect()->route('administracao.partidas.index')->with('message', 'Partida deletado com sucesso!');
	}

	/**
	 * List all Temporadas.
	 *
	 * @return Response
	 */
	public function temporadas(Request $request)
	{
		$temporadas = Temporada::paginate(30);
		(strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
		(strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
		(strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
		(isset($request->order)) ? $order = $request->order : $order = "numero desc";
		return view('administracao.partidas.temporada', ["temporadas" => $temporadas, "filtro" => $request->filtro, "valor" => $request->valor, "caret" => $caret, "param" => $param, "signal" => $signal]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function temporada_store(Request $request)
	{
		// Validar
		// SELECT rodada, COUNT(*) FROM partidas WHERE campeonato = 'Liga' GROUP BY rodad
		$temporadas = Temporada::all();
		$temporada = new Temporada();
		$temporada->numero = $temporadas->count()+1;
		$temporada->save();
		do {
			$times = Time::inRandomOrder()->get();
			Log::info('AAAA');
			// Sorteio da liga
			Partida::where('campeonato','Liga')->where('temporada',$temporada->id)->delete();
			$rodadas = [];
			for ($i=1; $i <= ($times->count()-1)*2; $i++)
				$rodadas[$i] = [];
			for ($turno=0; $turno <= 1; $turno++) { 
				foreach ($times as $key1 => $time1) {
					foreach ($times as $key2 => $time2) {
						if($time1->id < $time2->id){
							for ($i=1; $i <= ($times->count()-1)*2; $i++) { 
								if(in_array($time1->id, $rodadas[$i]) || in_array($time2->id, $rodadas[$i])){
									$rodada = 0;
									continue;
								}
								$rodadas[$i][] = $time1->id;
								$rodadas[$i][] = $time2->id;
								$rodada = $i;
								break;
							}
							$partida = new Partida();
							$partida->campeonato = "Liga";
							$partida->temporada = $temporada->numero;
							if($rodada % 2 == 0){
								$partida->rodada = $rodada;
								$partida->time1_id = $time1->id;
								$partida->time2_id = $time2->id;
							} else {
								$partida->rodada = $rodada;
								$partida->time1_id = $time2->id;
								$partida->time2_id = $time1->id;
							}
							$partida->save();
						}
					}
				}
			}
			$erradas = Partida::where('campeonato','Liga')->where('rodada',0)->where('temporada',$temporada->id)->get();
		} while ($erradas->count());

		// Sorteio da copa
		foreach ([0,2,4,6] as $ordem => $index) {
			// Ida
			$partida = new Partida();
			$partida->campeonato = "Copa";
			$partida->temporada = $temporada->numero;
			$partida->rodada = 1;
			$partida->ordem = $ordem;
			$partida->time1_id = $times[$index]->id;
			$partida->time2_id = $times[$index+1]->id;
			$partida->save();
			// Volta
			$partida = new Partida();
			$partida->campeonato = "Copa";
			$partida->temporada = $temporada->numero;
			$partida->rodada = 2;
			$partida->ordem = $ordem;
			$partida->time1_id = $times[$index+1]->id;
			$partida->time2_id = $times[$index]->id;
			$partida->save();
		}

		// Dinheiro do patrocínio
		foreach ($times as $key => $time) {
			$time->dinheiro += 50000000;
			$time->save();
		}

		return redirect()->route('administracao.partidas.temporadas')->with('message', 'Temporada '.$temporada->numero.' cadastrada com sucesso!');
	}

}
