<?php namespace App\Interfaces;

use Carbon\Carbon;

interface HorarioServiceInterface 
{
	public function isAvailableInterval($date, $medicoId, Carbon $start);
	public function getIntervalDisponible($date, $medicoId);
}