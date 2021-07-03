<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoConsulta;

class TipoConsultaController extends Controller
{
    public function index(){
        $tipoconsulta= TipoConsulta::all();
        return view('tipoconsulta.index', compact('tipoconsulta'));
    }

    public function create(){
        return view('tipoconsulta.create');
    }

    private function validar($request){
        $rules=['nombre'=>'required'];
        $messages=['nombre.required'=>'Es necesario ingresar un nombre'];
        $this->validate($request,$rules,$messages);
    }

    public function store(Request $request){
        $this->validar($request);

        $obj = new TipoConsulta();
        $obj->nombre = $request->nombre; 
        $obj->precio = $request->precio; 
        $obj->save();

        $notificacion='El tipo de consulta se ha registrado correctamente';
        return redirect('/tipoconsulta')->with(compact('notificacion'));
    }

    public function edit($id){
        $tipoconsulta = TipoConsulta::findOrFail($id);
        return view('tipoconsulta.edit', compact('tipoconsulta'));
    }

    public function update(Request $request){
        $this->validar($request);

        $obj = TipoConsulta::findOrFail($request->id);
        $obj->nombre = $request->nombre; 
        $obj->precio = $request->precio; 
        $obj->save();

        $notificacion='El tipo de consulta se ha actualizado correctamente';
        return redirect('/tipoconsulta')->with(compact('notificacion'));
    }

    public function destroy(Request $request){
        $obj = TipoConsulta::findOrFail($request->id); 
        $obj->delete();

        $notificacion='El tipo de consulta se ha eliminado correctamente';
        return redirect('/tipoconsulta')->with(compact('notificacion'));
    }
}
