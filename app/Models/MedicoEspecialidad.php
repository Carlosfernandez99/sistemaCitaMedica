<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicoEspecialidad extends Model
{
    use HasFactory;
    protected $table = 'medico_especialidad';
    protected $fillable = [
        'id_medico',
        'id_especialidad'
    ];    
    public $timestamps = false;
}
