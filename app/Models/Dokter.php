<?php

namespace App\Models;

class Dokter extends Person
{
    protected $table = 'dokters';
    protected $fillable = ['nama', 'email', 'password', 'spesialis'];
    protected $hidden = ['password'];

    // Override getRole
    public function getRole()
    {
        return 'Dokter';
    }

    // Relationship to schedules
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'dokter_id');
    }

    // Relationship to medical records
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'dokter_id');
    }

    // Fill diagnosis in RekamMedis
    public function isiDiagnosa($rekamMedis, $diagnosa, $resep)
    {
        if ($rekamMedis instanceof RekamMedis) {
            return $rekamMedis->simpanRekamMedis($diagnosa, $resep);
        }
        return "Data rekam medis tidak valid!";
    }

    // Add practice schedule
    public function tambahJadwalPraktek($jadwal)
    {
        if ($jadwal instanceof Jadwal) {
            $jadwal->dokter_id = $this->id;
            $jadwal->save();
            return "Jadwal praktek ditambahkan";
        }
        return "Data jadwal tidak valid!";
    }

    // Get doctor's schedules
    public function getJadwalPraktek()
    {
        return $this->jadwals;
    }
}
