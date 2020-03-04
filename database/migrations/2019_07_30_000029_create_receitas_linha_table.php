<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceitasLinhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receitas_linha', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('receita_id');
            $table->foreign('receita_id')->references('id')->on('receitas');
            $table->unsignedInteger('medicamento_id');
            $table->foreign('medicamento_id')->references('id')->on('medicamentos');
            $table->string('dosagem');
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
        Schema::dropIfExists('receitas_linha');
    }
}
