<?php
/**
 * Kontrak View (Strict Passive View).
 * View tidak mengenal entitas domain, tidak melakukan loop, dan tidak menghitung agregat.
 */
interface KontrakView {
    /**
     * Merender halaman daftar dengan menyisipkan baris tabel HTML siap pakai dan total data.
     */
    public function renderDaftar(string $tableRowsHtml, int $totalData): string;

    /**
     * Merender halaman form tambah/ubah dengan menyisipkan judul, aksi, dan nilai prefill.
     */
    public function renderForm(string $title, string $action, array $formData = []): string;
}
?>
