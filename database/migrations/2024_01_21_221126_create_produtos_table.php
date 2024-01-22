<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->string('imagem', 255);
            $table->integer('produto_minimo');
            $table->integer('produto_maximo');
            $table->integer('empresa_id')->unsigned();
            $table->text('descricao_detalhada');
            $table->double('imposto', 15, 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};