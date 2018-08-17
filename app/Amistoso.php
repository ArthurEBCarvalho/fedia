<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amistoso extends Model
{

     /**
     * Get the time record associated with the user.
     */
     public function time11()
     {
     	return $this->hasOne('App\Time', 'id', 'time11_id')->first();
     }

    /**
     * Get the time record associated with the user.
     */
    public function time12()
    {
    	return $this->hasOne('App\Time', 'id', 'time12_id')->first();
    }

    /**
     * Get the time record associated with the user.
     */
     public function time21()
     {
     	return $this->hasOne('App\Time', 'id', 'time21_id')->first();
     }

    /**
     * Get the time record associated with the user.
     */
    public function time22()
    {
    	return $this->hasOne('App\Time', 'id', 'time22_id')->first();
    }
}
