<?php
require_once 'Person.php';
require_once 'RekamMedis.php';

class Dokter extends Person {
    private $spesialis;
    private $jadwalPraktek = [];
    
    public function __construct($nama, $email, $password, $spesialis) {
        parent::__construct($nama, $email, $password);
        $this->spesialis = $spesialis;
    }
    
    // IMPLEMENTASI OVERRIDING METHOD (POIN 3)
    // Override method login dari abstract class
    public function login($email, $password) {
        if ($this->email == $email && $this->password == $password) {
            return "Login berhasil sebagai Dokter: " . $this->nama;
        }
        return "Login gagal! Email atau password salah.";
    }
    
    // Override method getRole
    public function getRole() {
        return "Dokter";
    }
    
    public function isiDiagnosa($rekamMedis, $diagnosa, $resep) {
        if ($rekamMedis instanceof RekamMedis) {
            return $rekamMedis->simpanRekamMedis($diagnosa, $resep);
        }
        return "Data rekam medis tidak valid!";
    }
    
    public function tambahJadwalPraktek($jadwal) {
        $this->jadwalPraktek[] = $jadwal;
        return "Jadwal praktek ditambahkan";
    }
    
    public function getJadwalPraktek() {
        return $this->jadwalPraktek;
    }
}
?>