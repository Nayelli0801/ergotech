<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Evita duplicados: solo agrega si NO existe
        if (!Schema::hasColumn('evaluaciones', 'puntaje_total')) {
            Schema::table('evaluaciones', function (Blueprint $table) {
                $table->integer('puntaje_total')->nullable()->after('observaciones');
            });
        }

        if (!Schema::hasColumn('evaluaciones', 'nivel_riesgo')) {
            Schema::table('evaluaciones', function (Blueprint $table) {
                $table->string('nivel_riesgo')->nullable()->after('puntaje_total');
            });
        }
    }

    public function down(): void
    {
        // No hacemos rollback aquí porque ya existen y podrían ser usadas
        // Si quieres, se puede implementar con cuidado.
    }
};