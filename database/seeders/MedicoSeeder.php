<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medico;

class MedicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Medico::create([
            'id' => 2,
	        'nombre' => 'Carlos',
	        'apellidos' => 'Pinto',
            'telefono' => '78495278',
        ]);
    }
}
