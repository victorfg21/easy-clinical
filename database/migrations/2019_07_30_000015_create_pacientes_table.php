<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 150);
            $table->string('rg', 30);
            $table->string('cpf', 11);
            $table->string('ih', 7);
            $table->date('dt_nasc');
            $table->string('sexo', 1);
            $table->string('celular', 11);
            $table->integer('numero');
            $table->string('endereco', 150);
            $table->string('complemento', 150)->nullable();
            $table->string('bairro', 150);
            $table->string('cidade', 150);
            $table->string('estado', 2);
            $table->string('cep', 8)->nullable();
            $table->unsignedInteger('foto_id')->nullable();
            $table->foreign('foto_id')->references('id')->on('fotos');
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
        Schema::dropIfExists('pacientes');
    }
}
