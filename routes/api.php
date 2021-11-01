<?php

use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PersonaSinAccesoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@authenticate');
    Route::post('roles', 'AuthController@roles');
    Route::post('register', 'AuthController@authenticate');
    Route::get('logout', 'AuthController@logout');
    Route::get('check', 'AuthController@check');

});

/* Ruta con middleware
Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function () {
    //Aqui pueden meter las rutas que necesitan que alguien este autenticado

    Route::group(['prefix' => 'rol'], function () {
        Route::get('/get', [
            'as' => 'admin.rol', 'uses' => 'RolController@index'
        ]);
        Route::post('/post', [
            'as' => 'admin.rol', 'uses' => 'RolController@store'
        ]);
        Route::put('/update', [
            'as' => 'admin.rol', 'uses' => 'RolController@update'
        ]);
        Route::put('/activar', [
            'as' => 'admin.rol', 'uses' => 'RolController@activar'
        ]);
        Route::put('/desactivar', [
            'as' => 'admin.rol', 'uses' => 'RolController@desactivar'
        ]);
    });

} );
*/

/*
Route::apiResource('rol', 'RolController')->only([
    'index', 'show','update','destroy','store'
]);
*/
/*
Route::apiResources([
	'rol'                   => 'RolController',
	'personaSinAcceso'      => 'PersonaSinAccesoController',
	'aldea'                 => 'AldeaController',
	'escuela'               => 'EscuelaController',
	'ppi'                   => 'PpiController',
	'fotografia'            => 'FotografiaController',
	'grupoPrestamo'         => 'GrupoPrestamoController',
	'destinoInversion'      => 'DestinoInversionController',
	'tipoVivienda'          => 'TipoViviendaController',
	'tipoExamen'            => 'TipoExamenController',
	'tipoCita'              => 'TipoCitaController',
	'tipoPaciente'          => 'TipoPacienteController',
	'profesion'             => 'ProfesionController',
	'casaMedica'            => 'CasaMedicaController',
	'categoriaMedicamento'  => 'CategoriaMedicamentoController',
	'user'               => 'UserController',
	'nino'                  => 'NinoController',
	'encargado'             => 'EncargadoController',
	'padrino'               => 'PadrinoController',
	'sector'                => 'SectorController',
	'constructor'           => 'ConstructorController',
	'microprestamo'         => 'MicroprestamoController',
	'medicamento'           => 'MedicamentoController',
	'proveedor'             => 'ProveedorController',
	'paciente'              => 'PacienteController',
	'tutor'                 => 'TutorController',
	'administrativo'        => 'AdministrativoController',
	'clinico'               => 'ClinicoController',
	'apadrinamiento'        => 'ApadrinamientoController',
	'relacion'              => 'RelacionController',
	'vivienda'              => 'ViviendaController',
	'historialPpi'          => 'HistorialPpiController',
	'historialFotografia'   => 'HistorialFotografiaController',
	'detalleIntegrante'     => 'DetalleIntegranteController',
	'examen'                => 'ExamenController',
	'beneficio'             => 'BeneficioController',
	'lote'                  => 'LoteController',
	'ingresoMedicamento'    => 'IngresoMedicamentoController',
	'salidaMedicamento'     => 'SalidaMedicamentoController',
	'tutoria'               => 'TutoriaController',
	'correspondencia'       => 'CorrespondenciaController',
	'abonoPrestamo'         => 'AbonoPrestamoController',
	'abonoVivienda'         => 'AbonoViviendaController',
	'cita'                  => 'CitaController',
	'detalleBeneficio'      => 'DetalleBeneficioController',
	'detalleIngreso'        => 'DetalleIngresoController',
	'detalleSalida'         => 'DetalleSalidaController',
	'historialExamen'       => 'HistorialExamenController',
	'historialClinico'      => 'HistorialClinicoController',
	'receta'                => 'RecetaController',
	'asignacionMedicamento' => 'AsignacionMedicamentoController'
]);
*/
/*
Route::group(['prefix' => 'rol'], function () {
    Route::get('/get', [
        'as' => 'admin.rol', 'uses' => 'RolController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.rol', 'uses' => 'RolController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.rol', 'uses' => 'RolController@update'
    ]);
    Route::put('/activar', [
        'as' => 'admin.rol', 'uses' => 'RolController@activar'
    ]);
    Route::put('/desactivar', [
        'as' => 'admin.rol', 'uses' => 'RolController@desactivar'
    ]);
});
*/

