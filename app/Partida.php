<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['campeonato', 'rodada', 'temporada', 'time1_id', 'time2_id', 'resultado1', 'resultado2', 'penalti1', 'penalti2', 'ordem'];

    /**
     * Get the time record associated with the user.
     */
    public function time1()
    {
        return $this->hasOne('App\Time', 'id', 'time1_id')->first();
    }

    /**
     * Get the time record associated with the user.
     */
    public function time2()
    {
        return $this->hasOne('App\Time', 'id', 'time2_id')->first();
    }
}
