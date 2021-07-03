<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

// Public resources
Route::get('/especialidad', 'EspecialidadController@index');
Route::get('/tipoconsulta', 'TipoConsultaController@index');
//JSON
Route::get('/medicos/especialidad/{id}', 'MedicoController@medicos');
Route::get('/horariotrabajo/hours', 'HorarioTrabajoController@hours');

Route::middleware('auth:api')->group(function () {
	Route::post('/logout', 'AuthController@logout');
    
    //Especialidad
    Route::post('/especialidad/guardar', 'EspecialidadController@guardar');

    //Tipo Consulta
    Route::post('/tipoconsulta/guardar', 'TipoConsultaController@guardar');

    //Paciente
    Route::get('/listar/paciente', 'PacienteController@buscarPaciente');
    Route::post('/paciente/guardar', 'PacienteController@storePaciente');

    //Medico
    Route::get('/listar/medico', 'MedicoController@buscarMedico');
    Route::post('/medico/guardar', 'MedicoController@storeMedico');

	// Consulta Medica
	Route::post('/citamedica/store', 'CitaMedicaController@store');
    Route::get('/citamedica/listar', 'CitaMedicaController@consultaMedicaHR');
    Route::post('/citamedica/confirmar/reserva/{id}', 'CitaMedicaController@confirmarReserva');
    Route::post('/citamedica/cancelar/reserva/{id}', 'CitaMedicaController@cancelarReserva');
    Route::post('/citamedica/atendida/{id}', 'CitaMedicaController@confirmarAtendida');
    Route::post('/citamedica/cancelar/confirmada/{id}', 'CitaMedicaController@cancelarConfirmada');    
});