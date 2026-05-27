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
        Schema::create('ocra_detalles', function (Blueprint $table) {
    $table->id();

    $table->foreignId('ocra_evaluacion_id')
        ->constrained('ocra_evaluaciones')
        ->onDelete('cascade');

    $table->string('seccion');
    $table->string('concepto');
    $table->string('valor')->nullable();
    $table->decimal('puntaje', 8, 2)->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocra_detalles');
    }
};
