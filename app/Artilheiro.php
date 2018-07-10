<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artilheiro extends Model
{
    /**
     * Get the jogador record associated with the user.
     */
    public function jogador()
    {
        return $this->belongsTo('App\Jogador')->first();
    }
}
