<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
	protected $fillable = ['cantidad','ingreso_medicamento_id','lote_id','estado'];

	public function ingresoMedicamento(){
		return $this->belongsTo('App\IngresoMedicamento','ingreso_medicamento_id','id');
	}
	public function lote(){
		return $this->belongsTo('App\Lote','lote_id','id');
	}
	public function datos_medicamento(){
		return $this->hasManyThrough(
			'App\Medicamento',
			'App\Lote',
			'id',
			'id',
			'lote_id',
			'medicamento_id'
		);
	}
}
