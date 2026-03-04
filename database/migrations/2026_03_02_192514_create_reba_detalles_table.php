<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reba_detalles', function (Blueprint $table) {

            $table->id();

            // Relación con evaluación
            $table->foreignId('evaluacion_id')
                ->constrained('evaluaciones')
                ->onDelete('cascade');

            // ====== POSTURAS ======
            $table->unsignedTinyInteger('cuello');       // 1–3
            $table->unsignedTinyInteger('tronco');       // 1–5
            $table->unsignedTinyInteger('piernas');      // 1–4
            $table->unsignedTinyInteger('carga')->default(0);   // 0–3

            $table->unsignedTinyInteger('brazo');        // 1–6
            $table->unsignedTinyInteger('antebrazo');    // 1–2
            $table->unsignedTinyInteger('muneca');       // 1–3

            // ====== ACTIVIDAD ======
            $table->unsignedTinyInteger('actividad')->default(0); // 0–3

            // ====== RESULTADOS ======
            $table->unsignedTinyInteger('puntaje_a');
            $table->unsignedTinyInteger('puntaje_b');
            $table->unsignedTinyInteger('puntaje_final');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reba_detalles');
    }
};