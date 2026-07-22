-- Seed Data for Smart Calibration Web Module (E-Calibration)

INSERT INTO `master_instrumen` (`nomor_identifikasi`, `nama_instrumen`, `seksi_pemakai`, `interval_kapasitas`, `ketelitian`, `model_tipe`, `pembuat`, `kegunaan`, `periode_kalibrasi`, `batas_penerimaan`, `keterangan`, `created_at`, `updated_at`) VALUES
('INS-001', 'Digital Caliper', 'QC Lab', '0-150 mm', '0.01 mm', 'CD-6"CS', 'Mitutoyo', 'Pengukuran dimensi luar dan dalam', 12, '0.05 mm', 'Instrumen utama QC', NOW(), NOW()),
('INS-002', 'Pressure Gauge', 'Maintenance', '0-100 psi', '1 psi', '232.50', 'Wika', 'Monitoring tekanan pipa air', 6, '2 psi', 'Kalibrasi rutin 6 bulanan', NOW(), NOW());

INSERT INTO `riwayat_kalibrasi` (`nomor_identifikasi`, `tanggal_terakhir`, `tanggal_berikutnya`, `badan_kalibrasi`, `nomor_sertifikat`, `deviasi_aktual`, `batas_penerimaan`, `keterangan`, `file_sertifikat`, `status`, `created_at`, `updated_at`) VALUES
('INS-001', DATE_SUB(CURDATE(), INTERVAL 11 MONTH), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), 'PT Kalibrasi Indonesia', 'CERT-2025-001', 0.0200, '0.05 mm', 'Hasil sesuai toleransi', 'cert_ins001.pdf', 'Aktif', NOW(), NOW()),
('INS-002', DATE_SUB(CURDATE(), INTERVAL 6 MONTH), CURDATE(), 'Balai Metrologi', 'CERT-2025-002', 1.5000, '2 psi', 'Jatuh tempo kalibrasi hari ini', 'cert_ins002.pdf', 'Aktif', NOW(), NOW());

INSERT INTO `master_instrumen_internal` (`nomor_identifikasi`, `nama_instrumen`, `seksi_pemakai`, `interval_kapasitas`, `ketelitian`, `model_tipe`, `pembuat`, `kegunaan`, `periode_kalibrasi`, `batas_penerimaan`, `keterangan`, `created_at`, `updated_at`) VALUES
('INS-INT-001', 'Micrometer Screw', 'Bengkel', '0-25 mm', '0.001 mm', '103-137', 'Mitutoyo', 'Pengecekan ketebalan plat', 6, '0.003 mm', 'Kalibrasi internal bengkel', NOW(), NOW());

INSERT INTO `riwayat_kalibrasi_internal` (`nomor_identifikasi`, `tanggal_terakhir`, `tanggal_berikutnya`, `batas_penerimaan`, `keterangan`, `file_sertifikat`, `status`, `created_at`, `updated_at`) VALUES
('INS-INT-001', DATE_SUB(CURDATE(), INTERVAL 5 MONTH), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), '0.003 mm', 'Verifikasi internal OK', 'cert_int_001.pdf', 'Aktif', NOW(), NOW());
