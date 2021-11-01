<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
	protected $fillable = ['dia_apoyo','persona_sin_acceso_id','tipo_paciente_id','estado'];

	public function datos(){
		return $this->belongsTo('App\PersonaSinAcceso','persona_sin_acceso_id','id');
	}
	public function tipoPaciente(){
		return $this->belongsTo('App\TipoPaciente','tipo_paciente_id','id');
	}
	public function beneficios(){
		return $this->hasMany(Beneficio::class);
	}
	public function lista_recetas()
	{
		return $this->hasManyThrough(
		  'App\Receta',
		  'App\HistorialClinico',
		  'paciente_id',
		  'historial_clinico_id',
		  'id',
		  'id'
		);
	}
}
