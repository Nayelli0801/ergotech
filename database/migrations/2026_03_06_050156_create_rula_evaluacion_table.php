<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rula_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluacion_id')->unique()->constrained('evaluaciones')->cascadeOnDelete();

            $table->integer('brazo')->nullable();
            $table->integer('antebrazo')->nullable();
            $table->integer('muneca')->nullable();
            $table->integer('giro_muneca')->nullable();
            $table->integer('cuello')->nullable();
            $table->integer('tronco')->nullable();
            $table->integer('piernas')->nullable();
            $table->boolean('uso_muscular')->default(false);
            $table->integer('carga_fuerza')->nullable();

            $table->integer('puntuacion_a')->nullable();
            $table->integer('puntuacion_b')->nullable();
            $table->integer('puntuacion_c')->nullable();
            $table->integer('puntuacion_d')->nullable();
            $table->integer('puntuacion_final');
            $table->string('nivel_accion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rula_evaluaciones');
    }
};