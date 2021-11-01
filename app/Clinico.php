<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinico extends Model
{
	/*protected $fillable = ['profesion_id','user_id','estado','colegiado'];

	public function datos(){
		return $this->belongsTo('App\User','user_id','id');
	}
	/*public function profesion(){
		return $this->belongsTo('App\Profesion','profesion_id','id');
	}
	public function consultas(){
		return $this->hasMany('App\HistorialClinico','clinico_id','id');
	}
	public function examenes(){
		return $this->hasMany('App\Examen','clinico_id','id');
	}*/
}
