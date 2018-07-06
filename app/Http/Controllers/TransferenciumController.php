<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Transferencium;
use App\Time;
use Illuminate\Http\Request;

class TransferenciumController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		(strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
		(strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
		(strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
		(isset($request->order)) ? $order = $request->order : $order = "transferencias.created_at DESC";
		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$transferencias = Transferencium::orderByRaw($order)->paginate(30);
			}
			else{
				switch ($request->filtro) {
					case 'data':
					$valor = date_format(date_create_from_format('d/m/Y', $request->valor), 'Y-m-d');
					break;
					case 'valor':
					$valor = str_replace(",", ".", str_replace(".", "", $request->valor));
					break;
					default:
					$valor = $request->valor;
					break;
				}
				$transferencias = Transferencium::where($request->filtro, $valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$transferencias = Transferencium::orderByRaw($order)->paginate(30);
		return view('administracao.transferencias.index', ["transferencias" => $transferencias, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$transferencium = new Transferencium();
		$times = Time::lists('nome','id')->all();
		return view('administracao.transferencias.form', ["transferencium" => $transferencium, "url" => "administracao.transferencias.store", "method" => "post", "times" => $times]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$transferencium = new Transferencium();
		$transferencium->jogador = $request->input("jogador");
		$transferencium->valor = str_replace(",", ".", str_replace(".", "", $request->input("valor")));
		$transferencium->time1 = $request->input("time1");
		$transferencium->time2 = $request->input("time2");
		$transferencium->save();
		$time1 = Time::where('nome',$request->input("time1"))->first();
		if(!is_null($time1)){
			$time1->dinheiro += floatval(str_replace(",", ".", str_replace(".", "", $request->input("valor"))));
			$time1->save();
		}
		$time2 = Time::where('nome',$request->input("time2"))->first();
		if(!is_null($time2)){
			$time2->dinheiro -= floatval(str_replace(",", ".", str_replace(".", "", $request->input("valor"))));
			$time2->save();
		}
		return redirect()->route('administracao.transferencias.index')->with('message', 'Transferência cadastrada com sucesso!');
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
		$times = Time::lists('nome','id')->all();
		return view('administracao.transferencias.form', ["transferencium" => $transferencium, "url" => "administracao.transferencias.update", "method" => "put", "times" => $times]);
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
		return redirect()->route('administracao.transferencias.index')->with('message', 'Transferência atualizada com sucesso!');
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
		$transferencium->delete();
		return redirect()->route('administracao.transferencias.index')->with('message', 'Transferência deletado com sucesso!');
	}

}
