# Janji
Saya Muhammad Rian Anugrah dengan NIM 2507241 mengerjakan Tugas Praktikum 9 pada Mata Kuliah Desain dan Pemrograman Berorientasi Objek (DPBO) untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

# Proyek MVP - Manajemen Data Rekrutmen HR

Proyek ini adalah implementasi aplikasi web berbasis PHP Native yang menggunakan arsitektur **Model-View-Presenter (MVP)** edisi **Strict Passive View (*Dumb View*)**. Proyek ini mengelola data rekrutmen HR yang mencakup data **Kandidat Karyawan** dan data **Lowongan Pekerjaan**.

## Setup Awal

1. Import `mvp_db.sql` ke MySQL / phpMyAdmin untuk membuat database `mvp_kandidat_db` beserta tabel `kandidat` dan `lowongan`.
2. Pastikan folder proyek berada di `htdocs/` (XAMPP / LAMPP), lalu buka `http://localhost/TP9DPBO2526C2/index.php`.

## Arsitektur Program (MVP)

Program ini memisahkan logika aplikasi menjadi tiga komponen utama yang berkomunikasi melalui **interface (contract)** untuk menjaga kode tetap rapi, terstruktur, dan mudah dikembangkan (*Separation of Concerns*).

1.  **Model (`models/`)**:
    * Bertanggung jawab mengelola data, memetakan baris query menjadi objek Entity (`Kandidat.php`, `Lowongan.php`), dan berinteraksi langsung dengan database MySQL menggunakan *prepared statements* PDO (`DB.php`).
    * Mengimplementasikan interface `KontrakModel` dan `KontrakModelLowongan`.
    * Implementasi: `TabelKandidat.php` dan `TabelLowongan.php`.

2.  **View (`views/`)**:
    * Bertanggung jawab menampilkan antarmuka pengguna (HTML) kepada user melalui pengisian token placeholder pada file template.
    * Menerapkan prinsip **Strict Passive View (*Dumb View*)**: View **tidak boleh** mengakses Model/Entity atau Database secara langsung, tidak melakukan `foreach`, dan tidak menghitung `count()`.
    * Mengimplementasikan interface `KontrakView`.
    * Implementasi: `ViewKandidat.php` dan `ViewLowongan.php`.

3.  **Presenter (`presenters/`)**:
    * Bertindak sebagai perantara (jembatan) antara View dan Model.
    * Meminta data dari Model, menghitung total data, merakit baris HTML tabel (`buildRowHtml()`), menyiapkan data *prefill* form edit, serta meneruskan aksi CRUD ke Model dan melakukan redirect.
    * Mengimplementasikan interface `KontrakPresenter` dan `KontrakPresenterLowongan`.
    * Implementasi: `PresenterKandidat.php` dan `PresenterLowongan.php`.

### Desain Database

Database `mvp_kandidat_db` memiliki dua tabel standalone:
* **`kandidat`**: `id`, `nama`, `posisi`, `domisili`, `skorTes`, `pengalamanTahun`.
* **`lowongan`**: `id`, `posisi`, `departemen`, `tipeKerja`, `kuota`, `status`.

### Alur Program

1.  **Request**: User membuka `index.php` (atau berpindah melalui tab navigasi **Kandidat** / **Lowongan**).
2.  **Routing**: `index.php` mengecek parameter `modul` dari `$_POST['modul']` atau `$_GET['modul']` (`kandidat` sebagai default, atau `lowongan`).
3.  **Inisialisasi**: `index.php` membuat objek Model, View, dan Presenter yang sesuai.
4.  **Proses**:
    * **Request `GET` (Read & Form)**:
        * `index.php` membaca parameter `screen` (`list`, `add`, atau `edit` dengan `id`).
        * Pada layar daftar (`list`): Presenter meminta data ke Model (`getAllKandidat()` / `getAllLowongan()`), Model melakukan query ke Database dan mengembalikan array objek Entity, lalu Presenter merakit baris `<tr>...</tr>` HTML serta menghitung total data dan menyerahkannya ke View (`renderDaftar()`).
        * Pada layar form (`add` / `edit`): Presenter memanggil `renderForm()` dengan data kosong untuk tambah, atau data hasil `getKandidatById($id)` / `getLowonganById($id)` untuk *prefill* form edit.
    * **Request `POST` (Create, Update, Delete — *Post-Redirect-Get*)**:
        * `index.php` membaca `$_POST['action']` (`tambah`, `ubah`, atau `hapus`) dan memanggil method Presenter terkait (`tambah...`, `ubah...`, `hapus...`).
        * Presenter meneruskan operasi ke Model (`add...`, `update...`, `delete...`) yang mengeksekusi query menggunakan PDO *prepared statement*.
        * Presenter melakukan redirect (`header("Location: ...")` dan `exit()`) kembali ke halaman daftar agar mencegah *resubmit* saat refresh.
5.  **Response**: View merender HTML menggunakan template (`skin.html`, `form.html`, `skin_lowongan.html`, atau `form_lowongan.html`) dan menampilkannya ke user.

## Struktur Folder

```text
TP9DPBO2526C2/
├── models/
│   ├── DB.php
│   ├── Kandidat.php
│   ├── KontrakModel.php
│   ├── KontrakModelLowongan.php
│   ├── Lowongan.php
│   ├── TabelKandidat.php
│   └── TabelLowongan.php
│
├── views/
│   ├── KontrakView.php
│   ├── ViewKandidat.php
│   └── ViewLowongan.php
│
├── presenters/
│   ├── KontrakPresenter.php
│   ├── KontrakPresenterLowongan.php
│   ├── PresenterKandidat.php
│   └── PresenterLowongan.php
│
├── template/
│   ├── form.html
│   ├── form_lowongan.html
│   ├── skin.html
│   └── skin_lowongan.html
│
├── index.php
├── mvp_db.sql
└── README.md
```

## Fitur CRUD

Aplikasi ini memiliki fitur CRUD lengkap untuk dua entitas:

1.  **Kandidat**:
      * Create: Form tambah kandidat (`Nama`, `Posisi Dilamar`, `Domisili`, `Skor Tes`, `Pengalaman Kerja`).
      * Read: Tabel daftar kandidat beserta total data.
      * Update: Form edit data kandidat (*prefill*).
      * Delete: Tombol hapus kandidat dengan konfirmasi.
2.  **Lowongan**:
      * Create: Form tambah lowongan (`Posisi`, `Departemen`, `Tipe Kerja`, `Kuota`, `Status`).
      * Read: Tabel daftar lowongan beserta badge status dan total data.
      * Update: Form edit lowongan (*prefill* input dan dropdown).
      * Delete: Tombol hapus lowongan dengan konfirmasi.

## Dokumentasi

