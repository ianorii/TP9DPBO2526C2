<?php
/**
 * Entry point & front controller aplikasi MVP Rekrutmen (Kandidat & Lowongan).
 * Mengarahkan request GET/POST ke presenter modul yang sesuai.
 */
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/presenters/PresenterKandidat.php';
require_once __DIR__ . '/models/TabelLowongan.php';
require_once __DIR__ . '/views/ViewLowongan.php';
require_once __DIR__ . '/presenters/PresenterLowongan.php';

// Menentukan modul aktif dari parameter POST atau GET (default: kandidat)
$modul = $_POST['modul'] ?? ($_GET['modul'] ?? 'kandidat');

if ($modul === 'lowongan') {
    // Inisialisasi triad MVP untuk modul Lowongan
    $model = new TabelLowongan('localhost', 'mvp_kandidat_db', 'root', '');
    $view = new ViewLowongan();
    $presenter = new PresenterLowongan($model, $view);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Menangani aksi mutasi data (Create, Update, Delete)
        $action = $_POST['action'] ?? '';
        if ($action === 'tambah') {
            $presenter->tambahLowongan(
                trim($_POST['posisi'] ?? ''),
                trim($_POST['departemen'] ?? ''),
                trim($_POST['tipeKerja'] ?? 'Full-time'),
                (int)($_POST['kuota'] ?? 1),
                trim($_POST['status'] ?? 'Dibuka')
            );
        } elseif ($action === 'ubah') {
            $presenter->ubahLowongan(
                (int)($_POST['id'] ?? 0),
                trim($_POST['posisi'] ?? ''),
                trim($_POST['departemen'] ?? ''),
                trim($_POST['tipeKerja'] ?? 'Full-time'),
                (int)($_POST['kuota'] ?? 1),
                trim($_POST['status'] ?? 'Dibuka')
            );
        } elseif ($action === 'hapus') {
            $presenter->hapusLowongan((int)($_POST['id'] ?? 0));
        }
        // Fallback redirect jika action POST tidak dikenali
        header("Location: index.php?modul=lowongan");
        exit();
    } else {
        // Menangani tampilan layar GET (daftar, form tambah, atau form edit)
        $screen = $_GET['screen'] ?? 'list';
        if ($screen === 'add') {
            echo $presenter->tampilkanFormLowongan();
        } elseif ($screen === 'edit' && isset($_GET['id'])) {
            echo $presenter->tampilkanFormLowongan((int)$_GET['id']);
        } else {
            echo $presenter->tampilkanLowongan();
        }
    }
} else {
    // Inisialisasi triad MVP untuk modul Kandidat
    $model = new TabelKandidat('localhost', 'mvp_kandidat_db', 'root', '');
    $view = new ViewKandidat();
    $presenter = new PresenterKandidat($model, $view);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Menangani aksi mutasi data (Create, Update, Delete)
        $action = $_POST['action'] ?? '';
        if ($action === 'tambah') {
            $presenter->tambahKandidat(
                trim($_POST['nama'] ?? ''),
                trim($_POST['posisi'] ?? ''),
                trim($_POST['domisili'] ?? ''),
                (int)($_POST['skorTes'] ?? 0),
                (int)($_POST['pengalamanTahun'] ?? 0)
            );
        } elseif ($action === 'ubah') {
            $presenter->ubahKandidat(
                (int)($_POST['id'] ?? 0),
                trim($_POST['nama'] ?? ''),
                trim($_POST['posisi'] ?? ''),
                trim($_POST['domisili'] ?? ''),
                (int)($_POST['skorTes'] ?? 0),
                (int)($_POST['pengalamanTahun'] ?? 0)
            );
        } elseif ($action === 'hapus') {
            $presenter->hapusKandidat((int)($_POST['id'] ?? 0));
        }
        // Fallback redirect jika action POST tidak dikenali
        header("Location: index.php");
        exit();
    } else {
        // Menangani tampilan layar GET (daftar, form tambah, atau form edit)
        $screen = $_GET['screen'] ?? 'list';
        if ($screen === 'add') {
            echo $presenter->tampilkanFormKandidat();
        } elseif ($screen === 'edit' && isset($_GET['id'])) {
            echo $presenter->tampilkanFormKandidat((int)$_GET['id']);
        } else {
            echo $presenter->tampilkanKandidat();
        }
    }
}
?>
