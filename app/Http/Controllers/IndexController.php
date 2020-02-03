<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Era;
use App\Noticium;
use App\UserTime;
use App\Temporada;
use App\Financeiro;
use App\Cartao;
use App\Lesao;
use App\Gol;
use App\Partida;
use App\Time;
use App\Amistoso;
use App\Jogador;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

class IndexController extends Controller {

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        if($request->getRequestUri() == '/') $index = true;
        else $index = false;

        if(isset($request->temporada)) $temporada = Temporada::where('era_id',Session::get('era')->id)->where('numero',$request->temporada)->first();
        else $temporada = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('id DESC')->first();

        if(!$temporada) $temporada = Temporada::where('era_id',Session::get('era')->id)->orderByRaw('id DESC')->first();

        $times_id = UserTime::where('era_id',Session::get('era')->id)->pluck('time_id')->toArray();
        $gols = Gol::selectRaw('jogador_id,SUM(quantidade) as qtd')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('temporada_id',@$temporada->id)->groupBy('jogador_id')->orderBy('qtd','desc')->limit(5)->get();
        $aproveitamento = ['Vitória' => 0, 'Empate' => 0, 'Derrota' => 0];

        if($index){
            $noticias = Noticium::join('times','noticias.time_id','=','times.id')->select('noticias.id','noticias.titulo','noticias.subtitulo','noticias.imagem','noticias.created_at','times.nome')->orderBy('id','DESC')->limit(3)->get();
            $contratacoes = Financeiro::selectRaw('valor, SUBSTRING(descricao, 25, CHAR_LENGTH(descricao)-25) as nome')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('descricao','LIKE','%Contratação de Jogador%')->whereIn('time_id',$times_id)->orderBy('id','DESC')->limit(5)->get();
            $cartoes = Cartao::selectRaw('jogador_id,cor,campeonato,COUNT(*) as qtd')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('cumprido',0)->where('campeonato','!=','Amistoso')->where('temporada_id',@$temporada->id)->groupBy('jogador_id','cor','campeonato')->get();
            $lesoes = Lesao::selectRaw('jogador_id,restantes')->where('time_id',@Auth::user()->time(Session::get('era')->id)->id)->where('temporada_id',@$temporada->id)->where('restantes','!=',0)->get();

            $where_rodada = "";
            $is_liga = true;
            $is_copa = true;
        } else {
            if(!isset($request->campeonato)) {
                $is_liga = true;
                $is_copa = false;
            } else {
                if($request->campeonato == "0") {
                    $is_liga = true;
                    $is_copa = false;
                } else {
                    $is_liga = false;
                    $is_copa = true;
                }
            }

            switch ($request->turno) {
                case '2':
                $where_rodada = " and rodada > 9";
                break;

                case '1':
                $where_rodada = " and rodada < 10";
                break;

                default:
                $where_rodada = "";
                break;
            }

            $final = Amistoso::where('tipo',3)->where('temporada_id',@$temporada->id)->first();

            if(isset($final)){
                $jogadores = [];
                foreach (Jogador::all() as $key => $value) {
                    if(empty($jogadores[$value->time_id]))
                    $jogadores[$value->time_id] = [];
                    $jogadores[$value->time_id][] = $value;
                }
                $gols = Gol::where('partida_id',$final->id)->where('campeonato','Amistoso')->get();
                $cartoes = Cartao::where('partida_id',$final->id)->where('campeonato','Amistoso')->get();
                $lesoes = Lesao::where('partida_id',$final->id)->get();
            }
        }

        if(isset($temporada)){
            if($is_liga){
                // Liga
                $partidas = Partida::where('temporada_id',@$temporada->id)->where('campeonato','Liga')->whereRaw("resultado1 IS NOT NULL and resultado2 IS NOT NULL $where_rodada")->get();
                $times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
                $times = Time::whereIn('id',$times_id)->get()->keyBy('id');
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
                $mvps = Partida::join('jogadors','partidas.mvp_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.id as time_id,times.escudo,times.nome,jogadors.nome as jogador,COUNT(partidas.mvp_id) as qtd')->where('temporada_id',@$temporada->id)->where('campeonato','Liga')->where('time_id','!=','11')->whereNotNull('mvp_id')->groupBy('partidas.mvp_id','times.id','jogadors.id')->orderBy('qtd','desc')->limit(10)->get()->toArray();
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
                if(!empty($sort)) array_multisort($sort['qtd'], SORT_DESC, $sort['colocacao'], SORT_ASC, $mvps);

                $artilheiros = [];
                // Artilheiros Liga
                $artilheiros['Liga'] = DB::table('gols')->join('jogadors','gols.jogador_id','=','jogadors.id')->join('times','jogadors.time_id','=','times.id')->selectRaw('times.nome,times.escudo,jogadors.nome as jogador,SUM(quantidade) as qtd')->where('temporada_id',@$temporada->id)->where('campeonato','Liga')->groupBy('jogadors.nome','times.nome','times.escudo')->orderBy('qtd','desc')->limit(10)->get();
            }

            if($is_copa){
                // Copa
                $copa = Partida::where('temporada_id',@$temporada->id)->where('campeonato','Copa')->get()->keyBy(function($item){return $item['ordem']."|".$item['rodada'];});
                foreach ($copa as $key => $value) {
                    if(is_null($value->resultado1) || is_null($value->resultado2)) continue;
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
            }

            if($index) return view("index", ['temporada' => $temporada, 'classificacao' => $classificacao, 'copa' => $copa, 'times' => $times, 'artilheiros' => $artilheiros, 'mvps' => $mvps, 'contratacoes' => $contratacoes, 'lesoes' => $lesoes, 'cartoes' => $cartoes, 'gols' => $gols, 'noticias' => $noticias, 'aproveitamento' => $aproveitamento, 'era' => Session::get('era')]);
            else return view("partidas.tabelas", ['temporada' => $temporada, 'classificacao' => @$classificacao, 'copa' => @$copa, 'times' => @$times, 'artilheiros' => $artilheiros, 'mvps' => @$mvps, 'aproveitamento' => $aproveitamento, 'era' => Session::get('era'), 'is_liga' => $is_liga, 'is_copa' => $is_copa, 'turno' => $request->turno, 'campeonato' => $request->campeonato, 'final' => $final, 'jogadores' => @$jogadores, 'gols' => @$gols, 'cartoes' => @$cartoes, 'lesoes' => @$lesoes]);
        } else {
            if($index) return view("index", ['contratacoes' => $contratacoes, 'lesoes' => $lesoes, 'cartoes' => $cartoes, 'gols' => $gols, 'noticias' => $noticias, 'era' => Session::get('era')]);
            else return view("partidas.tabelas", ['is_liga' => $is_liga, 'is_copa' => $is_copa, 'turno' => $request->turno, 'campeonato' => $request->campeonato, 'final' => $final, 'jogadores' => @$jogadores, 'gols' => @$gols, 'cartoes' => @$cartoes, 'lesoes' => @$lesoes]);
        }
    }

}
