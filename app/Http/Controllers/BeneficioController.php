<?php

namespace App\Http\Controllers;

use App\Beneficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class BeneficioController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Beneficio::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$beneficio = Beneficio::with('paciente')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$beneficio = Beneficio::with('paciente')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$beneficio = Beneficio::with('paciente')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$beneficio = Beneficio::with('paciente')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'fecha'){
				$beneficio = Beneficio::with('paciente')->where([['fecha_entrega','like',$buscar.'%']])->orderBy('id', 'desc')->paginate($count);
		}
		return [
			"beneficios"=>$beneficio
		];
	}

	public function store(Request $request)
	{
		try {
			$beneficio = new Beneficio();
			$beneficio->descripcion = $request->descripcion;
			$beneficio->fecha_entrega = $request->fecha_entrega;
			$beneficio->paciente_id = $request->paciente_id;
			$beneficio->save();
			return ['id' => $beneficio->id];
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$beneficio = Beneficio::findOrFail($request->id);
		$beneficio->descripcion = $request->descripcion;
		$beneficio->paciente_id = $request->paciente_id;
		$beneficio->save();
		return Response::json(['message' => 'Beneficio Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$beneficio = Beneficio::findOrFail($request->id);
        $beneficio->estado = '1';
        $beneficio->save();
		return Response::json(['message' => 'beneficio Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$beneficio = Beneficio::findOrFail($request->id);
        $beneficio->estado = '0';
        $beneficio->save();
		return Response::json(['message' => 'beneficio Desactivado'], 200);
	}
}