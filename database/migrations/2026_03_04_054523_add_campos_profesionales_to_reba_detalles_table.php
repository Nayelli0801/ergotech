<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reba_detalles', function (Blueprint $table) {

            // Lado evaluado (izq/der)
            $table->string('lado', 12)->nullable()->after('evaluacion_id');

            // Ajustes (checkbox +1) para igualar reportes
            $table->boolean('cuello_ajuste')->default(false)->after('cuello');
            $table->boolean('tronco_ajuste')->default(false)->after('tronco');
            $table->boolean('muneca_ajuste')->default(false)->after('muneca');

            // Agarre / Acoplamiento (según tus PDFs, ej: Regular=1)
            $table->unsignedTinyInteger('agarre')->default(0)->after('muneca_ajuste');

            // Actividad (si aún no existe)
            if (!Schema::hasColumn('reba_detalles', 'actividad')) {
                $table->unsignedTinyInteger('actividad')->default(0)->after('agarre');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reba_detalles', function (Blueprint $table) {
            $table->dropColumn([
                'lado',
                'cuello_ajuste',
                'tronco_ajuste',
                'muneca_ajuste',
                'agarre',
                'actividad',
            ]);
        });
    }
};