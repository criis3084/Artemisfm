<?php

namespace App\Http\Controllers;

use App\CategoriaMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class CategoriaMedicamentoController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
        $criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		$count = CategoriaMedicamento::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$categoriaMedicamento = CategoriaMedicamento::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$categoriaMedicamento = CategoriaMedicamento::where([['estado',1],[$criterio, 'like', $buscar]])->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if ($completo == 'true'){
			if ($buscar==''){
				$categoriaMedicamento = CategoriaMedicamento::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$categoriaMedicamento = CategoriaMedicamento::where($criterio, 'like', $buscar )->orderBy('id', 'desc');
			}
		}
		else if($completo == 'select')
		{
			$categoriaMedicamento = CategoriaMedicamento::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
        return[
            'categoriaMedicamentos' => $categoriaMedicamento
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$categoriaMedicamento = new CategoriaMedicamento();
			$categoriaMedicamento->nombre = $request->nombre;
			$categoriaMedicamento->descripcion = $request->descripcion;
			$categoriaMedicamento->save();
			return Response::json(['message' => 'CategoriaMedicamento Creada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }
	
    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$categoriaMedicamento = CategoriaMedicamento::findOrFail($request->id);
			$categoriaMedicamento->nombre = $request->nombre;
			$categoriaMedicamento->descripcion = $request->descripcion;
			$categoriaMedicamento->save();
		return Response::json(['message' => 'CategoriaMedicamento Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $categoriaMedicamento = CategoriaMedicamento::findOrFail($request->id);
        $categoriaMedicamento->estado = '1';
        $categoriaMedicamento->save();
		return Response::json(['message' => 'CategoriaMedicamento Activado'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$categoriaMedicamento = CategoriaMedicamento::findOrFail($request->id);
		$categoriaMedicamento->estado = '0';
		$categoriaMedicamento->save();
		return Response::json(['message' => 'CategoriaMedicamento Desactivado'], 200);
	}
}