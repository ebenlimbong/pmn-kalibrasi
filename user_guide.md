# 📘 USER GUIDE
## Sistem Manajemen Kalibrasi Instrumen (E-Calibration)
**PT Indonesia Asahan Aluminium (INALUM)**

---

## 1. Pendahuluan & Cara Akses Sistem

Aplikasi **E-Calibration (Sistem PMN Work Schedule)** digunakan untuk pengelolaan inventaris master instrumen, pemantauan masa berlaku kalibrasi, serta pencatatan riwayat kalibrasi dan dokumen sertifikat digital.

### Langkah Akses Sistem:
1. Buka browser pada komputer atau perangkat Anda.
2. Akses alamat web E-Calibration (`http://localhost:8080/kalibrasi`).
3. Akan muncul halaman utama aplikasi seperti pada gambar di bawah ini:
   
   *[masukkan gambar halaman login / dashboard utama]*

---

## 2. Modul Pemantauan Dashboard (Eksternal & Internal)

Modul Dashboard pada instrumen **Eksternal** dan **Internal** memiliki struktur serta fungsi pemantauan yang seragam.

### Langkah Memantau Dashboard:
1. Pada navbar utama bagian atas, klik menu **Eksternal** atau **Internal**.
2. Pilih menu dropdown **Dashboard** untuk menampilkan ringkasan grafik dan statistik.
   
   *[masukkan gambar navigasi dropdown ke dashboard]*

3. Halaman Dashboard akan menampilkan indikator utama (Stat Cards) dan 4 jenis grafik:
   
   *[masukkan gambar tampilan dashboard eksternal dan internal]*

4. **Memahami 4 Stat Cards Overview**:
   - **Total Instrumen**: Menampilkan total seluruh unit instrumen terdaftar.
   - **Dikalibrasi**: Menampilkan jumlah instrumen dengan jadwal kalibrasi yang masih aktif.
   - **Jatuh Tempo bulan ini**: Menampilkan jumlah instrumen yang memasuki masa expired dalam 30 hari ke depan.
   - **Rusak**: Menampilkan jumlah instrumen dengan kondisi fisik/operasional rusak.
   
   *[masukkan gambar 4 stat cards overview]*

5. **Kurva Pelaksanaan Kalibrasi Tahunan**:
   - Pilih tahun pada dropdown pilihan tahun di pojok kanan atas grafik.
   - Grafik line chart akan membandingkan **Target Kalibrasi** (garis biru) dengan **Selesai Dikalibrasi** (garis hijau) per bulan.
   
   *[masukkan gambar kurva pelaksanaan kalibrasi tahunan]*

6. **Grafik Kondisi Alat per Kategori**:
   - Memantau kondisi fisik instrumen per kategori (Baik 🟢, Rusak 🔴, Perbaikan 🟡).
   
   *[masukkan gambar grafik kondisi alat per kategori]*

7. **Status Populasi & Breakdown Jenis Alat**:
   - **Status Populasi (Pie Chart)**: Memantau persentase status kalibrasi (*Dikalibrasi*, *Akan Expired*, *Tidak Aktif*).
   - **Breakdown Status per Jenis Alat**: Memantau rincian status kalibrasi untuk setiap jenis instrumen.
   
   *[masukkan gambar status populasi pie chart dan breakdown jenis alat]*

---

## 3. Modul Pengelolaan Data Master Instrumen (Eksternal & Internal)

Pengelolaan data master instrumen berlaku untuk modul **Eksternal** (lembaga penguji luar) maupun **Internal** (alat standar kerja bengkel).

### A. Langkah Mengakses Tabel Instrumen:
1. Klik menu dropdown **Eksternal** atau **Internal** pada navbar utama.
2. Pilih menu **Instrumen**.
3. Akan muncul daftar tabel data instrumen seperti pada gambar di bawah ini:
   
   *[masukkan gambar navigasi ke tabel instrumen]*

---

### B. Langkah Menambahkan Data Instrumen Baru:
1. Pada halaman tabel instrumen, tekan tombol **+ Tambah Data** di bagian kanan atas.
   
   *[masukkan gambar tombol tambah data]*

2. Akan muncul form pengisian data instrumen baru:
   
   *[masukkan gambar field tambah data]*

3. Silakan isi data instrumen secara lengkap:
   - **Nomor Identifikasi**: Masukkan nomor unik alat (wajib diisi).
   - **Nama Instrumen & Seksi Pemakai**: Masukkan nama alat dan seksi pemilik/pemakai.
   - **Kategori Alat**: Pilih kategori instrumen (contoh: *Pressure Gauge*, *RTD*, *Multimeter*).
   - **Spesifikasi**: Isi interval/kapasitas, ketelitian, model/tipe, pembuat, dan kegunaan.
   - **Periode Kalibrasi**: Isi jangka waktu kalibrasi dalam satuan tahun (contoh: `1` untuk 1 tahun).
   - **Kondisi Alat**: Pilih kondisi operasional alat menggunakan segmented toggle (`🟢 Baik`, `🔴 Rusak`, atau `🟡 Perbaikan`).
   - **Foto Alat**: Unggah foto fisik instrumen (*opsional*).
   - **Data Kalibrasi Pertama**: Isi tanggal kalibrasi, badan penguji, nomor sertifikat, dan upload sertifikat PDF jika alat sudah pernah dikalibrasi (*opsional*).
