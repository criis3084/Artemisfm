<?php

namespace App\Http\Controllers;

use App\Beneficio;
use App\DetalleBeneficio;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class PacienteController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Paciente::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$paciente = Paciente::with('datos')->with('lista_recetas')->with('beneficios')->with('tipoPaciente')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$paciente = Paciente::with('datos')->with('lista_recetas')->with('beneficios')->with('tipoPaciente')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$paciente = Paciente::with('datos')->with('lista_recetas')->with('beneficios')->with('tipoPaciente')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$paciente = Paciente::with('datos')->with('lista_recetas')->with('beneficios')->with('tipoPaciente')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"pacientes"=>$paciente
		];
	}

	public function store(Request $request)
	{
		try {
			$paciente = new Paciente();
			$paciente->dia_apoyo = $request->dia_apoyo;
			$paciente->persona_sin_acceso_id = $request->persona_sin_acceso_id;
			$paciente->tipo_paciente_id = $request->tipo_paciente_id;
			$paciente->save();
			return ['id' => $paciente->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$paciente = Paciente::findOrFail($request->id);
		$paciente->dia_apoyo = $request->dia_apoyo;
		$paciente->tipo_paciente_id = $request->tipo_paciente_id;
		if ($request->id_beneficio==null){
			$beneficio = Beneficio::where('paciente_id', $paciente->id)->get()->first();
			if ($beneficio != null ){
				$beneficio->descripcion = $request->descripcion;
				$beneficio->save();
				
				$beneficioNuevo = new Beneficio();
				$beneficioNuevo->descripcion = $request->descripcion;
				$beneficioNuevo->fecha_entrega = $request->fecha_pago;
				$beneficioNuevo->paciente_id = $paciente->id;
				$beneficioNuevo->save();

				$beneficio = $beneficio->id;
				$eliminarDetalles = DetalleBeneficio::where('beneficio_id', $beneficio)->get();
			}
		}
		else{
			$beneficio = Beneficio::findOrFail($request->id_beneficio);
			$beneficio->descripcion = $request->descripcion;
			$beneficio->save();
			$eliminarDetalles = DetalleBeneficio::where('beneficio_id', $request->id_beneficio)->get();
			$beneficio= $request->id_beneficio; 
		}

		if ($beneficio == null)
		{
			$beneficio = new Beneficio();
			$beneficio->descripcion = $request->descripcion;
			$beneficio->fecha_entrega = $request->fecha_pago;
			$beneficio->paciente_id = $paciente->id;
			$beneficio->save();
			$beneficio= $beneficio->id;
		}
		else{
			foreach($eliminarDetalles as $det)
			{
				$detalle = DetalleBeneficio::where('id', $det['id'])->get()->first();
				$detalle->delete();
			}
		}
		$carrito = $request->carrito;
		$cantidades = $request->cantidades;
		$i =0;

		foreach ($carrito as $uno){
			$detalleBeneficio = new DetalleBeneficio();
			$detalleBeneficio->cantidad = (int) $cantidades[$i];
			$detalleBeneficio->beneficio_id = $beneficio;
			$detalleBeneficio->medicamento_id = $uno['id'];
			$detalleBeneficio->save();
			$i++;
		}
		$paciente->save();
		return Response::json(['message' => 'Paciente Actualizado'], 200);
	}

	public function activar(Request $request)
	{
		$paciente = Paciente::findOrFail($request->id);
        $paciente->estado = '1';
        $paciente->save();
		return Response::json(['message' => 'paciente Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$paciente = Paciente::findOrFail($request->id);
        $paciente->estado = '0';
        $paciente->save();
		return Response::json(['message' => 'paciente Desactivado'], 200);
	}
}