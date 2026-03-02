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
    $table->foreignId('evaluacion_id')->constrained()->onDelete('cascade');

    $table->integer('cuello');
    $table->integer('tronco');
    $table->integer('piernas');
    $table->integer('carga');
    $table->integer('brazo');
    $table->integer('antebrazo');
    $table->integer('muneca');

    $table->integer('puntaje_a');
    $table->integer('puntaje_b');
    $table->integer('puntaje_final');

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
