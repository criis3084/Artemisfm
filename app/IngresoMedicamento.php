<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoMedicamento extends Model
{
	protected $fillable = ['fecha_ingreso','descripcion','user_id','proveedor_id','estado'];

	public function user(){
		return $this->belongsTo('App\User','user_id','id');
	}
	public function proveedor(){
		return $this->belongsTo('App\Proveedor','proveedor_id','id');
	}
	public function detalleIngresos(){
		return $this->belongsTo('App\DetalleIngreso','detalle_ingreso_id','id');
	}
	public function datos_proveedor(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Proveedor',
			'id',
			'id',
			'proveedor_id',
			'persona_sin_acceso_id'
		);
	}
}
