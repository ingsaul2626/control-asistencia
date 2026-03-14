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
    Schema::create('assignments', function (Blueprint $table) {
        $table->id(); // ID único de la asignación
        
        // Relaciones con las tablas padre
        $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->string('status')->default('pendiente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
