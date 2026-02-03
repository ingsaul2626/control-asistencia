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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();

            // CONEXIÓN ÚNICA: Se conecta a la tabla 'users'
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->date('fecha'); // El día del registro
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();

            // STATUS: 'presente', 'ausente', 'tarde'
            $table->string('status')->default('presente');

            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
