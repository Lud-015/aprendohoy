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
        Schema::create('user_xps', function (Blueprint $table) {
            $table->id();

            // Define the foreign key columns first
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('curso_id');

            // Then apply the foreign key constraints
            $table->foreign('users_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('curso_id')
                  ->references('id')
                  ->on('cursos')
                  ->onDelete('cascade');

            $table->integer('xp')->default(0);
            $table->integer('level')->default(1);
            $table->timestamp('last_earned_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_xps');
    }
};
