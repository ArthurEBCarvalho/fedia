<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Financeiro;
use App\Time;
use App\UserTime;
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
		if(isset($request->time_id))
			$time = Time::findOrFail($request->time_id);
		else
			$time = Auth::user()->time(Session::get('era')->id);

		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$financeiros = Financeiro::where('time_id',$time->id)->orderByRaw($order);
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
				$financeiros = Financeiro::whereRaw("time_id = $time->id and $clausure")->orderByRaw($order);
			}
		}
		else
			$financeiros = Financeiro::where('time_id',$time->id)->orderByRaw($order);
		$total = 0;
		foreach ($financeiros->get() as $value) {
			if($value->operacao == 0)
				$total += $value->valor;
			else
				$total -= $value->valor;
		}
		$financeiros = $financeiros->paginate(30);
		$times = Time::whereIn('id',UserTime::where('era_id',Session::get('era')->id)->pluck('time_id')->toArray())->lists('nome','id')->all();
		return view('financeiros.index', ["financeiros" => $financeiros, "filtro" => $request->filtro, "valor" => $request->valor, "time" => $time, "times" => $times, "signal" => $signal, "param" => $param, "caret" => $caret, "total" => $total, "params" => $params]);
	}

}
