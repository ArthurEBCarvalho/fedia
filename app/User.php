<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function isAdmin()
    {
        if($this->admin == 1)
            return true;
        else
            return false;
    }

    /**
     * Get the time record associated with the user.
     */
    public function time($era)
    {
        // return $this->hasOne('App\Time')->first();
        return \DB::table('times')->join('user_times','user_times.time_id','=','times.id')->selectRaw('times.*')->where('user_times.user_id',$this->id)->where('user_times.era_id',$era)->first();
    }

}
