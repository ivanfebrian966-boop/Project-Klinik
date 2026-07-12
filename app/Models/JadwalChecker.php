<?php

namespace App\Models;

interface JadwalChecker
{
    // Method to check schedule availability
    public function isJadwalTersedia($tanggal, $jam);
}
