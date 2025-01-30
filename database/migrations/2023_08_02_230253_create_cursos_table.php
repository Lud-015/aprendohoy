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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombreCurso');
            $table->string('codigoCurso')->nullable();
            $table->string('descripcionC');
            $table->string('fecha_ini');
            $table->string('fecha_fin');
            $table->string('archivoContenidodelCurso')->nullable();
            $table->integer('notaAprobacion')->nullable();
            $table->string('formato');
            $table->string('estado')->default('Activo');
            $table->enum('tipo', ['curso', 'congreso'])->default('curso');
            $table->unsignedBigInteger('docente_id');
            $table->foreign('docente_id')->references('id')->on('users');
            $table->string('edad_dirigida')->nullable(); // Puede contener valores como "Niños", "Adolescentes", "Adultos"
            $table->string('nivel')->nullable(); // Puede contener valores como "Básico", "Intermedio", "Avanzado"
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};
