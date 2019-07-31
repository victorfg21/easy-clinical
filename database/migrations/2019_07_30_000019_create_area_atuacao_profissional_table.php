<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaAtuacaoProfissionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_atuacao_profissional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('profissional_id');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->unsignedInteger('area_atuacao_id');
            $table->foreign('area_atuacao_id')->references('id')->on('areas_atuacao');
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
        Schema::dropIfExists('area_atuacao_profissional');
    }
}
