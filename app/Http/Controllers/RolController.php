<?php

namespace App\Http\Controllers;

use App\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Rol::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$rol = Rol::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$rol = Rol::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$rol = Rol::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$rol = Rol::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if($completo == 'select')
		{
			$rol = Rol::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
		return [
			"roles"=>$rol
		];
    }

    public function store(Request $request)
    {
        try {
			$rol = new Rol();
			$rol->nombre = $request->nombre;
			$rol->save();
			return Response::json(['message' => 'Rol Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
        $rol = Rol::findOrFail($request->id);
        $rol->nombre = $request->nombre;
        $rol->save();
		return Response::json(['message' => 'Abono Prestamo Actualizado'], 200);

    }

    public function activar(Request $request)
    {
        $rol = Rol::findOrFail($request->id);
        $rol->estado = '1';
        $rol->save();
		return Response::json(['message' => 'rol Activado'], 200);
    }

    public function desactivar(Request $request)
    {
        $rol = Rol::findOrFail($request->id);
        $rol->estado = '0';
        $rol->save();
		return Response::json(['message' => 'rol desactivado'], 200);           
    }
}