4. Setelah seluruh data terisi dengan benar, tekan tombol **Simpan Data**.
   
   *[masukkan gambar tombol simpan data]*

5. Sistem akan menyimpan data dan mengarahkan kembali ke tabel instrumen dengan pesan konfirmasi sukses.
   
   *[masukkan gambar konfirmasi sukses tambah data]*

---

### C. Langkah Mengedit Data Instrumen & Kondisi:
1. Pada tabel instrumen, cari alat yang ingin diubah.
2. Tekan ikon **Edit** (pensil biru) pada kolom **Aksi** di sebelah kanan.
   
   *[masukkan gambar tombol edit instrumen]*

3. Form edit akan terbuka dengan data aktual instrumen:
   
   *[masukkan gambar field edit data dan toggle kondisi]*

4. Silakan ubah data spesifikasi atau perbarui status kondisi alat (`Baik`, `Rusak`, `Perbaikan`).
5. Tekan tombol **Update Data** untuk menyimpan perubahan.
   
   *[masukkan gambar tombol update data]*

---

### D. Langkah Menghapus Data Instrumen:
1. Pada tabel instrumen, tekan ikon **Hapus** (tempat sampah merah) pada kolom **Aksi**.
   
   *[masukkan gambar tombol hapus instrumen]*

2. Akan muncul konfirmasi dialog hapus data. Tekan **OK / Ya** untuk melanjutkan.
   
   *[masukkan gambar dialog konfirmasi hapus]*

3. Data master instrumen beserta seluruh file terikat akan terhapus dari sistem.

---

## 4. Modul Pengelolaan Riwayat Kalibrasi & Sertifikat PDF

### A. Langkah Memantau Detail Alat & Grafik Deviasi:
1. Pada tabel instrumen, tekan ikon **Detail** (mata biru) pada kolom **Aksi**.
   
   *[masukkan gambar tombol detail instrumen]*

2. Halaman Detail Instrumen akan menampilkan profil fisik alat, foto, line chart kurva deviasi pengujian, serta tabel riwayat kalibrasi:
   
   *[masukkan gambar halaman detail instrumen dan grafik deviasi]*

---

### B. Langkah Menambahkan Riwayat Kalibrasi Baru & Upload PDF:
1. Pada halaman Detail Instrumen, tekan tombol **+ Tambah Kalibrasi**.
   
   *[masukkan gambar tombol tambah kalibrasi di detail]*

2. Akan muncul form penginputan riwayat kalibrasi baru:
   
   *[masukkan gambar field tambah riwayat kalibrasi dan upload pdf]*

3. Silakan isi data kalibrasi:
   - **Tanggal Pelaksanaan Kalibrasi**: Pilih tanggal kalibrasi terbaru dilakukan.
   - **Badan Kalibrasi**: Isi nama lembaga pengkalibrasi (khusus eksternal).
   - **Nomor Sertifikat**: Isi nomor sertifikat resmi hasil kalibrasi.
   - **Deviasi Aktual**: Masukkan angka nilai deviasi hasil pengukuran.
   - **Upload File Sertifikat**: Pilih file sertifikat digital (format `.pdf`).
4. Tekan tombol **Simpan Riwayat**.
   
   *[masukkan gambar tombol simpan riwayat]*

5. Sistem akan menyimpan riwayat, menghitung **Tanggal Kalibrasi Berikutnya** secara otomatis, dan memperbarui status keaktifan alat.

---

### C. Langkah Menghapus Catatan Riwayat Kalibrasi:
1. Pada halaman Detail Instrumen, lihat tabel **Riwayat Kalibrasi**.
2. Tekan tombol **Hapus** pada baris catatan riwayat yang ingin dihapus.
   
   *[masukkan gambar tombol hapus riwayat kalibrasi]*

3. File sertifikat PDF akan terhapus dan sistem me-rekalkulasi jadwal kalibrasi terbaru.

---

## 5. Modul Live Search & Filtering Data

### Langkah Menggunakan Fitur Search & Filter Tanggal:
1. Buka halaman **Tabel Instrumen** (Eksternal atau Internal).
2. **Pencarian Live Search**:
   - Ketik kata kunci (nama alat, nomor identifikasi, seksi, kategori, dll.) pada kolom **Cari...**.
   - Tabel akan menyaring dan menampilkan data secara instan.
   
   *[masukkan gambar field pencarian live search]*

3. **Filtering Tanggal Kalibrasi**:
   - Pilih tanggal pada input **Date Filter**.
   - Tabel akan menampilkan instrumen yang dikalibrasi pada tanggal tersebut.
   
   *[masukkan gambar field filter tanggal]*

4. **Reset Filter**:
   - Tekan tombol **Clear Filter** untuk mengembalikan pencarian dan penyaringan data ke kondisi awal.
   
   *[masukkan gambar tombol clear filter]*

---
*Dokumen User Guide ini disusun untuk mendukung operasional sistem E-Calibration PT Indonesia Asahan Aluminium (INALUM).*
