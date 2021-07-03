<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    protected $table = 'medico';
    protected $fillable = [
        'id',
        'nombre',
        'apellidos',
        'telefono'
    ];    
    public $timestamps = false;

    public function especialidades(){
        return $this->belongsToMany(Especialidad::class,'medico_especialidad','id_medico','id_especialidad');
    }

    public function asDoctorAppointments(){
        return $this->hasMany(CitaMedica::class, 'id_medico');
    }

    public function attendedAppointments(){
        return $this->asDoctorAppointments()->where('estado', 'Atendida');
    }

    public function cancelledAppointments(){
        return $this->asDoctorAppointments()->where('estado', 'Cancelada');
    }
    
    public function asPatientAppointments(){
        return $this->hasMany(CitaMedica::class, 'id_paciente');
    }
}
