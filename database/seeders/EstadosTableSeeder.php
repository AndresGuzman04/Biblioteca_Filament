<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['name_estado' => 'Pendiente', 'created_at' => now(), 'updated_at' => now()],
            ['name_estado' => 'Devuelto', 'created_at' => now(), 'updated_at' => now()],
            ['name_estado' => 'Vencido', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('estados')->insert($estados);
    }
}
