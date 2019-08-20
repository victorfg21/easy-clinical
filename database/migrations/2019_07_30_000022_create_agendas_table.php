<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profissional_id');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->boolean('segunda')->nullable();
            $table->boolean('terca')->nullable();
            $table->boolean('quarta')->nullable();
            $table->boolean('quinta')->nullable();
            $table->boolean('sexta')->nullable();
            $table->boolean('sabado')->nullable();
            $table->boolean('domingo')->nullable();
            $table->date('inicio_periodo');
            $table->date('fim_periodo');
            $table->time('tempo_consulta');
            $table->time('inicio_horario_1');
            $table->time('fim_horario_1');
            $table->time('inicio_horario_2')->nullable();
            $table->time('fim_horario_2')->nullable();
            $table->boolean('ativo');
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
        Schema::dropIfExists('agendas');
    }
}
