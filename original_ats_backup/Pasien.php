<?php
require_once 'Person.php';
require_once 'Jadwal.php';

class Pasien extends Person {
    public $noRM;
    public $alamat;
    private $riwayatBooking = [];
    
    public function __construct($nama, $email, $password, $noRM, $alamat) {
        parent::__construct($nama, $email, $password);
        $this->noRM = $noRM;
        $this->alamat = $alamat;
    }
    
    // IMPLEMENTASI OVERRIDING METHOD (POIN 3)
    // Override method login dari abstract class
    public function login($email, $password) {
        if ($this->email == $email && $this->password == $password) {
            return "Login berhasil sebagai Pasien: " . $this->nama;
        }
        return "Login gagal! Email atau password salah.";
    }
    
    // Override method getRole
    public function getRole() {
        return "Pasien";
    }
    
    public function bookingJadwal($jadwal) {
        if ($jadwal instanceof Jadwal && $jadwal->isJadwalTersedia($jadwal->tanggal, $jadwal->jam)) {
            $jadwal->updateStatus('dipesan');
            $this->riwayatBooking[] = [
                'jadwal' => $jadwal,
                'tanggal_booking' => date('Y-m-d H:i:s')
            ];
            return "Booking berhasil untuk tanggal " . $jadwal->tanggal . " jam " . $jadwal->jam;
        }
        return "Maaf, jadwal tidak tersedia!";
    }
    
    public function lihatRiwayatBooking() {
        return $this->riwayatBooking;
    }
}
?>