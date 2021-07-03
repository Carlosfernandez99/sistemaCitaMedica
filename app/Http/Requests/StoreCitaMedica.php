<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Interfaces\HorarioServiceInterface;
use Carbon\Carbon;

class StoreCitaMedica extends FormRequest
{
    private $horarioTrabajoService;
    public function __construct(HorarioServiceInterface $horarioTrabajoService){
        $this->horarioTrabajoService = $horarioTrabajoService;
    }

    public function rules(){
        return [
            'descripcion'=>'required',
            'id_especialidad'=>'exists:especialidad,id',
            'id_tipo_consulta'=>'exists:tipo_consulta,id',
            'id_medico'=>'exists:medico,id',
            'hora_consulta'=>'required'
        ];
    }

    public function messages(){
        return [
            'hora_consulta.required' => 'Por favor seleccione una hora válida para su cita.'
        ];
    }

    public function withValidator($validator){
        $validator->after(function ($validator) {
            $date = $this->input('fecha_consulta');
            $medicoId = $this->input('id_medico');
            $horaConsulta = $this->input('hora_consulta');

            if (!$date || !$medicoId || !$horaConsulta) {
                return;
            }

            $start = new Carbon($horaConsulta);

            if (!$this->horarioTrabajoService->isAvailableInterval($date, $medicoId, $start)) {
                $validator->errors()
                ->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro paciente.');
            }
        });
    }
}
