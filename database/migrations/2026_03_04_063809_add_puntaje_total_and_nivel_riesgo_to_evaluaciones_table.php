<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->integer('puntaje_total')->nullable()->after('observaciones');
            $table->string('nivel_riesgo')->nullable()->after('puntaje_total');
        });
    }

    public function down(): void
    {
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->dropColumn(['puntaje_total', 'nivel_riesgo']);
        });
    }
};