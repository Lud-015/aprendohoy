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
        Schema::create('entregas_tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarea_id'); // Relación con la tarea
            $table->unsignedBigInteger('estudiante_id'); // Relación con el estudiante
            $table->string('archivo_entregado')->nullable(); // Archivo entregado por el estudiante
            $table->enum('estado', ['pendiente', 'entregado', 'calificado'])->default('pendiente'); // Estado de la entrega
            $table->double('calificacion')->nullable(); // Calificación de la tarea
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
        Schema::dropIfExists('tareas_entregas');
    }
};
