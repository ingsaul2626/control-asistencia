<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::table('asistencias', function ($table) {
        if (!Schema::hasColumn('asistencias', 'fecha')) $table->date('fecha')->after('empleado_id');
        if (!Schema::hasColumn('asistencias', 'status')) $table->string('status')->default('presente');
        if (!Schema::hasColumn('asistencias', 'observaciones')) $table->text('observaciones')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            //
        });
    }
};
