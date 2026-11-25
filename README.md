# Sistem Data Anggota OSIS (OSKA PASIM)

Aplikasi web OSIS SMK Pasim Plus Kota Sukabumi. Beranda publik di `/` memuat
informasi OSIS sekaligus seluruh data anggota. Data anggota bisa dilihat tanpa
login. Login hanya dipakai admin untuk mengelola data. Tampilan publik memakai
Blade dan CSS custom, sedangkan dashboard admin memakai Laravel Breeze.

## Fitur

- Halaman `/` adalah beranda publik: agenda dari database, visi/misi, Badan
  Pengurus Harian, daftar anggota, berita kegiatan, dan banner aspirasi.
  Informasi profil berada di `config/beranda.php`.
- Form `/aspirasi` menyimpan pesan ke tabel `aspirasi`. Nama boleh
  dikosongkan dan pengiriman dibatasi 5 kali per menit.
- Detail artikel tersedia di `/berita/{slug}`.
- Seluruh data anggota tampil di beranda dan bisa dibuka tanpa akun. Tidak ada
  halaman daftar anggota terpisah.
- Tamu hanya bisa melihat data anggota. Tidak ada tombol tambah, edit, atau
  hapus untuk tamu.
- Login hanya untuk admin.
- Registrasi publik dinonaktifkan. Akun admin dibuat lewat seeder atau Tinker.
- Admin dapat menambah, mengubah, dan menghapus anggota.
- Dashboard admin menampilkan total anggota, jumlah sekbid, dan tabel seluruh
  anggota yang bisa langsung diedit atau dihapus.
- Admin dapat menambah, mengedit, dan menghapus agenda/kegiatan melalui
  dashboard. Agenda hari ini dan mendatang tampil di beranda; agenda lampau
  tetap tersimpan dan dapat dikelola.
- Beranda memakai layout terpisah di `resources/views/layouts/public.blade.php`.
- Role disimpan di kolom `role` pada tabel `users`. Route pengelolaan tetap
  dilindungi middleware `auth` dan `admin`.
- Pencarian bawaan browser tetap bisa dipakai melalui `Ctrl + F`; tidak ada
  kotak pencarian aplikasi.
- Form tambah dan edit anggota memakai layout dan CSS sendiri (`osis.css` dan
  `navigasi.css`), terpisah dari Tailwind Breeze.

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

| Halaman / aksi | Tamu | Admin |
|---|---|---|
| `/` (beranda) | Ya | Ya |
| `/aspirasi` (form) | Ya | Ya |
| `/berita/{slug}` | Ya | Ya |
| `/osis` (halaman lama) | Dialihkan ke `/#anggota` | Dialihkan ke `/#anggota` |
| Path login admin (khusus) | Ya | Ya (sudah login diarahkan) |
| `/register` | 404 (dinonaktifkan) | 404 |
| `/dashboard` | Dialihkan ke path login | Ya |
| `/osis/create`, `POST /osis` | Dialihkan ke path login | Ya |
| `/osis/{id}/edit`, `PUT /osis/{id}` | Dialihkan ke path login | Ya |
| `DELETE /osis/{id}` | Dialihkan ke path login | Ya |
| `/profile` | Dialihkan ke path login | Ya |

Path login admin tidak ditampilkan di header publik dan tidak ditulis di
README ini. Catatan akses ada di file inventaris lokal di folder Documents.
Akun non-admin tidak bisa login.

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

Buka `http://127.0.0.1:8000`. Halaman awal menampilkan beranda publik beserta
seluruh data anggota.

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
app/Http/Controllers/BerandaController.php   beranda publik
app/Http/Controllers/BeritaController.php    detail berita
app/Http/Controllers/BeritaAdminController.php CRUD berita
app/Http/Controllers/AspirasiController.php  form dan simpan aspirasi
app/Http/Controllers/AgendaController.php    CRUD agenda/kegiatan
app/Http/Controllers/OsisController.php      CRUD + hapus anggota
app/Http/Controllers/Auth/                   login dan reset password
app/Http/Middleware/PastikanPenggunaAdmin.php penjaga route admin
app/Models/Aspirasi.php                      model aspirasi
app/Models/Agenda.php                        model agenda/kegiatan
app/Models/Berita.php                        model berita
app/Models/Osis.php                          model data anggota + daftar sekbid
app/Models/User.php                          role dan isAdmin()
config/beranda.php                           isi teks beranda
routes/web.php                               route publik, dashboard, OSIS
routes/auth.php                              login, logout, reset password

