<?php
require_once 'Jadwal.php';
require_once 'RekamMedis.php';
require_once 'Pasien.php';
require_once 'Dokter.php';
require_once 'Admin.php';

echo "========== APLIKASI KLINIK ==========<br><br>";

// POIN 5a - INSTANSIASI SEMUA CLASS
echo "1. INSTANSIASI OBJEK<br>";

// Instansiasi Jadwal
$jadwal1 = new Jadwal(1, "2024-12-20", "09:00", "tersedia");
$jadwal2 = new Jadwal(2, "2024-12-20", "14:00", "tersedia");
$jadwal3 = new Jadwal(3, "2024-12-21", "10:00", "dipesan");
echo "✓ Objek Jadwal dibuat (3 jadwal)<br>";

// Instansiasi RekamMedis
$rekamMedis1 = new RekamMedis(1001, "2024-12-20", "Demam tinggi dan batuk");
echo "✓ Objek RekamMedis dibuat<br>";

// POLYMORPHISME (POIN 4)
$person1 = new Pasien("Ahmad", "ahmad@email.com", "pass123", "RM001", "Jl. Merdeka No. 10");
$person2 = new Dokter("Dr. Muhammad Ivan Febrian", "dr.muhammad@klinik.com", "dokter123", "Umum");
$person3 = new Admin("Budi", "admin@klinik.com", "admin123", "super");

echo "✓ Objek Pasien dibuat (Polymorphism sebagai Person)<br>";
echo "✓ Objek Dokter dibuat (Polymorphism sebagai Person)<br>";
echo "✓ Objek Admin dibuat (Polymorphism sebagai Person)<br><br>";

// POIN 5b & 5c - PROSES BISNIS KLINIK
echo "2. PROSES BISNIS KLINIK<br>";

echo "<br>A. PROSES LOGIN:<br>";
echo $person1->login("ahmad@email.com", "pass123") . "<br>";
echo $person2->login("dr.muhammad@klinik.com", "dokter123") . "<br>";
echo $person3->login("admin@klinik.com", "admin123") . "<br>";

echo "<br>B. PROSES BOOKING JADWAL:<br>";
echo $person1->bookingJadwal($jadwal1) . "<br>";
echo $person1->bookingJadwal($jadwal3) . "<br>";

echo "<br>C. PROSES ADMIN KELOLA DATA:<br>";
echo $person3->kelolaDataPasien("UPDATE", $person1) . "<br>";

echo "<br>D. PROSES DOKTER ISI DIAGNOSA:<br>";
echo $person2->isiDiagnosa($rekamMedis1, "Demam berdarah ringan", 
                          "Paracetamol 3x1, Multivitamin 1x1") . "<br>";

echo "<br>E. LIHAT REKAM MEDIS:<br>";
$rm = $rekamMedis1->lihatRekamMedis();
echo "ID Rekam Medis: " . $rm['id'] . "<br>";
echo "Tanggal: " . $rm['tanggal'] . "<br>";
echo "Keluhan: " . $rm['keluhan'] . "<br>";
echo "Diagnosa: " . $rm['diagnosa'] . "<br>";
echo "Resep: " . $rm['resep'] . "<br>";

echo "<br>F. CEK KETERSEDIAAN JADWAL:<br>";
echo "Jadwal tanggal 20 Des 2024 jam 09:00: " . 
     ($jadwal1->isJadwalTersedia("2024-12-20", "09:00") ? "Tersedia" : "Tidak Tersedia") . "<br>";
echo "Jadwal tanggal 21 Des 2024 jam 10:00: " . 
     ($jadwal3->isJadwalTersedia("2024-12-21", "10:00") ? "Tersedia" : "Tidak Tersedia") . "<br>";

echo "<br>G. UPDATE STATUS JADWAL:<br>";
echo $jadwal1->updateStatus("selesai") . "<br>";

echo "<br>3. DEMONSTRASI POLYMORPHISM<br>";
$persons = [$person1, $person2, $person3];
foreach ($persons as $person) {
    echo $person->getNama() . " - Role: " . $person->getRole() . "<br>";
}

echo "<br>========== SELESAI ==========<br>";
?>