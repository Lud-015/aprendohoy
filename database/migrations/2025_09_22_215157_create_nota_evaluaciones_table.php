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
        Schema::create('nota_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('nota')->default(0);
            $table->string('retroalimentacion')->default('');
            $table->unsignedBigInteger('evaluaciones_id');
            $table->foreign('evaluaciones_id')->references('id')->on('evaluaciones');
            $table->unsignedBigInteger('inscripcion_id');
            $table->foreign('inscripcion_id')->references('id')->on('inscritos');
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
        Schema::dropIfExists('nota_entregas');
    }
};
