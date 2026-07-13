<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DokterSeeder::class,
            PasienSeeder::class,
            JadwalSeeder::class,
            RekamMedisSeeder::class,
        ]);
    }
}
