# Wizdam Editorial

Solusi manajemen editorial dan penerbitan jurnal ilmiah yang telah dimodernisasi sepenuhnya.

---

## Tentang Proyek

Wizdam Editorial adalah aplikasi web untuk mengelola alur kerja editorial, dari submisi naskah hingga publikasi. Proyek ini merupakan hasil refaktor dan modernisasi besar-besaran dengan arsitektur yang lebih bersih, performa lebih baik, serta antarmuka yang responsif dan mudah digunakan.

## Fitur Utama

- Manajemen multi-jurnal dalam satu instalasi
- Alur editorial fleksibel (submission, review, copyediting, production)
- Dukungan peer review blind/double-blind
- Manajemen pengguna dengan peran dan izin yang dapat disesuaikan
- Notifikasi email otomatis
- Pencarian dan indeks konten
- Tema dan plugin yang dapat diperluas
- REST API untuk integrasi dengan layanan eksternal
- Dashboard analitik sederhana

<!-- Sesuaikan fitur berdasarkan implementasi aktual -->

## Tumpukan Teknologi

- **Bahasa:** PHP 8.x (dengan framework <!-- sebutkan jika menggunakan Laravel/Symfony/dll. -->)
- **Basis Data:** MySQL 8.0 / PostgreSQL 14+
- **Frontend:** Blade + Livewire / Vue.js / React (pilih yang sesuai)
- **Queue & Job:** Redis / Database driver
- **Penyimpanan:** Lokal, Amazon S3, atau filesystem adapter lain
- **Autentikasi:** Laravel Sanctum / JWT (jika ada API)

<!-- Silakan rincikan versi dan dependensi persisnya -->

## Mulai Cepat

### Prasyarat

- PHP >= 8.1 dengan ekstensi: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`
- Composer 2
- Node.js & NPM (untuk asset frontend)
- MySQL 8.0 atau PostgreSQL 14
- Web server (Nginx atau Apache dengan konfigurasi rewrite)

### Instalasi

1. **Clone repositori**  
   ```bash
   git clone https://github.com/mokesano/scholaraux-ori.git
   cd scholaraux-ori
   ```

2. **Siapkan dependensi PHP**  
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Salin dan edit file environment**  
   ```bash
   cp .env.example .env
   ```
   Atur koneksi database, `APP_URL`, dan pengaturan lain di file `.env`.

4. **Generate application key**  
   ```bash
   php artisan key:generate   <!-- sesuaikan jika bukan Laravel -->
   ```

5. **Migrasi dan isi database**  
   ```bash
   php artisan migrate --seed
   ```

6. **Buat symbolic link untuk storage**  
   ```bash
   php artisan storage:link
   ```

7. **Build asset frontend** (jika menggunakan bundler)  
   ```bash
   npm ci
   npm run prod
   ```

8. **Atur izin direktori**  
   Pastikan web server dapat menulis ke direktori `storage` dan `bootstrap/cache`.

9. **Konfigurasi web server**  
   Arahkan document root ke folder `public`. Contoh konfigurasi Nginx tersedia di `docs/nginx.conf`.

### Menjalankan di Lingkungan Pengembangan

```bash
# Mulai server pengembangan
php artisan serve

# Watch perubahan front-end
npm run dev
```

## Konfigurasi Lanjutan

- **Email:** Ubah `MAIL_*` di `.env` untuk notifikasi.
- **Queue driver:** Ganti `QUEUE_CONNECTION` menjadi `database` atau `redis` dan jalankan worker:  
  ```bash
  php artisan queue:work
  ```
- **Penyimpanan file:** Atur `FILESYSTEM_DISK` untuk direktori unggahan (default `local`, bisa diubah ke `s3`).

## Penggunaan

1. Buka `http://your-domain.com` dan login sebagai administrator (kredensial bawaan dapat diubah, lihat dokumentasi).
2. Buat jurnal pertama, atur bagian dan alur editorial.
3. Undang editor, reviewer, dan penulis sesuai kebutuhan.

Dokumentasi lengkap tersedia di [wiki proyek](#) (tautan akan ditambahkan seiring waktu).

## Lisensi

Wizdam Editorial adalah perangkat lunak sumber terbuka yang dilisensikan di bawah [GNU General Public License v2](LICENSE.md).

## Kontribusi

Kami menyambut kontribusi! Silakan buka *issue* untuk melaporkan bug atau mengajukan fitur baru. Untuk *pull request*, baca panduan di [CONTRIBUTING.md](CONTRIBUTING.md).

## Penghargaan

Proyek ini merupakan hasil modernisasi dari sistem penerbitan jurnal yang sebelumnya, ditenagai oleh komunitas riset dan pengembang yang berdedikasi.