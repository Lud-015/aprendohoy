<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones_entregas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrega_archivo_id');
            $table->unsignedBigInteger('calificador_id')->nullable();
            $table->integer('nota')->nullable();
            $table->text('retroalimentacion')->nullable();
            $table->timestamps();

            $table->foreign('entrega_archivo_id')->references('id')->on('entregas_archivos')->onDelete('cascade');
            $table->foreign('calificador_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_entregas');
    }
};
