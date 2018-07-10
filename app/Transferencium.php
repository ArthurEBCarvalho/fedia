<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferencium extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transferencias';

    /**
     * Get the jogador record associated with the user.
     */
    public function jogador()
    {
    	return $this->belongsTo('App\Jogador')->first();
    }

    /**
     * Get the jogador record associated with the user.
     */
    public function time1()
    {
    	return $this->belongsTo('App\Time','time1_id')->first();
    }

    /**
     * Get the jogador record associated with the user.
     */
    public function time2()
    {
    	return $this->belongsTo('App\Time','time2_id')->first();
    }
}
