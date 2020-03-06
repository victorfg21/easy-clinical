<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacoesExamesLinhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes_exames_linha', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('solicitacao_exame_id');
            $table->foreign('solicitacao_exame_id')->references('id')->on('solicitacoes_exames');
            $table->unsignedInteger('exame_id');
            $table->foreign('exame_id')->references('id')->on('exames');
            $table->boolean('realizado')->nullable();;
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
        Schema::dropIfExists('solicitacoes_exames_linha');
    }
}
