<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
	protected $fillable = ['descripcion_puesto','user_id','estado'];

	public function datos(){
		return $this->belongsTo('App\User','user_id','id');
	}
}
