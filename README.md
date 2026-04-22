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
| Role   | Hak Akses           |
| -------| ------------------- |
| Admin  | Manage semua data |
| Pemilik Kos| Melihat daftar kosan tersedia |
| Pencari Kos| Mengupload kosan yang dimiliki      |

## 🔄 Alur Sistem

Contoh:

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
   * id INT
   * nama VARCHAR
   * email VARCHAR
   * password VARCHAR
   * role ENUM (admin, pemilik, pencari)
   * no_telepon VARCHAR
   * created_at TIMESTAMP
   * updated_at TIMESTAMP

2. Tabel kos
   * id INT
   * pemilik_id INT (FK ke users)
   * nama_kos VARCHAR
   * alamat TEXT
   * kota VARCHAR
   * kecamatan VARCHAR
   * tipe_kos ENUM (putra, putri, campur)
   * harga DECIMAL
   * periode_harga ENUM (bulan, tahun)
   * jumlah_kamar INT
   * deskripsi TEXT
   * created_at TIMESTAMP
   * updated_at TIMESTAMP

3. Tabel detail_kos
   * id INT
   * kos_id INT (FK ke kos)
   * fasilitas TEXT
   * foto VARCHAR
   * status_kamar ENUM (tersedia, penuh)
   * updated_at TIMESTAMP

4. Tabel booking
   * id INT
   * user_id INT (FK ke users)
   * kos_id INT (FK ke kos)
   * tanggal_booking DATE
   * tanggal_mulai DATE
   * tanggal_selesai DATE
   * pesan TEXT
   * status ENUM (pending, diterima, ditolak)
   * updated_at TIMESTAMP

5. Tabel foto_kos
   * id INT
   * kos_id INT (FK ke kos)
   * url_foto VARCHAR
   * urutan INT

6. Tabel fasilitas
   * id INT
   * nama_fasilitas VARCHAR

7. Tabel kos_fasilitas
   * kos_id INT (FK ke kos)
   * fasilitas_id INT (FK ke fasilitas)
