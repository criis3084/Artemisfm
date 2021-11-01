<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements JWTSubject
{
    use Notifiable;
	protected $table = 'users';
	protected $fillable = ['nombres','apellidos','CUI','genero','numero_telefono','correo','direccion','fecha_nacimiento','imagen_perfil','descripcion','estado','user','password','rol_id'];

	public function rol(){
		return $this->belongsTo('App\Rol','rol_id','id');
	}

	public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
