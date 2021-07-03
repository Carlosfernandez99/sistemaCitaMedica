<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\HorarioServiceInterface;
use App\Models\HorarioTrabajo;
use Carbon\Carbon;

class HorarioTrabajoController extends Controller
{
    public function hours(Request $request, HorarioServiceInterface $horarioTrabajoService){
    	$rules = [
    		'date' => 'required|date_format:"Y-m-d"',
    		'id_medico' => 'required|exists:medico,id'
    	];
    	$request->validate($rules);

    	$date = $request->date;
		$medicoId = $request->id_medico;
		return $horarioTrabajoService->getIntervalDisponible($date, $medicoId);  		
	}
}
