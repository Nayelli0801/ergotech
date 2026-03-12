<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nom036_evaluaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evaluacion_id')
                  ->constrained('evaluaciones')
                  ->onDelete('cascade');

            // Tipo de actividad
            $table->string('tipo_actividad'); 
            // levantar, bajar, transportar, empujar, jalar, arrastrar

            // Datos de la carga
            $table->string('objeto_manipulado')->nullable();
            $table->float('peso_carga')->nullable();

            // Condiciones de la tarea
            $table->float('frecuencia')->nullable();
            $table->float('duracion')->nullable();
            $table->float('distancia_recorrida')->nullable();

            // Alturas
            $table->float('altura_inicial')->nullable();
            $table->float('altura_final')->nullable();

            // Posturas
            $table->string('postura_tronco')->nullable();
            $table->string('postura_brazos')->nullable();
            $table->string('postura_piernas')->nullable();

            // Condiciones
            $table->string('agarre')->nullable();
            $table->boolean('asimetria')->default(false);
            $table->boolean('movimientos_repetitivos')->default(false);
            $table->boolean('fuerza_brusca')->default(false);

            // Ambiente
            $table->string('condiciones_ambientales')->nullable();
            $table->string('superficie_trabajo')->nullable();
            $table->string('espacio_trabajo')->nullable();

            // Resultado
            $table->string('nivel_riesgo')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nom036_evaluaciones');
    }
};