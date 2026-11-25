<?php
/**
 * Kontrak Presenter untuk mengatur alur presentasi dan aksi CRUD lowongan pekerjaan.
 */
interface KontrakPresenterLowongan {
    /**
     * Mengambil data lowongan, merakit HTML baris tabel, dan merender halaman daftar.
     */
    public function tampilkanLowongan(): string;

    /**
     * Merender form tambah lowongan (jika $id null) atau form ubah dengan prefill data.
     */
    public function tampilkanFormLowongan(?int $id = null): string;

    /**
     * Memproses penyimpanan lowongan baru lalu redirect ke daftar lowongan.
     */
    public function tambahLowongan(string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void;

    /**
     * Memproses pembaruan data lowongan berdasarkan ID lalu redirect ke daftar lowongan.
     */
    public function ubahLowongan(int $id, string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void;

    /**
     * Memproses penghapusan lowongan berdasarkan ID lalu redirect ke daftar lowongan.
     */
    public function hapusLowongan(int $id): void;
}
?>
