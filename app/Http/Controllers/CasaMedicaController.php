<?php

namespace App\Http\Controllers;

use App\CasaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class CasaMedicaController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
        $criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		$count = CasaMedica::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$casaMedica = CasaMedica::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$casaMedica = CasaMedica::where([['estado',1],[$criterio, 'like', $buscar ]])->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if ($completo == 'true'){
			if ($buscar==''){
				$casaMedica = CasaMedica::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$casaMedica = CasaMedica::where($criterio, 'like', $buscar)->orderBy('id', 'desc');
			}
		}
		else if($completo == 'select')
		{
			$casaMedica = CasaMedica::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
        return[
            'casaMedicas' => $casaMedica
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$casaMedica = new CasaMedica();
			$casaMedica->nombre = $request->nombre;
			$casaMedica->save();
			return Response::json(['message' => 'CasaMedica Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(CasaMedica $casaMedica)
    {
		#if(!$request->ajax())return redirect('/');
		return [
			'id'=> $casaMedica->id,
			'nombre'=> $casaMedica->nombre,
		];
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$casaMedica = CasaMedica::findOrFail($request->id);
		$casaMedica->nombre = $request->nombre;
		$casaMedica->save();
		return Response::json(['message' => 'CasaMedica Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $casaMedica = CasaMedica::findOrFail($request->id);
        $casaMedica->estado = '1';
        $casaMedica->save();
		return Response::json(['message' => 'CasaMedica Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$casaMedica = CasaMedica::findOrFail($request->id);
		$casaMedica->estado = '0';
		$casaMedica->save();
		return Response::json(['message' => 'CasaMedica Desactivada'], 200);

	}
}