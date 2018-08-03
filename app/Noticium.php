<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticium extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'noticias';

    /**
     * Get the time record associated with the user.
     */
    public function time()
    {
        return $this->hasOne('App\Time')->first();
    }
}
