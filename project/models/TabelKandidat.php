<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModel.php';
require_once __DIR__ . '/Kandidat.php';

/**
 * Model konkret untuk mengelola tabel `kandidat` di database.
 */
class TabelKandidat extends DB implements KontrakModel {

    /**
     * Membuka koneksi database melalui konstruktor kelas induk DB.
     */
    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    /**
     * Memetakan satu baris hasil query (array asosiatif) menjadi objek Kandidat.
     */
    private function mapRowToKandidat(array $row): Kandidat {
        return new Kandidat(
            (int)$row['id'],
            $row['nama'],
            $row['posisi'],
            $row['domisili'],
            (int)$row['skorTes'],
            (int)$row['pengalamanTahun']
        );
    }

    /**
     * Mengambil seluruh kandidat, diurutkan dari skor tes tertinggi lalu ID terkecil.
     * @return Kandidat[]
     */
    public function getAllKandidat(): array {
        $query = "SELECT * FROM kandidat ORDER BY skorTes DESC, id ASC";
        $this->executeQuery($query);
        $rows = $this->getAllResult();

        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->mapRowToKandidat($row);
        }
        return $list;
    }

    /**
     * Mengambil satu kandidat berdasarkan ID, atau null jika tidak ditemukan.
     */
    public function getKandidatById(int $id): ?Kandidat {
        $query = "SELECT * FROM kandidat WHERE id = :id LIMIT 1";
        $this->executeQuery($query, [':id' => $id]);
        $rows = $this->getAllResult();
        if (empty($rows)) {
            return null;
        }
        return $this->mapRowToKandidat($rows[0]);
    }

    /**
     * Menyimpan kandidat baru ke tabel `kandidat` dengan prepared statement.
     */
    public function addKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $query = "INSERT INTO kandidat (nama, posisi, domisili, skorTes, pengalamanTahun) VALUES (:nama, :posisi, :domisili, :skor_tes, :pengalaman_tahun)";
        $this->executeQuery($query, [
            ':nama' => $nama,
            ':posisi' => $posisi,
            ':domisili' => $domisili,
            ':skor_tes' => $skorTes,
            ':pengalaman_tahun' => $pengalamanTahun
        ]);
    }

    /**
     * Memperbarui seluruh kolom kandidat berdasarkan ID dengan prepared statement.
     */
    public function updateKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $query = "UPDATE kandidat SET nama = :nama, posisi = :posisi, domisili = :domisili, skorTes = :skor_tes, pengalamanTahun = :pengalaman_tahun WHERE id = :id";
        $this->executeQuery($query, [
            ':nama' => $nama,
            ':posisi' => $posisi,
            ':domisili' => $domisili,
            ':skor_tes' => $skorTes,
            ':pengalaman_tahun' => $pengalamanTahun,
            ':id' => $id
        ]);
    }

    /**
     * Menghapus satu kandidat berdasarkan ID dengan prepared statement.
     */
    public function deleteKandidat(int $id): void {
        $query = "DELETE FROM kandidat WHERE id = :id";
        $this->executeQuery($query, [':id' => $id]);
    }
}
?>
