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
            $table->unsignedBigInteger('solicitacao_exame_id');
            $table->foreign('solicitacao_exame_id')->references('id')->on('solicitacoes_exames');
            $table->unsignedBigInteger('solicitacao_exame_linha_id');
            $table->foreign('solicitacao_exame_linha_id')->references('id')->on('solicitacoes_exames_linha');
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
