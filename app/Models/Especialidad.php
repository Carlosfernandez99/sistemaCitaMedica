<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;
    protected $table = 'especialidad';
    protected $fillable = [
        'id',
        'nombre',
        'descripcion'
    ];    
    public $timestamps = false;

    public function medicos(){
        return $this->belongsToMany(Medico::class,'medico_especialidad','id_medico','id_especialidad');
    }
}
