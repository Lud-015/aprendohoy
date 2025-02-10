<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('subtemas', function (Blueprint $table) {
            $table->unsignedInteger('orden')->default(0)->after('tema_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subtemas', function (Blueprint $table) {
            $table->dropColumn('orden');
        });
    }
};
