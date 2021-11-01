<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class RecetaController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Receta::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$receta = Receta::with('detalle_receta')->with('historial')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$receta = Receta::with('detalle_receta')->with('historial')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$receta = Receta::with('detalle_receta')->with('historial')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$receta = Receta::with('detalle_receta')->with('historial')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"recetas"=>$receta
		];
	}

	public function store(Request $request)
	{
		try {
			$receta = new Receta();
			$receta->listado = $request->listado;
			$receta->historial_clinico_id = $request->historial_clinico_id;
			//$receta->estado = 0;
			$receta->save();
			#return Response::json(['message' => 'Abono Prestamo Creada'], 200);
			return ['id' => $receta->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$receta = Receta::findOrFail($request->id);
		$receta->listado = $request->listado;
		$receta->historial_clinico_id = $request->historial_clinico_id;
		$receta->save();
		return Response::json(['message' => 'Abono Prestamo Actualizado'], 200);
		
	}

	public function activar(Request $request)
	{
		$receta = Receta::findOrFail($request->id);
        $receta->estado = '1';
        $receta->save();
		return Response::json(['message' => 'receta Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$receta = Receta::findOrFail($request->id);
        $receta->estado = '0';
        $receta->save();
		return Response::json(['message' => 'receta Desactivado'], 200);
	}
}