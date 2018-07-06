<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
    public function time()
    {
        return $this->hasOne('App\Time')->first();
    }

}
