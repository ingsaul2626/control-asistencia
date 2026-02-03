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
    Schema::create('eventos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('imagen')->nullable();
        $table->text('descripcion');
        $table->date('fecha');
        $table->time('hora')->nullable();
        $table->string('lugar')->nullable();
        $table->boolean('activo')->default(true); // Para ocultar/mostrar eventos
        $table->timestamps();
        $table->string('tipo');
    });
}


};
