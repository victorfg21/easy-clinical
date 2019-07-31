<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('profissional_id');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->unsignedInteger('solicitacao_exame_id')->nullable();
            $table->foreign('solicitacao_exame_id')->references('id')->on('solicitacoes_exames');
            $table->unsignedInteger('receita_id')->nullable();
            $table->foreign('receita_id')->references('id')->on('receitas');
            $table->date('data_consulta');
            $table->time('horario_consulta');
            $table->text('anotacao');
            $table->boolean('compareceu');
            $table->boolean('cancelado');
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
        Schema::dropIfExists('consultas');
    }
}
