<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owas_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluacion_id')->unique()->constrained('evaluaciones')->cascadeOnDelete();

            $table->integer('espalda');
            $table->integer('brazos');
            $table->integer('piernas');
            $table->integer('carga');
            $table->string('codigo_postura', 20)->nullable();
            $table->integer('categoria_riesgo');
            $table->string('accion_correctiva')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owas_evaluaciones');
    }
};