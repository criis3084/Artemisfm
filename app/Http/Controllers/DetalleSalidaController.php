<?php

namespace App\Http\Controllers;

use App\DetalleSalida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class DetalleSalidaController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = DetalleSalida::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$detalleSalida = DetalleSalida::with('salidaMedicamento')->with('lote')->with('datos_medicamento')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$detalleSalida = DetalleSalida::with('salidaMedicamento')->with('lote')->with('datos_medicamento')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$detalleSalida = DetalleSalida::with('salidaMedicamento')->with('lote')->with('datos_medicamento')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$detalleSalida = DetalleSalida::with('salidaMedicamento')->with('lote')->with('datos_medicamento')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"detalleSalidas"=>$detalleSalida
		];
	}

	public function store(Request $request)
	{
		try {
			$detalleSalida = new DetalleSalida();
			$detalleSalida->cantidad = $request->cantidad;
			$detalleSalida->salida_medicamento_id = $request->salida_medicamento_id;
			$detalleSalida->lote_id = $request->lote_id;
			$detalleSalida->save();
			return Response::json(['message' => 'Detalle salida Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$detalleSalida = DetalleSalida::findOrFail($request->id);
		$detalleSalida->cantidad = $request->cantidad;
		$detalleSalida->salida_medicamento_id = $request->salida_medicamento_id;
		$detalleSalida->lote_id = $request->lote_id;
		$detalleSalida->save();
		return Response::json(['message' => 'Detalle salida Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$detalleSalida = DetalleSalida::findOrFail($request->id);
        $detalleSalida->estado = '1';
        $detalleSalida->save();
		return Response::json(['message' => 'detalleSalida Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$detalleSalida = DetalleSalida::findOrFail($request->id);
        $detalleSalida->estado = '0';
        $detalleSalida->save();
		return Response::json(['message' => 'detalleSalida Desactivado'], 200);
	}
}