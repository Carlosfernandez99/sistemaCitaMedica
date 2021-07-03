<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\User;

class PacienteController extends Controller
{
    public function buscarPaciente(Request $request){
		$buscar = $request->buscar;        
        $rol_usuario =auth('api')->user()->rol_usuario;
        switch ($rol_usuario) {
            case "administrador":
                if($buscar==''){
                    $paciente= Paciente::all();
                }else{
                    $paciente = Paciente::where('paciente.nombre', 'like', '%'.$buscar.'%')			
                    ->orderBy('paciente.id','desc')
                    ->get();
                }
                break;
            case "doctor":
                if($buscar==''){
                    $paciente= Paciente::join('cita_medica as cm','paciente.id', '=', 'cm.id_paciente')
                    ->where('cm.id_medico','=',auth('api')->user()->id)	
                    ->orderBy('paciente.id','desc')
                    ->get();
                }else{
                    $paciente = Paciente::join('cita_medica as cm','paciente.id', '=', 'cm.id_paciente')
                    ->where('paciente.nombre', 'like', '%'.$buscar.'%')
                    ->where('cm.id_medico','=',auth('api')->user()->id)		
                    ->orderBy('paciente.id','desc')
                    ->get();
                }
                break;
        }
        return $paciente;
	}

	public function storePaciente(Request $request){
        $request->validate([
            'nombre' => 'required|min:3',
            'email' => 'required|email',
            'apellidos' => 'nullable|min:5',
            'ci' => 'nullable|min:7|max:8',
            'telefono' => 'nullable|min:6',
        ]);

        $user = new User();
        $user->login = $request->login; 
        $user->email = $request->email;
        $user->password = bcrypt($request->ci);
        $user->rol_usuario = 'paciente'; 
        $user->save();

        $obj = new Paciente();
        $obj->id = $user->id;
        $obj->nombre = $request->nombre; 
        $obj->apellidos = $request->apellidos;
        $obj->ci = $request->ci;
        $obj->fecha_nac = $request->fecha_nac;
        $obj->telefono = $request->telefono; 
        $obj->save();

		if ($user){
            $success = true;
        }
    	else{
            $success = false;
        }
        return compact('success');
    }
}
