<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
	protected $fillable = ['descripcion','paciente_id','fecha_entrega','estado'];

	public function paciente(){
		return $this->belongsTo('App\Paciente','paciente_id','id');
	}

	public function beneficios(){
		return $this->hasMany('App\DetalleBeneficio','beneficio_id','id');
	}
}