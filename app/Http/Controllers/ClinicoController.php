<?php

namespace App\Http\Controllers;

use App\Clinico;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
class ClinicoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Clinico::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$clinico = Clinico::with('datos')->with('profesion')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$clinico = Clinico::with('datos')->with('profesion')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$clinico = Clinico::with('datos')->with('profesion')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$clinico = Clinico::with('datos')->with('profesion')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"clinicos"=>$clinico
		];
	}

	public function store(Request $request)
	{
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
			$user->save();
			
			$clinico = new Clinico();
			$clinico->profesion_id = $request->profesion_id;
			$clinico->colegiado = $request->colegiado;
			$clinico->user_id = $user->id;
			$clinico->save();
			return Response::json(['message' => 'User clinico Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		try {
		$clinico = Clinico::findOrFail($request->id);
		$user = User::findOrFail($clinico->user_id);
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
		

		$clinico->profesion_id = $request->profesion_id;
		if (isset($request->colegiado)){
			$clinico->colegiado = $request->colegiado;
		}
		$clinico->user_id = $user->id;
		$clinico->save();
		$user->save();
		return Response::json(['message' => 'User clinico actualizado'], 200);
		#return ['id' => $nino->id];
	} catch (Exception $e) {
		return Response::json(['message' => $e->getMessage()], 400);
	}
	}

	public function activar(Request $request)
	{
		$clinico = Clinico::findOrFail($request->id);
		$user = User::findOrFail($clinico->user_id);
		$user->estado = '1';
		$clinico->estado = '1';
		$clinico->save();
		$user->save();
		return Response::json(['message' => 'clinico Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$clinico = Clinico::findOrFail($request->id);
		$user = User::findOrFail($clinico->user_id);
		$user->estado = '0';
		$clinico->estado = '0';
		$clinico->save();
		$user->save();
		return Response::json(['message' => 'clinico Desactivado'], 200);
	}

	public function imagen(Request $request){
		$imagen = $request->photos;
		$nombreEliminar = public_path('storage\public\personalClinico\\') .  $request->header("imagenanterior");
		if (File::exists($nombreEliminar)) {
			File::delete($nombreEliminar);
		}
		$completo = time() . "." . $imagen->extension();
		$imagen_redi = Image::make($imagen)->resize(300,200);
		$imagen_redi->save(public_path('storage/public/personalClinico/'. $completo));
		return Response::json($completo, 200);
	}
}