<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Financeiro;
use Illuminate\Http\Request;
use Auth;

class FinanceiroController extends Controller {

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
		(isset($request->order)) ? $order = $request->order : $order = "id DESC";
		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$financeiros = Financeiro::where('time_id',Auth::user()->time()->id)->orderByRaw($order);
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
				$financeiros = Financeiro::where('time_id',Auth::user()->time()->id)->where($request->filtro, $valor)->orderByRaw($order);
			}
		}
		else
			$financeiros = Financeiro::where('time_id',Auth::user()->time()->id)->orderByRaw($order);
		$total = 0;
		foreach ($financeiros->get() as $value) {
			if($value->operacao == 0)
				$total += $value->valor;
			else
				$total -= $value->valor;
		}
		$financeiros = $financeiros->paginate(30);
		return view('financeiros.index', ["financeiros" => $financeiros, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret, "total" => $total]);
	}

}
