<?php

namespace App\Http\Controllers;

use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\DB;

class PersonaSinAccesoController extends Controller
{

    public function index(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		$count = PersonaSinAcceso::all()->count();
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$persona_sin_acceso = PersonaSinAcceso::with('sector')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$persona_sin_acceso = PersonaSinAcceso::with('sector')->where([[$criterio, 'like', $buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$persona_sin_acceso = PersonaSinAcceso::with('sector')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$persona_sin_acceso = PersonaSinAcceso::with('sector')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}

		return [
			"personas"=>$persona_sin_acceso
		];
    }

    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$persona = new PersonaSinAcceso();
			$persona->nombres = $request->nombres;
			$persona->apellidos = $request->apellidos;
			$persona->CUI = $request->CUI;
			$persona->genero = $request->genero;
			$persona->fecha_nacimiento = $request->fecha_nacimiento;
			$persona->direccion = $request->direccion;
			$persona->numero_telefono = $request->numero_telefono;
			$persona->save();
			return ['id' => $persona->id];
			#return Response::json(['message' => 'Persona Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}

    }

	public function show(PersonaSinAcceso $personaSinAcceso)
    {
		$nino = $personaSinAcceso->nino();
        return[
			"nombres" => $personaSinAcceso->nombres,
			"apellidos"=>$personaSinAcceso->apellidos,
			"CUI"=>$personaSinAcceso->CUI,
			"genero"=>$personaSinAcceso->genero,
			"fecha_nacimiento"=>$personaSinAcceso->fecha_nacimiento,
			"direccion"=>$personaSinAcceso->direccion,
			"numero_telefono"=>$personaSinAcceso->numero_telefono,
			//'sector_id' => $personaSinAcceso->sector_id,
			'sector_nombre' => $personaSinAcceso->sector->nombre
		];
    }

    public function update(Request $request)
    {
		$persona = PersonaSinAcceso::findOrFail($request->id);
		$persona->nombres = $request->nombres;
		$persona->apellidos = $request->apellidos;
		$persona->CUI = $request->CUI;
		$persona->genero = $request->genero;
		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->direccion = $request->direccion;
		$persona->numero_telefono = $request->numero_telefono;
		//$persona->sector_id = $request->sector_id;
		$persona->save();
		return Response::json(['message' => 'Sector Actualizada'], 200);
    }

    public function desactivar(Request $personaSinAcceso)
    {
		$personaSinAcceso = PersonaSinAcceso::findOrFail($personaSinAcceso->id);
        $personaSinAcceso->estado = '0';
		$personaSinAcceso->save();
		return Response::json(['message' => 'Persona Desactivado'], 200);
    }
    public function activar(Request $personaSinAcceso)
    {
		$personaSinAcceso = PersonaSinAcceso::findOrFail($personaSinAcceso->id);
        $personaSinAcceso->estado = '1';
		$personaSinAcceso->save();
		return Response::json(['message' => 'Persona Activada'], 200);
    }
}