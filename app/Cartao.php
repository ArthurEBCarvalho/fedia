<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    /**
     * Get the time record associated with the user.
     */
    public function time()
    {
        return $this->hasOne('App\Time')->first();
    }

    /**
     * Get the partida record associated with the user.
     */
    public function partida()
    {
        return $this->hasOne('App\Partida')->first();
    }

    /**
     * Get the jogador record associated with the user.
     */
    public function jogador()
    {
        return $this->belongsTo('App\Jogador')->first();
    }
}
