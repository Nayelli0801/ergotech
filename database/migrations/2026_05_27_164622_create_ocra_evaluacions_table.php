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
        Schema::create('ocra_evaluaciones', function (Blueprint $table) {
    $table->id();

    $table->foreignId('evaluacion_id')
        ->constrained('evaluaciones')
        ->onDelete('cascade');

    $table->string('lado_evaluado')->nullable(); // Derecho, izquierdo, ambos
    $table->decimal('duracion_tarea', 5, 2)->default(0);
    $table->integer('acciones_tecnicas')->default(0);
    $table->integer('frecuencia_acciones')->default(0);

    $table->integer('fuerza')->default(0);
    $table->integer('postura_hombro')->default(0);
    $table->integer('postura_codo')->default(0);
    $table->integer('postura_muneca')->default(0);
    $table->integer('postura_mano')->default(0);
    $table->integer('repetitividad')->default(0);
    $table->integer('factores_adicionales')->default(0);
    $table->integer('recuperacion')->default(0);

    $table->decimal('indice_ocra', 8, 2)->default(0);
    $table->string('nivel_riesgo')->nullable();
    $table->text('recomendaciones')->nullable();
    $table->text('observaciones')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocra_evaluacions');
    }
};
