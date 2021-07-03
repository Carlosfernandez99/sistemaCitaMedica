<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\CitaMedica;
use App\Models\Medico;
use Carbon\Carbon;
use DB;

class ChartController extends Controller
{
    public function consultamedica(){    	
    	$monthlyCounts = CitaMedica::select(
			DB::raw('MONTH(fecha_consulta) as month'), 
			DB::raw('COUNT(1) as count')
		)->groupBy('month')->get()->toArray();

		$counts = array_fill(0, 12, 0);
		foreach ($monthlyCounts as $monthlyCount) {
			$index = $monthlyCount['month']-1;
			$counts[$index] = $monthlyCount['count'];
		}
    	return view('dashboard.citamedica', compact('counts'));
    }

    public function medicos(){
    	$now = Carbon::now();
		$end = $now->format('Y-m-d'); 
		$start = $now->subYear()->format('Y-m-d');

    	return view('dashboard.medico', compact('start', 'end'));
    }

    public function medicoJson(Request $request){    	
    	$start = $request->start;
    	$end = $request->end;

		$doctors = Medico::select('nombre')
		// ->where('users.rol_usuario','=','doctor')
		->withCount([
			'attendedAppointments' => function ($query) use ($start, $end) {
				$query->whereBetween('fecha_consulta',[$start,$end]);
			},
			'cancelledAppointments' => function ($query) use ($start, $end) {
				$query->whereBetween('fecha_consulta',[$start,$end]);
			}
		])
		->orderBy('attended_appointments_count', 'desc')
		->take(5)
		->get();

    	$data = [];
    	$data['categories'] = $doctors->pluck('nombre');

    	$series = [];
    	// Atendidas
    	$series1['name'] = 'Citas atendidas';
    	$series1['data'] = $doctors->pluck('attended_appointments_count'); 
    	// Canceladas
    	$series2['name'] = 'Citas canceladas';
    	$series2['data'] = $doctors->pluck('cancelled_appointments_count'); 

    	$series[] = $series1;
    	$series[] = $series2;

    	$data['series'] = $series;
    	return $data;
    }
}
