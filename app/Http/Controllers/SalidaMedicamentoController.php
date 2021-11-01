<?php

namespace App\Http\Controllers;

use Exception;
use App\SalidaMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SalidaMedicamentoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = SalidaMedicamento::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$salidaMedicamento = SalidaMedicamento::with('user')->with('datos_persona')->with('paciente')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$salidaMedicamento = SalidaMedicamento::with('user')->with('datos_persona')->with('paciente')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$salidaMedicamento = SalidaMedicamento::with('user')->with('datos_persona')->with('paciente')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$salidaMedicamento = SalidaMedicamento::with('user')->with('datos_persona')->with('paciente')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"salidaMedicamentos"=>$salidaMedicamento
		];
	}

	public function store(Request $request)
	{
		try {
			$salidaMedicamento = new SalidaMedicamento();
			$salidaMedicamento->fecha_salida = $request->fecha_salida;
			$salidaMedicamento->descripcion = $request->descripcion;
			$salidaMedicamento->user_id = $request->user_id;
			$salidaMedicamento->tipo_salida = $request->tipo_salida;
			$salidaMedicamento->paciente_id = $request->paciente_id;
			$salidaMedicamento->save();
			return ['id' => $salidaMedicamento->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$salidaMedicamento = SalidaMedicamento::findOrFail($request->id);
		$salidaMedicamento->fecha_salida = $request->fecha_salida;
		$salidaMedicamento->descripcion = $request->descripcion;
		$salidaMedicamento->user_id = $request->user_id;
		$salidaMedicamento->paciente_id = $request->paciente_id;
		if (isset($request->tipo_salida)){
			$salidaMedicamento->tipo_salida = $request->tipo_salida;
		}
		$salidaMedicamento->save();
		return Response::json(['message' => 'Salida Medicamento Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$salidaMedicamento = SalidaMedicamento::findOrFail($request->id);
        $salidaMedicamento->estado = '1';
        $salidaMedicamento->save();
		return Response::json(['message' => 'salidaMedicamento Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$salidaMedicamento = SalidaMedicamento::findOrFail($request->id);
        $salidaMedicamento->estado = '0';
        $salidaMedicamento->save();
		return Response::json(['message' => 'salidaMedicamento Desactivado'], 200);
	}

	public function reporteSalidas (Request $request)
	{
		$completo= $request->completo;
		$anio = $request->anio;
		$medicamento = $request->medicamento;
        if ($completo =='true'){
			if($anio==''){
				$consulta = DB::table('salida_medicamentos')
				->selectRaw('YEAR(fecha_salida) AS anio')
				->groupBy('anio')
				->get();
				return response()->json($consulta);
			}
			else
			{
				$consulta = DB::table('salida_medicamentos')	
				->join('detalle_salidas', 'salida_medicamentos.id', '=', 'detalle_salidas.salida_medicamento_id')
				->join('lotes','lotes.id','=','detalle_salidas.lote_id')
				->join('medicamentos','medicamentos.id','=','lotes.medicamento_id')
				->whereYear('fecha_salida',$anio)
				->Where('medicamentos.id',$medicamento)
				->select(DB::raw('MONTH(fecha_salida) mes'),'nombre' , DB::raw ('SUM(detalle_salidas.cantidad) as total'))
				->groupBy('mes','nombre')
				->get();
				return response()->json($consulta);
			}
		} 

	}

}