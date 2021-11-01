<?php

namespace App\Http\Controllers;

use App\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class LoteController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Lote::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$lote = Lote::with('medicamento')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$lote = Lote::with('medicamento')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$lote = Lote::with('medicamento')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$lote = Lote::with('medicamento')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"lotes"=>$lote
		];
	}

	public function store(Request $request)
	{
		try {
			$lote = new Lote();
			$lote->stock = $request->stock;
			$lote->fecha_expiracion = $request->fecha_expiracion;
			$lote->numero_referencia = $request->numero_referencia;
			$lote->medicamento_id = $request->medicamento_id;
			$lote->save();
			return ['id' => $lote->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$lote = Lote::findOrFail($request->id);
		if (isset($request->stock)){
			$lote->stock = $request->stock;
		}
		if (isset($request->fecha_expiracion)){
			$lote->fecha_expiracion = $request->fecha_expiracion;
		}
		if (isset($request->numero_referencia)){
			$lote->numero_referencia = $request->numero_referencia;
		}
		if (isset($request->estado)){
			$lote->estado = $request->estado;
		}
		
		$lote->save();
		return Response::json(['message' => 'Lote Actualizado'], 200);
	}

	public function activar(Request $request)
	{
		$lote = Lote::findOrFail($request->id);
        $lote->estado = '1';
        $lote->save();
		return Response::json(['message' => 'lote Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$lote = Lote::findOrFail($request->id);
        $lote->estado = '0';
        $lote->save();
		return Response::json(['message' => 'lote Desactivado'], 200);
	}
}