Route::group(['prefix' => 'rol'], function () {
    Route::get('/get', [
        'as' => 'admin.rol', 'uses' => 'RolController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.rol', 'uses' => 'RolController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.rol', 'uses' => 'RolController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.rol', 'uses' => 'RolController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.rol', 'uses' => 'RolController@desactivar'
    ]);
});

Route::group(['prefix' => 'personaSinAcceso'], function () {
    Route::get('/get', [
        'as' => 'admin.personaSinAcceso', 'uses' => 'PersonaSinAccesoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.personaSinAcceso', 'uses' => 'PersonaSinAccesoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.personaSinAcceso', 'uses' => 'PersonaSinAccesoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.personaSinAcceso', 'uses' => 'PersonaSinAccesoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.personaSinAcceso', 'uses' => 'PersonaSinAccesoController@desactivar'
    ]);
});
Route::group(['prefix' => 'aldea'], function () {
    Route::get('/get', [
        'as' => 'admin.aldea', 'uses' => 'AldeaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.aldea', 'uses' => 'AldeaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.aldea', 'uses' => 'AldeaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.aldea', 'uses' => 'AldeaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.aldea', 'uses' => 'AldeaController@desactivar'
    ]);
});
Route::group(['prefix' => 'escuela'], function () {
    Route::get('/get', [
        'as' => 'admin.escuela', 'uses' => 'EscuelaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.escuela', 'uses' => 'EscuelaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.escuela', 'uses' => 'EscuelaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.escuela', 'uses' => 'EscuelaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.escuela', 'uses' => 'EscuelaController@desactivar'
    ]);
});
Route::group(['prefix' => 'ppi'], function () {
    Route::get('/get', [
        'as' => 'admin.ppi', 'uses' => 'PpiController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.ppi', 'uses' => 'PpiController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.ppi', 'uses' => 'PpiController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.ppi', 'uses' => 'PpiController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.ppi', 'uses' => 'PpiController@desactivar'
    ]);
});
Route::group(['prefix' => 'fotografia'], function () {
    Route::get('/get', [
        'as' => 'admin.fotografia', 'uses' => 'FotografiaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.fotografia', 'uses' => 'FotografiaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.fotografia', 'uses' => 'FotografiaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.fotografia', 'uses' => 'FotografiaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.fotografia', 'uses' => 'FotografiaController@desactivar'
    ]);
});
Route::group(['prefix' => 'grupoPrestamo'], function () {
    Route::get('/get', [
        'as' => 'admin.grupoPrestamo', 'uses' => 'GrupoPrestamoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.grupoPrestamo', 'uses' => 'GrupoPrestamoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.grupoPrestamo', 'uses' => 'GrupoPrestamoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.grupoPrestamo', 'uses' => 'GrupoPrestamoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.grupoPrestamo', 'uses' => 'GrupoPrestamoController@desactivar'
    ]);
    Route::put('/updateDatos', [
        'as' => 'admin.grupoPrestamo', 'uses' => 'GrupoPrestamoController@updateDatos'
    ]);
});
Route::group(['prefix' => 'destinoInversion'], function () {
    Route::get('/get', [
        'as' => 'admin.destinoInversion', 'uses' => 'DestinoInversionController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.destinoInversion', 'uses' => 'DestinoInversionController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.destinoInversion', 'uses' => 'DestinoInversionController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.destinoInversion', 'uses' => 'DestinoInversionController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.destinoInversion', 'uses' => 'DestinoInversionController@desactivar'
    ]);
});
Route::group(['prefix' => 'tipoVivienda'], function () {
    Route::get('/get', [
        'as' => 'admin.tipoVivienda', 'uses' => 'TipoViviendaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.tipoVivienda', 'uses' => 'TipoViviendaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.tipoVivienda', 'uses' => 'TipoViviendaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.tipoVivienda', 'uses' => 'TipoViviendaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.tipoVivienda', 'uses' => 'TipoViviendaController@desactivar'
    ]);
});
Route::group(['prefix' => 'tipoExamen'], function () {
    Route::get('/get', [
        'as' => 'admin.tipoExamen', 'uses' => 'TipoExamenController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.tipoExamen', 'uses' => 'TipoExamenController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.tipoExamen', 'uses' => 'TipoExamenController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.tipoExamen', 'uses' => 'TipoExamenController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.tipoExamen', 'uses' => 'TipoExamenController@desactivar'
    ]);
});
Route::group(['prefix' => 'tipoCita'], function () {
    Route::get('/get', [
        'as' => 'admin.tipoCita', 'uses' => 'TipoCitaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.tipoCita', 'uses' => 'TipoCitaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.tipoCita', 'uses' => 'TipoCitaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.tipoCita', 'uses' => 'TipoCitaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.tipoCita', 'uses' => 'TipoCitaController@desactivar'
    ]);
});
Route::group(['prefix' => 'tipoPaciente'], function () {
    Route::get('/get', [
        'as' => 'admin.tipoPaciente', 'uses' => 'TipoPacienteController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.tipoPaciente', 'uses' => 'TipoPacienteController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.tipoPaciente', 'uses' => 'TipoPacienteController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.tipoPaciente', 'uses' => 'TipoPacienteController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.tipoPaciente', 'uses' => 'TipoPacienteController@desactivar'
    ]);
});
Route::group(['prefix' => 'profesion'], function () {
    Route::get('/get', [
        'as' => 'admin.profesion', 'uses' => 'ProfesionController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.profesion', 'uses' => 'ProfesionController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.profesion', 'uses' => 'ProfesionController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.profesion', 'uses' => 'ProfesionController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.profesion', 'uses' => 'ProfesionController@desactivar'
    ]);
});
Route::group(['prefix' => 'casaMedica'], function () {
    Route::get('/get', [
        'as' => 'admin.casaMedica', 'uses' => 'CasaMedicaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.casaMedica', 'uses' => 'CasaMedicaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.casaMedica', 'uses' => 'CasaMedicaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.casaMedica', 'uses' => 'CasaMedicaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.casaMedica', 'uses' => 'CasaMedicaController@desactivar'
    ]);
});
Route::group(['prefix' => 'categoriaMedicamento'], function () {
    Route::get('/get', [
        'as' => 'admin.categoriaMedicamento', 'uses' => 'CategoriaMedicamentoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.categoriaMedicamento', 'uses' => 'CategoriaMedicamentoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.categoriaMedicamento', 'uses' => 'CategoriaMedicamentoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.categoriaMedicamento', 'uses' => 'CategoriaMedicamentoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.categoriaMedicamento', 'uses' => 'CategoriaMedicamentoController@desactivar'
    ]);
});
Route::group(['prefix' => 'user'], function () {
    Route::get('/get', [
        'as' => 'admin.user', 'uses' => 'UserController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.user', 'uses' => 'UserController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.user', 'uses' => 'UserController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.user', 'uses' => 'UserController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.user', 'uses' => 'UserController@desactivar'
    ]);
    Route::post('/imagen', [
        'as' => 'admin.user', 'uses' => 'UserController@imagen'
    ]);
});
Route::group(['prefix' => 'permisos'], function () {
    Route::get('/get', [
        'as' => 'admin.permisos', 'uses' => 'PermisosController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.permisos', 'uses' => 'PermisosController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.permisos', 'uses' => 'PermisosController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.permisos', 'uses' => 'PermisosController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.permisos', 'uses' => 'PermisosController@desactivar'
    ]);
});
Route::group(['prefix' => 'nino'], function () {
    Route::get('/get', [
        'as' => 'admin.nino', 'uses' => 'NinoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.nino', 'uses' => 'NinoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.nino', 'uses' => 'NinoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.nino', 'uses' => 'NinoController@activar'
	]);
    Route::put('/apadrinar', [
        'as' => 'admin.nino', 'uses' => 'NinoController@apadrinar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.nino', 'uses' => 'NinoController@desactivar'
	]);
	Route::post('/imagen', [
        'as' => 'admin.nino', 'uses' => 'NinoController@imagen'
    ]);
    Route::get('/apadrinamientos', [
        'as' => 'admin.nino', 'uses' => 'NinoController@apadrinamientos'
    ]);
});
Route::group(['prefix' => 'encargado'], function () {
    Route::get('/get', [
        'as' => 'admin.encargado', 'uses' => 'EncargadoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.encargado', 'uses' => 'EncargadoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.encargado', 'uses' => 'EncargadoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.encargado', 'uses' => 'EncargadoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.encargado', 'uses' => 'EncargadoController@desactivar'
	]);
	Route::post('/imagen', [
        'as' => 'admin.encargado', 'uses' => 'EncargadoController@imagen'
    ]);
});
Route::group(['prefix' => 'padrino'], function () {
    Route::get('/get', [
        'as' => 'admin.padrino', 'uses' => 'PadrinoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.padrino', 'uses' => 'PadrinoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.padrino', 'uses' => 'PadrinoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.padrino', 'uses' => 'PadrinoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.padrino', 'uses' => 'PadrinoController@desactivar'
	]);
	Route::post('/imagen', [
        'as' => 'admin.padrino', 'uses' => 'PadrinoController@imagen'
    ]);
});
Route::group(['prefix' => 'sector'], function () {
    Route::get('/get', [
        'as' => 'admin.sector', 'uses' => 'SectorController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.sector', 'uses' => 'SectorController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.sector', 'uses' => 'SectorController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.sector', 'uses' => 'SectorController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.sector', 'uses' => 'SectorController@desactivar'
    ]);
});
Route::group(['prefix' => 'constructor'], function () {
    Route::get('/get', [
        'as' => 'admin.constructor', 'uses' => 'ConstructorController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.constructor', 'uses' => 'ConstructorController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.constructor', 'uses' => 'ConstructorController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.constructor', 'uses' => 'ConstructorController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.constructor', 'uses' => 'ConstructorController@desactivar'
    ]);
});
Route::group(['prefix' => 'microprestamo'], function () {
    Route::get('/get', [
        'as' => 'admin.microprestamo', 'uses' => 'MicroprestamoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.microprestamo', 'uses' => 'MicroprestamoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.microprestamo', 'uses' => 'MicroprestamoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.microprestamo', 'uses' => 'MicroprestamoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.microprestamo', 'uses' => 'MicroprestamoController@desactivar'
    ]);
});
Route::group(['prefix' => 'medicamento'], function () {
    Route::get('/get', [
        'as' => 'admin.medicamento', 'uses' => 'MedicamentoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.medicamento', 'uses' => 'MedicamentoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.medicamento', 'uses' => 'MedicamentoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.medicamento', 'uses' => 'MedicamentoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.medicamento', 'uses' => 'MedicamentoController@desactivar'
    ]);
});
Route::group(['prefix' => 'proveedor'], function () {
    Route::get('/get', [
        'as' => 'admin.proveedor', 'uses' => 'ProveedorController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.proveedor', 'uses' => 'ProveedorController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.proveedor', 'uses' => 'ProveedorController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.proveedor', 'uses' => 'ProveedorController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.proveedor', 'uses' => 'ProveedorController@desactivar'
    ]);
});
Route::group(['prefix' => 'paciente'], function () {
    Route::get('/get', [
        'as' => 'admin.paciente', 'uses' => 'PacienteController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.paciente', 'uses' => 'PacienteController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.paciente', 'uses' => 'PacienteController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.paciente', 'uses' => 'PacienteController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.paciente', 'uses' => 'PacienteController@desactivar'
    ]);
});
Route::group(['prefix' => 'tutor'], function () {
    Route::get('/get', [
        'as' => 'admin.tutor', 'uses' => 'TutorController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.tutor', 'uses' => 'TutorController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.tutor', 'uses' => 'TutorController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.tutor', 'uses' => 'TutorController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.tutor', 'uses' => 'TutorController@desactivar'
    ]);
    Route::post('/imagen', [
        'as' => 'admin.tutor', 'uses' => 'TutorController@imagen'
    ]);
});
Route::group(['prefix' => 'administrativo'], function () {
    Route::get('/get', [
        'as' => 'admin.administrativo', 'uses' => 'AdministrativoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.administrativo', 'uses' => 'AdministrativoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.administrativo', 'uses' => 'AdministrativoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.administrativo', 'uses' => 'AdministrativoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.administrativo', 'uses' => 'AdministrativoController@desactivar'
    ]);
});
Route::group(['prefix' => 'clinico'], function () {
    Route::get('/get', [
        'as' => 'admin.clinico', 'uses' => 'ClinicoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.clinico', 'uses' => 'ClinicoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.clinico', 'uses' => 'ClinicoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.clinico', 'uses' => 'ClinicoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.clinico', 'uses' => 'ClinicoController@desactivar'
    ]);
    Route::post('/imagen', [
        'as' => 'admin.clinico', 'uses' => 'ClinicoController@imagen'
    ]);
});
Route::group(['prefix' => 'apadrinamiento'], function () {
    Route::get('/get', [
        'as' => 'admin.apadrinamiento', 'uses' => 'ApadrinamientoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.apadrinamiento', 'uses' => 'ApadrinamientoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.apadrinamiento', 'uses' => 'ApadrinamientoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.apadrinamiento', 'uses' => 'ApadrinamientoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.apadrinamiento', 'uses' => 'ApadrinamientoController@desactivar'
    ]);
});
Route::group(['prefix' => 'relacion'], function () {
    Route::get('/get', [
        'as' => 'admin.relacion', 'uses' => 'RelacionController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.relacion', 'uses' => 'RelacionController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.relacion', 'uses' => 'RelacionController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.relacion', 'uses' => 'RelacionController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.relacion', 'uses' => 'RelacionController@desactivar'
    ]);
    Route::put('/eliminar', [
        'as' => 'admin.relacion', 'uses' => 'RelacionController@eliminar'
    ]);
});
Route::group(['prefix' => 'vivienda'], function () {
    Route::get('/get', [
        'as' => 'admin.vivienda', 'uses' => 'ViviendaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.vivienda', 'uses' => 'ViviendaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.vivienda', 'uses' => 'ViviendaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.vivienda', 'uses' => 'ViviendaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.vivienda', 'uses' => 'ViviendaController@desactivar'
    ]);
    Route::post('/imagen', [
        'as' => 'admin.vivienda', 'uses' => 'ViviendaController@imagen'
    ]);
    Route::get('/reporteViviendas', [
        'as' => 'admin.vivienda', 'uses' => 'ViviendaController@reporteViviendas'
    ]);
});
Route::group(['prefix' => 'historialPpi'], function () {
    Route::get('/get', [
        'as' => 'admin.historialPpi', 'uses' => 'HistorialPpiController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.historialPpi', 'uses' => 'HistorialPpiController@store'
	]);
	/*
    Route::put('/update', [
        'as' => 'admin.historialPpi', 'uses' => 'HistorialPpiController@update'
	]);
	*/
    Route::put('/activar', [
        'as' => 'admin.historialPpi', 'uses' => 'HistorialPpiController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.historialPpi', 'uses' => 'HistorialPpiController@desactivar'
    ]);
});
Route::group(['prefix' => 'historialFotografia'], function () {
    Route::get('/get', [
        'as' => 'admin.historialFotografia', 'uses' => 'HistorialFotografiaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.historialFotografia', 'uses' => 'HistorialFotografiaController@store'
	]);
	Route::put('/update', [
        'as' => 'admin.historialFotografia', 'uses' => 'HistorialFotografiaController@update'
	]);
	Route::put('/activar', [
        'as' => 'admin.historialFotografia', 'uses' => 'HistorialFotografiaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.historialFotografia', 'uses' => 'HistorialFotografiaController@desactivar'
	]);
	Route::post('/imagen', [
        'as' => 'admin.historialFotografia', 'uses' => 'HistorialFotografiaController@imagen'
    ]);
});
Route::group(['prefix' => 'detalleIntegrante'], function () {
    Route::get('/get', [
        'as' => 'admin.detalleIntegrante', 'uses' => 'DetalleIntegranteController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.detalleIntegrante', 'uses' => 'DetalleIntegranteController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.detalleIntegrante', 'uses' => 'DetalleIntegranteController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.detalleIntegrante', 'uses' => 'DetalleIntegranteController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.detalleIntegrante', 'uses' => 'DetalleIntegranteController@desactivar'
    ]);
    Route::put('/updatefecha', [
        'as' => 'admin.detalleIntegrante', 'uses' => 'DetalleIntegranteController@ActualizarFecha'
    ]);
    Route::put('/updateGrupo', [
        'as' => 'admin.detalleIntegrante', 'uses' => 'DetalleIntegranteController@ActualizarGrupo'
    ]);
});
Route::group(['prefix' => 'examen'], function () {
    Route::get('/get', [
        'as' => 'admin.examen', 'uses' => 'ExamenController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.examen', 'uses' => 'ExamenController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.examen', 'uses' => 'ExamenController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.examen', 'uses' => 'ExamenController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.examen', 'uses' => 'ExamenController@desactivar'
    ]);
    Route::post('/imagen', [
        'as' => 'admin.examen', 'uses' => 'ExamenController@imagen'
    ]);
});
Route::group(['prefix' => 'beneficio'], function () {
    Route::get('/get', [
        'as' => 'admin.beneficio', 'uses' => 'BeneficioController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.beneficio', 'uses' => 'BeneficioController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.beneficio', 'uses' => 'BeneficioController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.beneficio', 'uses' => 'BeneficioController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.beneficio', 'uses' => 'BeneficioController@desactivar'
    ]);
});
Route::group(['prefix' => 'lote'], function () {
    Route::get('/get', [
        'as' => 'admin.lote', 'uses' => 'LoteController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.lote', 'uses' => 'LoteController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.lote', 'uses' => 'LoteController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.lote', 'uses' => 'LoteController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.lote', 'uses' => 'LoteController@desactivar'
    ]);
});
Route::group(['prefix' => 'ingresoMedicamento'], function () {
    Route::get('/get', [
        'as' => 'admin.ingresoMedicamento', 'uses' => 'IngresoMedicamentoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.ingresoMedicamento', 'uses' => 'IngresoMedicamentoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.ingresoMedicamento', 'uses' => 'IngresoMedicamentoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.ingresoMedicamento', 'uses' => 'IngresoMedicamentoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.ingresoMedicamento', 'uses' => 'IngresoMedicamentoController@desactivar'
    ]);
    Route::get('/reporteIngreso', [
        'as' => 'admin.ingresoMedicamento', 'uses' => 'IngresoMedicamentoController@reporteIngreso'
    ]);
});
Route::group(['prefix' => 'salidaMedicamento'], function () {
    Route::get('/get', [
        'as' => 'admin.salidaMedicamento', 'uses' => 'SalidaMedicamentoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.salidaMedicamento', 'uses' => 'SalidaMedicamentoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.salidaMedicamento', 'uses' => 'SalidaMedicamentoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.salidaMedicamento', 'uses' => 'SalidaMedicamentoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.salidaMedicamento', 'uses' => 'SalidaMedicamentoController@desactivar'
    ]);
    Route::get('/reporteSalidas', [
        'as' => 'admin.salidaMedicamento', 'uses' => 'SalidaMedicamentoController@reporteSalidas'
    ]);
});
Route::group(['prefix' => 'tutoria'], function () {
    Route::get('/get', [
        'as' => 'admin.tutoria', 'uses' => 'TutoriaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.tutoria', 'uses' => 'TutoriaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.tutoria', 'uses' => 'TutoriaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.tutoria', 'uses' => 'TutoriaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.tutoria', 'uses' => 'TutoriaController@desactivar'
    ]);
    Route::get('/tutoriasmen', [
        'as' => 'admin.tutoria', 'uses' => 'TutoriaController@tutoriasmen'
    ]);
});
Route::group(['prefix' => 'correspondencia'], function () {
    Route::get('/get', [
        'as' => 'admin.correspondencia', 'uses' => 'CorrespondenciaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.correspondencia', 'uses' => 'CorrespondenciaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.correspondencia', 'uses' => 'CorrespondenciaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.correspondencia', 'uses' => 'CorrespondenciaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.correspondencia', 'uses' => 'CorrespondenciaController@desactivar'
    ]);
});
Route::group(['prefix' => 'abonoPrestamo'], function () {
    Route::get('/get', [
        'as' => 'admin.abonoPrestamo', 'uses' => 'AbonoPrestamoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.abonoPrestamo', 'uses' => 'AbonoPrestamoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.abonoPrestamo', 'uses' => 'AbonoPrestamoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.abonoPrestamo', 'uses' => 'AbonoPrestamoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.abonoPrestamo', 'uses' => 'AbonoPrestamoController@desactivar'
    ]);
});
Route::group(['prefix' => 'abonoVivienda'], function () {
    Route::get('/get', [
        'as' => 'admin.abonoVivienda', 'uses' => 'AbonoViviendaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.abonoVivienda', 'uses' => 'AbonoViviendaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.abonoVivienda', 'uses' => 'AbonoViviendaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.abonoVivienda', 'uses' => 'AbonoViviendaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.abonoVivienda', 'uses' => 'AbonoViviendaController@desactivar'
    ]);
});
Route::group(['prefix' => 'cita'], function () {
    Route::get('/get', [
        'as' => 'admin.cita', 'uses' => 'CitaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.cita', 'uses' => 'CitaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.cita', 'uses' => 'CitaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.cita', 'uses' => 'CitaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.cita', 'uses' => 'CitaController@desactivar'
    ]);
    Route::get('/reporteCitas', [
        'as' => 'admin.cita', 'uses' => 'CitaController@reporteCitas'
    ]);
});
Route::group(['prefix' => 'detalleBeneficio'], function () {
    Route::get('/get', [
        'as' => 'admin.detalleBeneficio', 'uses' => 'DetalleBeneficioController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.detalleBeneficio', 'uses' => 'DetalleBeneficioController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.detalleBeneficio', 'uses' => 'DetalleBeneficioController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.detalleBeneficio', 'uses' => 'DetalleBeneficioController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.detalleBeneficio', 'uses' => 'DetalleBeneficioController@desactivar'
    ]);
});
Route::group(['prefix' => 'detalleIngreso'], function () {
    Route::get('/get', [
        'as' => 'admin.detalleIngreso', 'uses' => 'DetalleIngresoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.detalleIngreso', 'uses' => 'DetalleIngresoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.detalleIngreso', 'uses' => 'DetalleIngresoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.detalleIngreso', 'uses' => 'DetalleIngresoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.detalleIngreso', 'uses' => 'DetalleIngresoController@desactivar'
    ]);
});
Route::group(['prefix' => 'detalleSalida'], function () {
    Route::get('/get', [
        'as' => 'admin.detalleSalida', 'uses' => 'DetalleSalidaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.detalleSalida', 'uses' => 'DetalleSalidaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.detalleSalida', 'uses' => 'DetalleSalidaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.detalleSalida', 'uses' => 'DetalleSalidaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.detalleSalida', 'uses' => 'DetalleSalidaController@desactivar'
    ]);
});
Route::group(['prefix' => 'historialExamen'], function () {
    Route::get('/get', [
        'as' => 'admin.historialExamen', 'uses' => 'HistorialExamenController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.historialExamen', 'uses' => 'HistorialExamenController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.historialExamen', 'uses' => 'HistorialExamenController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.historialExamen', 'uses' => 'HistorialExamenController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.historialExamen', 'uses' => 'HistorialExamenController@desactivar'
    ]);
    Route::put('/programar', [
        'as' => 'admin.historialExamen', 'uses' => 'HistorialExamenController@programar'
    ]);
});
Route::group(['prefix' => 'historialClinico'], function () {
    Route::get('/get', [
        'as' => 'admin.historialClinico', 'uses' => 'HistorialClinicoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.historialClinico', 'uses' => 'HistorialClinicoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.historialClinico', 'uses' => 'HistorialClinicoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.historialClinico', 'uses' => 'HistorialClinicoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.historialClinico', 'uses' => 'HistorialClinicoController@desactivar'
    ]);
});
Route::group(['prefix' => 'receta'], function () {
    Route::get('/get', [
        'as' => 'admin.receta', 'uses' => 'RecetaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.receta', 'uses' => 'RecetaController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.receta', 'uses' => 'RecetaController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.receta', 'uses' => 'RecetaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.receta', 'uses' => 'RecetaController@desactivar'
    ]);
});
Route::group(['prefix' => 'asignacionMedicamento'], function () {
    Route::get('/get', [
        'as' => 'admin.asignacionMedicamento', 'uses' => 'AsignacionMedicamentoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.asignacionMedicamento', 'uses' => 'AsignacionMedicamentoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.asignacionMedicamento', 'uses' => 'AsignacionMedicamentoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.asignacionMedicamento', 'uses' => 'AsignacionMedicamentoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.asignacionMedicamento', 'uses' => 'AsignacionMedicamentoController@desactivar'
    ]);
    
});
Route::group(['prefix' => 'historialAbonoVivienda'], function () {
    Route::get('/get', [
        'as' => 'admin.historialAbonoVivienda', 'uses' => 'HistorialAbonoViviendaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.historialAbonoVivienda', 'uses' => 'HistorialAbonoViviendaController@store'
    ]);
    Route::put('/activar', [
        'as' => 'admin.historialAbonoVivienda', 'uses' => 'HistorialAbonoViviendaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.historialAbonoVivienda', 'uses' => 'HistorialAbonoViviendaController@desactivar'
    ]);
});
Route::group(['prefix' => 'historialCorrespondencia'], function () {
    Route::get('/get', [
        'as' => 'admin.historialCorrespondencia', 'uses' => 'HistorialCorrespondenciaController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.historialCorrespondencia', 'uses' => 'HistorialCorrespondenciaController@store'
    ]);
    Route::put('/activar', [
        'as' => 'admin.historialCorrespondencia', 'uses' => 'HistorialCorrespondenciaController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.historialCorrespondencia', 'uses' => 'HistorialCorrespondenciaController@desactivar'
    ]);
    Route::post('/imagen', [
        'as' => 'admin.historialCorrespondencia', 'uses' => 'HistorialCorrespondenciaController@imagen'
    ]);
});
Route::group(['prefix' => 'historialEstudio'], function () {
    Route::get('/get', [
        'as' => 'admin.historialEstudio', 'uses' => 'HistorialEstudioController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.historialEstudio', 'uses' => 'HistorialEstudioController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.historialEstudio', 'uses' => 'HistorialEstudioController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.historialEstudio', 'uses' => 'HistorialEstudioController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.historialEstudio', 'uses' => 'HistorialEstudioController@desactivar'
    ]);
});
Route::group(['prefix' => 'estudioSocioeconomico'], function () {
    Route::get('/get', [
        'as' => 'admin.estudioSocioeconomico', 'uses' => 'EstudioSocioeconomicoController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.estudioSocioeconomico', 'uses' => 'EstudioSocioeconomicoController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.estudioSocioeconomico', 'uses' => 'EstudioSocioeconomicoController@update'
	]);
    Route::put('/activar', [
        'as' => 'admin.estudioSocioeconomico', 'uses' => 'EstudioSocioeconomicoController@activar'
	]);
    Route::put('/desactivar', [
        'as' => 'admin.estudioSocioeconomico', 'uses' => 'EstudioSocioeconomicoController@desactivar'
    ]);
});