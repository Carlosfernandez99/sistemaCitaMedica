<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnulacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anulacion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_cancelada');
            $table->string('justificacion');
            $table->foreignId('id_cita_medica');
            $table->foreignId('id_usuario');
            $table->foreign('id_cita_medica')->references('id')->on('cita_medica');            
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anulacion');
    }
}
