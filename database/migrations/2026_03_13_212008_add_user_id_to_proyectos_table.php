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
    Schema::table('proyectos', function (Blueprint $table) {
        // Creamos la columna para vincular con la tabla users


        if (!Schema::hasColumn('proyectos', 'user_id')) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('proyectos', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
