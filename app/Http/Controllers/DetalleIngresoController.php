<?php

namespace App\Http\Controllers;

use App\DetalleIngreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class DetalleIngresoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = DetalleIngreso::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$detalleIngreso = DetalleIngreso::with('ingresoMedicamento')->with('lote')->with('datos_medicamento')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$detalleIngreso = DetalleIngreso::with('ingresoMedicamento')->with('lote')->with('datos_medicamento')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$detalleIngreso = DetalleIngreso::with('ingresoMedicamento')->with('lote')->with('datos_medicamento')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$detalleIngreso = DetalleIngreso::with('ingresoMedicamento')->with('lote')->with('datos_medicamento')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"detalleIngresos"=>$detalleIngreso
		];
	}

	public function store(Request $request)
	{
		try {
			$detalleIngreso = new DetalleIngreso();
			$detalleIngreso->ingreso_medicamento_id = $request->ingreso_medicamento_id;
			$detalleIngreso->lote_id = $request->lote_id;
			$detalleIngreso->save();
			return ['id' => $detalleIngreso->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$detalleIngreso = DetalleIngreso::findOrFail($request->id);
		$detalleIngreso->ingreso_medicamento_id = $request->ingreso_medicamento_id;
		$detalleIngreso->lote_id = $request->lote_id;
		$detalleIngreso->save();
		return Response::json(['message' => 'Detalle Ingreso Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$detalleIngreso = DetalleIngreso::findOrFail($request->id);
        $detalleIngreso->estado = '1';
        $detalleIngreso->save();
		return Response::json(['message' => 'detalleIngreso Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$detalleIngreso = DetalleIngreso::findOrFail($request->id);
        $detalleIngreso->estado = '0';
        $detalleIngreso->save();
		return Response::json(['message' => 'detalleIngreso Desactivado'], 200);
	}
}