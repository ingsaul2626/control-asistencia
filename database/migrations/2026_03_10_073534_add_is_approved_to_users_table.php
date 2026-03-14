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
    Schema::table('users', function (Blueprint $table) {
        // Añadimos la columna. Por defecto será 0 (false)
        $table->boolean('is_approved')->default(0);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('is_approved');
    });
}
};
