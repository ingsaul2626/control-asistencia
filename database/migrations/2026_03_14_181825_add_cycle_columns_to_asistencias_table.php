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
        Schema::table('asistencias', function (Blueprint $table) {
            // Verificamos si NO existen antes de crearlas
            if (!Schema::hasColumn('asistencias', 'status')) {
                $table->string('status')->default('asignado')->after('user_id');
            }

            if (!Schema::hasColumn('asistencias', 'hora_entrada_admin')) {
                $table->time('hora_entrada_admin')->nullable()->after('status');
            }

            if (!Schema::hasColumn('asistencias', 'hora_entrada_real')) {
                $table->time('hora_entrada_real')->nullable()->after('hora_entrada_admin');
            }

            if (!Schema::hasColumn('asistencias', 'hora_salida')) {
                $table->time('hora_salida')->nullable()->after('hora_entrada_real');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            // Solo borramos si existen
            $table->dropColumn(['status', 'hora_entrada_admin', 'hora_entrada_real', 'hora_salida']);
        });
    }
};
