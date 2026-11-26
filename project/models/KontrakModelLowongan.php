<?php
/**
 * Kontrak Model untuk operasi CRUD data lowongan pekerjaan.
 */
interface KontrakModelLowongan {
    /**
     * Mengambil seluruh data lowongan sebagai array objek Lowongan.
     * @return Lowongan[]
     */
    public function getAllLowongan(): array;

    /**
     * Mengambil satu data lowongan berdasarkan ID.
     */
    public function getLowonganById(int $id): ?Lowongan;

    /**
     * Menambahkan data lowongan baru ke database.
     */
    public function addLowongan(string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void;

    /**
     * Memperbarui data lowongan yang sudah ada berdasarkan ID.
     */
    public function updateLowongan(int $id, string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void;

    /**
     * Menghapus data lowongan berdasarkan ID.
     */
    public function deleteLowongan(int $id): void;
}
?>
