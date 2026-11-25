-- ============================================================================
-- Skema & Data Awal Database: mvp_kandidat_db
-- Digunakan oleh aplikasi MVP Rekrutmen (Modul Kandidat & Lowongan)
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `mvp_kandidat_db`;
USE `mvp_kandidat_db`;

-- Tabel kandidat: menyimpan profil pelamar kerja beserta skor tes dan pengalaman
CREATE TABLE IF NOT EXISTS `kandidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `domisili` varchar(100) NOT NULL,
  `skorTes` int(11) NOT NULL DEFAULT 0,
  `pengalamanTahun` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal sampel tabel kandidat
INSERT INTO `kandidat` (`id`, `nama`, `posisi`, `domisili`, `skorTes`, `pengalamanTahun`) VALUES
(1, 'Raka Pratama', 'Backend Developer', 'Bandung', 92, 3),
(2, 'Sinta Maharani', 'UI/UX Designer', 'Jakarta', 88, 2),
(3, 'Dimas Nugroho', 'Data Analyst', 'Yogyakarta', 85, 1),
(4, 'Nadia Kusuma', 'Frontend Developer', 'Surabaya', 90, 2),
(5, 'Bagas Setiawan', 'QA Engineer', 'Bandung', 81, 1);

-- Tabel lowongan: menyimpan daftar lowongan pekerjaan yang tersedia pada perusahaan
CREATE TABLE IF NOT EXISTS `lowongan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posisi` varchar(100) NOT NULL,
  `departemen` varchar(100) NOT NULL,
  `tipeKerja` varchar(50) NOT NULL,
  `kuota` int(11) NOT NULL DEFAULT 1,
  `status` varchar(30) NOT NULL DEFAULT 'Dibuka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal sampel tabel lowongan
INSERT INTO `lowongan` (`id`, `posisi`, `departemen`, `tipeKerja`, `kuota`, `status`) VALUES
(1, 'Backend Developer', 'Engineering', 'Full-time', 2, 'Dibuka'),
(2, 'UI/UX Designer', 'Product & Design', 'Full-time', 1, 'Dibuka'),
(3, 'Data Analyst', 'Data & Analytics', 'Contract', 1, 'Dibuka'),
(4, 'Frontend Developer Intern', 'Engineering', 'Internship', 3, 'Dibuka'),
(5, 'QA Engineer', 'Quality Assurance', 'Part-time', 1, 'Ditutup');
