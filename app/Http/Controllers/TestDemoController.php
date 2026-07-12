<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Admin;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class TestDemoController extends Controller
{
    public function runDemo()
    {
        $logs = [];

        // 1. INSTANSIASI OBJEK (Mendapatkan dari DB yang merepresentasikan instansiasi data)
        $logs[] = "=== [1. INSTANSIASI OBJEK & DATA DARI MYSQL] ===";
        
        $jadwal1 = Jadwal::find(1);
        $jadwal2 = Jadwal::find(2);
        $jadwal3 = Jadwal::find(3);
        $logs[] = "✓ Objek Jadwal berhasil diload dari Database (ID 1, 2, dan 3)";

        $rekamMedis1 = RekamMedis::find(1001);
        $logs[] = "✓ Objek RekamMedis berhasil diload dari Database (ID 1001)";

        // POLYMORPHISME (Menggunakan tipe abstract Person)
        $person1 = Pasien::where('nama', 'Ahmad')->first();
        $person2 = Dokter::where('nama', 'Dr. Muhammad Ivan Febrian')->first();
        $person3 = Admin::where('nama', 'Budi')->first();
        
        $logs[] = "✓ Objek Pasien [Polymorphism sebagai Person] loaded: " . $person1->getNama();
        $logs[] = "✓ Objek Dokter [Polymorphism sebagai Person] loaded: " . $person2->getNama();
        $logs[] = "✓ Objek Admin [Polymorphism sebagai Person] loaded: " . $person3->getNama();
        $logs[] = "";

        // 2. PROSES BISNIS KLINIK
        $logs[] = "=== [2. PROSES BISNIS KLINIK] ===";
        
        $logs[] = "A. PROSES LOGIN (Overriding Method):";
        $logs[] = " - " . $person1->login("ahmad@email.com", "pass123");
        $logs[] = " - " . $person2->login("dr.muhammad@klinik.com", "dokter123");
        $logs[] = " - " . $person3->login("admin@klinik.com", "admin123");
        $logs[] = "";

        $logs[] = "B. PROSES BOOKING JADWAL (OOP Method):";
        // Reset status to tersedia for demonstration
        if ($jadwal1) {
            $jadwal1->status = 'tersedia';
            $jadwal1->pasien_id = null;
            $jadwal1->save();
            $logs[] = " - " . $person1->bookingJadwal($jadwal1);
        }
        if ($jadwal3) {
            $logs[] = " - " . $person1->bookingJadwal($jadwal3) . " (Jadwal 3 sudah dipesan)";
        }
        $logs[] = "";

        $logs[] = "C. PROSES KELOLA DATA PASIEN OLEH ADMIN:";
        $logs[] = " - " . $person3->kelolaDataPasien("UPDATE", $person1);
        $logs[] = "";

        $logs[] = "D. PROSES DOKTER ISI DIAGNOSA (OOP Method):";
        if ($rekamMedis1) {
            $logs[] = " - " . $person2->isiDiagnosa($rekamMedis1, "Demam berdarah ringan (Diperbarui)", "Paracetamol 3x1, Multivitamin 1x1");
        }
        $logs[] = "";

        $logs[] = "E. DETAIL REKAM MEDIS:";
        if ($rekamMedis1) {
            $rm = $rekamMedis1->lihatRekamMedis();
            $logs[] = " - ID Rekam Medis: " . $rm['id'];
            $logs[] = " - Tanggal: " . $rm['tanggal'];
            $logs[] = " - Keluhan: " . $rm['keluhan'];
            $logs[] = " - Diagnosa: " . $rm['diagnosa'];
            $logs[] = " - Resep: " . $rm['resep'];
        }
        $logs[] = "";

        $logs[] = "F. CEK KETERSEDIAAN JADWAL (Interface Method):";
        if ($jadwal1) {
            $logs[] = " - Jadwal 1 (20 Des 2024 09:00): " . ($jadwal1->isJadwalTersedia("2024-12-20", "09:00") ? "Tersedia" : "Tidak Tersedia");
        }
        if ($jadwal3) {
            $logs[] = " - Jadwal 3 (21 Des 2024 10:00): " . ($jadwal3->isJadwalTersedia("2024-12-21", "10:00") ? "Tersedia" : "Tidak Tersedia");
        }
        $logs[] = "";

        $logs[] = "G. UPDATE STATUS JADWAL:";
        if ($jadwal1) {
            $logs[] = " - " . $jadwal1->updateStatus("selesai");
        }
        $logs[] = "";

        // 3. DEMONSTRASI POLYMORPHISME
        $logs[] = "=== [3. DEMONSTRASI POLYMORPHISME] ===";
        $persons = [$person1, $person2, $person3];
        foreach ($persons as $person) {
            $logs[] = " - " . $person->getNama() . " - Role: " . $person->getRole();
        }
        $logs[] = "";
        $logs[] = "=== [DEMO SELESAI] ===";

        return view('test_demo', compact('logs'));
    }
}
