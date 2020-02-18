<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->unsignedInteger('exame_metodo_id');
            $table->foreign('exame_metodo_id')->references('id')->on('exame_metodos');
            $table->unsignedInteger('exame_material_id');
            $table->foreign('exame_material_id')->references('id')->on('exame_materiais');
            $table->text('observacao');
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
        Schema::dropIfExists('exames');
    }
}
