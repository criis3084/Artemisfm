<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
	protected $fillable = ['stock','fecha_expiracion','numero_referencia','medicamento_id','estado'];

	public function medicamento(){
		return $this->belongsTo('App\Medicamento','medicamento_id','id');
	}
	public function detalleSalida(){
		return $this->hasMany('App\DetalleSalida','lote_id','id');
	}
	public function detalleEntrada(){
		return $this->hasMany('App\DetalleEntrada','lote_id','id');
	}
}
