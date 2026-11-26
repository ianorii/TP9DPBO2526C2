<?php
require_once __DIR__ . '/KontrakPresenter.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../views/KontrakView.php';

/**
 * Presenter konkret modul kandidat (penghubung KontrakModel dan KontrakView).
 */
class PresenterKandidat implements KontrakPresenter {
    private KontrakModel $model;
    private KontrakView $view;

    /**
     * Menyuntikkan dependensi model dan view melalui interface masing-masing.
     */
    public function __construct(KontrakModel $model, KontrakView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    /**
     * Helper untuk merakit 1 baris HTML tabel kandidat.
     * Panggil dari dalam tampilkanKandidat() saat melakukan foreach.
     */
    private function buildRowHtml(int $no, Kandidat $kandidat): string {
        $id = (int)$kandidat->getId();
        $nama = htmlspecialchars($kandidat->getNama());
        $posisi = htmlspecialchars($kandidat->getPosisi());
        $domisili = htmlspecialchars($kandidat->getDomisili());
        $skorTes = number_format($kandidat->getSkorTes()) . ' / 100';
        $pengalaman = number_format($kandidat->getPengalamanTahun()) . ' Tahun';

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$posisi}</td>
            <td>{$domisili}</td>
            <td>{$skorTes}</td>
            <td>{$pengalaman}</td>
            <td class='col-actions'>
                <a href='index.php?screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus kandidat ini?')\">
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    /**
     * Mengambil daftar kandidat dari model, merakit HTML baris, dan meneruskannya ke view.
     */
    public function tampilkanKandidat(): string {
        $listKandidat = $this->model->getAllKandidat();
        $totalKandidat = count($listKandidat);

        $rowsHtml = '';
        if (empty($listKandidat)) {
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data kandidat.</td></tr>';
        } else {
            $no = 1;
            foreach ($listKandidat as $kandidat) {
                $rowsHtml .= $this->buildRowHtml($no, $kandidat);
                $no++;
            }
        }

        return $this->view->renderDaftar($rowsHtml, $totalKandidat);
    }

    /**
     * Menampilkan form tambah atau edit kandidat; redirect ke daftar jika ID edit tidak ditemukan.
     */
    public function tampilkanFormKandidat(?int $id = null): string {
        if ($id !== null) {
            $kandidat = $this->model->getKandidatById($id);
            if ($kandidat === null) {
                header("Location: index.php");
                exit();
            }

            $formData = [
                'id'              => $kandidat->getId(),
                'nama'            => $kandidat->getNama(),
                'posisi'          => $kandidat->getPosisi(),
                'domisili'        => $kandidat->getDomisili(),
                'skorTes'         => $kandidat->getSkorTes(),
                'pengalamanTahun' => $kandidat->getPengalamanTahun(),
            ];
            return $this->view->renderForm("Ubah Data Kandidat", "ubah", $formData);
        }

        return $this->view->renderForm("Tambah Kandidat Baru", "tambah", []);
    }

    /**
     * Meneruskan penambahan kandidat ke model lalu menerapkan pola Post-Redirect-Get.
     */
    public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $this->model->addKandidat($nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
        header("Location: index.php");
        exit();
    }

    /**
     * Meneruskan pembaruan kandidat ke model lalu redirect ke halaman daftar.
     */
    public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $this->model->updateKandidat($id, $nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
        header("Location: index.php");
        exit();
    }

    /**
     * Meneruskan penghapusan kandidat ke model lalu redirect ke halaman daftar.
     */
    public function hapusKandidat(int $id): void {
        $this->model->deleteKandidat($id);
        header("Location: index.php");
        exit();
    }
}
?>
