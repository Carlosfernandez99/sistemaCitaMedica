<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use App\Models\Medico;

class EspecialidadController extends Controller
{
    public function index(){
    	return Especialidad::all(['id', 'nombre']);
    }

    public function guardar(Request $request){
        $especialidad = new Especialidad();
        $especialidad->nombre = $request->nombre; 
        $especialidad->descripcion = $request->descripcion; 
        $especialidad->save();

        if ($especialidad){
            $success = true;
        }
    	else{
            $success = false;
        }
    	return compact('success');
    }
}
