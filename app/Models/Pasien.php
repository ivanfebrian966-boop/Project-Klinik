<?php

namespace App\Models;

class Pasien extends Person
{
    protected $table = 'pasiens';

    // Override getRole
    public function getRole()
    {
        return 'Pasien';
    }

    // Relationship to booked schedules
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'pasien_id');
    }

    // Relationship to medical records
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'pasien_id');
    }

    // Booking method
    public function bookingJadwal($jadwal)
    {
        if ($jadwal instanceof Jadwal && $jadwal->isJadwalTersedia($jadwal->tanggal, $jadwal->jam)) {
            $jadwal->updateStatus('dipesan');
            $jadwal->pasien_id = $this->id;
            $jadwal->save();
            return "Booking berhasil untuk tanggal " . $jadwal->tanggal . " jam " . $jadwal->jam;
        }
        return "Maaf, jadwal tidak tersedia!";
    }

    // View booking history
    public function lihatRiwayatBooking()
    {
        return $this->jadwals()->with('dokter')->get();
    }
}
