<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reba_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluacion_id')->unique()->constrained('evaluaciones')->cascadeOnDelete();

            $table->integer('cuello')->nullable();
            $table->integer('tronco')->nullable();
            $table->integer('piernas')->nullable();
            $table->integer('brazo')->nullable();
            $table->integer('antebrazo')->nullable();
            $table->integer('muneca')->nullable();
            $table->integer('carga')->nullable();
            $table->integer('tipo_agarre')->nullable();
            $table->integer('actividad')->nullable();

            $table->integer('puntuacion_a')->nullable();
            $table->integer('puntuacion_b')->nullable();
            $table->integer('puntuacion_c')->nullable();
            $table->integer('puntuacion_final');
            $table->string('nivel_riesgo')->nullable();
            $table->string('accion_requerida')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reba_evaluaciones');
    }
};