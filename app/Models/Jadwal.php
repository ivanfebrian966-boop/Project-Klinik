<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model implements JadwalChecker
{
    protected $table = 'jadwals';
    protected $guarded = [];

    // Relationship to Doctor
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    // Relationship to Patient (who booked this schedule)
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // Implement method from interface
    public function isJadwalTersedia($tanggal, $jam)
    {
        if ($this->tanggal == $tanggal && $this->jam == $jam && $this->status == 'tersedia') {
            return true;
        }
        return false;
    }

    // Update schedule status
    public function updateStatus($statusBaru)
    {
        $this->status = $statusBaru;
        $this->save();
        return "Status jadwal berhasil diupdate menjadi: " . $statusBaru;
    }
}
