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
    Schema::create('proyectos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('imagen')->nullable();
        $table->text('descripcion');
        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_entrega')->nullable();
        $table->time('hora')->nullable();
        $table->string('lugar')->nullable();
        $table->boolean('activo')->default(true);
        $table->timestamps();
        $table->string('tipo');
        $table->string('archivo_pdf')->nullable();
        $table->string('categoria')->nullable();
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        $table->text('reporte_trabajador')->nullable();

    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');

}
};
