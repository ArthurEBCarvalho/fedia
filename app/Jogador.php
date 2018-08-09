<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jogador extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status'];

    // Arrays para retornar strings
	protected $POS = ['PE' => 'Ataque', 'ATA' => 'Ataque', 'PD' => 'Ataque', 'MAE' => 'Meio Campo', 'SA' => 'Ataque', 'MAD' => 'Meio Campo', 'MEI' => 'Meio Campo', 'ME' => 'Meio Campo', 'MC' => 'Meio Campo', 'MD' => 'Meio Campo', 'VOL' => 'Meio Campo', 'ADE' => 'Defesa', 'LE' => 'Defesa', 'ZAG' => 'Defesa', 'LD' => 'Defesa', 'ADD' => 'Defesa', 'GOL' => 'Goleiro'];
    protected $STATUS = ['Negociável','Inegociável','À Venda'];
	
    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
	public function posicao()
	{
		return $this->POS[(explode('|', $this->posicoes)[0])];
	}

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getStatus()
    {
        return $this->STATUS[$this->status];
    }

    /**
     * Get the jogador record associated with the user.
     */
    public function jogador()
    {
    	return $this->belongsTo('App\Jogador')->first();
    }
}
