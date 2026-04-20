# Kontribusi EasyKos (Versi Singkat)

Dokumen ini sementara fokus pada poin penting dulu. Bagian lain menyusul.

## 2. Stack dan Konvensi Dasar

- Backend: Laravel 12, PHP 8.2
- Frontend: Blade + Vite + Tailwind CSS
- Formatting PHP: Laravel Pint

## 3. Setup Lokal (Wajib)

Jalankan sekali setelah clone:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
```

Menjalankan project:

```bash
composer run dev
```

## 4. Alur Kerja Git

Branch yang dipakai:

- **main**
- dev
- feature/nama-fitur
- fix/nama-bug
- docs/topik

**Flow kerja dasar:**

1. Pindah ke branch dev dan ambil update terbaru:

```bash
git checkout dev
git pull origin dev
```

2. Buat branch baru dari dev (jangan kerja langsung di dev):

```bash
git checkout -b feature/nama-fitur
```

3. Kerja secukupnya, lalu commit kecil-kecil:

```bash
git add .
git commit -m "feat: deskripsi perubahan"
```

4. Sebelum push, sinkronkan lagi dengan dev agar konflik berkurang:

```bash
git checkout dev
git pull origin dev
git checkout feature/nama-fitur
git merge dev
```

5. Jika muncul conflict:
- Buka file yang conflict.
- Pilih bagian kode yang benar (hapus penanda `<<<<<<<`, `=======`, `>>>>>>>`).
- Simpan, lalu lanjut:

```bash
git add .
git commit -m "chore: resolve merge conflict"
```

6. Push branch lalu buat PR ke dev:

```bash
git push -u origin feature/nama-fitur
```

Tips biar minim conflict:

- Selalu mulai kerja dari dev terbaru.
- Satu branch untuk satu tugas kecil.
- Jangan edit file yang sama secara bersamaan tanpa koordinasi.
- Sering pull update dev sebelum lanjut coding.
- Jangan force push ke branch orang lain.

## 5. Standar Commit Message

Format:

```text
type: ringkasan singkat
```

Type yang dipakai:

- `feat`: menambahkan fitur baru
- `fix`: memperbaiki bug/perilaku yang salah
- `refactor`: merapikan struktur kode tanpa mengubah perilaku fitur
- `docs`: update dokumentasi (README, CONTRIBUTING, catatan teknis)
- `chore`: pekerjaan pendukung non-fitur (config, tooling, dependency)

Contoh:

- `feat: tambah CRUD data kos`
- `fix: perbaiki validasi harga`
- `refactor: rapikan service booking`

## 6. Standar Pull Request

Isi PR:

1. Ringkasan perubahan.
2. Masalah yang diselesaikan.
3. Cara cek fitur singkat.
4. Screenshot UI (kalau ada perubahan tampilan).
5. Catatan migration/env (kalau ada).

Checklist:

- [ ] Sudah update dari dev
- [ ] Tidak ada konflik merge
- [ ] Tidak ada file sensitif ikut ke-commit