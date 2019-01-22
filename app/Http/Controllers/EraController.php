<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Era;
use Illuminate\Http\Request;
use Session;

class EraController extends Controller {

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
			$order = "id";
		}

		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$eras = Era::orderByRaw($order)->paginate(30);
			}
			else{
				$params['filtro'] = $request->filtro;
				$params['valor'] = $request->valor;
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
				$eras = Era::where($request->filtro, $valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$eras = Era::orderByRaw($order)->paginate(30);
		return view('administracao.eras.index', ["eras" => $eras, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret, "params" => $params]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$era = new Era();
		return view('administracao.eras.form', ["era" => $era, "url" => "administracao.eras.store", "method" => "post"]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$era = new Era();
		$era->nome = $request->input("nome");
		$era->save();
		return redirect()->route('administracao.eras.index')->with('message', 'Era cadastrado com sucesso!');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$era = Era::findOrFail($id);
		return view('administracao.eras.form', ["era" => $era, "url" => "administracao.eras.update", "method" => "put"]);
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
		$era = Era::findOrFail($id);
		$era->nome = $request->input("nome");
		$era->save();
		return redirect()->route('administracao.eras.index')->with('message', 'Era atualizado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$era = Era::findOrFail($id);
		$era->delete();
		return redirect()->route('administracao.eras.index')->with('message', 'Era deletado com sucesso!');
	}

	/**
	 * Change the era from Session.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function change(Request $request)
	{
		Session::put('era',Era::findOrFail($request->id));
		return redirect()->back()->with('message', 'Era alterada com sucesso!');
	}

}
