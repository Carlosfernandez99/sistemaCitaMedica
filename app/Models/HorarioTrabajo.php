<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioTrabajo extends Model
{
    use HasFactory;
    protected $table = 'horario_trabajo';
    protected $fillable = [
        'id',
        'num_dia',
        'estado',
        'dia_start',
        'dia_end',
        'tarde_start',
        'tarde_end',
        'id_medico'
    ];    
    public $timestamps = false;
}
