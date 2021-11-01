<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
	protected $fillable = ['listado','estado','historial_clinico_id'];

	public function historial(){
		return $this->belongsTo('App\HistorialClinico','historial_clinico_id','id');
	}
	public function detalle_receta(){
		return $this->hasMany('App\AsignacionMedicamento','receta_id','id');
	}
}
