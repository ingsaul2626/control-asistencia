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
    Schema::create('empleados', function (Blueprint $table) {
        $table->id();
        $table->string('cedula')->unique(); // La columna "CÉDULA" de tu lista
        $table->string('nombre_apellido');  // Columna "NOMBRE Y APELLIDOS"
        $table->string('tipo_trabajador')->nullable(); // Ej: ADM/FIJO, ADM/CONT
        $table->string('seccion')->nullable(); // Ej: SALA TÉCNICA, INSPECCIÓN DE OBRAS
        $table->timestamps(); // Registra fecha de creación y edición
    });
}
};
