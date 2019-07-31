<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_atendimentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('profissional_id');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->boolean('segunda')->nullable();
            $table->boolean('terca')->nullable();
            $table->boolean('quarta')->nullable();
            $table->boolean('quinta')->nullable();
            $table->boolean('sexta')->nullable();
            $table->boolean('sabado')->nullable();
            $table->boolean('domingo')->nullable();
            $table->time('tempo_consulta');
            $table->time('inicio_periodo_1');
            $table->time('fim_periodo_1');
            $table->time('inicio_periodo_2')->nullable();
            $table->time('fim_periodo_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horario_atendimentos');
    }
}
