<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
	protected $fillable = ['fecha_consulta','descripcion','peso_actual','glicemia','semanas_embarazo','talla','pulso','respiracion','temperatura','presion_arterial','objetivo','subjetivo','paciente_id','clinico_id','estado'];

	
	public function paciente(){
		return $this->belongsTo('App\Paciente','paciente_id','id');
	}
	
	

}
