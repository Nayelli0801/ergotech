<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nom036_detalles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('nom036_evaluacion_id')
                  ->constrained('nom036_evaluaciones')
                  ->onDelete('cascade');

            $table->string('seccion');
            $table->string('concepto');
            $table->string('valor')->nullable();
            $table->string('resultado')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nom036_detalles');
    }
};