<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->decimal('precio', 8, 2)->default(0); // Nueva columna para el precio con valor por defecto 0
            $table->string('imagen')->nullable(); // Nueva columna para la imagen del curso
            $table->integer('duracion'); // Nueva columna para la duración del curso
            $table->integer('cupos');
        });
    }

    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('precio');
            $table->dropColumn('imagen');
            $table->dropColumn('duracion');
            $table->dropColumn('cupos');
        });
    }
};
