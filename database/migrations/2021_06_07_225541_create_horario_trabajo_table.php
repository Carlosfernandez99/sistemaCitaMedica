<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_trabajo', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('num_dia');
            $table->boolean('estado');            
            $table->time('dia_start');
            $table->time('dia_end');
            $table->time('tarde_start');
            $table->time('tarde_end');
            $table->foreignId('id_medico');
            $table->foreign('id_medico')->references('id')->on('medico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horario_trabajo');
    }
}
