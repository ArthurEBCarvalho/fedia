<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    /**
     * Get the time record associated with the user.
     */
    public function liga1()
    {
        return $this->hasOne('App\Time', 'id', 'liga1_id')->first();
    }

    /**
     * Get the time record associated with the user.
     */
    public function liga2()
    {
        return $this->hasOne('App\Time', 'id', 'liga2_id')->first();
    }

    /**
     * Get the time record associated with the user.
     */
    public function liga3()
    {
        return $this->hasOne('App\Time', 'id', 'liga3_id')->first();
    }

    /**
     * Get the time record associated with the user.
     */
    public function copa1()
    {
        return $this->hasOne('App\Time', 'id', 'copa1_id')->first();
    }

    /**
     * Get the time record associated with the user.
     */
    public function copa2()
    {
        return $this->hasOne('App\Time', 'id', 'copa2_id')->first();
    }
}
