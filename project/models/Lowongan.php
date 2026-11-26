<?php
/**
 * Entity class yang merepresentasikan satu data lowongan pekerjaan.
 */
class Lowongan {
    private ?int $id;
    private string $posisi;
    private string $departemen;
    private string $tipeKerja;
    private int $kuota;
    private string $status;

    /**
     * Konstruktor entity Lowongan.
     */
    public function __construct(
        ?int $id,
        string $posisi,
        string $departemen,
        string $tipeKerja,
        int $kuota,
        string $status
    ) {
        $this->id = $id;
        $this->posisi = $posisi;
        $this->departemen = $departemen;
        $this->tipeKerja = $tipeKerja;
        $this->kuota = $kuota;
        $this->status = $status;
    }

    // Getter properti lowongan
    public function getId(): ?int { return $this->id; }
    public function getPosisi(): string { return $this->posisi; }
    public function getDepartemen(): string { return $this->departemen; }
    public function getTipeKerja(): string { return $this->tipeKerja; }
    public function getKuota(): int { return $this->kuota; }
    public function getStatus(): string { return $this->status; }

    // Setter properti lowongan
    public function setPosisi(string $posisi): void { $this->posisi = $posisi; }
    public function setDepartemen(string $departemen): void { $this->departemen = $departemen; }
    public function setTipeKerja(string $tipeKerja): void { $this->tipeKerja = $tipeKerja; }
    public function setKuota(int $kuota): void { $this->kuota = $kuota; }
    public function setStatus(string $status): void { $this->status = $status; }
}
?>
