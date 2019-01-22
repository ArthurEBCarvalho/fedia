<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Financeiro;
use Illuminate\Http\Request;
use Auth;
use Session;

class FinanceiroController extends Controller {

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
			$order = "id DESC";
		}

		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$financeiros = Financeiro::where('time_id',Auth::user()->time(Session::get('era')->id)->id)->orderByRaw($order);
			}
			else{
				$params['filtro'] = $request->filtro;
				$params['valor'] = $request->valor;
				switch ($request->filtro) {
					case 'valor':
					$clausure = "valor = ".str_replace(",", ".", str_replace(".", "", $request->valor));
					break;
					case 'descricao':
					$clausure = "descricao LIKE '%$request->valor%'";
					break;
					case 'operacao':
					if(strpos(strtoupper($request->valor), 'EN') !== false)
						$clausure = "operacao = 0";
					else
						$clausure = "operacao = 1";
					break;
				}
				$financeiros = Financeiro::whereRaw("time_id = ".Auth::user()->time(Session::get('era')->id)->id." and $clausure")->orderByRaw($order);
			}
		}
		else
			$financeiros = Financeiro::where('time_id',Auth::user()->time(Session::get('era')->id)->id)->orderByRaw($order);
		$total = 0;
		foreach ($financeiros->get() as $value) {
			if($value->operacao == 0)
				$total += $value->valor;
			else
				$total -= $value->valor;
		}
		$financeiros = $financeiros->paginate(30);
		return view('financeiros.index', ["financeiros" => $financeiros, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret, "total" => $total, "params" => $params]);
	}

}
