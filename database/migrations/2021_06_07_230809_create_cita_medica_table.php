<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaMedicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_medica', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->date('fecha_reserva');
            $table->date('fecha_consulta');
            $table->time('hora_consulta');
            $table->string('estado',40);
            $table->foreignId('id_medico');
            $table->foreignId('id_paciente');
            $table->foreignId('id_especialidad');
            $table->foreignId('id_tipo_consulta');
            $table->foreign('id_medico')->references('id')->on('users');            
            $table->foreign('id_paciente')->references('id')->on('users');            
            $table->foreign('id_especialidad')->references('id')->on('especialidad');
            $table->foreign('id_tipo_consulta')->references('id')->on('tipo_consulta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cita_medica');
    }
}
