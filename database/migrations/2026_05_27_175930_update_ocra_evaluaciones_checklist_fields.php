<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ocra_evaluaciones', function (Blueprint $table) {
            $table->integer('duracion_turno')->default(480)->after('lado_evaluado');
            $table->integer('tiempo_no_repetitivo')->default(0)->after('duracion_turno');
            $table->integer('pausas')->default(0)->after('tiempo_no_repetitivo');
            $table->integer('almuerzo')->default(0)->after('pausas');
            $table->integer('numero_ciclos')->default(1)->after('almuerzo');

            $table->decimal('tntr', 8, 2)->default(0)->after('numero_ciclos');
            $table->decimal('tnc', 8, 2)->default(0)->after('tntr');

            $table->decimal('fr', 8, 2)->default(0)->after('tnc');
            $table->decimal('atd', 8, 2)->default(0)->after('fr');
            $table->decimal('ate', 8, 2)->default(0)->after('atd');
            $table->decimal('ff', 8, 2)->default(0)->after('ate');
            $table->decimal('ffz', 8, 2)->default(0)->after('ff');

            $table->decimal('pho', 8, 2)->default(0)->after('ffz');
            $table->decimal('pco', 8, 2)->default(0)->after('pho');
            $table->decimal('pmu', 8, 2)->default(0)->after('pco');
            $table->decimal('pma', 8, 2)->default(0)->after('pmu');
            $table->decimal('pes', 8, 2)->default(0)->after('pma');
            $table->decimal('fp', 8, 2)->default(0)->after('pes');

            $table->decimal('ffm', 8, 2)->default(0)->after('fp');
            $table->decimal('fso', 8, 2)->default(0)->after('ffm');
            $table->decimal('fc', 8, 2)->default(0)->after('fso');

            $table->decimal('md', 8, 3)->default(1)->after('fc');
            $table->decimal('ickl', 8, 2)->default(0)->after('md');
            $table->string('accion_recomendada')->nullable()->after('nivel_riesgo');
        });
    }

    public function down(): void
    {
        Schema::table('ocra_evaluaciones', function (Blueprint $table) {
            $table->dropColumn([
                'duracion_turno',
                'tiempo_no_repetitivo',
                'pausas',
                'almuerzo',
                'numero_ciclos',
                'tntr',
                'tnc',
                'fr',
                'atd',
                'ate',
                'ff',
                'ffz',
                'pho',
                'pco',
                'pmu',
                'pma',
                'pes',
                'fp',
                'ffm',
                'fso',
                'fc',
                'md',
                'ickl',
                'accion_recomendada',
            ]);
        });
    }
};