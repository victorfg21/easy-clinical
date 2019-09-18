<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamesLinhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exames_linha', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exame_id');
            $table->foreign('exame_id')->references('id')->on('exames');
            $table->unsignedInteger('exame_grupo_id');
            $table->foreign('exame_grupo_id')->references('id')->on('exame_grupos');
            $table->string('descricao');
            $table->string('tipo_valor', 10);
            $table->string('valor_simples', 30);
            $table->string('valor_min', 30);
            $table->string('valor_max', 30);
            $table->string('unidade', 50);
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
        Schema::dropIfExists('exames_linha');
    }
}
