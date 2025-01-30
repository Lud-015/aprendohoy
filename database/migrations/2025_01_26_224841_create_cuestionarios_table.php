<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cuestionarios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_cuestionario');
            $table->text('descripcion')->nullable();
            $table->date('fecha_habilitacion');
            $table->date('fecha_vencimiento');
            $table->double('puntos');
            $table->unsignedBigInteger('subtema_id');
            $table->foreign('subtema_id')->references('id')->on('subtemas');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuestionarios');
    }
};
