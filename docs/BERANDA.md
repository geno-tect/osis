# Beranda Publik OSKA PASIM

Dokumen ini menjelaskan halaman publik di project Laravel OSIS SMK Pasim Plus
Kota Sukabumi. Halaman daftar anggota `/osis` yang lama sudah dihapus; seluruh
data anggota tampil di beranda.

Status: pratinjau desain. Nama kabinet, pengurus, agenda, berita, dan tautan
sosial masih berupa contoh yang ditandai di halaman. Jangan menganggap isinya
sebagai data resmi sebelum diganti.

## Route

| Route | Method | Keterangan |
|---|---|---|
| `/` | GET | Beranda publik (route `beranda`) |
| `/aspirasi` | GET | Formulir kotak aspirasi (route `aspirasi.index`) |
| `/aspirasi` | POST | Simpan aspirasi, dibatasi `throttle:5,1` (route `aspirasi.store`) |
| `/berita/{slug}` | GET | Detail artikel contoh (route `berita.show`) |
| `/osis` | GET | Halaman lama, dialihkan ke `/#anggota` |

Seluruh data anggota tampil di bagian `#anggota` pada beranda. Tidak ada lagi
halaman daftar anggota terpisah. Tautan merek di layout lama diarahkan ke
beranda. Menu "Beranda" ada di navigasi panel Laravel
(`layouts/navigation.blade.php`).

## Sumber isi

Semua isi beranda berada di `config/beranda.php`:

- `cabinet`, `period`, `school`, `city`
- `hero`
- `events`
- `about` (termasuk visi dan misi)
- `bph`
- `sekbid` (10 seksi bidang)
- `news`
- `aspiration`
- `social`
- `contact`
- `preview_note`

Setelah mengubah config, cukup muat ulang halaman. Tidak perlu build asset.
Jika config di-cache di server, jalankan `php artisan config:clear`.

## Struktur halaman

1. Navbar sticky dengan blur tipis, logo asli OSIS, dan CTA aspirasi.
2. Hero dua kolom: badge kabinet/periode, judul, dua CTA, dan bingkai foto
   kegiatan 4:5. Bingkai saat ini adalah placeholder yang jelas, bukan foto
   palsu.
3. Tiga kartu agenda terdekat dengan status dan detail yang bisa dibuka.
4. Tentang kabinet, visi, dan misi di atas bidang `#F0F9FF`.
5. Kartu Badan Pengurus Harian dan tab interaktif Sekbid 1 sampai 10.
6. Tiga kartu berita 16:9 dengan kategori, tanggal, judul, dan ringkasan.
7. Banner aspirasi bergradasi dengan teks putih dan tombol putih.
8. Footer dengan alamat sekolah, tautan cepat, ikon sosial, dan copyright.

## Arah desain

Dials: **ENERGY 2 / RHYTHM 3 / MOTION 1**.

- **Palet:** biru langit `#0EA5E9` sebagai identitas, `#E0F2FE` dan `#F0F9FF`
  sebagai bidang pendukung, amber `#F59E0B` sebagai aksen, serta slate untuk
  teks dan border. Rasio 60-30-10 dijaga: bidang putih dan `#F8FAFC` mendominasi,
  biru menjadi identitas, amber hanya untuk penanda penting.
- **Tipografi:** Plus Jakarta Sans untuk judul karena bentuknya tegas dan ramah
  untuk organisasi sekolah; Inter untuk isi karena nyaman dibaca dalam paragraf
  panjang.
- **Motif identitas:** cincin amber tipis dan bidang langit. Motif ini muncul di
  bingkai hero, thumbnail berita, dan banner aspirasi, sehingga halaman punya
  pengulangan yang khas tanpa menambah ornamen acak.
- **Bayangan:** hanya untuk kartu, menu seluler, dan bingkai hero sebagai penanda
  elevasi. Tidak setiap elemen diberi bayangan.
- **Glassmorphism:** hanya navbar, sesuai permintaan. Tidak dipakai di kartu,
  modal, atau sidebar.
- **Tema terang saja:** identitas visual dibangun di atas putih dan biru langit.
  Mode gelap akan menjadi identitas terpisah, bukan sekadar pembalikan warna,
  jadi tidak dipaksakan di versi ini.
- **Ikon:** ikon garis sederhana untuk fungsi nyata (kalender, centang, panah,
  menu, peta, Instagram, TikTok, YouTube). Tidak ada ikon dekoratif berbentuk
  sparkle atau robot.

## Kontras dan aksesibilitas

Beberapa keputusan sengaja menyimpang dari warna mentah agar teks tetap lolos
WCAG AA:

- Tombol biru memakai teks navy `#0F172A` di atas `#0EA5E9`. Putih di atas
  `#0EA5E9` hanya 2,77:1 dan tidak lolos.
- Saat hover, tombol biru menjadi `#0369A1` dengan teks putih (5,93:1).
- Banner aspirasi memakai gradasi `#0369A1` sampai `#0C4A6E` agar teks putih
  aman. Gradasi `#0EA5E9` ke `#0284C7` tidak cukup kontras untuk teks putih.
