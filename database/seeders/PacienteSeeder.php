<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paciente::create([
            'id' => 3,
	        'nombre' => 'Jose Ignacio',
	        'apellidos' => 'Montiel',
            'ci' => '8595478',
            'fecha_nac' => '1998/12/01',
            'telefono' => '78495266',
        ]);
    }
}
