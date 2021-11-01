<?php

namespace App\Http\Controllers;

use App\Permisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class PermisosController extends Controller
{
    public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Permisos::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$permisos = Permisos::with('rol')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$permisos = Permisos::with('rol')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$permisos = Permisos::with('rol')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$permisos = Permisos::with('rol')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"permisos"=>$permisos
		];
    }
    
    public function store(Request $request)
	{
		try {
			$permisos = new Permisos();
			$permisos->nombre = $request->nombre;
			$permisos->descripcion = $request->descripcion;
			$permisos->rol_id = $request->rol_id;
			$permisos->save();
			return Response::json(['message' => 'Permisos Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }
    
    public function update(Request $request)
	{
		$permisos = Permisos::findOrFail($request->id);
		$permisos->nombre = $request->nombre;
		$permisos->descripcion = $request->descripcion;
		$permisos->rol_id = $request->rol_id;
		$permisos->save();
		return Response::json(['message' => 'Permisos Actualizado'], 200);
	}

    public function activar(Request $request)
	{
		$permisos = Permisos::findOrFail($request->id);
        $permisos->estado = '1';
        $permisos->save();
		return Response::json(['message' => 'Permisos Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$permisos = Permisos::findOrFail($request->id);
        $permisos->estado = '0';
        $permisos->save();
		return Response::json(['message' => 'Permisos Desactivado'], 200);
	}
}
