<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('evaluaciones', 'puntaje')) {
            Schema::table('evaluaciones', function (Blueprint $table) {
                $table->dropColumn('puntaje');
            });
        }
    }

    public function down(): void
    {
        // Si quieres poder revertir, solo agrega la columna si no existe
        if (!Schema::hasColumn('evaluaciones', 'puntaje')) {
            Schema::table('evaluaciones', function (Blueprint $table) {
                $table->integer('puntaje')->nullable();
            });
        }
    }
};