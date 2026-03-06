<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reba_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reba_evaluacion_id')->constrained('reba_evaluaciones')->cascadeOnDelete();
            $table->string('seccion');
            $table->string('concepto');
            $table->string('valor')->nullable();
            $table->integer('puntaje')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reba_detalles');
    }
};