resources/views/layouts/public.blade.php     kerangka beranda, form, artikel
resources/views/beranda.blade.php            halaman beranda
resources/views/aspirasi/index.blade.php     form aspirasi
resources/views/berita/detail.blade.php      detail artikel
resources/views/components/ikon-situs.blade.php ikon SVG
resources/views/layouts/osis.blade.php       kerangka form tambah/edit anggota
resources/views/layouts/navigation.blade.php navbar Breeze/admin
resources/views/osis/                        form tambah dan edit anggota
resources/views/dashboard.blade.php          dashboard admin
resources/views/components/ringkasan-dashboard.blade.php

public/css/beranda.css                       styling beranda dan halaman publik
public/css/osis.css                          styling halaman OSIS
public/css/navigasi.css                      styling navbar OSIS
public/js/beranda.js                         navigasi aktif dan state form
public/js/osis.js                            cegah submit ganda

database/migrations/                         struktur database
database/seeders/AgendaSeeder.php            data awal agenda, idempotent
database/seeders/BeritaSeeder.php            data awal berita, idempotent
tests/Feature/BerandaTest.php                test beranda dan artikel
tests/Feature/AspirasiTest.php               test validasi dan simpan aspirasi
tests/Feature/OsisRoleTest.php               test akses publik, role, CRUD
```

Registrasi publik sudah dihapus. File `RegisteredUserController` dan view
`auth/register.blade.php` sudah dihapus dari project.

## Mengedit tampilan

Ringkasnya:

- Isi profil beranda (kabinet, visi/misi, aspirasi, sosial): `config/beranda.php`.
- Agenda/kegiatan: tabel `agenda`, dikelola dari dashboard admin. `AgendaSeeder`
  mengisi contoh hanya saat tabel agenda masih kosong.
- Berita: tabel `berita`, dikelola dari dashboard admin. `BeritaSeeder` mengisi
  contoh berdasarkan slug yang belum ada.
- Tampilan beranda, form aspirasi, dan artikel: `public/css/beranda.css`.
- Navigasi aktif dan state form: `public/js/beranda.js`.
- Warna, font, tombol halaman OSIS: `public/css/osis.css`.
- Navbar: `public/css/navigasi.css` dan `resources/views/layouts/osis.blade.php`.
- Dashboard admin dan halaman login: class Tailwind di file Blade, lalu
  `npm run build`.
- Teks halaman: file di `resources/views/osis/`.

Halaman publik baru tidak memakai Vite atau Tailwind. Setelah mengubah CSS
atau JavaScript publik, cukup hard refresh (`Ctrl + F5`). Setelah mengubah
class Tailwind, jalankan:

```powershell
npm run build
php artisan view:clear
```

## Testing

Test memakai SQLite in-memory, jadi tidak menyentuh database `db_osis`.

```powershell
php artisan test
```

Status terakhir: 50 test lulus, 163 assertion.

Cakupan penting:

- Route `/` menampilkan beranda dengan seluruh data anggota.
- Halaman `/osis` lama dialihkan ke bagian anggota di beranda.
- Section yang dituju navigasi beranda benar-benar ada.
- Artikel contoh bisa dibuka dan slug yang tidak ada mengembalikan 404.
- Form aspirasi menolak isian kosong atau terlalu pendek.
- Aspirasi tersimpan dengan nama maupun tanpa nama.
- Tamu bisa melihat data anggota di beranda tanpa tombol pengelolaan.
- Tamu yang membuka route admin diarahkan ke login.
- Admin bisa login dan mengelola data.
- Dashboard admin menampilkan seluruh anggota.
- Akun non-admin ditolak saat login.
- Registrasi `/register` mengembalikan 404.
- Admin bisa menghapus anggota; user yang sudah login tidak bisa.

## Catatan repository

- `.env` tidak ikut di-commit karena berisi kredensial database.
- `vendor`, `node_modules`, dan `public/build` juga diabaikan.
- Setelah clone, jalankan `composer install`, `npm install`, dan
  `npm run build`.
- Jangan mengedit file di `public/build` secara manual; itu hasil build.
- Data anggota tampil publik di beranda, jadi pastikan datanya memang boleh
  ditampilkan.
- Jalankan `php artisan migrate` untuk membuat tabel `aspirasi` sebelum
  form aspirasi dipakai di database MySQL.
- Nama kabinet, pengurus, agenda, berita, dan tautan sosial di beranda masih
  placeholder. Ganti dulu sebelum publikasi.
