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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('appaterno');
            $table->string('apmaterno');
            $table->string('CI')->unique();
            $table->text('descripcion')->nullable();
            $table->integer('Celular');
            $table->date('fechadenac');
            $table->string('PaisReside')->nullable();
            $table->string('CiudadReside')->nullable();
            $table->string('fechadenac');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable(); // Campo para el avatar
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
        Schema::dropIfExists('users');
    }
};
