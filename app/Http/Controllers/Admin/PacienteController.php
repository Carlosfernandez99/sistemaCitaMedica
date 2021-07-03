<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\User;

class PacienteController extends Controller
{
    public function index(){
        $paciente= Paciente::all();
        return view('paciente.index', compact('paciente'));
    }

    public function create(){
        return view('paciente.create');
    }

    public function store(Request $request){
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
        $user->password = bcrypt($request->password);
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

        
        $notificacion = 'El paciente se ha registrado correctamente.';
        return redirect('/paciente')->with(compact('notificacion'));
    }

    public function edit($id){ 
        $paciente = Paciente::join('users', 'paciente.id', '=', 'users.id')
        ->select('users.id','users.login','users.email','users.password','paciente.nombre','paciente.apellidos','paciente.ci','paciente.fecha_nac','paciente.telefono')
        ->where('users.id',$id)
        ->first(); 
        return view('paciente.edit', compact('paciente'));
    }

    public function update(Request $request){
        $request->validate([
            'nombre' => 'required|min:3',
            'email' => 'required|email',
            'apellidos' => 'nullable|min:5',
            'ci' => 'nullable|min:7|max:8',
            'telefono' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($request->id);
        $data = $request->only('login', 'email');
        $password = $request->password;
        if ($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();

        $obj = Paciente::findOrFail($request->id);
        $data = $request->only('nombre', 'apellidos','ci','fecha_nac','telefono');
        $obj->fill($data);
        $obj->save();

        $notificacion = 'La información del paciente se ha actualizado correctamente.';
        return redirect('/paciente')->with(compact('notificacion'));
    }

    public function destroy(Request $request){
        $obj = Paciente::findOrFail($request->id); 
        $obj->delete();

        $user = User::findOrFail($request->id); 
        $user->delete();

        $notificacion = "El paciente se ha eliminado correctamente.";
        return redirect('/paciente')->with(compact('notificacion'));
    }
}
