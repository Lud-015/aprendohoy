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
        Schema::create('curso_categoria', function (Blueprint $table) {
            $table->id(); // Clave primaria auto-incrementable
            $table->string('name'); // Nombre de la categoría (ej: "Desarrollo Web", "Marketing Digital")
            $table->string('slug')->unique(); // Slug único para la URL (ej: "desarrollo-web")
            $table->text('description')->nullable(); // Descripción opcional de la categoría
            $table->string('image')->nullable(); // Ruta de la imagen de la categoría (opcional)
            $table->unsignedBigInteger('parent_id')->nullable(); // ID de la categoría padre (para categorías anidadas)
            $table->foreign('parent_id')->references('id')->on('curso_categoria'); // Relación con la tabla de categorías (para categorías anidadas)
            $table->timestamps(); // Campos created_at y updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courso_categoria');
    }
};
