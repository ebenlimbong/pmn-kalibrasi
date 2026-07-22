-- Schema Database Smart Calibration Web Module (E-Calibration)
-- MySQL / MariaDB

CREATE TABLE IF NOT EXISTS `master_instrumen` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nomor_identifikasi` VARCHAR(100) NOT NULL UNIQUE,
  `nama_instrumen` VARCHAR(255) NOT NULL,
  `seksi_pemakai` VARCHAR(100) DEFAULT NULL,
  `interval_kapasitas` VARCHAR(100) DEFAULT NULL,
  `ketelitian` VARCHAR(100) DEFAULT NULL,
  `model_tipe` VARCHAR(100) DEFAULT NULL,
  `pembuat` VARCHAR(255) DEFAULT NULL,
  `kegunaan` VARCHAR(255) DEFAULT NULL,
  `periode_kalibrasi` INT(11) DEFAULT NULL,
  `batas_penerimaan` VARCHAR(100) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  `foto_alat` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `riwayat_kalibrasi` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nomor_identifikasi` VARCHAR(100) NOT NULL,
  `tanggal_terakhir` DATE DEFAULT NULL,
  `tanggal_berikutnya` DATE DEFAULT NULL,
  `badan_kalibrasi` VARCHAR(255) DEFAULT NULL,
  `nomor_sertifikat` VARCHAR(100) DEFAULT NULL,
  `deviasi_aktual` DECIMAL(10,4) DEFAULT NULL,
  `batas_penerimaan` VARCHAR(100) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  `file_sertifikat` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Aktif',
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  CONSTRAINT `fk_riwayat_master` FOREIGN KEY (`nomor_identifikasi`) REFERENCES `master_instrumen` (`nomor_identifikasi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `master_instrumen_internal` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nomor_identifikasi` VARCHAR(100) NOT NULL UNIQUE,
  `nama_instrumen` VARCHAR(255) NOT NULL,
  `seksi_pemakai` VARCHAR(100) DEFAULT NULL,
  `interval_kapasitas` VARCHAR(100) DEFAULT NULL,
  `ketelitian` VARCHAR(100) DEFAULT NULL,
  `model_tipe` VARCHAR(100) DEFAULT NULL,
  `pembuat` VARCHAR(255) DEFAULT NULL,
  `kegunaan` VARCHAR(255) DEFAULT NULL,
  `periode_kalibrasi` INT(11) DEFAULT NULL,
  `batas_penerimaan` VARCHAR(100) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  `foto_alat` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `riwayat_kalibrasi_internal` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nomor_identifikasi` VARCHAR(100) NOT NULL,
  `tanggal_terakhir` DATE DEFAULT NULL,
  `tanggal_berikutnya` DATE DEFAULT NULL,
  `batas_penerimaan` VARCHAR(100) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  `file_sertifikat` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Aktif',
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  CONSTRAINT `fk_riwayat_internal_master` FOREIGN KEY (`nomor_identifikasi`) REFERENCES `master_instrumen_internal` (`nomor_identifikasi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
