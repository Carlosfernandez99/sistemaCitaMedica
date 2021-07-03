<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use App\Models\User;
use App\Models\Medico;
use App\Models\MedicoEspecialidad;
use DB;

class MedicoController extends Controller
{
    public function index(){
        $medico= Medico::join('users', 'users.id', '=', 'medico.id')
        ->select('medico.id','medico.nombre','medico.apellidos','medico.telefono','users.login','users.email')
        ->get();
        return view('medico.index', compact('medico'));
    }

    public function create(){
        $especialidad = Especialidad::all();
        return view('medico.create', compact('especialidad'));
    }

    public function store(Request $request){
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
                    'password' => bcrypt($request->password)
                ]
            );

            $obj = new Medico();
            $obj->id = $user->id;
            $obj->nombre = $request->nombre; 
            $obj->apellidos = $request->apellidos;
            $obj->telefono = $request->telefono; 
            $obj->save();

            $detalle = $request->especialidad;            
            foreach($detalle as $key=>$value) {
                $obj = new MedicoEspecialidad();
                $obj->id_medico = $user->id; 
                $obj->id_especialidad = $value;
                $obj->save();
            }            

            DB::commit();

            $notificacion = 'El médico se ha registrado correctamente.';
            return redirect('/medico')->with(compact('notificacion'));
            return[
                'id'=>$user->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function edit($id){
        $medico = Medico::join('users', 'medico.id', '=', 'users.id')
        ->select('users.id','users.login','users.email','users.password','medico.nombre','medico.apellidos','medico.telefono')
        ->where('users.id',$id)
        ->first();
        $especialidad = Especialidad::all();
        $especialidadIds = $medico->especialidades()->pluck('especialidad.id');
        return view('medico.edit', compact('medico', 'especialidad', 'especialidadIds'));
    }

    public function update(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'login' => 'required|min:3',
                'email' => 'required|email',
                'nombre' => 'nullable|min:5',
                'apellidos' => 'nullable|min:10',
                'telefono' => 'nullable|min:6',
            ]);
    
            $user = User::findOrFail($request->id);
            $data = $request->only('login', 'email');
            $password = $request->password;
            if ($password)
                $data['password'] = bcrypt($password);
    
            $user->fill($data);
            $user->save();

            $obj = Medico::findOrFail($request->id);
            $dat = $request->only('nombre', 'apellidos','telefono');
            $obj->fill($dat);
            $obj->save();

            $obj = MedicoEspecialidad::where('medico_especialidad.id_medico','=',$request->id);
            $obj->delete();

            $detalle = $request->especialidad;            
            foreach($detalle as $key=>$value) {
                $obj = new MedicoEspecialidad();
                $obj->id_medico = $user->id; 
                $obj->id_especialidad = $value;
                $obj->save();
            }            

            DB::commit();

            $notificacion = 'La información del médico se ha actualizado correctamente.';
            return redirect('/medico')->with(compact('notificacion'));
            return[
                'id'=>$user->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function destroy(Request $request){
        $esp = MedicoEspecialidad::where('medico_especialidad.id_medico','=',$request->id);
        $esp->delete();

        $obj = Medico::findOrFail($request->id); 
        $obj->delete();

        $user = User::findOrFail($request->id); 
        $user->delete();

        $notificacion = "El médico se ha eliminado correctamente.";
        return redirect('/medico')->with(compact('notificacion'));
    }

    private $dias = [
        'Lunes', 
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo'
    ];
    
    public function verDetalles(Request $request){
        $id_medico = $request->id;

        $medico = Medico::select('nombre','apellidos','telefono')
        ->where('medico.id',$id_medico)
        ->first();

        $especialidad = MedicoEspecialidad::join('especialidad', 'medico_especialidad.id_especialidad', '=', 'especialidad.id')
        ->select('especialidad.nombre')
        ->where('medico_especialidad.id_medico',$id_medico)
        ->get(); 

        $horariotrabajo = DB::table('horario_trabajo as ht')
        ->select('ht.num_dia','ht.estado','ht.dia_start','ht.dia_end','ht.tarde_start','ht.tarde_end')
        ->where('ht.id_medico', $id_medico)
        ->where('ht.estado', 1)
        ->get();

        $dias = $this->dias;
        return view('medico.detallemedico', compact('medico', 'especialidad', 'horariotrabajo','dias'));
    }
}
