<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoSeeder extends Seeder
{
    public function run(): void
    {
        $metodos = [
            [
                'nombre' => 'RULA',
                'descripcion' => 'Rapid Upper Limb Assessment',
                'activo' => 1,
            ],
            [
                'nombre' => 'REBA',
                'descripcion' => 'Rapid Entire Body Assessment',
                'activo' => 1,
            ],
            [
                'nombre' => 'OWAS',
                'descripcion' => 'Ovako Working Posture Analysis System',
                'activo' => 1,
            ],
            [
                'nombre' => 'NIOSH',
                'descripcion' => 'Ecuación revisada de levantamiento NIOSH',
                'activo' => 1,
            ],
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