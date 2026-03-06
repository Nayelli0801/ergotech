<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'evaluador', 'visitante'];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $rol],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}