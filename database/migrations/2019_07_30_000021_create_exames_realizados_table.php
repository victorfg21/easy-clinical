<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamesRealizadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exames_realizados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('exame_id');
            $table->foreign('exame_id')->references('id')->on('exames');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->unsignedBigInteger('solicitacao_exame_id');
            $table->foreign('solicitacao_exame_id')->references('id')->on('solicitacoes_exames');
            $table->string('val_resultado', 300);
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
        Schema::dropIfExists('exames_realizados');
    }
}
