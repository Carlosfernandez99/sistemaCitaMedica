<?php namespace App\Services;

use App\Interfaces\HorarioServiceInterface;
use Carbon\Carbon;
use App\Models\HorarioTrabajo;
use App\Models\CitaMedica;

class HorarioService implements HorarioServiceInterface{

    public function isAvailableInterval($date, $medicoId, Carbon $start) {
        $exists = CitaMedica::where('id_medico', $medicoId)
            ->where('fecha_consulta', $date)
            ->where('hora_consulta', $start->format('H:i:s'))
            ->exists();

        return !$exists;
    }

    public function getIntervalDisponible($date, $medicoId){
        $horariotrabajo=HorarioTrabajo::where('estado',true)
            ->where('num_dia', $this->getDayFromDate($date))
            ->where('id_medico', $medicoId)
            ->first([
                'dia_start','dia_end',
			    'tarde_start','tarde_end'
            ]);

        if ($horariotrabajo) {
            $intervaloTurno1 = $this->getIntervalo($horariotrabajo->dia_start, $horariotrabajo->dia_end,$date, $medicoId);
            $intervaloTurno2 = $this->getIntervalo($horariotrabajo->tarde_start, $horariotrabajo->tarde_end,$date, $medicoId);
        } else {
            $intervaloTurno1 = []; 
            $intervaloTurno2 = [];
        }        

        $data = [];
		$data['turno1']=$intervaloTurno1;
        $data['turno2']=$intervaloTurno2;

        return $data;
    }

	private function getDayFromDate($date){
    	$dateCarbon = new Carbon($date);
    	$i = $dateCarbon->dayOfWeek;
    	$day = ($i==0 ? 6 : $i-1);
    	return $day;
	}

	private function getIntervalo($horaInicio, $horaFin, $date, $medicoId) {
		$horaInicio = new Carbon($horaInicio);
    	$horaFin = new Carbon($horaFin);

    	$intervalo = [];
    	while ($horaInicio < $horaFin) {
    		$interval = [];

    		$interval['inicio']  = $horaInicio->format('g:i A');
            $available = $this->isAvailableInterval($date, $medicoId, $horaInicio);
    		$horaInicio->addMinutes(30);
    		$interval['fin']  = $horaInicio->format('g:i A');

            if ($available) {
                $intervalo []= $interval;           
            }    		
    	}
    	return $intervalo;
    }
}