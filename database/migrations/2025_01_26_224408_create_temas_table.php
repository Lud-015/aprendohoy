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
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_tema'); // Nombre del tema
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable(); // Descripción opcional del tema
            $table->unsignedBigInteger('curso_id'); // Relación con el curso
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temas');
    }
};
