<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Noticium;
use App\Time;
use Illuminate\Http\Request;
use File;
use Storage;
use Auth;
use Session;

class NoticiumController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$noticias = Noticium::join('times','noticias.time_id','=','times.id')->select('noticias.id','noticias.titulo','noticias.subtitulo','noticias.imagem','noticias.created_at','times.nome')->orderBy('id','DESC')->paginate(30);
			}
			else{
				switch ($request->filtro) {
					case 'data':
					$valor = date_format(date_create_from_format('d/m/Y', $request->valor), 'Y-m-d');
					$where = "created_at between '".date_format(date_create_from_format('d/m/Y', $request->valor), 'Y-m-d')." 00:00:00' and '".date_format(date_create_from_format('d/m/Y', $request->valor), 'Y-m-d')." 23:59:59'";
					break;
					case 'time':
					$where = "times.nome LIKE '%$request->valor%'";
					break;
					default:
					$where = "$request->filtro LIKE '%$request->valor%'";
					break;
				}
				$noticias = Noticium::join('times','noticias.time_id','=','times.id')->select('noticias.id','noticias.titulo','noticias.subtitulo','noticias.imagem','noticias.created_at','times.nome')->whereRaw($where)->orderBy('id','DESC')->paginate(30);
			}
		}
		else
			$noticias = Noticium::join('times','noticias.time_id','=','times.id')->select('noticias.id','noticias.titulo','noticias.subtitulo','noticias.imagem','noticias.created_at','times.nome')->orderBy('id','DESC')->paginate(30);
		return view('noticias.index', ["noticias" => $noticias, "filtro" => $request->filtro, "valor" => $request->valor]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$noticium = new Noticium();
		return view('noticias.form', ["noticium" => $noticium, "url" => "noticias.store", "method" => "post"]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$noticium = new Noticium();
		$noticium->titulo = $request->input("titulo");
		$noticium->subtitulo = $request->input("subtitulo");
		$noticium->conteudo = $request->input("conteudo");
		$noticium->time_id = Auth::user()->time(Session::get('era')->id)->id;
		// Imagem de Anexo
		$path = public_path()."/images/noticias/$noticium->id";
		if(!File::exists($path))
			File::makeDirectory($path);

		if($request->hasFile('imagem')){
			$noticium->imagem = $request->file("imagem")->getClientOriginalName();
			$noticium->save();
			Storage::disk('public_noticias')->put("$noticium->id/".$request->file("imagem")->getClientOriginalName(), file_get_contents($request->file("imagem")->getRealPath()));
		} else {
			$noticium->save();
		}

		return redirect()->route('noticias.index')->with('message', 'Notícia cadastrado com sucesso!');
	}

	/**
	 * Show the noticia.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$noticium = Noticium::findOrFail($id);
		return view('noticias.show', ["noticium" => $noticium]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$noticium = Noticium::findOrFail($id);
		return view('noticias.form', ["noticium" => $noticium, "url" => "noticias.update", "method" => "put"]);
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
		$noticium = Noticium::findOrFail($id);
		$noticium->titulo = $request->input("titulo");
		$noticium->subtitulo = $request->input("subtitulo");
		$noticium->conteudo = $request->input("conteudo");
		$noticium->imagem = $request->input("imagem");
		$noticium->time_id = $request->input("time_id");
		$noticium->save();
		return redirect()->route('noticias.index')->with('message', 'Notícia atualizado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$noticium = Noticium::findOrFail($id);
		$noticium->delete();
		return redirect()->route('noticias.index')->with('message', 'Notícia deletado com sucesso!');
	}

}
