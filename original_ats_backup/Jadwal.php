<?php
require_once 'JadwalChecker.php';

class Jadwal implements JadwalChecker {
    public $idJadwal;
    public $tanggal;
    public $jam;
    public $status; // 'tersedia', 'dipesan', 'selesai'
    
    public function __construct($idJadwal, $tanggal, $jam, $status = 'tersedia') {
        $this->idJadwal = $idJadwal;
        $this->tanggal = $tanggal;
        $this->jam = $jam;
        $this->status = $status;
    }
    
    // Implementasi method dari interface
    public function isJadwalTersedia($tanggal, $jam) {
        if ($this->tanggal == $tanggal && $this->jam == $jam && $this->status == 'tersedia') {
            return true;
        }
        return false;
    }
    
    public function updateStatus($statusBaru) {
        $this->status = $statusBaru;
        return "Status jadwal berhasil diupdate menjadi: " . $statusBaru;
    }
}
?>