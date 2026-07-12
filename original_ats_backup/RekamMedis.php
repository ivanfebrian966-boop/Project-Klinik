<?php
class RekamMedis {
    public $idRekamMedis;
    public $tanggal;
    public $keluhan;
    public $diagnosa;
    public $resep;
    
    public function __construct($idRekamMedis, $tanggal, $keluhan) {
        $this->idRekamMedis = $idRekamMedis;
        $this->tanggal = $tanggal;
        $this->keluhan = $keluhan;
    }
    
    public function simpanRekamMedis($diagnosa, $resep) {
        $this->diagnosa = $diagnosa;
        $this->resep = $resep;
        return "Rekam medis berhasil disimpan dengan diagnosa: " . $diagnosa;
    }
    
    public function lihatRekamMedis() {
        return [
            'id' => $this->idRekamMedis,
            'tanggal' => $this->tanggal,
            'keluhan' => $this->keluhan,
            'diagnosa' => $this->diagnosa,
            'resep' => $this->resep
        ];
    }
}
?>