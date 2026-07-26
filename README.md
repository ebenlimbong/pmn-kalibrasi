# E-Calibration (Sistem Manajemen Kalibrasi Instrumen)
**PT Indonesia Asahan Aluminium (INALUM)**

Sistem **E-Calibration (PMN Work Schedule - Calibration Module)** adalah aplikasi berbasis web yang digunakan untuk mengelola inventaris instrumen pabrik, memantau masa berlaku kalibrasi, mencatat riwayat pelaksanaan pengujian, serta menyajikan visualisasi data analisis kinerja kalibrasi dalam bentuk dashboard interaktif.

---

## Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan kombinasi teknologi web modern berikut:

- **Backend Framework**: CodeIgniter 3 (PHP 7.4 / PHP 8.x)
- **Database Management System**: MySQL / MariaDB (Driver `mysqli`)
- **Frontend & Styling**: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5
- **Icon Set**: Bootstrap Icons
- **Visualisasi Grafik & Chart**: ApexCharts.js & Chart.js (Line Chart, Donut/Pie Chart, Stacked Column Chart, Horizontal Bar Chart)
- **Tabel Data Interaktif**: jQuery DataTables (Real-time Live Search, Pagination, Dynamic Page Length)
- **Integrasi QR Code**: Endroid QR Code / PHP GD Library (Penjanaan Kode QR Instrumen)

---

## Fitur Utama Sistem

1. **Dashboard Pemantauan Interaktif**:
   - **4 Stat Cards Overview**: Menampilkan indikator KPI utama (*Total Instrumen*, *Dikalibrasi*, *Jatuh Tempo bulan ini*, dan *Rusak*).
   - **Kurva Pelaksanaan Kalibrasi Tahunan**: Line chart perbandingan *Target* vs *Realisasi* kalibrasi per bulan dengan filter tahun.
   - **Grafik Kondisi Alat per Kategori**: Stacked column chart statistik kondisi fisik alat (Baik, Rusak, Perbaikan).
   - **Status Populasi & Breakdown**: Donut chart proporsi status kalibrasi (*Dikalibrasi*, *Akan Expired*, *Tidak Aktif*) & horizontal bar per kategori alat.

2. **Pengelolaan Master Instrumen**:
   - Input spesifikasi teknis instrumen secara lengkap.
   - Segmented Toggle untuk memperbarui kondisi fisik/operasional alat (Baik, Rusak, Perbaikan).
   - Unggah foto fisik instrumen pabrik.

3. **Riwayat Kalibrasi & Dokumentasi PDF**:
   - Pencatatan riwayat pengujian instrumen secara kronologis.
   - **Kalkulasi Otomatis**: Menghitung tanggal kalibrasi berikutnya secara otomatis berdasarkan periode kalibrasi.
   - Unggah dan unduh dokumen digital sertifikat resmi (format PDF).
   - Kurva deviasi pengukuran pada halaman detail alat.

4. **Live Search & Filtering Data**:
   - Pencarian kata kunci real-time (DataTables Live Search).
   - Filter rentang tanggal kalibrasi dan tombol reset filter.

5. **Modul Eksternal vs Internal**:
   - **Kalibrasi Eksternal**: Pengelolaan instrumen yang dikalibrasi oleh lembaga/badan penguji luar terakreditasi.
   - **Kalibrasi Internal**: Pengelolaan instrumen standar kerja yang dikalibrasi secara mandiri oleh tim internal/bengkel INALUM.

---

## Struktur Database

Database menggunakan MySQL / MariaDB dengan struktur terisolasi untuk modul Eksternal dan Internal:

- `master_instrumen` -> `riwayat_kalibrasi` (Relasi 1 to N, Foreign Key `nomor_identifikasi`, Constraint `CASCADE`).
- `master_instrumen_internal` -> `riwayat_kalibrasi_internal` (Relasi 1 to N, Foreign Key `nomor_identifikasi`, Constraint `CASCADE`).

---
*Pengembangan Modul E-Calibration - PT Indonesia Asahan Aluminium (INALUM)*
