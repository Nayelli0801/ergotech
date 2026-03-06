<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('niosh_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluacion_id')->unique()->constrained('evaluaciones')->cascadeOnDelete();

            $table->decimal('distancia_horizontal', 8, 2)->nullable();
            $table->decimal('altura_inicial', 8, 2)->nullable();
            $table->decimal('desplazamiento_vertical', 8, 2)->nullable();
            $table->decimal('angulo_asimetria', 8, 2)->nullable();
            $table->decimal('frecuencia_levantamiento', 8, 2)->nullable();
            $table->string('duracion')->nullable();
            $table->string('calidad_agarre')->nullable();
            $table->decimal('peso_objeto', 8, 2);
            $table->decimal('constante_carga', 8, 2)->nullable();

            $table->decimal('hm', 8, 3)->nullable();
            $table->decimal('vm', 8, 3)->nullable();
            $table->decimal('dm', 8, 3)->nullable();
            $table->decimal('am', 8, 3)->nullable();
            $table->decimal('fm', 8, 3)->nullable();
            $table->decimal('cm', 8, 3)->nullable();
            $table->decimal('rwl', 10, 2)->nullable();
            $table->decimal('indice_levantamiento', 10, 2)->nullable();

            $table->string('nivel_riesgo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niosh_evaluaciones');
    }
};