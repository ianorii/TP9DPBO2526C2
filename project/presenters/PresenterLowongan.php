<?php
require_once __DIR__ . '/KontrakPresenterLowongan.php';
require_once __DIR__ . '/../models/KontrakModelLowongan.php';
require_once __DIR__ . '/../views/KontrakView.php';

/**
 * Presenter konkret modul lowongan pekerjaan (penghubung KontrakModelLowongan dan KontrakView).
 */
class PresenterLowongan implements KontrakPresenterLowongan {
    private KontrakModelLowongan $model;
    private KontrakView $view;

    /**
     * Menyuntikkan dependensi model dan view melalui interface masing-masing.
     */
    public function __construct(KontrakModelLowongan $model, KontrakView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    /**
     * Helper untuk merakit 1 baris HTML tabel lowongan beserta badge status dan tombol aksi.
     */
    private function buildRowHtml(int $no, Lowongan $lowongan): string {
        $id = (int)$lowongan->getId();
        $posisi = htmlspecialchars($lowongan->getPosisi());
        $departemen = htmlspecialchars($lowongan->getDepartemen());
        $tipeKerja = htmlspecialchars($lowongan->getTipeKerja());
        $kuota = number_format($lowongan->getKuota()) . ' Orang';
        $statusRaw = $lowongan->getStatus();
        $status = htmlspecialchars($statusRaw);
        $badgeClass = $statusRaw === 'Dibuka' ? 'badge-open' : 'badge-closed';

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$posisi}</strong></td>
            <td>{$departemen}</td>
            <td>{$tipeKerja}</td>
            <td>{$kuota}</td>
            <td><span class='badge {$badgeClass}'>{$status}</span></td>
            <td class='col-actions'>
                <a href='index.php?modul=lowongan&screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php?modul=lowongan' style='display:inline;' onsubmit=\"return confirm('Hapus lowongan ini?')\">
                    <input type='hidden' name='modul' value='lowongan'>
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    /**
     * Mengambil daftar lowongan dari model, merakit HTML baris, dan meneruskannya ke view.
     */
    public function tampilkanLowongan(): string {
        $listLowongan = $this->model->getAllLowongan();
        $totalLowongan = count($listLowongan);

        $rowsHtml = '';
        if (empty($listLowongan)) {
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data lowongan.</td></tr>';
        } else {
            $no = 1;
            foreach ($listLowongan as $lowongan) {
                $rowsHtml .= $this->buildRowHtml($no, $lowongan);
                $no++;
            }
        }

        return $this->view->renderDaftar($rowsHtml, $totalLowongan);
    }

    /**
     * Menampilkan form tambah atau edit lowongan; redirect ke daftar jika ID edit tidak ditemukan.
     */
    public function tampilkanFormLowongan(?int $id = null): string {
        if ($id !== null) {
            $lowongan = $this->model->getLowonganById($id);
            if ($lowongan === null) {
                header("Location: index.php?modul=lowongan");
                exit();
            }

            $formData = [
                'id'         => $lowongan->getId(),
                'posisi'     => $lowongan->getPosisi(),
                'departemen' => $lowongan->getDepartemen(),
                'tipeKerja'  => $lowongan->getTipeKerja(),
                'kuota'      => $lowongan->getKuota(),
                'status'     => $lowongan->getStatus(),
            ];
            return $this->view->renderForm("Ubah Data Lowongan", "ubah", $formData);
        }

        return $this->view->renderForm("Tambah Lowongan Baru", "tambah", []);
    }

    /**
     * Meneruskan penambahan lowongan ke model lalu menerapkan pola Post-Redirect-Get.
     */
    public function tambahLowongan(string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void {
        $this->model->addLowongan($posisi, $departemen, $tipeKerja, $kuota, $status);
        header("Location: index.php?modul=lowongan");
        exit();
    }

    /**
     * Meneruskan pembaruan lowongan ke model lalu redirect ke daftar lowongan.
     */
    public function ubahLowongan(int $id, string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void {
        $this->model->updateLowongan($id, $posisi, $departemen, $tipeKerja, $kuota, $status);
        header("Location: index.php?modul=lowongan");
        exit();
    }

    /**
     * Meneruskan penghapusan lowongan ke model lalu redirect ke daftar lowongan.
     */
    public function hapusLowongan(int $id): void {
        $this->model->deleteLowongan($id);
        header("Location: index.php?modul=lowongan");
        exit();
    }
}
?>
