<?php

namespace App\Http\Controllers;

use App\TipoPaciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class TipoPacienteController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = TipoPaciente::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$tipoPaciente = TipoPaciente::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$tipoPaciente = TipoPaciente::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$tipoPaciente = TipoPaciente::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$tipoPaciente = TipoPaciente::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"tipoPacientes"=>$tipoPaciente
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$tipoPaciente = new TipoPaciente();
			$tipoPaciente->nombre = $request->nombre;
			$tipoPaciente->descripcion = $request->descripcion;
			$tipoPaciente->save();
			return Response::json(['message' => 'TipoPaciente Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$tipoPaciente = TipoPaciente::findOrFail($request->id);
		$tipoPaciente->nombre = $request->nombre;
		$tipoPaciente->descripcion = $request->descripcion;
		$tipoPaciente->save();
		return Response::json(['message' => 'TipoPaciente Actualizado'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $tipoPaciente = TipoPaciente::findOrFail($request->id);
        $tipoPaciente->estado = '1';
        $tipoPaciente->save();
		return Response::json(['message' => 'TipoPaciente Activado'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tipoPaciente = TipoPaciente::findOrFail($request->id);
		$tipoPaciente->estado = '0';
		$tipoPaciente->save();
		return Response::json(['message' => 'TipoPaciente Desactivado'], 200);
	}
}