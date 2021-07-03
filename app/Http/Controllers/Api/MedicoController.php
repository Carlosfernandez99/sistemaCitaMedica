<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicoEspecialidad;
use App\Models\Medico;
use App\Models\User;
use Auth;
use DB;

class MedicoController extends Controller
{
    public function medicos(Request $request){
        $idEspecialidad = $request->id;
        $obj =Medico::join('medico_especialidad', 'medico.id', '=', 'medico_especialidad.id_medico')
        ->select('medico.id','medico.nombre')
        ->where('medico_especialidad.id_especialidad','=',$idEspecialidad)
        ->get();
        return $obj;
    }

	public function buscarMedico(Request $request){
		$buscar = $request->buscar;
		if($buscar==''){
			$medico= Medico::all();
		}else{
			$medico = Medico::where('medico.nombre', 'like', '%'.$buscar.'%')			
            ->orderBy('medico.id','desc')
			->get();
		}		
        return $medico;
	}

    public function storeMedico(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'login' => 'required|min:3',
                'email' => 'required|email',
                'nombre' => 'nullable|min:5',
                'apellidos' => 'nullable|min:5',
                'telefono' => 'nullable|min:6',
            ]);

            $user = User::create(
                $request->only('login', 'email')
                + [
                    'rol_usuario' => 'doctor',
                    'password' => bcrypt($request->ci)
                ]
            );

            $medico = new Medico();
            $medico->id = $user->id;
            $medico->nombre = $request->nombre; 
            $medico->apellidos = $request->apellidos;
            $medico->telefono = $request->telefono; 
            $medico->save();

            $obj = new MedicoEspecialidad();
            $obj->id_medico = $user->id; 
            $obj->id_especialidad = $request->id_especialidad;
            $obj->save();           

            DB::commit();

            if ($obj){
                $success = true;
            }
            else{
                $success = false;
            }            
            return compact('success');

            return[
                'id'=>$user->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
}
