<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Paciente;

trait ValidateAndCreatePaciente
{
    protected function validator(array $data){
        return Validator::make($data, User::$rules);
    }

    protected function create(array $data){
        $dataUser = [
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => $data['password'],
            'rol_usuario' => 'paciente',
        ];

        $user = User::createUser($dataUser);
        $dataPaciente = [
            'id' => $user->id,
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'ci' => $data['ci'],
            'fecha_nac' => $data['fecha_nac'],
            'telefono' => $data['telefono'],
        ];
        $paciente = Paciente::createPaciente($dataPaciente);

        return $user;
    }
}
