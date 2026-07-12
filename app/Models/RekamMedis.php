<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $fillable = ['tanggal', 'keluhan', 'diagnosa', 'resep', 'pasien_id', 'dokter_id'];
    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationship to Patient
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // Relationship to Doctor
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    // Save medical record details
    public function simpanRekamMedis($diagnosa, $resep)
    {
        $this->diagnosa = $diagnosa;
        $this->resep = $resep;
        $this->save();
        return "Rekam medis berhasil disimpan dengan diagnosa: " . $diagnosa;
    }

    // View medical record details
    public function lihatRekamMedis()
    {
        return [
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'keluhan' => $this->keluhan,
            'diagnosa' => $this->diagnosa,
            'resep' => $this->resep
        ];
    }
}
