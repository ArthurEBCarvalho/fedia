<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Amistoso;
use App\Temporada;
use App\Jogador;
use App\Time;
use App\UserTime;
use App\Lesao;
use App\Gol;
use App\Cartao;
use App\Financeiro;
use App\Partida;
use App\Artilheiro;
use DB;
use Log;
use Session;
use Illuminate\Http\Request;

class AmistosoController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request)
	{
		if(isset($request->temporada))
		$temporada = Temporada::where('era_id',Session::get('era')->id)->where('numero',$request->temporada)->first();
		else
		$temporada = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('numero DESC')->first();
		$amistosos = Amistoso::where('temporada_id',@$temporada->id)->where('tipo',$request->tipo)->orderBy('id')->get();
		$amistosos_id = Amistoso::where('temporada_id',@$temporada->id)->where('tipo',$request->tipo)->orderBy('id')->pluck('id');
		$jogadores = [];
		foreach (Jogador::all() as $key => $value) {
			if(empty($jogadores[$value->time_id]))
			$jogadores[$value->time_id] = [];
			$jogadores[$value->time_id][] = $value;
		}
		$gols = Gol::whereIn('partida_id',$amistosos_id)->where('campeonato','Amistoso')->get();
		$cartoes = Cartao::whereIn('partida_id',$amistosos_id)->where('campeonato','Amistoso')->get();
		$lesoes = Lesao::whereIn('partida_id',$amistosos_id)->get();
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
		return view('amistosos.index', ["amistosos" => $amistosos, "temporada" => $temporada, 'jogadores' => $jogadores, 'gols' => $gols, 'cartoes' => $cartoes, 'lesoes' => $lesoes, "indisponiveis" => $indisponiveis, 'lesionados' => $request->lesionados, 'tipo' => $request->tipo]);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create(Request $request)
	{
		$amistoso = new Amistoso();
		$times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		$times = Time::whereIn('id',$times_id)->orderBy('nome')->lists('nome','id')->all();
		return view('amistosos.form', ["amistoso" => $amistoso, 'times' => $times, 'tipo' => $request->tipo]);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param Request $request
	* @return Response
	*/
	public function store(Request $request)
	{
		$amistoso = new Amistoso();
		$amistoso->temporada_id = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('numero DESC')->pluck('id')->first();
		$amistoso->tipo = $request->input("tipo");
		$amistoso->time11_id = $request->input("time11_id");
		$amistoso->time21_id = $request->input("time21_id");
		if($request->modelo == "0" && $request->tipo == 0){
			$amistoso->time12_id = $request->input("time12_id");
			$amistoso->time22_id = $request->input("time22_id");
		}
		if($request->tipo == 0)
		$amistoso->valor = $request->input("valor");
		else
		$amistoso->valor = 0;
		$amistoso->save();
		if($request->tipo == 1){
			$amistoso = new Amistoso();
			$amistoso->temporada_id = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('numero DESC')->pluck('id')->first();
			$amistoso->tipo = $request->input("tipo");
			$amistoso->time11_id = $request->input("time21_id");
			$amistoso->time21_id = $request->input("time11_id");
			$amistoso->valor = 0;
			$amistoso->save();
		}
		return redirect()->route('amistosos.index', ['tipo' => $request->tipo])->with('message', 'Amistoso cadastrado com sucesso!');
	}

	/**
	* Update a old created resource in storage.
	*
	* @param Request $request
	* @return Response
	*/
	public function update(Request $request)
	{
		$amistoso = Amistoso::findOrFail($request->partida_id);
		$amistoso->resultado1 = $request->input("resultado1");
		$amistoso->resultado2 = $request->input("resultado2");
		if((isset($request->penalti1) && $request->penalti1 != '') && (isset($request->penalti2) && $request->penalti2 != '')){
			$amistoso->penalti1 = $request->input("penalti1");
			$amistoso->penalti2 = $request->input("penalti2");
		}
		$amistoso->save();
		// Finalizar lesões
		Lesao::whereIn('time_id',[$amistoso->time11_id,$amistoso->time21_id,$amistoso->time12_id,$amistoso->time22_id])->where('restantes','>',0)->where('temporada_id',$amistoso->temporada_id)->decrement('restantes');
		$lesionados = [];
		foreach ($request->gols_jogador1 as $key => $value) {
			if($value == '')
			continue;
			$gol = new Gol();
			$gol->jogador_id = $value;
			$gol->quantidade = $request->gols_qtd1[$key];
			$gol->campeonato = "Amistoso";
			$gol->temporada_id = $amistoso->temporada_id;
			$gol->partida_id = $amistoso->id;
			$gol->time_id = $amistoso->time11_id;
			$gol->save();
		}
		foreach ($request->gols_jogador2 as $key => $value) {
			if($value == '')
			continue;
			$gol = new Gol();
			$gol->jogador_id = $value;
			$gol->quantidade = $request->gols_qtd2[$key];
			$gol->campeonato = "Amistoso";
			$gol->temporada_id = $amistoso->temporada_id;
			$gol->partida_id = $amistoso->id;
			$gol->time_id = $amistoso->time21_id;
			$gol->save();
		}
		foreach ($request->cartoes_jogador1 as $key => $value) {
			if($value == '')
			continue;
			$cartao = new Cartao();
			$cartao->jogador_id = $value;
			$cartao->cor = $request->cartoes_cor1[$key];
			$cartao->campeonato = "Amistoso";
			$cartao->cumprido = 0;
			$cartao->temporada_id = $amistoso->temporada_id;
			$cartao->partida_id = $amistoso->id;
			$cartao->time_id = $amistoso->time11_id;
			$cartao->save();
		}
		foreach ($request->cartoes_jogador2 as $key => $value) {
			if($value == '')
			continue;
			$cartao = new Cartao();
			$cartao->jogador_id = $value;
			$cartao->cor = $request->cartoes_cor2[$key];
			$cartao->campeonato = "Amistoso";
			$cartao->temporada_id = $amistoso->temporada_id;
			$cartao->cumprido = 0;
			$cartao->partida_id = $amistoso->id;
			$cartao->time_id = $amistoso->time21_id;
			$cartao->save();
		}
		foreach ($request->lesoes_jogador1 as $key => $value) {
			if($value == '')
			continue;
			$lesao = new Lesao();
			$lesao->jogador_id = $value;
			if($request->lesoes_tipo1[$key] == 0)
			$rodadas = rand(1,2);
			else
			$rodadas = rand(3,7);
			$jogador = Jogador::findOrFail($value);
			$lesionados[$jogador->nome] = $rodadas;
			$lesao->rodadas = $rodadas;
			$lesao->restantes = $rodadas;
			$lesao->temporada_id = $amistoso->temporada_id;
			$lesao->partida_id = $amistoso->id;
			$lesao->time_id = $amistoso->time11_id;
			$lesao->save();
		}
		foreach ($request->lesoes_jogador2 as $key => $value) {
			if($value == '')
			continue;
			$lesao = new Lesao();
			$lesao->jogador_id = $value;
			if($request->lesoes_tipo2[$key] == 0)
			$rodadas = rand(1,2);
			else
			$rodadas = rand(3,7);
			$jogador = Jogador::findOrFail($value);
			$lesionados[$jogador->nome] = $rodadas;
			$lesao->rodadas = $rodadas;
			$lesao->restantes = $rodadas;
			$lesao->temporada_id = $amistoso->temporada_id;
			$lesao->partida_id = $amistoso->id;
			$lesao->time_id = $amistoso->time21_id;
			$lesao->save();
		}

		// Premiação
		if((isset($request->penalti1) && $request->penalti1 != '') && (isset($request->penalti2) && $request->penalti2 != '')){
			if($amistoso->penalti1 > $amistoso->penalti2){
				$v = Time::findOrFail($amistoso->time11_id);
				$v->dinheiro += $amistoso->valor;
				$v->save();
				$d = Time::findOrFail($amistoso->time21_id);
				if($amistoso->tipo == "0"){
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				}
			} else {
				$v = Time::findOrFail($amistoso->time21_id);
				$v->dinheiro += $amistoso->valor;
				$v->save();
				$d = Time::findOrFail($amistoso->time11_id);
				if($amistoso->tipo == "0"){
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				}
			}
		} else {
			if($amistoso->resultado1 > $amistoso->resultado2){
				$v = Time::findOrFail($amistoso->time11_id);
				$v->dinheiro += $amistoso->valor;
				$v->save();
				$d = Time::findOrFail($amistoso->time21_id);
				if($amistoso->tipo == "0"){
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				}
			} else {
				$v = Time::findOrFail($amistoso->time21_id);
				$v->dinheiro += $amistoso->valor;
				$v->save();
				$d = Time::findOrFail($amistoso->time11_id);
				if($amistoso->tipo == "0"){
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				}
			}
		}

		// Se tiver valor
		if($amistoso->valor != 0){
			$temporada = Temporada::findOrFail($amistoso->temporada_id);
			if($amistoso->tipo == "2"){
				Financeiro::create(['valor' => $amistoso->valor, 'operacao' => 0, 'descricao' => 'Campeão da Supercopa', 'time_id' => $v->id]);
				$temporada->supercopa_id = $v->id;
			}
			if($amistoso->tipo == "0"){
				Financeiro::create(['valor' => $amistoso->valor, 'operacao' => 0, 'descricao' => 'Vitória do Amistoso', 'time_id' => $v->id]);
				Financeiro::create(['valor' => $amistoso->valor, 'operacao' => 1, 'descricao' => 'Derrota no Amistoso', 'time_id' => $d->id]);
			}

			$request->tipo = 3;
			$temporada->save();
		}
		// Se for 2 contra 2
		if(!blank($amistoso->time12_id) && !blank($amistoso->time22_id)){
			if((isset($request->penalti1) && $request->penalti1 != '') && (isset($request->penalti2) && $request->penalti2 != '')){
				if($amistoso->penalti1 > $amistoso->penalti2){
					$v = Time::findOrFail($amistoso->time12_id);
					$v->dinheiro += $amistoso->valor;
					$v->save();
					$d = Time::findOrFail($amistoso->time22_id);
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				} else {
					$v = Time::findOrFail($amistoso->time22_id);
					$v->dinheiro += $amistoso->valor;
					$v->save();
					$d = Time::findOrFail($amistoso->time12_id);
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				}
			} else {
				if($amistoso->resultado1 > $amistoso->resultado2){
					$v = Time::findOrFail($amistoso->time12_id);
					$v->dinheiro += $amistoso->valor;
					$v->save();
					$d = Time::findOrFail($amistoso->time22_id);
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				} else {
					$v = Time::findOrFail($amistoso->time22_id);
					$v->dinheiro += $amistoso->valor;
					$v->save();
					$d = Time::findOrFail($amistoso->time12_id);
					$d->dinheiro -= $amistoso->valor;
					$d->save();
				}
			}
			if($amistoso->valor != 0){
				Financeiro::create(['valor' => $amistoso->valor, 'operacao' => 0, 'descricao' => 'Vitória do Amistoso', 'time_id' => $v->id]);
				Financeiro::create(['valor' => $amistoso->valor, 'operacao' => 1, 'descricao' => 'Derrota no Amistoso', 'time_id' => $d->id]);
			}
		}
		return redirect()->route('amistosos.index',['lesionados' => $lesionados, 'tipo' => $request->tipo])->with('message', 'Amistoso cadastrado com sucesso!');
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
