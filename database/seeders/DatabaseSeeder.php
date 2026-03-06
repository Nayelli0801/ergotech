<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rol;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            MetodoSeeder::class,
        ]);

        $rolAdmin = Rol::where('nombre', 'admin')->first();

        User::updateOrCreate(
            ['email' => 'admin@ergotech.com'],
            [
                'name' => 'Admin',
                'last_name' => 'Ergotech',
                'password' => bcrypt('Admin12345'),
                'rol_id' => $rolAdmin?->id,
            ]
        );
    }
}