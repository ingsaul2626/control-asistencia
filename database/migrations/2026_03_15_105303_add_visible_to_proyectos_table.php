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
    Schema::table('proyectos', function (Blueprint $table) {
        // Añadimos la columna. Usamos boolean y un valor por defecto.
        $table->boolean('visible')->default(true);
    });
}

public function down()
{
    Schema::table('proyectos', function (Blueprint $table) {
        $table->dropColumn('visible');
    });
}
};
