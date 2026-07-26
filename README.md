# 🛠️ E-Calibration (Sistem Manajemen Kalibrasi Instrumen)
**PT Indonesia Asahan Aluminium (INALUM)**

Sistem **E-Calibration (PMN Work Schedule - Calibration Module)** adalah aplikasi web yang digunakan untuk mengelola inventaris instrumen pabrik, memantau masa berlaku kalibrasi, mencatat riwayat pelaksanaan pengujian, serta menyajikan visualisasi data analisis kinerja kalibrasi dalam bentuk dashboard interaktif.

---

## 📌 Fitur Utama Sistem

1. **📊 Dashboard Pemantauan Interaktif**:
   - **4 Stat Cards Overview**: Menampilkan indikator KPI (*Total Instrumen*, *Dikalibrasi*, *Jatuh Tempo bulan ini*, dan *Rusak*).
   - **Kurva Pelaksanaan Kalibrasi Tahunan**: Line chart perbandingan *Target* vs *Realisasi* kalibrasi per bulan dengan filter tahun.
   - **Grafik Kondisi Alat per Kategori**: Stacked column chart statistik kondisi fisik alat (`🟢 Baik`, `🔴 Rusak`, `🟡 Perbaikan`).
   - **Status Populasi & Breakdown**: Donut chart proporsi status kalibrasi (*Dikalibrasi*, *Akan Expired*, *Tidak Aktif*) & horizontal bar per kategori alat.

2. **⚙️ Pengelolaan Master Instrumen**:
   - Input spesifikasi teknis instrumen lengkap.
   - Modern Segmented Toggle untuk memperbarui kondisi fisik/operasional alat (`Baik`, `Rusak`, `Perbaikan`).
   - Unggah foto fisik instrumen pabrik.

3. **📜 Riwayat Kalibrasi & Dokumentasi PDF**:
   - Pencatatan riwayat pengujian instrumen kronologis.
   - **Kalkulasi Otomatis**: Menghitung `tanggal_berikutnya` secara otomatis berdasarkan periode kalibrasi.
   - Unggah & unduh dokumen digital sertifikat resmi (`.pdf`).
   - Kurva deviasi pengukuran pada halaman detail alat.

4. **🔎 Live Search & Filtering Data**:
   - Pencarian kata kunci real-time (DataTables Live Search).
   - Filter rentang tanggal kalibrasi & tombol reset filter.

5. **🔀 Modul Eksternal vs Internal**:
   - **Kalibrasi Eksternal**: Pengelolaan instrumen yang dikalibrasi oleh lembaga/badan penguji luar terakreditasi.
   - **Kalibrasi Internal**: Pengelolaan instrumen standar kerja yang dikalibrasi secara mandiri oleh tim internal/bengkel INALUM.

---

## 🗄️ Struktur Database

Database dirancang menggunakan **MySQL / MariaDB** dengan struktur terisolasi untuk modul Eksternal dan Internal:

- `master_instrumen` ➔ `riwayat_kalibrasi` (`1 : N`, Foreign Key: `nomor_identifikasi`, Constraint: `CASCADE`).
- `master_instrumen_internal` ➔ `riwayat_kalibrasi_internal` (`1 : N`, Foreign Key: `nomor_identifikasi`, Constraint: `CASCADE`).

*File DDL Schema database dapat diakses di: [`database/schema.sql`](database/schema.sql)*

---

## 🚀 Panduan Instalasi & Pengoperasian (Tim IT)

### 1. Prasyarat Sistem:
- **PHP**: v7.4 atau v8.x (Extension: `mysqli`, `gd`, `json`, `mbstring`).
- **Database**: MySQL v5.7+ / MariaDB v10.3+.
- **Web Server**: Apache / Nginx / PHP Built-in CLI Server.

### 2. Langkah Instalasi:
1. **Clone / Salin Repository**:
   ```bash
   git clone <repository_url> pmn-kalibrasi
   cd pmn-kalibrasi
   ```

2. **Import Database**:
   - Buat database baru bernama `pmn_kalibrasi` di MySQL/MariaDB.
   - Import schema dari file [`database/schema.sql`](database/schema.sql):
     ```bash
     mysql -u root -p pmn_kalibrasi < database/schema.sql
     ```

3. **Konfigurasi Environment (`.env`)**:
   - Salin file `.env.example` menjadi `.env`:
     ```bash
     cp .env.example .env
     ```
   - Buka file `.env` dan atur koneksi database Anda:
     ```env
     CI_ENV = development
     APP_BASE_URL = http://localhost:8080/

     DB_HOSTNAME = localhost
     DB_USERNAME = root
     DB_PASSWORD = 
     DB_DATABASE = pmn_kalibrasi
     DB_DRIVER   = mysqli
     ```

4. **Jalankan Aplikasi (PHP Built-in Server)**:
   ```bash
   php -S localhost:8080
   ```

5. **Akses Aplikasi di Browser**:
   - **Modul Eksternal**: `http://localhost:8080/kalibrasi`
   - **Modul Internal**: `http://localhost:8080/kalibrasi-internal`

---

## 📚 Berkas Dokumentasi Terkait

- 📄 **User Guide (Panduan Pengguna)**: [`user_guide.md`](user_guide.md)
- 📑 **Technical Blueprint & Business Process**: [`bpm_blueprint_teknis.md`](bpm_blueprint_teknis.md)
- 📊 **Workflow Level List (Inalum Standard Flowchart)**: [`bpm_workflow_level_list.md`](bpm_workflow_level_list.md)
- 🗃️ **Database DDL Schema**: [`database/schema.sql`](database/schema.sql)

---
*Pengembangan Modul E-Calibration - PT Indonesia Asahan Aluminium (INALUM)*
