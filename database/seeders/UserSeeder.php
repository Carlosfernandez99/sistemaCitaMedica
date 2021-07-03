<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'login' => 'fernandez',
	        'email' => 'carlosfernandez381@gmail.com',
	        'password' => bcrypt('123456789'),
            'rol_usuario' => 'administrador',
        ]);

        User::create([
            'login' => 'chipindi',
	        'email' => 'chipindifresc081@gmail.com',
	        'password' => bcrypt('123456789'),
            'rol_usuario' => 'doctor',
        ]);

        User::create([
            'login' => 'pinpong',
	        'email' => 'pinpong381@gmail.com',
	        'password' => bcrypt('123456789'),
            'rol_usuario' => 'paciente',
        ]);
    }
}
