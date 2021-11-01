<?php

namespace App\Http\Controllers;

use App\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class MedicamentoController extends Controller
{
	public function index(Request $request)
	{
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Medicamento::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$medicamento = Medicamento::with('categoria')->with('lotes')->with('casaMedica')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$medicamento = Medicamento::with('categoria')->with('lotes')->with('casaMedica')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$medicamento = Medicamento::with('categoria')->with('lotes')->with('casaMedica')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$medicamento = Medicamento::with('categoria')->with('lotes')->with('casaMedica')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"medicamentos"=>$medicamento
		];
	}

	public function store(Request $request)
	{
		try {
			$medicamento = new Medicamento();
			$medicamento->nombre = $request->nombre;
			$medicamento->descripcion = $request->descripcion;
			$medicamento->stock_general = 0;
			$medicamento->categoria_medicamento_id = $request->categoria_medicamento_id;
			$medicamento->casa_medica_id = $request->casa_medica_id;
			$medicamento->save();
			return Response::json(['message' => 'medicamento Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$medicamento = Medicamento::findOrFail($request->id);
		if (isset($request->nombre)){
			$medicamento->nombre = $request->nombre;
		}
		if (isset($request->descripcion)){
			$medicamento->descripcion = $request->descripcion;
		}
		if (isset($request->stock_general)){
			$medicamento->stock_general = $request->stock_general;
		}
		if (isset($request->categoria_medicamento_id)){
			$medicamento->categoria_medicamento_id = $request->categoria_medicamento_id;
		}
		if (isset($request->casa_medica_id)){
			$medicamento->casa_medica_id = $request->casa_medica_id;
		}
		if (isset($request->estado)){
			$medicamento->estado = $request->estado;
		}
		$medicamento->save();
		return Response::json(['message' => 'medicamento Actualizado'], 200);
	}

	public function activar(Request $request)
	{
		$medicamento = Medicamento::findOrFail($request->id);
        $medicamento->estado = '1';
        $medicamento->save();
		return Response::json(['message' => 'medicamento Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$medicamento = Medicamento::findOrFail($request->id);
        $medicamento->estado = '0';
        $medicamento->save();
		return Response::json(['message' => 'medicamento desactivado'], 200);
	}
}