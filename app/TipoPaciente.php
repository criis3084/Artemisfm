<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPaciente extends Model
{
	protected $fillable = ['nombre','estado','descripcion'];

	public function pacientes(){
		return $this->hasMany('App\Paciente','tipo_paciente_id','id');
	}
}