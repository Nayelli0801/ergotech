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
        Schema::table('evaluaciones', function (Blueprint $table) {

            // Agregar columna metodo_id
            $table->foreignId('metodo_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('metodos')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluaciones', function (Blueprint $table) {

            // Eliminar la relación y la columna
            $table->dropForeign(['metodo_id']);
            $table->dropColumn('metodo_id');

        });
    }
};