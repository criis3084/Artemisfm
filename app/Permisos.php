<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    protected $fillable = ['nombre','descripcion','estado','rol_id'];

    public function rol(){
		return $this->belongsTo('App\Rol','rol_id','id');
	}
}
