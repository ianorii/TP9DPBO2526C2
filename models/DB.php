<?php
/**
 * Kelas dasar koneksi dan eksekusi query database menggunakan PDO.
 */
class DB {
    private string $host = "localhost";
    private string $db_name = "mvp_kandidat_db";
    private string $username = "root";
    private string $password = "";
    private ?PDO $conn = null;
    private ?PDOStatement $result = null;

    /**
     * Menginisialisasi konfigurasi koneksi dan langsung membuka koneksi PDO.
     */
    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->conn = $this->connect();
    }

    /**
     * Membuat instance PDO dengan mode error exception dan native prepared statements.
     */
    public function connect(): PDO {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            return new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new RuntimeException("Koneksi Database Gagal: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Menyiapkan dan mengeksekusi query SQL secara aman menggunakan prepared statement.
     */
    public function executeQuery(string $query, array $params = []): PDOStatement {
        if ($this->conn === null) {
            throw new RuntimeException("Tidak ada koneksi database aktif.");
        }
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            $this->result = $stmt;
            return $stmt;
        } catch (PDOException $e) {
            throw new RuntimeException("Query Gagal: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Mengambil seluruh baris hasil eksekusi query terakhir dalam bentuk array asosiatif.
     */
    public function getAllResult(): array {
        if ($this->result === null) {
            return [];
        }
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Menutup statement hasil dan memutus referensi koneksi database.
     */
    public function close(): void {
        $this->result = null;
        $this->conn = null;
    }
}
?>
