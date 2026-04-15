<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Agregamos las columnas que necesita Spatie
            $table->string('name')->nullable()->after('id');
            $table->string('guard_name')->default('web')->after('name');
        });

        // Copiamos los datos de 'nombre' a 'name'
        DB::statement('UPDATE roles SET name = nombre');
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['name', 'guard_name']);
        });
    }
};
