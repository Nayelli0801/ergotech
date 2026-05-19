<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRol = DB::table('roles')->updateOrInsert(
            ['nombre' => 'admin'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $evaluadorRol = DB::table('roles')->updateOrInsert(
            ['nombre' => 'evaluador'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $visitanteRol = DB::table('roles')->updateOrInsert(
            ['nombre' => 'visitante'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $adminId = DB::table('roles')->where('nombre', 'admin')->value('id');
        $evaluadorId = DB::table('roles')->where('nombre', 'evaluador')->value('id');
        $visitanteId = DB::table('roles')->where('nombre', 'visitante')->value('id');

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@ergotech.com'],
            [
                'name' => 'Admin',
                'last_name' => 'Demo',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'rol_id' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'evaluador@ergotech.com'],
            [
                'name' => 'Evaluador',
                'last_name' => 'Demo',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'rol_id' => $evaluadorId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'visitante@ergotech.com'],
            [
                'name' => 'Visitante',
                'last_name' => 'Demo',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'rol_id' => $visitanteId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}