<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Database\Seeder;

class RekamMedisSeeder extends Seeder
{
    public function run(): void
    {
        $dokter = Dokter::where('email', 'dr.muhammad@klinik.com')->first();
        $pasien = Pasien::where('email', 'ahmad@email.com')->first();

        if (!$dokter || !$pasien) {
            return;
        }

        RekamMedis::updateOrCreate([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'tanggal' => '2024-12-20',
        ], [
            'keluhan' => 'Demam tinggi dan batuk',
            'diagnosa' => 'Demam berdarah ringan',
            'resep' => 'Paracetamol 3x1, Multivitamin 1x1',
        ]);
    }
}
