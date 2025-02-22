<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     
/**
 * Run the migrations.
 */
public function up(): void
{
    Schema::table('cursos', function (Blueprint $table) {
        $table->unsignedBigInteger('categoria_id')->nullable(); 
        $table->foreign('categoria_id')->references('id')->on('curso_categoria'); // Relación con categorías
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('cursos', function (Blueprint $table) {
        $table->dropForeign(['categoria_id']); // Eliminar la clave foránea
        $table->dropColumn('categoria_id'); // Eliminar la columna
    });
}

};
