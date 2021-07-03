<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
use App\Http\Controllers\Admin\PacienteController;
use App\Http\Controllers\Admin\MedicoController;
use App\Http\Controllers\Admin\EspecialidadController;
use App\Http\Controllers\Admin\TipoConsultaController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Medico\HorarioTrabajoController;
use App\Http\Controllers\CitaMedicaController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
    //Rutas de Especialidad
    Route::get('/especialidad', [EspecialidadController::class, 'index']);
    Route::get('/especialidad/create', [EspecialidadController::class, 'create']);
    Route::get('/especialidad/edit/{id}', [EspecialidadController::class, 'edit']);
    Route::post('/especialidad/store', [EspecialidadController::class, 'store']);
    Route::put('/especialidad/update/{id}', [EspecialidadController::class, 'update']);
    Route::delete('/especialidad/delete/{id}', [EspecialidadController::class, 'destroy']);

    //Rutas Paciente
    Route::get('/paciente', [PacienteController::class, 'index']);
    Route::get('/paciente/create', [PacienteController::class, 'create']);
    Route::get('/paciente/edit/{id}', [PacienteController::class, 'edit']);
    Route::post('/paciente/store', [PacienteController::class, 'store']);
    Route::put('/paciente/update/{id}', [PacienteController::class, 'update']);
    Route::delete('/paciente/delete/{id}', [PacienteController::class, 'destroy']);

    //Rutas Medico
    Route::get('/medico', [MedicoController::class, 'index']);
    Route::get('/medico/create', [MedicoController::class, 'create']);
    Route::get('/medico/edit/{id}', [MedicoController::class, 'edit']);
    Route::post('/medico/store', [MedicoController::class, 'store']);
    Route::put('/medico/update/{id}', [MedicoController::class, 'update']);
    Route::delete('/medico/delete/{id}', [MedicoController::class, 'destroy']);
    Route::get('/medico/detallemedico/{id}', [MedicoController::class, 'verDetalles']);

    //Rutas de Tipo Consulta
    Route::get('/tipoconsulta', [TipoConsultaController::class, 'index']);
    Route::get('/tipoconsulta/create', [TipoConsultaController::class, 'create']);
    Route::get('/tipoconsulta/edit/{id}', [TipoConsultaController::class, 'edit']);
    Route::post('/tipoconsulta/store', [TipoConsultaController::class, 'store']);
    Route::put('/tipoconsulta/update/{id}', [TipoConsultaController::class, 'update']);
    Route::delete('/tipoconsulta/delete/{id}', [TipoConsultaController::class, 'destroy']);

    // Charts
	Route::get('/charts/citamedica/line', [ChartController::class, 'consultamedica']);
	Route::get('/charts/medico/column', [ChartController::class, 'medicos']);
	Route::get('/charts/medico/column/data', [ChartController::class, 'medicoJson']);    
});

Route::middleware(['auth', 'medico'])->namespace('Medico')->group(function () {
    //Rutas de HorarioTrabajo
    Route::get('/horariotrabajo', [HorarioTrabajoController::class, 'edit']); 
    Route::post('/horariotrabajo/store', [HorarioTrabajoController::class, 'store']); 
});

Route::middleware('auth')->group(function () {
    Route::get('/citamedica/create', [CitaMedicaController::class, 'create']);
    Route::post('/citamedica/store', [CitaMedicaController::class, 'store']);
    Route::get('/citamedica', [CitaMedicaController::class, 'index']);

    Route::post('/citamedica/cancelar/{id}', [CitaMedicaController::class, 'cancelarReservada']);

    Route::get('/citamedica/cancelarConfir/{id}', [CitaMedicaController::class, 'cancelarConfir']);
    Route::post('/citamedica/cancelarConfirmada/{id}', [CitaMedicaController::class, 'cancelarConfirmada']);
    Route::post('/citamedica/consultaAtend/{id}', [CitaMedicaController::class, 'consultaAtendida']);

    Route::get('/citamedica/verConsulta/{id}', [CitaMedicaController::class, 'verConsulta']);	
    Route::post('/citamedica/confirmar/{id}', [CitaMedicaController::class, 'confirmarConsulta']);

    //Ruta paciente - Mis Pacientes
    Route::get('/mispacientes', [CitaMedicaController::class, 'misPacientes']);

    //Users
    Route::get('/user/perfil', [UserController::class, 'edit']);
    Route::put('/user/update/login/{id}', [UserController::class, 'modificarLogin']);
    Route::put('/user/update/password/{id}', [UserController::class, 'modificarPassword']);
});