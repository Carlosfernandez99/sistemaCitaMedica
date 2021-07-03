<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoConsulta;

class TipoConsultaController extends Controller
{
    public function index(){
    	return TipoConsulta::all(['id','nombre', 'precio']);
    }

    public function guardar(Request $request){
        $tipoconsulta = new TipoConsulta();
        $tipoconsulta->nombre = $request->nombre; 
        $tipoconsulta->precio = $request->precio; 
        $tipoconsulta->save();

        if ($tipoconsulta){
            $success = true;
        }
    	else{
            $success = false;
        }
    	return compact('success');
    }
}
