<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\HorarioServiceInterface;
use App\Http\Requests\StoreCitaMedica;
use App\Models\CitaMedica;
use App\Models\TipoConsulta;
use App\Models\Anulacion;
use App\Models\Especialidad;
use Carbon\Carbon;
use DB;
use Validator;


class CitaMedicaController extends Controller
{
    public function index(){
        $rol_usuario = \Auth::user()->rol_usuario;

        if ($rol_usuario == 'administrador') { 
            $consultaPendiente = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->where('cm.estado', 'Reservada')
            ->orderBy('cm.id','desc')->paginate(10);

            $consultaConfirmada = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->where('cm.estado', 'Confirmada')
            ->orderBy('cm.id','desc')->paginate(10);

            $consultaHistorial = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->whereIn('cm.estado', ['Atendida', 'Cancelada'])
            ->orderBy('cm.id','desc')->paginate(10);

        } elseif ($rol_usuario == 'doctor') {
            $consultaPendiente = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')    
            ->where('cm.estado', 'Reservada')
            ->where('cm.id_medico','=', \Auth::user()->id)
            ->orderBy('cm.id','desc')
            ->paginate(10);

            $consultaConfirmada = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->where('cm.estado', 'Confirmada')
            ->where('cm.id_medico','=', \Auth::user()->id)
            ->orderBy('cm.id','desc')
            ->paginate(10);

            $consultaHistorial = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->whereIn('cm.estado', ['Atendida', 'Cancelada'])
            ->where('cm.id_medico','=', \Auth::user()->id)
            ->orderBy('cm.id','desc')
            ->paginate(10);

        } elseif ($rol_usuario == 'paciente') {
            $consultaPendiente = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->where('cm.estado', 'Reservada')
            ->where('cm.id_paciente','=', \Auth::user()->id)
            ->orderBy('cm.id','desc')
            ->paginate(10);

            $consultaConfirmada = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->where('cm.estado', 'Confirmada')
            ->where('cm.id_paciente','=', \Auth::user()->id)
            ->orderBy('cm.id','desc')
            ->paginate(10);

            $consultaHistorial = DB::table('cita_medica as cm')
            ->join('medico as m', 'cm.id_medico', '=', 'm.id')
            ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
            ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
            ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
            ->select('cm.id','cm.descripcion','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
            'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
            ->whereIn('cm.estado', ['Atendida', 'Cancelada'])
            ->where('cm.id_paciente','=', \Auth::user()->id)
            ->orderBy('cm.id','desc')
            ->paginate(10);
        }       

        return view('citamedica.index',compact('consultaPendiente', 'consultaConfirmada', 'consultaHistorial','rol_usuario'));
    }

    public function create(HorarioServiceInterface $horarioTrabajoService){
    	$especialidad = Especialidad::all();
        $tipoconsulta = TipoConsulta::all();

        $especialidadId = old('id_especialidad');
        if ($especialidadId) {
            $especialidad = Especialidad::find($especialidadId);
            $medico = $especialidad->medicos;
        } else {
            $medico = collect();
        }
        
        $date = old('fecha_consulta');
        $medicoId = old('id_medico');
        if ($date && $medicoId) {
            $intervalo = $horarioTrabajoService->getIntervalDisponible($date, $medicoId);
        } else {
            $intervalo = null;
        }

        return view('citamedica.create', compact('especialidad','medico','tipoconsulta','intervalo'));
    }

    public function store(StoreCitaMedica $request){
    	$created = CitaMedica::createForPaciente($request, \Auth::user()->id);
        if ($created)
    	   $notificacion = 'La cita se ha registrado correctamente!';
        else
           $notificacion = 'Ocurrió un problema al registrar la cita médica.';
        
    	return back()->with(compact('notificacion'));
    }

    public function cancelarReservada(Request $request){
        $citamedica = CitaMedica::findOrFail($request->id); 
        $citamedica->estado = 'Cancelada';
        $citamedica->save();

        $notificacion = 'La consulta medica se ha cancelado correctamente.';
	    return back()->with(compact('notificacion'));
    }

    public function cancelarConfir(Request $request){
        $citamedica = DB::table('cita_medica as cm')
        ->join('medico as m', 'cm.id_medico', '=', 'm.id')
        ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
        ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
        ->select('cm.id','cm.fecha_consulta','cm.hora_consulta','cm.estado','m.nombre as nombreMedico',
        'p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
        ->where('cm.id','=',$request->id)->first();

        if ($citamedica->estado == 'Confirmada') {
            $rol_usuario = \Auth::user()->rol_usuario;
            return view('citamedica.anular', compact('citamedica', 'rol_usuario'));
        }

        return redirect('/citamedica');
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
        $obj->id_usuario = \Auth::user()->id; 
        $obj->save();

        $notificacion = 'La consulta medica se ha cancelado correctamente.';
        return redirect('/citamedica')->with(compact('notificacion'));
    }

    public function consultaAtendida(Request $request){
        $citamedica = CitaMedica::findOrFail($request->id); 
        $citamedica->estado = 'Atendida';
        $citamedica->save();

        $notificacion = 'La consulta medica se ha marcado como atendida.';
	    return back()->with(compact('notificacion'));
    }

    public function verConsulta(Request $request){
        $citamedica = DB::table('cita_medica as cm')
        ->join('medico as m', 'cm.id_medico', '=', 'm.id')
        ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
        ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
        ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
        ->select('cm.id','cm.fecha_consulta','cm.hora_consulta','cm.estado','tc.nombre as tipoConsulta',
        'm.nombre as nombreMedico','p.nombre as nombrePaciente','e.nombre as nombreEspecialidad')
        ->where('cm.id','=',$request->id)->first();

        $consultaCancelada = DB::table('anulacion as a')
        ->join('users as u', 'a.id_usuario', '=', 'u.id')
        ->join('cita_medica as cm', 'a.id_cita_medica', '=', 'cm.id')
        ->select('a.id','a.fecha_cancelada','a.justificacion','u.login as nombreAbrogador','u.email','a.id_usuario')
        ->where('cm.id','=',$request->id)->first();

        $rol_usuario = \Auth::user()->rol_usuario;
        return view('citamedica.show', compact('citamedica', 'rol_usuario','consultaCancelada'));
    }

    public function confirmarConsulta(Request $request){
        $citamedica = CitaMedica::findOrFail($request->id); 
        $citamedica->estado = 'Confirmada';
        $citamedica->save();

        $notificacion = 'La consulta medica se ha confirmado correctamente.';
        return redirect('/citamedica')->with(compact('notificacion'));
    }

    public function misPacientes(){
        $id_medico = \Auth::user()->id;

        $paciente = DB::table('cita_medica as cm')
        ->join('paciente as p', 'cm.id_paciente', '=', 'p.id')
        ->join('especialidad as e', 'cm.id_especialidad', '=', 'e.id')
        ->join('tipo_consulta as tc', 'cm.id_tipo_consulta', '=', 'tc.id')
        ->select('p.nombre','p.apellidos','cm.fecha_reserva','cm.fecha_consulta','cm.hora_consulta','tc.nombre as tipoConsulta','cm.estado',
        'e.nombre as nombreEspecialidad')
        ->where('cm.id_medico','=',$id_medico)
        ->orderBy('cm.fecha_consulta','desc')
        ->get();

        return view('medico.mipaciente', compact('paciente'));
    }
}
