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
        $table->text('reporte_trabajador')->nullable()->after('descripcion');
    });
}

public function down(): void
{
    Schema::table('proyectos', function (Blueprint $table) {
        $table->dropColumn('reporte_trabajador');
    });
}
};
