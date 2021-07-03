<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'paciente';
    protected $fillable = [
        'id',
        'nombre',
        'apellidos',
        'ci',
        'fecha_nac',
        'telefono'
    ];    
    public $timestamps = false;

    public static function createPaciente(array $data){
        return self::create([
            'id' => $data['id'],
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'ci' => $data['ci'],
            'fecha_nac' => $data['fecha_nac'],
            'telefono' => $data['telefono'],
        ]);
    }
}
