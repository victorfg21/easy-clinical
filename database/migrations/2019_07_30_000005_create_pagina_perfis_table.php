<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaPerfisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagina_perfis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('pagina_id');
            $table->foreign('pagina_id')->references('id')->on('paginas');
            $table->unsignedInteger('perfil_id');
            $table->foreign('perfil_id')->references('id')->on('perfis');
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
        Schema::dropIfExists('pagina_perfis');
    }
}
