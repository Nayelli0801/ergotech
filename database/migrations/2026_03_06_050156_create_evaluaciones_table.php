<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('sucursal_id')->constrained('sucursales')->cascadeOnDelete();
            $table->foreignId('puesto_id')->constrained('puestos')->cascadeOnDelete();
            $table->foreignId('trabajador_id')->nullable()->constrained('trabajadores')->nullOnDelete();
            $table->foreignId('metodo_id')->constrained('metodos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->date('fecha_evaluacion');
            $table->string('area_evaluada')->nullable();
            $table->string('actividad')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('resultado_final')->nullable();
            $table->string('nivel_riesgo')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};