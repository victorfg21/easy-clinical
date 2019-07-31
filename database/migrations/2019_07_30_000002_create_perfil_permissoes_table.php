<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilPermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_permissoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('perfil_id');
            $table->foreign('perfil_id')->references('id')->on('perfis');
            $table->boolean('visualizar');
            $table->boolean('criar');
            $table->boolean('editar');
            $table->boolean('deletar');
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
        Schema::dropIfExists('perfil_permissoes');
    }
}
