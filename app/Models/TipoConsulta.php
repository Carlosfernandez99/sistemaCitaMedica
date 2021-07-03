<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoConsulta extends Model
{
    use HasFactory;
    protected $table = 'tipo_consulta';
    protected $fillable = [
        'id',
        'nombre',
        'precio'
    ];    
    public $timestamps = false;
}
