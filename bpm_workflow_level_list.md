# 📑 BluePrint Teknis: Detail Alur Proses Bisnis (BPM Level List)
**Sistem PMN (Work Schedule) - E-Calibration**
*PT Indonesia Asahan Aluminium (INALUM)*

---

## 📌 Daftar Hirarki Alur Proses Bisnis (9 Level Workflows)

Berikut adalah 9 alur proses bisnis bertingkat yang disusun sesuai format **Inalum Technical Blueprint** dengan diagram alir horizontal (`flowchart LR`) serta rincian tabel proses & deskripsi.

---

### 🔹 Level 1: Manajemen Navigasi & Pemantauan Dashboard

#### 3.1 Alur Navigasi Switch Mode (Eksternal vs Internal)

```mermaid
flowchart LR
    A([Mulai]) --> B[Pilih Modul Eksternal / Internal]
    B --> C[Pilih View Mode: Dashboard / Instrumen]
    C --> D[Validasi Param Tab]
    D --> E[Tampilkan View Aktif]
    E --> F([Selesai])
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Navigasi Switch Mode | - User memilih modul **Eksternal** atau **Internal** dari navbar utama<br>- User memilih opsi tampilan **Dashboard** atau **Instrumen**<br>- Sistem memvalidasi parameter tampilan pada URL<br>- Sistem menampilkan view aktif secara dinamis<br>- Selesai |

---

#### 3.2 Alur Pemantauan Dashboard (Eksternal & Internal)

```mermaid
flowchart LR
    A([Mulai]) --> B[Pilih Menu Dashboard]
    B --> C[Hitung Stat Cards & Ringkasan KPI]
    C --> D[Render 4 Grafik Utama Kalibrasi]
    D --> E([Selesai])
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Pemantauan Dashboard | - User mengakses menu Dashboard (Eksternal / Internal)<br>- Sistem menghitung 4 Stat Cards Overview (Total, Dikalibrasi, Jatuh Tempo, Rusak)<br>- Sistem merender Kurva Pelaksanaan Tahunan & Grafik Kondisi per Kategori<br>- Sistem merender Pie Chart Populasi & Breakdown Jenis Alat<br>- Selesai |

---

### 🔹 Level 2: Pengelolaan Master Instrumen & Kondisi Alat

#### 3.3 Alur Tambah Data Master Instrumen Baru

```mermaid
flowchart LR
    A([Mulai]) --> B[Menu Tabel Instrumen] --> C[Klik Tambah Data] --> D[Input Data Master & Kondisi] --> E[Validasi Data] --> F[Submit] --> G([Selesai])
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Tambah Master Instrumen | - User memilih menu Tabel Instrumen<br>- User menekan tombol **+ Tambah Data**<br>- User menginput spesifikasi instrumen, memilih kondisi alat, dan upload foto<br>- User melakukan validasi atas data yang diinputkan<br>- User menekan tombol **Submit** untuk menyimpan data<br>- Selesai |

---

#### 3.4 Alur Edit Data Master & Perubahan Kondisi Alat

```mermaid
flowchart LR
    A([Mulai]) --> B[Menu Tabel Instrumen] --> C[Pilih Alat & Klik Edit] --> D[Ubah Spesifikasi / Kondisi] --> E[Validasi Data] --> F[Submit] --> G([Selesai])
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Edit Master Instrumen | - User memilih menu Tabel Instrumen<br>- User memilih alat dan menekan ikon **Edit**<br>- User mengubah data spesifikasi atau memperbarui kondisi alat<br>- User melakukan validasi atas data yang diubah<br>- User menekan tombol **Submit** untuk menyimpan perubahan<br>- Selesai |

---

#### 3.5 Alur Hapus Data Master Instrumen

```mermaid
flowchart LR
    A([Mulai]) --> B[Menu Tabel Instrumen] --> C[Klik Hapus] --> D{Konfirmasi?} -->|Ya| E[Hapus File & Database] --> F([Selesai])
    D -->|Tidak| F
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Hapus Master Instrumen | - User memilih menu Tabel Instrumen<br>- User menekan ikon **Hapus** pada baris instrumen<br>- User mengonfirmasi dialog hapus data<br>- Sistem menghapus file fisik foto/pdf dan record database master<br>- Selesai |

---

### 🔹 Level 3: Pengelolaan Riwayat Kalibrasi & Sertifikat PDF

#### 3.6 Alur Pemantauan Halaman Detail & Grafik Deviasi Alat

```mermaid
flowchart LR
    A([Mulai]) --> B[Menu Tabel Instrumen] --> C[Klik Detail] --> D[Tampilkan Profil & Grafik Deviasi] --> E([Selesai])
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Halaman Detail | - User memilih menu Tabel Instrumen<br>- User menekan ikon **Detail** (mata) pada instrumen<br>- Sistem menampilkan profil alat, foto fisik, dan line chart kurva deviasi<br>- Sistem menampilkan tabel riwayat kalibrasi terurut kronologis<br>- Selesai |

---

#### 3.7 Alur Input Riwayat Kalibrasi Baru & Upload Sertifikat PDF

```mermaid
flowchart LR
    A([Mulai]) --> B[Halaman Detail] --> C[Klik Tambah Kalibrasi] --> D[Input Tanggal, Deviasi & Upload PDF] --> E[Validasi Data] --> F[Submit] --> G([Selesai])
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Input Riwayat Kalibrasi | - User membuka Halaman Detail instrumen<br>- User menekan tombol **+ Tambah Kalibrasi**<br>- User menginput tanggal kalibrasi, deviasi, dan mengunggah sertifikat PDF<br>- Sistem menghitung tanggal berikutnya secara otomatis<br>- User menekan tombol **Submit** untuk menyimpan riwayat<br>- Selesai |

---

#### 3.8 Alur Hapus Riwayat Kalibrasi Alat

```mermaid
flowchart LR
    A([Mulai]) --> B[Halaman Detail] --> C[Klik Hapus Riwayat] --> D{Konfirmasi?} -->|Ya| E[Hapus File PDF & Recalculate Master] --> F([Selesai])
    D -->|Tidak| F
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Hapus Riwayat Kalibrasi | - User membuka Halaman Detail instrumen<br>- User menekan tombol **Hapus** pada baris riwayat kalibrasi<br>- User mengonfirmasi dialog hapus riwayat<br>- Sistem menghapus file PDF dan menghitung ulang tanggal berikutnya master alat<br>- Selesai |

---

### 🔹 Level 4: Filtering Data & Fitur Operasional

#### 3.9 Alur Pencarian Live & Filtering Tanggal Kalibrasi

```mermaid
flowchart LR
    A([Mulai]) --> B[Menu Tabel Instrumen] --> C[Input Keyword / Pilih Tanggal Filter] --> D[DataTables Live Filtering] --> E([Selesai])
```

| Proses | Deskripsi |
| :--- | :--- |
| **User** | |
| Live Search & Filter | - User memilih menu Tabel Instrumen<br>- User memasukkan kata kunci pada kolom **Cari...** atau memilih tanggal filter<br>- Sistem menyaring dan menampilkan data instrumen secara real-time<br>- User dapat menekan tombol **Clear Filter** untuk me-reset tampilan<br>- Selesai |
