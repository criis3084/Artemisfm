<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
	public function index(Request $request)
	{
		//if (!$request->ajax()) return redirect('/');
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = User::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$user = User::with('rol')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$user = User::with('rol')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$user = User::with('rol')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$user = User::with('rol')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"users"=>$user
		];
	}

	public function store(Request $request)
	{
		//if (!$request->ajax()) return redirect('/');
		try {
			$user = new User();
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
			$user->user = $request->user;
			$user->password = Hash::make($request->password);
			$user->rol_id = $request->rol_id;
			$user->save();
			return Response::json(['message' => 'User Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		//if (!$request->ajax()) return redirect('/');
		$user = User::findOrFail($request->id);
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
		$user->user = $request->user;
		$user->password = Hash::make($request->password);
		//$user->password = $request->password;
		$user->rol_id = $request->rol_id;
		$user->save();
		return Response::json(['message' => 'User Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$user = User::findOrFail($request->id);
        $user->estado = '1';
        $user->save();
		return Response::json(['message' => 'user Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$user = User::findOrFail($request->id);
        $user->estado = '0';
        $user->save();
		return Response::json(['message' => 'user Desactivado'], 200);
	}
	
	public function imagen(Request $request){
		$imagen = $request->photos;
		$nombreEliminar = public_path('storage\public\usuarios\\') .  $request->header("imagenanterior");
		if (File::exists($nombreEliminar)) {
			File::delete($nombreEliminar);
		}
		$completo = time() . "." . $imagen->extension();
		$imagen_redi = Image::make($imagen)->resize(300,200);

		$imagen_redi->save(public_path('storage/public/usuarios/'.$completo));
		return Response::json($completo, 200);
	}
}