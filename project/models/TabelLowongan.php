<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModelLowongan.php';
require_once __DIR__ . '/Lowongan.php';

/**
 * Model konkret untuk mengelola tabel `lowongan` di database.
 */
class TabelLowongan extends DB implements KontrakModelLowongan {

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
     * Memetakan satu baris hasil query (array asosiatif) menjadi objek Lowongan.
     */
    private function mapRowToLowongan(array $row): Lowongan {
        return new Lowongan(
            (int)$row['id'],
            $row['posisi'],
            $row['departemen'],
            $row['tipeKerja'],
            (int)$row['kuota'],
            $row['status']
        );
    }

    /**
     * Mengambil seluruh lowongan, memprioritaskan status 'Dibuka' lalu urutan ID.
     * @return Lowongan[]
     */
    public function getAllLowongan(): array {
        $query = "SELECT * FROM lowongan ORDER BY status ASC, id ASC";
        $this->executeQuery($query);
        $rows = $this->getAllResult();

        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->mapRowToLowongan($row);
        }
        return $list;
    }

    /**
     * Mengambil satu lowongan berdasarkan ID, atau null jika tidak ditemukan.
     */
    public function getLowonganById(int $id): ?Lowongan {
        $query = "SELECT * FROM lowongan WHERE id = :id LIMIT 1";
        $this->executeQuery($query, [':id' => $id]);
        $rows = $this->getAllResult();
        if (empty($rows)) {
            return null;
        }
        return $this->mapRowToLowongan($rows[0]);
    }

    /**
     * Menyimpan lowongan baru ke tabel `lowongan` dengan prepared statement.
     */
    public function addLowongan(string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void {
        $query = "INSERT INTO lowongan (posisi, departemen, tipeKerja, kuota, status) VALUES (:posisi, :departemen, :tipeKerja, :kuota, :status)";
        $this->executeQuery($query, [
            ':posisi' => $posisi,
            ':departemen' => $departemen,
            ':tipeKerja' => $tipeKerja,
            ':kuota' => $kuota,
            ':status' => $status
        ]);
    }

    /**
     * Memperbarui seluruh kolom lowongan berdasarkan ID dengan prepared statement.
     */
    public function updateLowongan(int $id, string $posisi, string $departemen, string $tipeKerja, int $kuota, string $status): void {
        $query = "UPDATE lowongan SET posisi = :posisi, departemen = :departemen, tipeKerja = :tipeKerja, kuota = :kuota, status = :status WHERE id = :id";
        $this->executeQuery($query, [
            ':posisi' => $posisi,
            ':departemen' => $departemen,
            ':tipeKerja' => $tipeKerja,
            ':kuota' => $kuota,
            ':status' => $status,
            ':id' => $id
        ]);
    }

    /**
     * Menghapus satu lowongan berdasarkan ID dengan prepared statement.
     */
    public function deleteLowongan(int $id): void {
        $query = "DELETE FROM lowongan WHERE id = :id";
        $this->executeQuery($query, [':id' => $id]);
    }
}
?>
