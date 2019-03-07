<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'data', 'temporada_id'];
}
