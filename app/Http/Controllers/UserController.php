<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Time;
use App\UserTime;
use App\Era;
use App\Financeiro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;
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
        $params = [];
        (strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
        (strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
        (strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
        if(isset($request->order)){
            $order = $request->order;
            $params['order'] = $request->order;
        } else {
            $order = "users.id";
        }

        if(isset($request->filtro)){
            if($request->filtro == "Limpar"){
                $request->valor = NULL;
                $users = \DB::table('users')->join('user_times','user_times.user_id','=','users.id')->join('times','times.id','=','user_times.time_id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->where('user_times.era_id',Session::get('era')->id)->orderByRaw($order)->paginate(30);
            }
            else{
                $params['filtro'] = $request->filtro;
                $params['valor'] = $request->valor;
                if(strpos($request->filtro,"nome"))
                    $users = \DB::table('users')->join('user_times','user_times.user_id','=','users.id')->join('times','times.id','=','user_times.time_id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->where($request->filtro, 'LIKE', "%$request->valor%")->where('user_times.era_id',Session::get('era')->id)->orderByRaw($order)->paginate(30);
                else
                    $users = \DB::table('users')->join('user_times','user_times.user_id','=','users.id')->join('times','times.id','=','user_times.time_id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->where($request->filtro, $request->valor)->where('user_times.era_id',Session::get('era')->id)->orderByRaw($order)->paginate(30);
            }
        }
        else
            $users = \DB::table('users')->join('user_times','user_times.user_id','=','users.id')->join('times','times.id','=','user_times.time_id')->select('users.id', 'users.nome','users.email','times.nome as time','times.dinheiro','users.admin')->where('user_times.era_id',Session::get('era')->id)->orderByRaw($order)->paginate(30);
        return view('administracao.users.index', ["users" => $users, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret, "params" => $params]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = new User();
        $eras = Era::all();
        return view('administracao.users.form', ["user" => $user, "eras" => $eras, "url" => "administracao.users.store", "method" => "post", "permit" => true, "config" => false]);
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
        foreach ($request->times as $key => $value) {
            if(blank($value))
                continue;
            $time = new Time();
            $time->nome = $value;
            $time->dinheiro = 0;
            $time->escudo = $request->escudos[$key]->getClientOriginalName();
            $time->save();
            Storage::put('times/'.$request->escudos[$key]->getClientOriginalName(), file_get_contents($request->escudos[$key]->getRealPath()));
            $relation = new UserTime();
            $relation->era_id = $key;
            $relation->user_id = $user->id;
            $relation->time_id = $time->id;
            $relation->save();
        }
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
        $eras = Era::all();
        (is_null($request->config)) ? $config = false : $config = true;
        return view('administracao.users.form', ["user" => $user, "eras" => $eras, "url" => "administracao.users.update", "method" => "put", "config" => $config]);
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
        foreach ($request->times as $key => $value) {
            if(blank($value))
                continue;
            $time_id = UserTime::where('user_id',$id)->where('era_id',$key)->pluck('time_id')->first();
            if(isset($time_id)){
                $time = Time::findOrFail($time_id);
                $time->nome = $value;
                if(!blank($request->escudos[$key]))
                    $time->escudo = $request->escudos[$key]->getClientOriginalName();
                $time->save();
            } else {
                $time = new Time();
                $time->nome = $value;
                $time->dinheiro = 0;
                $time->escudo = $request->escudos[$key]->getClientOriginalName();
                $time->save();
                Storage::put('times/'.$request->escudos[$key]->getClientOriginalName(), file_get_contents($request->escudos[$key]->getRealPath()));
                $relation = new UserTime();
                $relation->era_id = $key;
                $relation->user_id = $id;
                $relation->time_id = $time->id;
                $relation->save();
            }
        }
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
        $relation = UserTime::where('user_id',$id);
        $times = Time::whereRaw('id IN ('.join(',',UserTime::where('user_id',$id)->pluck('time_id')->toArray()).')');
        foreach ($times as $value)
            Storage::delete('times/'.$value->escudo);
        $relation->delete();
        $times->delete();
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
     * Formulário para aplicar multa
     *
     * @return Response
     */
    public function multa_create()
    {
        $times = Time::join('user_times','user_times.time_id','=','times.id')->join('users','users.id','=','user_times.user_id')->selectRaw("times.id,CONCAT(times.nome,' - ',users.nome) as nome")->where("user_times.era_id",Session::get('era')->id)->lists('nome','id')->all();
        return view('administracao.users.multa_create', ["times" => $times]);
    }

    /**
     * Aplica Multa ao time selecionado, creditando do dinheiro e criando o registro financeiro
     *
     * @return Response
     */
    public function multa_store(Request $request)
    {
        $request->valor = floatval(str_replace(",", ".", str_replace(".", "", $request->valor)));
        $time = Time::findOrFail($request->time_id);
        $time->dinheiro -= $request->valor;
        $time->save();
        Financeiro::create(['valor' => $request->valor, 'operacao' => 1, 'descricao' => "Multa: $request->descricao", 'time_id' => $time->id]);
        return redirect()->route('administracao.users.multa_create')->with('message', 'Multa aplicada com sucesso!');
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
