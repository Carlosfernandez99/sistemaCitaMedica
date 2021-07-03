<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anulacion extends Model
{
    use HasFactory;
    protected $table = 'anulacion';
    protected $fillable = [
        'id',
        'fecha_cancelada',
        'justificacion',
        'id_cita_medica',
        'id_usuario'
    ];    
    public $timestamps = false;
}
