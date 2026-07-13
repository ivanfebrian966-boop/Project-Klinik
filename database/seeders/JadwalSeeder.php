<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pasien;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $dokter1 = Dokter::where('email', 'dr.muhammad@klinik.com')->first();
        $dokter2 = Dokter::where('email', 'dr.siti@klinik.com')->first();

        if (!$dokter1 || !$dokter2) {
            return;
        }

        Jadwal::updateOrCreate(
            [
                'tanggal' => '2024-12-20',
                'jam' => '09:00',
                'dokter_id' => $dokter1->id,
            ],
            [
                'status' => 'tersedia',
            ]
        );

        Jadwal::updateOrCreate(
            [
                'tanggal' => '2024-12-20',
                'jam' => '14:00',
                'dokter_id' => $dokter1->id,
            ],
            [
                'status' => 'tersedia',
            ]
        );

        Jadwal::updateOrCreate(
            [
                'tanggal' => '2024-12-21',
                'jam' => '10:00',
                'dokter_id' => $dokter1->id,
            ],
            [
                'status' => 'dipesan',
                'pasien_id' => Pasien::where('email', 'ahmad@email.com')->first()->id ?? null,
                'tanggal_booking' => now(),
            ]
        );

        Jadwal::updateOrCreate(
            [
                'tanggal' => '2024-12-22',
                'jam' => '11:00',
                'dokter_id' => $dokter2->id,
            ],
            [
                'status' => 'tersedia',
            ]
        );

        Jadwal::updateOrCreate(
            [
                'tanggal' => '2024-12-23',
                'jam' => '09:30',
                'dokter_id' => $dokter2->id,
            ],
            [
                'status' => 'dipesan',
                'pasien_id' => Pasien::where('email', 'rina@email.com')->first()->id ?? null,
                'tanggal_booking' => now(),
            ]
        );

        Jadwal::updateOrCreate(
            [
                'tanggal' => '2024-12-24',
                'jam' => '15:00',
                'dokter_id' => $dokter1->id,
            ],
            [
                'status' => 'tersedia',
            ]
        );
    }
}
