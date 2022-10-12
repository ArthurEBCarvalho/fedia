<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Transferencium;
use App\Time;
use App\UserTime;
use App\Financeiro;
use App\Jogador;
use Illuminate\Http\Request;
use DB;
use Session;

class TransferenciumController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$params = [];
		(strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
		(strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
		(strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
		if(isset($request->order)){
			$order = $request->order;
			$params['order'] = $request->order;
		} else {
			$order = "transferencias.created_at DESC";
		}

		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$transferencias = \DB::table('transferencias')->join(DB::raw('times time1'),'time1.id','=','transferencias.time1_id')->join(DB::raw('times time2'),'time2.id','=','transferencias.time2_id')->join('jogadors','jogadors.id','=','transferencias.jogador_id')->select('transferencias.id','transferencias.created_at', 'jogadors.nome as jogador','transferencias.valor','time1.nome as time1','time2.nome as time2')->where('transferencias.era_id',Session::get('era')->id)->orderByRaw($order)->paginate(30);
			}
			else{
				$params['filtro'] = $request->filtro;
				$params['valor'] = $request->valor;
				switch ($request->filtro) {
					case 'data':
					$clausure = "transferencias.created_at between '".date_format(date_create_from_format('d/m/Y', $request->valor), 'Y-m-d')." 00:00:00' and '".date_format(date_create_from_format('d/m/Y', $request->valor), 'Y-m-d')." 23:59:59'";
					break;
					case 'valor':
					$clausure = "valor = ".str_replace(",", ".", str_replace(".", "", str_replace("€", "", $request->valor)));
					break;
					case 'jogador':
					$clausure = "jogadors.nome LIKE '%$request->valor%'";
					break;
					case 'time1':
					$clausure = "time1.nome LIKE '%$request->valor%'";
					break;
					case 'time2':
					$clausure = "time2.nome LIKE '%$request->valor%'";
					break;
				}
				$transferencias = \DB::table('transferencias')->join(DB::raw('times time1'),'time1.id','=','transferencias.time1_id')->join(DB::raw('times time2'),'time2.id','=','transferencias.time2_id')->join('jogadors','jogadors.id','=','transferencias.jogador_id')->select('transferencias.id','transferencias.created_at', 'jogadors.nome as jogador','transferencias.valor','time1.nome as time1','time2.nome as time2')->whereRaw($clausure)->where('transferencias.era_id',Session::get('era')->id)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$transferencias = \DB::table('transferencias')->join(DB::raw('times time1'),'time1.id','=','transferencias.time1_id')->join(DB::raw('times time2'),'time2.id','=','transferencias.time2_id')->join('jogadors','jogadors.id','=','transferencias.jogador_id')->select('transferencias.id','transferencias.created_at', 'jogadors.nome as jogador','transferencias.valor','time1.nome as time1','time2.nome as time2')->where('transferencias.era_id',Session::get('era')->id)->orderByRaw($order)->paginate(30);
		return view('transferencias.index', ["transferencias" => $transferencias, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret, "color" => $request->color, "params" => $params]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$transferencium = new Transferencium();
		$externo = Time::where('nome','Mercado Externo')->pluck('id')->first();
		$times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		$times_id[] = $externo;
		$times = Time::whereIn('id',$times_id)->orderBy('nome')->lists('nome','id')->all();
		$jogadores = [];
		foreach (Jogador::whereIn('time_id',$times_id)->get() as $key => $value) {
			if(empty($jogadores[$value->time_id]))
				$jogadores[$value->time_id] = [];
			$jogadores[$value->time_id][] = $value;
		}
		return view('transferencias.form', ["transferencium" => $transferencium, "url" => "transferencias.store", "method" => "post", "times" => $times, "jogadores" => $jogadores]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$destino = Time::findOrFail($request->input("time2_id"));
		if($destino->dinheiro < str_replace(",", ".", str_replace(".", "", $request->input("valor")))){
			return redirect()->route('transferencias.index', ['color' => 'red'])->with('message', "O $destino->nome não tem dinheiro suficiente para concretizar a contratação!");
		} else {
			$transferencium = new Transferencium();
			$transferencium->era_id = Session::get('era')->id;
			$transferencium->valor = str_replace(",", ".", str_replace(".", "", $request->input("valor")));
			$transferencium->time1_id = $request->input("time1_id");
			$transferencium->time2_id = $request->input("time2_id");
			$time1 = Time::findOrFail($request->input("time1_id"));
			if($time1->nome == "Mercado Externo"){
				$jogador = new Jogador();
				$jogador->nome = $request->input("jogador");
				$jogador->overall = $request->input("overall");
				$jogador->idade = $request->input("idade");
				$jogador->posicoes = join('|',$request->input("posicoes"));
				$jogador->status = '0';
				$jogador->valor = str_replace(",", ".", str_replace(".", "", $request->input("valor")));
				$jogador->time_id = $request->input("time2_id");
				$jogador->save();
			} else {
				$jogador = Jogador::findOrFail($request->input("jogador_id"));
				$jogador->time_id = $request->input("time2_id");
				if(isset($request->atualiza_valor))
					$jogador->valor = $transferencium->valor;
				$jogador->save();
			}
			$transferencium->jogador_id = $jogador->id;
			$transferencium->save();
			if(!is_null($time1)){
				$time1->dinheiro += floatval(str_replace(",", ".", str_replace(".", "", $request->input("valor"))));
				$time1->save();
				Financeiro::create(['valor' => floatval(str_replace(",", ".", str_replace(".", "", $request->input("valor")))), 'operacao' => 0, 'descricao' => 'Venda de Jogador ('.$jogador->nome.')', 'time_id' => $time1->id]);
			}
			$time2 = Time::findOrFail($request->input("time2_id"));
			if(!is_null($time2)){
				$time2->dinheiro -= floatval(str_replace(",", ".", str_replace(".", "", $request->input("valor"))));
				$time2->save();
				Financeiro::create(['valor' => floatval(str_replace(",", ".", str_replace(".", "", $request->input("valor")))), 'operacao' => 1, 'descricao' => 'Contratação de Jogador ('.$jogador->nome.')', 'time_id' => $time2->id]);
			}
			return redirect()->route('transferencias.index', ['color' => 'green'])->with('message', 'Transferência cadastrada com sucesso!');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$transferencium = Transferencium::findOrFail($id);
		$externo = Time::where('nome','Mercado Externo')->pluck('id')->first();
		$times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		$times_id[] = $externo;
		$times = Time::whereIn('id',$times_id)->orderBy('nome')->lists('nome','id')->all();
		$jogadores = [];
		foreach (Jogador::whereIn('time_id',$times_id)->get() as $key => $value) {
			if(empty($jogadores[$value->time_id]))
				$jogadores[$value->time_id] = [];
			$jogadores[$value->time_id][] = $value;
		}
		return view('transferencias.form', ["transferencium" => $transferencium, "url" => "transferencias.update", "method" => "put", "times" => $times]);
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
		$transferencium = Transferencium::findOrFail($id);
		$transferencium->jogador = $request->input("jogador");
		$transferencium->valor = str_replace(",", ".", str_replace(".", "", $request->input("valor")));
		$transferencium->time1 = $request->input("time1");
		$transferencium->time2 = $request->input("time2");
		$transferencium->save();
		return redirect()->route('transferencias.index')->with('message', 'Transferência atualizada com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$transferencium = Transferencium::findOrFail($id);
		$jogador = Jogador::findOrFail($transferencium->jogador_id);
		$jogador->time_id = $transferencium->time1_id;
		$jogador->save();
		$time1 = Time::findOrFail($transferencium->time1_id);
		if(!is_null($time1)){
			$time1->dinheiro -= $transferencium->valor;
			$time1->save();
			Financeiro::where('descricao',"Venda de Jogador ($jogador->nome)")->where('time_id',$time1->id)->delete();
		}
		$time2 = Time::findOrFail($transferencium->time2_id);
		if(!is_null($time2)){
			$time2->dinheiro += $transferencium->valor;
			$time2->save();
			Financeiro::where('descricao',"Contratação de Jogador ($jogador->nome)")->where('time_id',$time2->id)->delete();
		}
		$transferencium->delete();
		return redirect()->route('transferencias.index')->with('message', 'Transferência deletado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function elencos(Request $request)
	{
		$registros = [];
		$posicoes = ['PE' => 'Ataque', 'ATA' => 'Ataque', 'PD' => 'Ataque', 'MAE' => 'Meio Campo', 'SA' => 'Ataque', 'MAD' => 'Meio Campo', 'MEI' => 'Meio Campo', 'ME' => 'Meio Campo', 'MC' => 'Meio Campo', 'MD' => 'Meio Campo', 'VOL' => 'Meio Campo', 'ADE' => 'Defesa', 'LE' => 'Defesa', 'ZAG' => 'Defesa', 'LD' => 'Defesa', 'ADD' => 'Defesa', 'GOL' => 'Goleiro'];
		$times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		if(!blank($request->time) && $request->time != "Todos")
			$times = Time::where('id',$request->time)->get();
		else
			$times = Time::whereIn('id',$times_id)->get();
		$options = Time::whereIn('id',$times_id)->get();
		$jogadores = Jogador::whereIn('time_id',$times_id)->orderBy('overall','DESC')->get();
		foreach ($times as $key => $value)
			$registros[$value->id] = ['Goleiro' => [], 'Defesa' => [], 'Meio Campo' => [],'Ataque' => []];
		foreach ($jogadores as $key => $value) {
			if(!isset($registros[$value->time_id]))
				continue;
			$registros[$value->time_id][$value->posicao()][] = $value;
		}
		return view('transferencias.elencos', ["registros" => $registros, "times" => $times, "time" => $request->time, "options" => $options]);
	}

	/**
	 * Update status from Jogador via Ajax GET request
	 *
	 * @param  Request  $request
	 * @return Json
	 */
	public function update_status(Request $request)
	{
		Jogador::findOrFail($request->id)->update(['status' => $request->status]);
		return response()->json(['response' => 'Status Atualizado com Sucesso!']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function jogadores(Request $request)
	{
		$params = [];
		(strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
		(strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
		(strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
		if(isset($request->order)){
			$order = $request->order;
			$params['order'] = $request->order;
		} else {
			$order = "overall DESC";
		}

		$times_id = UserTime::where("era_id",Session::get('era')->id)->pluck('time_id')->toArray();
		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$jogadores = \DB::table('jogadors')->join(DB::raw('times'),'times.id','=','jogadors.time_id')->select('jogadors.nome','jogadors.posicoes', 'jogadors.idade','jogadors.overall','jogadors.status','jogadors.valor','times.nome as time')->whereIn('jogadors.time_id',$times_id)->orderByRaw($order)->paginate(30);
			}
			else{
				$params['filtro'] = $request->filtro;
				$params['valor'] = $request->valor;
				if(in_array($request->filtro, ['jogadors.nome','jogadors.posicoes','times.nome']))
					$jogadores = \DB::table('jogadors')->join(DB::raw('times'),'times.id','=','jogadors.time_id')->select('jogadors.nome','jogadors.posicoes', 'jogadors.idade','jogadors.overall','jogadors.status','jogadors.valor','times.nome as time')->whereIn('jogadors.time_id',$times_id)->where($request->filtro,'LIKE',"%$request->valor%")->orderByRaw($order)->paginate(30);
				elseif($request->filtro == 'jogadors.valor')
					$jogadores = \DB::table('jogadors')->join(DB::raw('times'),'times.id','=','jogadors.time_id')->select('jogadors.nome','jogadors.posicoes', 'jogadors.idade','jogadors.overall','jogadors.status','jogadors.valor','times.nome as time')->whereIn('jogadors.time_id',$times_id)->where($request->filtro,str_replace(",", ".", str_replace(".", "", str_replace("€", "", $request->valor))))->orderByRaw($order)->paginate(30);
				else
					$jogadores = \DB::table('jogadors')->join(DB::raw('times'),'times.id','=','jogadors.time_id')->select('jogadors.nome','jogadors.posicoes', 'jogadors.idade','jogadors.overall','jogadors.status','jogadors.valor','times.nome as time')->whereIn('jogadors.time_id',$times_id)->where($request->filtro,$request->valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$jogadores = \DB::table('jogadors')->join(DB::raw('times'),'times.id','=','jogadors.time_id')->select('jogadors.nome','jogadors.posicoes', 'jogadors.idade','jogadors.overall','jogadors.status','jogadors.valor','times.nome as time')->whereIn('jogadors.time_id',$times_id)->orderByRaw($order)->paginate(30);
		return view('transferencias.jogadores', ["jogadores" => $jogadores, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret, "STATUS" => ['Negociável','Inegociável','À Venda'], 'params' => $params]);
	}

	/**
	 * Calcula o valor de jogadores via javascript.
	 *
	 * @return Response
	 */
	public function calcula_valor()
	{
		return view('transferencias.calcula_valor', ["posicoes" => ['GOL' => 'GOL','ADD' => 'ADD','LD' => 'LD','ZAG' => 'ZAG','LE' => 'LE','ADE' => 'ADE','VOL' => 'VOL','MD' => 'MD','MC' => 'MC','ME' => 'ME','MEI' => 'MEI','MAD' => 'MAD','SA' => 'SA','MAE' => 'MAE','PD' => 'PD','ATA' => 'ATA','PE' => 'PE']]);
	}

	/**
	 * Exibe a tabela de valores dos jogadores.
	 *
	 * @return Response
	 */
	public function valores()
	{
		return view('transferencias.valores');
	}

}
