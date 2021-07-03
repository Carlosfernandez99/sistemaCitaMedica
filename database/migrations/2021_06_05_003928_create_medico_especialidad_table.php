<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicoEspecialidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medico_especialidad', function (Blueprint $table) {
            $table->foreignId('id_medico');
            $table->foreignId('id_especialidad');
            $table->primary(['id_medico', 'id_especialidad']);
            $table->foreign('id_medico')->references('id')->on('medico');            
            $table->foreign('id_especialidad')->references('id')->on('especialidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medico_especialidad');
    }
}
