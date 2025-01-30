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
        Schema::create('subtemas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_subtema'); // Nombre del subtema
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable(); // Descripción opcional del subtema
            $table->unsignedBigInteger('tema_id'); // Relación con el tema
            $table->foreign('tema_id')->references('id')->on('temas');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtemas');
    }
};
