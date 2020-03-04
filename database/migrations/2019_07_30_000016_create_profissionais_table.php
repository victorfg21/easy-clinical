<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfissionaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profissionais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 150);
            $table->string('rg', 30);
            $table->string('cpf', 11);
            $table->string('conselho', 30)->nullable();
            $table->string('conselho_uf', 2)->nullable();
            $table->string('numero_registro', 30)->nullable();
            $table->date('dt_nasc');
            $table->string('sexo', 1);
            $table->string('celular', 11);
            $table->string('telefone', 10);
            $table->integer('numero');
            $table->string('endereco', 150);
            $table->string('complemento', 150)->nullable();
            $table->string('bairro', 150);
            $table->string('cidade', 150);
            $table->string('estado', 2);
            $table->string('cep', 8)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('foto_id')->nullable()->nullable();
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
        Schema::dropIfExists('profissionais');
    }
}
