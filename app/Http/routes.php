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
	return redirect('/administracao/users');
});


// Authentication routes...
// Auth::routes();
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
// Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::group(['before' => 'auth'], function() {
	Route::get('/', function () {
		// Liga
		$temporada = App\Partida::all()->max('temporada');
		if(isset($temporada)){
			$partidas = App\Partida::where('temporada',$temporada)->where('campeonato','Liga')->whereRaw("resultado1 IS NOT NULL && resultado2 IS NOT NULL")->get();
			$times = App\Time::all()->keyBy('id');
			$classificacao = [];
			foreach ($times as $key => $value) {
				$classificacao[$value->id] = ['P' => 0, 'J' => 0, 'V' => 0, 'E' => 0, 'D' => 0, 'GP' => 0, 'GC' => 0, 'SG' => 0, 'nome' => $times[$value->id]->nome, 'escudo' => $times[$value->id]->escudo];
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

			$artilheiros = [];
		// Artilheiros Liga
			$artilheiros['Liga'] = DB::table('gols')->join('times','gols.time_id','=','times.id')->selectRaw('times.nome,times.escudo,jogador,SUM(quantidade) as qtd')->where('temporada',$temporada)->where('campeonato','Liga')->groupBy('jogador')->orderBy('qtd','desc')->get();

		// Copa
			$copa = App\Partida::where('temporada',$temporada)->where('campeonato','copa')->get()->keyBy(function($item){return $item['ordem']."|".$item['rodada'];});

		// Artilheiros Copa
			$artilheiros['Copa'] = DB::table('gols')->join('times','gols.time_id','=','times.id')->selectRaw('times.nome,times.escudo,jogador,SUM(quantidade) as qtd')->where('temporada',$temporada)->where('campeonato','Copa')->groupBy('jogador')->orderBy('qtd','desc')->get();

			return view("index", ['temporada' => $temporada, 'classificacao' => $classificacao, 'copa' => $copa, 'times' => $times, 'artilheiros' => $artilheiros]);
		} else {
			return view("index");
		}

	});

	Route::resource("administracao/users","UserController");
	Route::resource("times","TimeController");
	Route::resource("administracao/transferencias","TransferenciumController");
	Route::resource("administracao/partidas","PartidaController");

	Route::get('user_verificar_password', 'UserController@verificar_senha');
	Route::get('user_verificar_login', 'UserController@verificar_login');

	Route::get("administracao/temporadas", ['as' => 'administracao.partidas.temporadas', 'uses' => 'PartidaController@temporadas']);
	Route::get("administracao/temporada_store", ['as' => 'administracao.partidas.temporada_store', 'uses' => 'PartidaController@temporada_store']);

});
