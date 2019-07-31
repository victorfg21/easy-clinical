<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialidadeProfissionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidade_profissional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('profissional_id');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->unsignedInteger('especialidade_id');
            $table->foreign('especialidade_id')->references('id')->on('especialidades');
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
        Schema::dropIfExists('especialidade_profissional');
    }
}
