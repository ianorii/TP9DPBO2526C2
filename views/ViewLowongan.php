<?php
require_once __DIR__ . '/KontrakView.php';

/**
 * Implementasi Passive View untuk modul lowongan pekerjaan.
 * Hanya bertugas membaca template HTML dan mengganti token placeholder.
 */
class ViewLowongan implements KontrakView {
    private string $skinPath;
    private string $formPath;

    /**
     * Menentukan path file template daftar dan form lowongan.
     */
    public function __construct(string $skinPath = '', string $formPath = '') {
        $this->skinPath = $skinPath ?: __DIR__ . '/../template/skin_lowongan.html';
        $this->formPath = $formPath ?: __DIR__ . '/../template/form_lowongan.html';
    }

    /**
     * Menyisipkan baris tabel yang sudah dirakit presenter serta total data ke template daftar.
     */
    public function renderDaftar(string $tableRowsHtml, int $totalData): string {
        $template = file_get_contents($this->skinPath);

        $tokens = [
            '{{TABLE_ROWS}}' => $tableRowsHtml,
            '{{TOTAL_DATA}}' => (string)$totalData,
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }

    /**
     * Menyisipkan nilai form (termasuk atribut selected pada dropdown) ke template form.
     */
    public function renderForm(string $title, string $action, array $formData = []): string {
        $template = file_get_contents($this->formPath);
        $tipeKerja = $formData['tipeKerja'] ?? 'Full-time';
        $status = $formData['status'] ?? 'Dibuka';

        $tokens = [
            '{{FORM_TITLE}}'      => htmlspecialchars($title),
            '{{ACTION}}'          => htmlspecialchars($action),
            '{{ID}}'              => htmlspecialchars((string)($formData['id'] ?? '')),
            '{{POSISI}}'          => htmlspecialchars($formData['posisi'] ?? ''),
            '{{DEPARTEMEN}}'      => htmlspecialchars($formData['departemen'] ?? ''),
            '{{KUOTA}}'           => htmlspecialchars((string)($formData['kuota'] ?? 1)),
            '{{TIPE_FULL_TIME}}'  => $tipeKerja === 'Full-time' ? 'selected' : '',
            '{{TIPE_PART_TIME}}'  => $tipeKerja === 'Part-time' ? 'selected' : '',
            '{{TIPE_INTERNSHIP}}' => $tipeKerja === 'Internship' ? 'selected' : '',
            '{{TIPE_CONTRACT}}'   => $tipeKerja === 'Contract' ? 'selected' : '',
            '{{STATUS_DIBUKA}}'   => $status === 'Dibuka' ? 'selected' : '',
            '{{STATUS_DITUTUP}}'  => $status === 'Ditutup' ? 'selected' : '',
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }
}
?>
