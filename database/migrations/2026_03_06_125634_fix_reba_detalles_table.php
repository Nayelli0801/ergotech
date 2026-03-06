<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE reba_detalles MODIFY seccion VARCHAR(50) NOT NULL");
        DB::statement("ALTER TABLE reba_detalles MODIFY concepto VARCHAR(100) NOT NULL");
        DB::statement("ALTER TABLE reba_detalles MODIFY valor VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE reba_detalles MODIFY puntaje INT NOT NULL");
    }

    public function down(): void
    {
        //
    }
};