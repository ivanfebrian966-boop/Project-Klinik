<?php

namespace App\Models;

class Admin extends Person
{
    protected $table = 'admins';

    // Override getRole
    public function getRole()
    {
        return 'Admin';
    }

    // Manage patient data (CRUD action logging matching original ATS)
    public function kelolaDataPasien($action, $pasien)
    {
        if ($pasien instanceof Pasien) {
            return "Admin " . $this->nama . " melakukan " . $action . " pada data pasien " . $pasien->getNama();
        }
        return "Data pasien tidak valid!";
    }
}
