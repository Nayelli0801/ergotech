<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Metodo;

class MetodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['REBA','RULA','NIOSH','OWAS'] as $m) {
        Metodo::firstOrCreate(['nombre' => $m]);
    }
    }
}
