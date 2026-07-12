<?php
require_once 'Person.php';

class Admin extends Person {
    private $levelAkses;
    
    public function __construct($nama, $email, $password, $levelAkses = 'super') {
        parent::__construct($nama, $email, $password);
        $this->levelAkses = $levelAkses;
    }
    
    // IMPLEMENTASI OVERRIDING METHOD (POIN 3)
    // Override method login dari abstract class
    public function login($email, $password) {
        if ($this->email == $email && $this->password == $password) {
            return "Login berhasil sebagai Admin: " . $this->nama;
        }
        return "Login gagal! Email atau password salah.";
    }
    
    // Override method getRole
    public function getRole() {
        return "Admin";
    }
    
    public function kelolaDataPasien($action, $pasien) {
        if ($pasien instanceof Pasien) {
            return "Admin " . $this->nama . " melakukan " . $action . " pada data pasien " . $pasien->getNama();
        }
        return "Data pasien tidak valid!";
    }
}
?>