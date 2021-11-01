<?php

namespace App\Http\Controllers;

use Exception;
use App\IngresoMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class IngresoMedicamentoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		$count = IngresoMedicamento::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$ingresoMedicamento = IngresoMedicamento::with('user')->with('datos_proveedor')->with('proveedor')->with('detalleIngresos')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$ingresoMedicamento = IngresoMedicamento::with('user')->with('datos_proveedor')->with('proveedor')->with('detalleIngresos')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$ingresoMedicamento = IngresoMedicamento::with('user')->with('datos_proveedor')->with('proveedor')->with('detalleIngresos')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$ingresoMedicamento = IngresoMedicamento::with('user')->with('datos_proveedor')->with('proveedor')->with('detalleIngresos')->where([[$criterio, 'like', $buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"ingresoMedicamentos"=>$ingresoMedicamento
		];
	}

	public function store(Request $request)
	{
		try {
			$ingresoMedicamento = new IngresoMedicamento();
			$ingresoMedicamento->fecha_ingreso = $request->fecha_ingreso;
			$ingresoMedicamento->descripcion = $request->descripcion;
			$ingresoMedicamento->user_id = $request->user_id;
			$ingresoMedicamento->proveedor_id = $request->proveedor_id;
			$ingresoMedicamento->save();
			return ['id' => $ingresoMedicamento->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$ingresoMedicamento = IngresoMedicamento::findOrFail($request->id);
		$ingresoMedicamento->fecha_ingreso = $request->fecha_ingreso;
		$ingresoMedicamento->descripcion = $request->descripcion;
		$ingresoMedicamento->user_id = $request->user_id;
		$ingresoMedicamento->proveedor_id = $request->proveedor_id;
		$ingresoMedicamento->save();
		return Response::json(['message' => 'Ingreso Medicamento Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$ingresoMedicamento = IngresoMedicamento::findOrFail($request->id);
        $ingresoMedicamento->estado = '1';
        $ingresoMedicamento->save();
		return Response::json(['message' => 'ingresoMedicamento Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$ingresoMedicamento = IngresoMedicamento::findOrFail($request->id);
        $ingresoMedicamento->estado = '0';
        $ingresoMedicamento->save();
		return Response::json(['message' => 'ingresoMedicamento Desactivado'], 200);
	}

	public function reporteIngreso (Request $request)
	{
		$completo= $request->completo;
		$anio = $request->anio;
		$medicamento = $request->medicamento;
        if ($completo =='true'){
			if($anio==''){
				$consulta = DB::table('ingreso_medicamentos')
				->selectRaw('YEAR(fecha_ingreso) AS anio')
				->groupBy('anio')
				->get();
				return response()->json($consulta);
			}
			else
			{
				$consulta = DB::table('ingreso_medicamentos')	
				->join('detalle_ingresos', 'ingreso_medicamentos.id', '=', 'detalle_ingresos.ingreso_medicamento_id')
				->join('lotes','lotes.id','=','detalle_ingresos.lote_id')
				->join('medicamentos','medicamentos.id','=','lotes.medicamento_id')
				->whereYear('fecha_ingreso',$anio)
				->Where('medicamentos.id',$medicamento)
				->select(DB::raw('MONTH(fecha_ingreso) mes'),'nombre' , DB::raw ('SUM(lotes.stock) as total'))
				->groupBy('mes','nombre')
				->get();
				return response()->json($consulta);
			}
		} 

	}
}