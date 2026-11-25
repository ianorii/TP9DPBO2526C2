<?php
/**
 * Kontrak Model untuk operasi CRUD data kandidat.
 */
interface KontrakModel {
    /**
     * Mengambil seluruh data kandidat sebagai array objek Kandidat.
     * @return Kandidat[]
     */
    public function getAllKandidat(): array;

    /**
     * Mengambil satu data kandidat berdasarkan ID.
     */
    public function getKandidatById(int $id): ?Kandidat;

    /**
     * Menambahkan data kandidat baru ke database.
     */
    public function addKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void;

    /**
     * Memperbarui data kandidat yang sudah ada berdasarkan ID.
     */
    public function updateKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void;

    /**
     * Menghapus data kandidat berdasarkan ID.
     */
    public function deleteKandidat(int $id): void;
}
?>
