<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasMarcacoesConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas_marcacoes_consultas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('profissional_id');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->date('data_consulta');
            $table->time('horario_consulta');
            $table->text('anotacao')->nullable();
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
        Schema::dropIfExists('reservas_marcacoes_consultas');
    }
}
