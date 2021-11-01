<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleSalida extends Model
{
	protected $fillable = ['cantidad','salida_medicamento_id','lote_id','estado'];

	public function salidaMedicamento(){
		return $this->belongsTo('App\SalidaMedicamento','salida_medicamento_id','id');
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
