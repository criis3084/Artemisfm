<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaSinAcceso extends Model
{
	// Confirmar si es hasOne o hasMany
	protected $fillable = ['nombres','apellidos','CUI','genero','fecha_nacimiento','direccion','numero_telefono','estado'];

}
