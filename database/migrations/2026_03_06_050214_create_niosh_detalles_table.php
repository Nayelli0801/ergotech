<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('niosh_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('niosh_evaluacion_id')->constrained('niosh_evaluaciones')->cascadeOnDelete();
            $table->string('seccion');
            $table->string('concepto');
            $table->string('valor')->nullable();
            $table->decimal('resultado', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niosh_detalles');
    }
};