- Border input memakai slate yang lebih gelap agar batas kontrol terlihat,
  bukan hanya mengandalkan placeholder.
- Fokus keyboard memakai outline 3px. Fokus pada kartu sukses dan ringkasan
  error memakai biru `#0369A1`.
- Menu seluler bisa dibuka dengan Enter/Space, ditutup dengan Escape, dan
  mengembalikan fokus ke tombol menu.
- Tab Sekbid mendukung klik, tombol panah, Home, dan End.
- Semua gerakan hover berhenti saat `prefers-reduced-motion: reduce`.

## Formulir aspirasi

- Validasi: kategori wajib dan harus salah satu pilihan di config, pesan wajib
  20 sampai 2000 karakter, nama opsional maksimal 100 karakter.
- Nama boleh dikosongkan. Middleware Laravel mengubah string kosong menjadi
  `null`.
- Setiap pengiriman disimpan ke tabel `aspirations` lewat model
  `App\Models\Aspiration`.
- Route POST dibatasi 5 percobaan per menit per alamat IP.
- Pesan tidak ditampilkan di halaman publik mana pun.
- Halaman menampilkan keadaan sukses, error validasi, dan label tombol
  "Mengirim..." saat proses kirim.

Jalankan migration saat database MySQL siap:

```powershell
php artisan migrate
```

Sampai ada halaman admin khusus, isi tabel bisa dibaca lewat database atau
Tinker:

```powershell
php artisan tinker
```

```php
\App\Models\Aspiration::latest()->take(10)->get();
```

## Mengganti placeholder

| Placeholder | Lokasi |
|---|---|
| `[Nama Kabinet]` | `config/beranda.php`, key `cabinet` |
| `[Nama Ketua]`, `[Nama Wakil]`, dan lainnya | `config/beranda.php`, key `bph` |
| Agenda dan status contoh | `config/beranda.php`, key `events` |
| Berita dan isi artikel contoh | `config/beranda.php`, key `news` |
| Foto kegiatan hero | `resources/views/beranda.blade.php`, ganti isi `.hero-frame__inner` dengan `<img>` 4:5 |
| Tautan Instagram, TikTok, YouTube | `config/beranda.php`, isi `url`; selama `null`, ikon tampil nonaktif |
| Email sekretariat | `config/beranda.php`, key `contact.email` |
| Alamat lengkap | `config/beranda.php`, key `contact.address_lines` dan `note` |
| Catatan pratinjau footer | `config/beranda.php`, key `preview_note` |

Jangan mengganti placeholder dengan nama, foto, atau tautan yang belum
diverifikasi. Halaman ini sengaja menampilkan label "Contoh" dan catatan
pratinjau daripada membuat data palsu.

## File utama

```text
config/beranda.php                              isi beranda
app/Http/Controllers/HomeController.php         halaman beranda
app/Http/Controllers/NewsController.php         detail artikel
app/Http/Controllers/AspirationController.php   form dan simpan aspirasi
app/Models/Aspiration.php                       model aspirasi
database/migrations/2026_11_21_000001_create_aspirations_table.php

resources/views/layouts/public.blade.php        layout publik baru
resources/views/beranda.blade.php               halaman beranda
resources/views/aspirasi/index.blade.php        form aspirasi
resources/views/berita/show.blade.php           detail artikel
resources/views/components/site-icon.blade.php  ikon SVG

public/css/beranda.css                          styling halaman publik
public/js/beranda.js                            menu, tab, fokus, state kirim

tests/Feature/ExampleTest.php                   route / menampilkan beranda
tests/Feature/BerandaTest.php                   section dan artikel
tests/Feature/AspirationTest.php                validasi dan penyimpanan
```

Halaman publik baru tidak memakai Vite atau Tailwind. CSS dan JavaScript
dimuat langsung dari `public/`, jadi tidak perlu `npm run build` untuk
mengubah tampilan beranda.

## Verifikasi

Test PHPUnit:

```powershell
php artisan test
```

Status terakhir: 49 test lulus, 155 assertion. Cakupan baru mencakup route
beranda, data anggota di beranda, pengalihan halaman `/osis` lama, section yang
dituju navigasi, artikel yang ada dan tidak ada, validasi form, penyimpanan
aspirasi dengan atau tanpa nama, serta penolakan kategori yang tidak dikenal.

Pemeriksaan browser lokal juga dilakukan untuk:

- lebar 320, 360, 390, 768, 1024, 1280, dan 1440 tanpa overflow horizontal
- menu seluler buka/tutup, Escape, dan klik tautan
- tab Sekbid dengan klik dan tombol panah
- state sukses dan error form aspirasi
- axe WCAG 2.2 AA pada beranda, form, dan artikel
- tidak ada error console

Pemeriksaan browser tersebut memakai alat sementara di luar repository. Yang
tersimpan sebagai test permanen adalah PHPUnit di atas.
