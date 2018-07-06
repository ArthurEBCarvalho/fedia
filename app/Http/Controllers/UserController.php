<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Time;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Hash;
// use App\UserPermissao;

class UserController extends Controller
{
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
        (isset($request->order)) ? $order = $request->order : $order = "id";
        if(isset($request->filtro)){
            if($request->filtro == "Limpar"){
                $request->valor = NULL;
                $users = \DB::table('users')->join('times','times.user_id','=','users.id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->orderByRaw($order)->paginate(30);
            }
            else{
                if(strpos($request->filtro,"nome"))
                    $users = \DB::table('users')->join('times','times.user_id','=','users.id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->where($request->filtro, 'LIKE', "%$request->valor%")->orderByRaw($order)->paginate(30);
                else
                    $users = \DB::table('users')->join('times','times.user_id','=','users.id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->where($request->filtro, $request->valor)->orderByRaw($order)->paginate(30);
            }
        }
        else
            $users = \DB::table('users')->join('times','times.user_id','=','users.id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->orderByRaw($order)->paginate(30);
        return view('administracao.users.index', ["users" => $users, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = new User();
        return view('administracao.users.form', ["user" => $user, "url" => "administracao.users.store", "method" => "post", "permit" => true, "config" => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validar($request, 'store');
        $user = new User();
        $user->nome = $request->nome;
        $user->email = $request->email;
        $user->password = bcrypt("123mudar");
        if(is_null($request->admin))
            $user->admin = 0;
        else
            $user->admin = 1;
        $user->save();
        $time = new Time();
        $time->nome = $request->time;
        $time->user_id = $user->id;
        $time->escudo = $request->file('escudo')->getClientOriginalName();
        $time->save();
        Storage::put('times/'.$request->file('escudo')->getClientOriginalName(), file_get_contents($request->file('escudo')->getRealPath()));
        return redirect()->route('administracao.users.index')->with('message', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        (is_null($request->config)) ? $config = false : $config = true;
        return view('administracao.users.form', ["user" => $user, "url" => "administracao.users.update", "method" => "put", "config" => $config]);
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
        $this->validar($request, 'update');
        $user = User::findOrFail($id);
        $user->nome = $request->nome;
        $user->email = $request->email;
        if(is_null($request->admin))
            $user->admin = 0;
        else
            $user->admin = 1;
        if($request->alterar_credenciais == "true"){
            if(Hash::check($request->password_antigo,Auth::user()->password) && $request->password == $request->password_confirmation && !User::where("email",$request->email)->where("id","!=",Auth::user()->id)->count()){
                $user->password = bcrypt($request->password);
            }
        }
        $user->save();
        $time = Time::where('user_id',$id)->first();
        $time->nome = $request->time;
        if(!is_null($request->file('escudo'))){
            Storage::delete('times/'.$time->escudo);
            $time->escudo = $request->file('escudo')->getClientOriginalName();
            Storage::put('times/'.$request->file('escudo')->getClientOriginalName(), file_get_contents($request->file('escudo')->getRealPath()));
        }
        $time->save();
        return redirect()->route('administracao.users.index')->with('message', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $time = Time::where('user_id',$id)->first();
        Storage::delete('times/'.$time->escudo);
        $time->delete();
        $user->delete();
        return redirect()->route('administracao.users.index')->with('message', 'Usuário deletado com sucesso!');
    }

    /**
     * Get the OrdemHistorico from the specified resource.
     *
     * @return Response
     */
    public function verificar_senha(Request $request)
    {
        if(Hash::check($request->password,Auth::user()->password))
            return "true";
        else
            return "false";
    }

    /**
     * Get the OrdemHistorico from the specified resource.
     *
     * @return Response
     */
    public function verificar_login(Request $request)
    {
        if($request->method == "post"){
            if(User::where("login",$request->login)->count() || blank($request->login))
                return "false";
            else
                return "true";
        } else {
            if(User::where("login",$request->login)->where("id","!=",Auth::user()->id)->count() || blank($request->login))
                return "false";
            else
                return "true";
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validar(Request $request, $tipo)
    {
        if($tipo == "update")
            return $this->validate($request, [
                'nome' => 'required|max:255',
                // 'email' => 'required|email|max:255',
                ]);
        else
            return $this->validate($request, [
                'nome' => 'required|max:255',
                'email' => 'required|max:255|unique:users',
                ]);
    }
}
