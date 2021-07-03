<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    public function index(){
        $especialidad= Especialidad::all();
        return view('especialidad.index', compact('especialidad'));
    }

    public function create(){
        return view('especialidad.create');
    }

    private function validar($request){
        $rules=['nombre'=>'required'];
        $messages=['nombre.required'=>'Es necesario ingresar un nombre'];
        $this->validate($request,$rules,$messages);
    }

    public function store(Request $request){
        $this->validar($request);

        $obj = new Especialidad();
        $obj->nombre = $request->nombre; 
        $obj->descripcion = $request->descripcion; 
        $obj->save();

        $notificacion='La especialidad se ha registrado correctamente';
        return redirect('/especialidad')->with(compact('notificacion'));
    }

    public function edit($id){
        $especialidad = Especialidad::findOrFail($id);
        return view('especialidad.edit', compact('especialidad'));
    }

    public function update(Request $request){
        $this->validar($request);

        $obj = Especialidad::findOrFail($request->id);
        $obj->nombre = $request->nombre; 
        $obj->descripcion = $request->descripcion; 
        $obj->save();

        $notificacion='La especialidad se ha actualizado correctamente';
        return redirect('/especialidad')->with(compact('notificacion'));
    }

    public function destroy(Request $request){
        $obj = Especialidad::findOrFail($request->id); 
        $obj->delete();

        $notificacion='La especialidad se ha eliminado correctamente';
        return redirect('/especialidad')->with(compact('notificacion'));
    }
}
