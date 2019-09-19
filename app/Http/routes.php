<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get("auth/logout", function () {
	Auth::logout();
	return redirect('/');
});


// Authentication routes...
// Auth::routes();
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
// Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', function () {
		$noticias = App\Noticium::join('times','noticias.time_id','=','times.id')->select('noticias.id','noticias.titulo','noticias.subtitulo','noticias.imagem','noticias.created_at','times.nome')->orderBy('id','DESC')->limit(3)->get();
		$times_id = App\UserTime::where('era_id',Session::get('era')->id)->pluck('time_id')->toArray();
		$temporada = App\Temporada::where('era_id',Session::get('era')->id)->orderByRaw('id DESC')->first();
		$contratacoes = App\Financeiro::selectRaw('valor, SUBSTRING(descricao, 25, CHAR_LENGTH(descricao)-25) as nome')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('descricao','LIKE','%Contratação de Jogador%')->whereIn('time_id',$times_id)->orderBy('id','DESC')->limit(5)->get();
		$cartoes = App\Cartao::selectRaw('jogador_id,cor,campeonato,COUNT(*) as qtd')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('cumprido',0)->where('campeonato','!=','Amistoso')->where('temporada_id',@$temporada->id)->groupBy('jogador_id','cor','campeonato')->get();
		$lesoes = App\Lesao::selectRaw('jogador_id,restantes')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('temporada_id',@$temporada->id)->where('restantes','!=',0)->get();
		$gols = App\Gol::selectRaw('jogador_id,SUM(quantidade) as qtd')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('temporada_id',@$temporada->id)->groupBy('jogador_id')->orderBy('qtd','desc')->limit(5)->get();
		$aproveitamento = ['Vitória' => 0, 'Empate' => 0, 'Derrota' => 0];
		// Liga
		if(isset($temporada)){
			$partidas = App\Partida::where('temporada_id',@$temporada->id)->where('campeonato','Liga')->whereRaw("resultado1 IS NOT NULL and resultado2 IS NOT NULL")->get();
			$times = App\Time::whereRaw("nome != 'Mercado Externo' and id IN (".join(',',$times_id).")")->get()->keyBy('id');
			$classificacao = [];
			foreach ($times as $key => $value) {
				$classificacao[$value->id] = ['P' => 0, 'J' => 0, 'V' => 0, 'E' => 0, 'D' => 0, 'GP' => 0, 'GC' => 0, 'SG' => 0, 'id' => $value->id, 'nome' => $times[$value->id]->nome, 'escudo' => $times[$value->id]->escudo];
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
					if($value->time1_id == @Auth::user()->time(Session::get('era')->id)->id)
						$aproveitamento['Vitória'] += 1;
					elseif($value->time2_id == @Auth::user()->time(Session::get('era')->id)->id)
						$aproveitamento['Derrota'] += 1;
				} elseif ($value->resultado1 == $value->resultado2) {
					$classificacao[$value->time1_id]["P"] += 1;
					$classificacao[$value->time2_id]["P"] += 1;
					$classificacao[$value->time1_id]["E"] += 1;
					$classificacao[$value->time2_id]["E"] += 1;
					if($value->time1_id == @Auth::user()->time(Session::get('era')->id)->id || $value->time2_id == @Auth::user()->time(Session::get('era')->id)->id)
						$aproveitamento['Empate'] += 1;
				} else {
					$classificacao[$value->time2_id]["P"] += 3;
					$classificacao[$value->time2_id]["V"] += 1;
					$classificacao[$value->time1_id]["D"] += 1;
					if($value->time1_id == @Auth::user()->time(Session::get('era')->id)->id)
						$aproveitamento['Derrota'] += 1;
					elseif($value->time2_id == @Auth::user()->time(Session::get('era')->id)->id)
						$aproveitamento['Vitória'] += 1;
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

			// MVPS ordenados por quantidade e colocação na Liga
			$mvps = App\Partida::join('jogadors','partidas.mvp_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.id as time_id,times.escudo,times.nome,jogadors.nome as jogador,COUNT(partidas.mvp_id) as qtd')->where('temporada_id',@$temporada->id)->where('campeonato','Liga')->whereNotNull('mvp_id')->groupBy('partidas.mvp_id','times.id','jogadors.id')->orderBy('qtd','desc')->limit(10)->get()->toArray();
			$sort = array();
			foreach ($mvps as $key => $value){
				foreach ($classificacao as $k => $v){
					if($v['nome'] == $value['nome']){
						$sort['colocacao'][$key] = $k;
						break;
					}
				}
				$sort['qtd'][$key] = $value['qtd'];
			}
			if(!empty($sort))
				array_multisort($sort['qtd'], SORT_DESC, $sort['colocacao'], SORT_ASC, $mvps);

			$artilheiros = [];
			// Artilheiros Liga
			$artilheiros['Liga'] = DB::table('gols')->join('jogadors','gols.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.nome,times.escudo,jogadors.nome as jogador,SUM(quantidade) as qtd')->where('temporada_id',@$temporada->id)->where('campeonato','Liga')->groupBy('jogadors.nome','times.nome','times.escudo')->orderBy('qtd','desc')->limit(10)->get();

			// Copa
			$copa = App\Partida::where('temporada_id',@$temporada->id)->where('campeonato','Copa')->get()->keyBy(function($item){return $item['ordem']."|".$item['rodada'];});
			foreach ($copa as $key => $value) {
				if(is_null($value->resultado1) || is_null($value->resultado2))
					continue;
				if($value->time1_id == @Auth::user()->time(Session::get('era')->id)->id){
					if($value->resultado1 > $value->resultado2)
						$aproveitamento['Vitória'] += 1;
					elseif ($value->resultado1 == $value->resultado2)
						$aproveitamento['Empate'] += 1;
					else
						$aproveitamento['Derrota'] += 1;
				} elseif($value->time2_id == @Auth::user()->time(Session::get('era')->id)->id){
					if($value->resultado1 > $value->resultado2)
						$aproveitamento['Derrota'] += 1;
					elseif ($value->resultado1 == $value->resultado2)
						$aproveitamento['Empate'] += 1;
					else
						$aproveitamento['Derrota'] += 1;
				}
			}

			// Artilheiros Copa
			$artilheiros['Copa'] = DB::table('gols')->join('jogadors','gols.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.nome,times.escudo,jogadors.nome as jogador,SUM(quantidade) as qtd')->where('temporada_id',@$temporada->id)->where('campeonato','Copa')->groupBy('jogadors.nome','times.nome','times.escudo')->orderBy('qtd','desc')->limit(8)->get();

			return view("index", ['temporada' => $temporada, 'classificacao' => $classificacao, 'copa' => $copa, 'times' => $times, 'artilheiros' => $artilheiros, 'mvps' => $mvps, 'contratacoes' => $contratacoes, 'lesoes' => $lesoes, 'cartoes' => $cartoes, 'gols' => $gols, 'noticias' => $noticias, 'aproveitamento' => $aproveitamento, 'era' => Session::get('era')]);
		} else {
			return view("index", ['contratacoes' => $contratacoes, 'lesoes' => $lesoes, 'cartoes' => $cartoes, 'gols' => $gols, 'noticias' => $noticias, 'era' => Session::get('era')]);
		}

	});

