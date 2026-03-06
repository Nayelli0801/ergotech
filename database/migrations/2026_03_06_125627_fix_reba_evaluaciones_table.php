<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reba_evaluaciones', function (Blueprint $table) {
            // Si no existe la FK, puedes dejar esta parte comentada
            // y agregarla manualmente después de revisar tu BD.
        });

        // Ajuste de nulos por seguridad
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY cuello INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY tronco INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY piernas INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY brazo INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY antebrazo INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY muneca INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY carga INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY tipo_agarre INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY actividad INT NOT NULL");

        DB::statement("ALTER TABLE reba_evaluaciones MODIFY puntuacion_a INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY puntuacion_b INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY puntuacion_c INT NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY puntuacion_final INT NOT NULL");

        DB::statement("ALTER TABLE reba_evaluaciones MODIFY nivel_riesgo VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE reba_evaluaciones MODIFY accion_requerida VARCHAR(255) NOT NULL");
    }

    public function down(): void
    {
        //
    }
};