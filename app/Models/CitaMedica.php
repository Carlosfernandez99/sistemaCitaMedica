<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CitaMedica extends Model
{
    use HasFactory;
    protected $table = 'cita_medica';
    protected $fillable = [
        'id',
        'descripcion',
        'fecha_reserva',
        'fecha_consulta',
        'hora_consulta',
        'estado',
        'id_medico',
        'id_paciente',
        'id_especialidad',
        'id_tipo_consulta'
    ];    
    public $timestamps = false;

    static public function createForPaciente(Request $request, $id_paciente){
        $data = $request->only([
            'descripcion',
            'fecha_consulta',
            'hora_consulta',
            'id_medico',
            'id_especialidad',
            'id_tipo_consulta'
        ]);
        $data['estado']='Reservada';
        $myDate= Carbon::now();
        $data['fecha_reserva']=$myDate->toDateString();
        $data['id_paciente']=$id_paciente;
        $carbonTime= Carbon::createFromFormat('g:i A',$data['hora_consulta']);
        $data['hora_consulta']= $carbonTime->format('H:i:s');

        return self::create($data);
    } 
}
