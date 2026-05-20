# EasyKos

Website Manajemen Kosan Kota Malang adalah platform berbasis web yang memudahkan pengguna mencari dan memesan kos berdasarkan lokasi, harga, dan fasilitas, serta membantu pemilik kos mengelola properti dan ketersediaan kamar secara real-time dengan sistem yang terintegrasi dan aman.

## 👥 Anggota kelompok
1. 245150700111031- Nabath Nuur Muhammad
2. 245150701111027 - Muhammad Abi Abdillah
3. 245150707111043 - Reinhard Frano Randalinggi

## 🎯 Fitur-fitur

### Fitur Wajib
1. Manajemen Data Kos oleh Pemilik (CRUD)
2. Detail Kos (foto, deskripsi, harga, fasilitas, status kamar)
3. Registrasi dan Login (Role: Admin, Pemilik Kos, Pencari Kos)

### Fitur Opsional
1. Update Status Ketersediaan Kamar
2. Sistem Booking atau Pengajuan Sewa
3. Pencarian dan Filter Kos berdasarkan lokasi, harga, dan fasilitas

## 👤 _Role_
| Role        | Hak Akses                        |
| ----------- | -------------------------------- |
| Admin       | Manage semua data                |
| Pemilik Kos | Mengelola kosan yang dimiliki    |
| Pencari Kos | Melihat dan memesan kosan        |

## ▶️ Cara Menjalankan (Dev)
1. Install dependency
   ```bash
   composer install
   npm install
   ```
2. Siapkan environment & database
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```
3. Build asset & jalankan server
   ```bash
   npm run build
   php artisan serve
   ```

## 🔄 Alur Sistem

Alur 1: Registrasi dan Login Pengguna
1. Pengguna melakukan registrasi akun sesuai role (Admin, Pemilik Kos, atau Pencari Kos)
2. Pengguna melakukan login ke sistem
3. Sistem memvalidasi data pengguna
4. Sistem mengarahkan pengguna ke dashboard sesuai role

Alur 2: Pemilik Kos Mengelola Data Kos (CRUD)
1. Pemilik kos login
2. Masuk ke menu manajemen kos
3. Tambah / ubah / hapus data kos (foto, deskripsi, harga, fasilitas)
4. Kirim data ke sistem
5. Data disimpan atau diperbarui di database

Alur 3: Melihat Detail Kos
1. Pengguna login
2. Pengguna memilih kos dari daftar
3. Sistem menampilkan detail kos (foto, deskripsi, harga, fasilitas, status kamar)

## 🗂️ Desain Database

1. Tabel users
   * id INT (PK, Auto Increment)
   * nama VARCHAR
   * email VARCHAR (Unique)
   * password VARCHAR
   * role ENUM (admin, pemilik, pencari)
   * no_telepon VARCHAR
   * created_at TIMESTAMP
   * updated_at TIMESTAMP

2. Tabel kos
   * id INT (PK, Auto Increment)
   * pemilik_id INT (FK ke users)
   * nama_kos VARCHAR
   * alamat TEXT
   * kota VARCHAR
   * kecamatan VARCHAR
   * tipe_kos ENUM (putra, putri, campur)
   * harga DECIMAL(10,2)
   * periode_harga ENUM (bulan, tahun)
   * jumlah_kamar INT
   * status_kamar ENUM (tersedia, penuh)
   * deskripsi TEXT
   * created_at TIMESTAMP
   * updated_at TIMESTAMP

3. Tabel foto_kos
   * id INT (PK, Auto Increment)
   * kos_id INT (FK ke kos)
   * url_foto VARCHAR
   * urutan INT (DEFAULT 0)
   * created_at TIMESTAMP

4. Tabel fasilitas
   * id INT (PK, Auto Increment)
   * nama_fasilitas VARCHAR (Unique)
   * created_at TIMESTAMP

5. Tabel kos_fasilitas
   * id INT (PK, Auto Increment)
   * kos_id INT (FK ke kos)
   * fasilitas_id INT (FK ke fasilitas)

6. Tabel booking
   * id INT (PK, Auto Increment)
   * user_id INT (FK ke users)
   * kos_id INT (FK ke kos)
   * tanggal_booking DATE
   * tanggal_mulai DATE
   * tanggal_selesai DATE
   * pesan TEXT
   * status ENUM (pending, diterima, ditolak)
   * created_at TIMESTAMP
   * updated_at TIMESTAMP
