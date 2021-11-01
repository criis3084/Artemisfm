<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
	protected $fillable = ['nombre','descripcion','stock_general','estado','categoria_medicamento_id','casa_medica_id'];

	public function categoria(){
		return $this->belongsTo('App\CategoriaMedicamento','categoria_medicamento_id','id');
	}
	public function casaMedica(){
		return $this->belongsTo('App\CasaMedica','casa_medica_id','id');
	}
	public function lotes(){
		return $this->hasMany('App\Lote','medicamento_id','id');
	}
}
