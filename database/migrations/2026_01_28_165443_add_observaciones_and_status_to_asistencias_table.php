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
        // Añadimos lo que falta. Usamos ifNotExists para evitar errores.
        if (!Schema::hasColumn('asistencias', 'fecha')) {
            $table->date('fecha')->nullable()->after('empleado_id');
        }
        if (!Schema::hasColumn('asistencias', 'observaciones')) {
            $table->text('observaciones')->nullable()->after('hora_salida');
        }
        if (!Schema::hasColumn('asistencias', 'status')) {
            $table->string('status')->default('presente')->after('observaciones');
        }
    });
}

public function down(): void
{
    Schema::table('asistencias', function (Blueprint $table) {
        $table->dropColumn(['fecha', 'observaciones', 'status']);
    });
}
};
