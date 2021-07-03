<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HorarioTrabajo;
use Carbon\Carbon;

class HorarioTrabajoController extends Controller
{
    private $dias = [
        'Lunes', 
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo'
	];

    public function edit(){
    	$horariotrabajo = HorarioTrabajo::where('horario_trabajo.id_medico', '=' ,\Auth::user()->id)->get();
        
        if (count($horariotrabajo) > 0) {
            $horariotrabajo->map(function ($workDay) {
                $workDay->dia_start = (new Carbon($workDay->dia_start))->format('g:i A');
                $workDay->dia_end = (new Carbon($workDay->dia_end))->format('g:i A');
                $workDay->tarde_start = (new Carbon($workDay->tarde_start))->format('g:i A');
                $workDay->tarde_end = (new Carbon($workDay->tarde_end))->format('g:i A');
                return $workDay;
            });
        } else {
            $horariotrabajo = collect();
            for ($i=0; $i<7; ++$i)
                $horariotrabajo->push(new HorarioTrabajo());
        }
    	    	
    	$dias = $this->dias;
    	return view('horariotrabajo', compact('horariotrabajo', 'dias'));
    }

    public function store(Request $request){
    	$estado = $request->estado ?: [];
    	$dia_start = $request->dia_start;
    	$dia_end = $request->dia_end;
    	$tarde_start = $request->tarde_start;
    	$tarde_end = $request->tarde_end;

    	$errors = [];
    	for ($i=0; $i<7; ++$i) {
    		if ($dia_start[$i] > $dia_end[$i]) {
    			$errors []= 'Las horas del turno mañana son inconsistentes para el día ' . $this->dias[$i] . '.';
    		}
    		if ($tarde_start[$i] > $tarde_end[$i]) {
    			$errors []= 'Las horas del turno tarde son inconsistentes para el día ' . $this->dias[$i] . '.';
    		}

	    	HorarioTrabajo::updateOrCreate([
				'num_dia' => $i,
				'id_medico' => \Auth::user()->id
			], [		        
				'estado' => in_array($i, $estado),
				'dia_start' => $dia_start[$i],
				'dia_end' => $dia_end[$i],
				'tarde_start' => $tarde_start[$i],
				'tarde_end' => $tarde_end[$i]
			]);
		}

		if (count($errors) > 0)
	    	return back()->with(compact('errors'));

	    $notificacion = 'Los cambios se han guardado correctamente.';
	    return back()->with(compact('notificacion'));
    }
}
