<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaMedicamento extends Model
{
	protected $fillable = ['nombre','estado','descripcion'];

	public function medicamentos(){
		return $this->hasMany('App\Medicamento','categoria_medicamento_id','id');
	}
}
