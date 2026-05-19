<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodosSeeder extends Seeder
{
    public function run(): void
    {
        $metodos = [
            ['nombre' => 'REBA', 'descripcion' => 'Evaluación rápida de cuerpo entero.', 'activo' => 1],
            ['nombre' => 'RULA', 'descripcion' => 'Evaluación rápida de extremidades superiores.', 'activo' => 1],
            ['nombre' => 'OWAS', 'descripcion' => 'Clasificación de posturas de trabajo.', 'activo' => 1],
            ['nombre' => 'NIOSH', 'descripcion' => 'Evaluación de levantamiento manual de cargas.', 'activo' => 1],
            ['nombre' => 'NOM-036', 'descripcion' => 'Evaluación de factores de riesgo ergonómico por manejo manual de cargas.', 'activo' => 1],
            ['nombre' => 'ERGONOMIA GENERAL', 'descripcion' => 'Evaluación ergonómica general del puesto de trabajo.', 'activo' => 1],
        ];

        foreach ($metodos as $metodo) {
            DB::table('metodos')->updateOrInsert(
                ['nombre' => $metodo['nombre']],
                [
                    'descripcion' => $metodo['descripcion'],
                    'activo' => $metodo['activo'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}