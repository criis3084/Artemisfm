<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
	protected $fillable = ['nombre','estado'];

	public function users(){
		return $this->hasMany('App\User','rol_id','id');
	}
	public function permisos(){
		return $this->hasMany('App\Permisos','rol_id','id');
	}
}
