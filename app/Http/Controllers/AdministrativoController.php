<?php

namespace App\Http\Controllers;

use App\Administrativo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\Hash;

class AdministrativoController extends Controller
{
	public function index(Request $request)
	{
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		$count = Administrativo::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$administrativo = Administrativo::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$administrativo = Administrativo::with('datos')->where([[$criterio, 'like', $buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$administrativo = Administrativo::with('datos')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$administrativo = Administrativo::with('datos')->where($criterio, 'like', $buscar )->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"administrativos"=>$administrativo
		];
	}

	public function store(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$user= new User();
			$user->nombres = $request->nombres;
			$user->apellidos = $request->apellidos;
			$user->CUI = $request->CUI;
			$user->genero = $request->genero;
			$user->numero_telefono = $request->numero_telefono;
			$user->correo = $request->correo;
			$user->direccion = $request->direccion;
			$user->fecha_nacimiento = $request->fecha_nacimiento;
			$user->imagen_perfil = $request->imagen_perfil;
			$user->descripcion = $request->descripcion;
			// Comprobacion de unico
			$user->user = $request->user;
			$user->password = Hash::make($request->password);
			//$user->password = $request->password;
			$user->rol_id = $request->rol_id;

			$administrativo = new Administrativo();
			$administrativo->descripcion_puesto = $request->descripcion_puesto;
			$administrativo->user_id = $user->user_id;
			$administrativo->save();
			return Response::json(['message' => 'User administrativo Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$administrativo= Administrativo::findOrFail($request->id);
			$user= User::findOrFail($administrativo->user_id);
			$user->nombres = $request->nombres;
			$user->apellidos = $request->apellidos;
			$user->CUI = $request->CUI;
			$user->genero = $request->genero;
			$user->numero_telefono = $request->numero_telefono;
			$user->correo = $request->correo;
			$user->direccion = $request->direccion;
			$user->fecha_nacimiento = $request->fecha_nacimiento;
			$user->imagen_perfil = $request->imagen_perfil;
			$user->descripcion = $request->descripcion;
			// Comprobacion de unico
			#$user->user = $request->user;
			$user->password = Hash::make($request->password);
			//$user->password = $request->password;
			$user->rol_id = $request->rol_id;

			$administrativo->descripcion_puesto = $request->descripcion_puesto;
			$administrativo->save();
			return Response::json(['message' => 'User administrativo Actualizado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $administrativo = Administrativo::findOrFail($request->id);
        $user = User::findOrFail($administrativo->user_id);
		$user->estado = '1';
        $administrativo->estado = '1';
        $administrativo->save();
        $user->save();
		return Response::json(['message' => 'Persona administrativa Activada'], 200);
	}

	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$administrativo = Administrativo::findOrFail($request->id);
        $user = User::findOrFail($administrativo->user_id);
		$user->estado = '0';
		$administrativo->estado = '0';
		$administrativo->save();
		$user->save();
		return Response::json(['message' => 'Personal administrativo Desactivado'], 200);
	}
}