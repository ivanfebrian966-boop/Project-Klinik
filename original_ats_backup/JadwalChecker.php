<?php
interface JadwalChecker {
    // Method untuk mengecek ketersediaan jadwal
    public function isJadwalTersedia($tanggal, $jam);
}
?>