Route::resource("users","UserController");
Route::resource("administracao/eras","EraController");
Route::resource("times","TimeController");
Route::resource("transferencias","TransferenciumController");
Route::resource("partidas","PartidaController");
Route::resource("financeiros","FinanceiroController");
Route::resource("amistosos","AmistosoController");
Route::resource("noticias","NoticiumController");

Route::get('user_verificar_password', 'UserController@verificar_senha');
Route::get('user_verificar_login', 'UserController@verificar_login');

Route::get("partidas_temporadas", ['as' => 'partidas.temporadas', 'uses' => 'PartidaController@temporadas']);
Route::get("partidas_temporada_store", ['as' => 'partidas.temporada_store', 'uses' => 'PartidaController@temporada_store']);
Route::post("partidas_temporada_fotos", ['as' => 'partidas.temporada_fotos', 'uses' => 'PartidaController@temporada_fotos']);
Route::get("indisponiveis", ['as' => 'partidas.indisponiveis', 'uses' => 'PartidaController@indisponiveis']);
Route::get("partidas_time", ['as' => 'partidas.partidas', 'uses' => 'PartidaController@partidas']);
Route::get("elencos", ['as' => 'transferencias.elencos', 'uses' => 'TransferenciumController@elencos']);
Route::get("elencos_atualiza_status", 'TransferenciumController@update_status');
Route::get("jogadores", ['as' => 'transferencias.jogadores', 'uses' => 'TransferenciumController@jogadores']);
Route::get("calcula_valor", ['as' => 'transferencias.calcula_valor', 'uses' => 'TransferenciumController@calcula_valor']);
Route::post("administracao/eras_change", ['as' => 'administracao.eras.change', 'uses' => 'EraController@change']);
Route::get("administracao/multa_create", ['as' => 'administracao.users.multa_create', 'uses' => 'UserController@multa_create']);
Route::post("administracao/multa_store", ['as' => 'administracao.users.multa_store', 'uses' => 'UserController@multa_store']);
Route::get("administracao/ausencia_create", ['as' => 'administracao.users.ausencia_create', 'uses' => 'UserController@ausencia_create']);
Route::post("administracao/ausencia_store", ['as' => 'administracao.users.ausencia_store', 'uses' => 'UserController@ausencia_store']);
Route::get("administracao/wo_create", ['as' => 'administracao.users.wo_create', 'uses' => 'UserController@wo_create']);
Route::post("administracao/wo_store", ['as' => 'administracao.users.wo_store', 'uses' => 'UserController@wo_store']);
Route::get("administracao/copa_create", ['as' => 'administracao.users.copa_create', 'uses' => 'UserController@copa_create']);
Route::post("administracao/copa_store", ['as' => 'administracao.users.copa_store', 'uses' => 'UserController@copa_store']);

// Legislação
Route::get('legislacao/premiacoes', function (){ return view("legislacao.premiacoes"); });
Route::get("legislacao/regras", function() { return Redirect::to("Regras.pdf"); });

//Artilharia
Route::get('artilharia', 'ArtilhariaController@index');


});

Route::get("noticia/{id}","NoticiumController@show");