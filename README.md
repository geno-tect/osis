# Sistem Data Anggota OSIS (OSKA PASIM)

Aplikasi web untuk mencatat anggota OSIS. Dibuat dengan Laravel, Blade, dan CSS
custom untuk halaman data. Login dan dashboard admin memakai Laravel Breeze.

## Fitur

- Login, register, logout, dan halaman profil.
- Dua role: `admin` dan `user`.
- Admin dapat menambah, mengubah, dan menghapus anggota.
- User hanya dapat melihat daftar anggota. Tidak ada tombol tambah, edit, atau
  hapus, dan route pengelolaan tetap ditolak dengan status 403.
- Dashboard hanya untuk admin. User yang membuka `/dashboard` dialihkan ke
  `/osis`.
- Pencarian bawaan browser tetap bisa dipakai melalui `Ctrl + F`; tidak ada
  kotak pencarian aplikasi.
- Halaman daftar anggota memakai layout dan CSS sendiri (`osis.css` dan
  `navbar.css`), terpisah dari Tailwind Breeze.

## Teknologi

| Bagian | Teknologi |
|---|---|
| Backend | PHP 8.2, Laravel 12 |
| Database | MySQL / MariaDB (`db_osis`) |
| Tampilan OSIS | Blade, CSS custom, JavaScript vanilla |
| Tampilan admin | Blade, Tailwind CSS, Alpine.js (Laravel Breeze) |
| Build asset | Vite 7, npm |
| Testing | PHPUnit 11 |
| Version control | Git, GitHub |

## Hak akses

| Halaman / aksi | Admin | User |
|---|---|---|
| `/login`, `/register`, `/profile` | Ya | Ya |
| `/dashboard` | Ya | Dialihkan ke `/osis` |
| `/osis` (daftar) | Ya | Ya |
| `/osis/create`, `/osis` (POST) | Ya | 403 |
| `/osis/{id}/edit`, `/osis/{id}` (PUT) | Ya | 403 |
| `/osis/{id}` (DELETE) | Ya | 403 |

Role disimpan di kolom `role` pada tabel `users`. Akun lama dipromosikan
menjadi `admin` oleh migration, sedangkan akun baru dari registrasi otomatis
mendapat role `user`.

## Instalasi

Prasyarat: PHP 8.2+, Composer, Node.js 20+, dan MySQL/MariaDB (XAMPP juga bisa).

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Buat database `db_osis` di MySQL, lalu sesuaikan `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_osis
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration, seeder, dan build asset:

```powershell
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Akun default

Seeder membuat akun admin:

```text
Email    : test@example.com
Password : password
```

Segera ganti password setelah login. Untuk membuat admin baru:

```powershell
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@osis.test',
    'password' => 'password',
    'role' => 'admin',
]);
```

Atau promosikan akun yang sudah ada:

```php
\App\Models\User::where('email', 'contoh@email.com')->update(['role' => 'admin']);
```

## Struktur penting

```text
app/Http/Controllers/OsisController.php     CRUD + hapus anggota
app/Http/Middleware/EnsureUserIsAdmin.php   penjaga route admin
app/Models/Osis.php                         model data anggota
app/Models/User.php                         role dan isAdmin()
routes/web.php                              route dashboard dan OSIS

resources/views/layouts/osis.blade.php      kerangka halaman OSIS
resources/views/layouts/navigation.blade.php navbar Breeze
resources/views/osis/                       daftar, tambah, edit
resources/views/dashboard.blade.php         dashboard admin
resources/views/components/dashboard-summary.blade.php

public/css/osis.css                         styling halaman OSIS
public/css/navbar.css                       styling navbar
public/js/osis.js                           cegah submit ganda

database/migrations/                        struktur database
tests/Feature/OsisRoleTest.php              test role dan CRUD
```

## Mengedit tampilan

Panduan lengkap ada di [`docs/PANDUAN-EDIT-TAMPILAN.txt`](docs/PANDUAN-EDIT-TAMPILAN.txt).
Ringkasnya:

- Warna, font, tombol, tabel halaman OSIS: `public/css/osis.css`.
- Navbar: `public/css/navbar.css` dan `resources/views/layouts/osis.blade.php`.
- Dashboard admin dan halaman login: class Tailwind di file Blade, lalu
  `npm run build`.
- Teks halaman: file di `resources/views/osis/`.

Setelah mengubah CSS custom, cukup hard refresh (`Ctrl + F5`). Setelah
mengubah class Tailwind atau JavaScript, jalankan:

```powershell
npm run build
php artisan view:clear
```

## Testing

Test memakai SQLite in-memory, jadi tidak menyentuh database `db_osis`.

```powershell
php artisan test
```

Status terakhir: 34 test lulus, 92 assertion.

## Catatan repository

- `.env` tidak ikut di-commit karena berisi kredensial database.
- `vendor`, `node_modules`, dan `public/build` juga diabaikan.
- Setelah clone, jalankan `composer install`, `npm install`, dan
  `npm run build`.
- Jangan mengedit file di `public/build` secara manual; itu hasil build.
