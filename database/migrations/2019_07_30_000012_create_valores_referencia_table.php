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
        Schema::create('valores_referencia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->string('val_desejavel', 10);
            $table->string('val_limitrofe_min', 10);
            $table->string('val_limitrofe_max', 10);
            $table->string('val_alto', 10);
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
        Schema::dropIfExists('valores_referencia');
    }
}
