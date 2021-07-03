<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CitaMedica;
use DB;
use Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function daysToMinutes($days){
        $hours = $days * 24;
        return $hours * 60;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $results = CitaMedica::select([
            DB::raw('DAYOFWEEK(fecha_consulta) as day'),
            DB::raw('COUNT(*) as count')
        ])
        ->groupBy(DB::raw('DAYOFWEEK(fecha_consulta)'))
        ->whereIn('estado', ['Confirmada', 'Atendida'])
        ->get(['day', 'count'])
        ->mapWithKeys(function ($item) {
            return [$item['day'] => $item['count']];
        })->toArray();

        $consultamedicaPorDia = [];
        for ($i=1; $i<=7; ++$i) {
            if (array_key_exists($i, $results))
                $consultamedicaPorDia[] = $results[$i];
            else
                $consultamedicaPorDia[] = 0;
        }    

        return view('home', compact('consultamedicaPorDia'));
    }
}
