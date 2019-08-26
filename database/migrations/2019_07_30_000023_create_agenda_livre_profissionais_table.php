<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaLivreProfissionaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_livre_profissionais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profissional_id');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->date('data_livre');
            $table->time('inicio_periodo');
            $table->time('fim_periodo');
            $table->string('motivo', 200);
            $table->boolean('ativo')->nullable();;
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
        Schema::dropIfExists('agenda_livre_profissionais');
    }
}
