<?php
/**
 * Kontrak Presenter untuk mengatur alur presentasi dan aksi CRUD kandidat.
 */
interface KontrakPresenter {
    /**
     * Mengambil data kandidat, merakit HTML baris tabel, dan merender halaman daftar.
     */
    public function tampilkanKandidat(): string;

    /**
     * Merender form tambah kandidat (jika $id null) atau form ubah dengan prefill data.
     */
    public function tampilkanFormKandidat(?int $id = null): string;

    /**
     * Memproses penyimpanan kandidat baru lalu redirect ke daftar.
     */
    public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void;

    /**
     * Memproses pembaruan data kandidat berdasarkan ID lalu redirect ke daftar.
     */
    public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void;

    /**
     * Memproses penghapusan kandidat berdasarkan ID lalu redirect ke daftar.
     */
    public function hapusKandidat(int $id): void;
}
?>
