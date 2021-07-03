<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCitaMedica;
use App\Models\CitaMedica;
use App\Models\Anulacion;
use Auth;
use DB;
use Carbon\Carbon;

class CitaMedicaController extends Controller
{
    public function consultaMedicaHR(Request $request){
        $tipoEstado = $request->tipoEstado;
        $rol_usuario =auth('api')->user()->rol_usuario;
        switch ($rol_usuario) {
            case "administrador":
                if ($tipoEstado == 'historial') { 
                    $cita = DB::table('cita_medica as cm')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
                    ->whereIn('cm.estado', ['Atendida', 'Cancelada'])
                    ->orderBy('cm.id','desc')
                    ->get();
        
                } elseif ($tipoEstado == 'reservada') {
                    $cita = DB::table('cita_medica as cm')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')    
                    ->where('cm.estado', 'Reservada')
                    ->orderBy('cm.id','desc')
                    ->get();
        
                } elseif ($tipoEstado == 'confirmada') {
                    $cita = DB::table('cita_medica as cm')
                    ->join('medico as m', 'cm.id_medico', '=', 'm.id')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
                    ->where('cm.estado', 'Confirmada')
                    ->orderBy('cm.id','desc')
                    ->get();
                }
                break;
            case "doctor":
                if ($tipoEstado == 'historial') { 
                    $cita = DB::table('cita_medica as cm')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
                    ->whereIn('cm.estado', ['Atendida', 'Cancelada'])
                    ->where('cm.id_medico','=',auth('api')->user()->id)
                    ->orderBy('cm.id','desc')
                    ->get();
        
                } elseif ($tipoEstado == 'reservada') {
                    $cita = DB::table('cita_medica as cm')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')    
                    ->where('cm.estado', 'Reservada')
                    ->where('cm.id_medico','=',auth('api')->user()->id)
                    ->orderBy('cm.id','desc')
                    ->get();
        
                } elseif ($tipoEstado == 'confirmada') {
                    $cita = DB::table('cita_medica as cm')
                    ->join('medico as m', 'cm.id_medico', '=', 'm.id')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
                    ->where('cm.estado', 'Confirmada')
                    ->where('cm.id_medico','=',auth('api')->user()->id)
                    ->orderBy('cm.id','desc')
                    ->get();
                }
                break;
            case "paciente":
                if ($tipoEstado == 'historial') { 
                    $cita = DB::table('cita_medica as cm')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
                    ->whereIn('cm.estado', ['Atendida', 'Cancelada'])
                    ->where('cm.id_paciente','=',auth('api')->user()->id)
                    ->orderBy('cm.id','desc')
                    ->get();
        
                } elseif ($tipoEstado == 'reservada') {
                    $cita = DB::table('cita_medica as cm')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')    
                    ->where('cm.estado', 'Reservada')
                    ->where('cm.id_paciente','=',auth('api')->user()->id)
                    ->orderBy('cm.id','desc')
                    ->get();
        
                } elseif ($tipoEstado == 'confirmada') {
                    $cita = DB::table('cita_medica as cm')
                    ->join('medico as m', 'cm.id_medico', '=', 'm.id')
                    ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
                    ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
                    ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
                    ->select('cm.id','cm.descripcion','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
                    'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
                    ->where('cm.estado', 'Confirmada')
                    ->where('cm.id_paciente','=',auth('api')->user()->id)
                    ->orderBy('cm.id','desc')
                    ->get();
                }
                break;
        }
        return $cita;
    }

    public function store(StoreCitaMedica $request){
    	$id_paciente = auth('api')->user()->id;    	
    	$citamedica = CitaMedica::createForPaciente($request, $id_paciente);    	
    	if ($citamedica){
            $success = true;
        }
    	else{
            $success = false;
        }

    	return compact('success');
    }

    public function confirmarReserva(Request $request){ 
        $citamedica = CitaMedica::findOrFail($request->id); 
        $citamedica->estado = 'Confirmada';
        $citamedica->save(); 	
    	if ($citamedica){
            $success = true;
        }
    	else{
            $success = false;
        }

    	return compact('success');
    }

    public function cancelarReserva(Request $request){ 
        $citamedica = CitaMedica::findOrFail($request->id); 
        $citamedica->estado = 'Cancelada';
        $citamedica->save(); 	
    	if ($citamedica){
            $success = true;
        }
    	else{
            $success = false;
        }

    	return compact('success');
    }

    public function confirmarAtendida(Request $request){ 
        $citamedica = CitaMedica::findOrFail($request->id); 
        $citamedica->estado = 'Atendida';
        $citamedica->save(); 	
    	if ($citamedica) 
    		$success = true;
    	else 
    		$success = false;

    	return compact('success');
    }

    public function cancelarConfirmada(Request $request){ 
        $citamedica = CitaMedica::findOrFail($request->id); 
        $citamedica->estado = 'Cancelada';
        $citamedica->save(); 	

        $myDate= Carbon::now();
        $obj = new Anulacion();
        $obj->fecha_cancelada = $myDate->toDateString(); 
        $obj->justificacion = $request->justificacion; 
        $obj->id_cita_medica = $request->id; 
        $obj->id_usuario = auth('api')->user()->id; 
        $obj->save();

    	if ($obj) 
    		$success = true;
    	else 
    		$success = false;

    	return compact('success');
    }
}
