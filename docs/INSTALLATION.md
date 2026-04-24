# Panduan Instalasi Wizdam Framework 1.0

Panduan lengkap untuk menginstal Wizdam Framework 1.0 di berbagai lingkungan.

---

## 📋 Daftar Isi

- [Prasyarat Sistem](#prasyarat-sistem)
- [Instalasi Development (Local)](#instalasi-development-local)
- [Instalasi Production (Shared Hosting)](#instalasi-production-shared-hosting)
- [Instalasi Production (VPS/Dedicated Server)](#instalasi-production-vpsdedicated-server)
- [Konfigurasi Database](#konfigurasi-database)
- [Troubleshooting](#troubleshooting)

---

## Prasyarat Sistem

### Minimum Requirements

| Komponen | Versi Minimum | Rekomendasi |
|----------|---------------|-------------|
| PHP | 8.1 | 8.4 |
| MySQL | 5.7 | 8.0+ |
| MariaDB | 10.3 | 10.6+ |
| PostgreSQL | 11 | 14+ |
| Web Server | Apache 2.4 / Nginx 1.18 | Latest stable |
| RAM | 512 MB | 2 GB+ |
| Storage | 1 GB | 10 GB+ |

### PHP Extensions Required

Pastikan ekstensi PHP berikut terinstal:

```bash
# Required extensions
- php-mysqlnd / php-pgsql (database driver)
- php-mbstring (multibyte string)
- php-xml (XML parsing)
- php-gd (image processing)
- php-curl (HTTP requests)
- php-zip (archive handling)
- php-intl (internationalization)
- php-json (JSON support - built-in PHP 8+)
- php-fileinfo (file type detection)
```

Verifikasi dengan:
```bash
php -m
```

---

## Instalasi Development (Local)

### Langkah 1: Clone Repository

```bash
git clone https://github.com/wizdam/framework.git wizdam
cd wizdam
```

### Langkah 2: Install Dependencies PHP

```bash
composer install --no-interaction --prefer-dist
```

**Catatan**: Jika tidak ada Composer, download dari https://getcomposer.org

### Langkah 3: Install Dependencies Node (Opsional)

Untuk compile assets CSS/JS:

```bash
npm install
```

### Langkah 4: Setup Environment

```bash
cp .env.example .env
```

Edit file `.env` sesuai konfigurasi lokal Anda:

```ini
APP_NAME="Wizdam Dev"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=wizdam_dev
DB_USERNAME=root
DB_PASSWORD=

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file

# Log level untuk development
LOG_LEVEL=debug
```

### Langkah 5: Buat Database

**MySQL/MariaDB:**
```bash
mysql -u root -p -e "CREATE DATABASE wizdam_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p -e "GRANT ALL PRIVILEGES ON wizdam_dev.* TO 'root'@'localhost';"
```

**PostgreSQL:**
```bash
createdb -U postgres wizdam_dev
```

### Langkah 6: Jalankan Installer

```bash
php scripts/install.php
```

Atau gunakan web-based installer:
```bash
php -S localhost:8000 -t public/
```

Kemudian akses: `http://localhost:8000`

### Langkah 7: Build Assets (Opsional)

```bash
npm run build
```

Untuk development dengan auto-reload:
```bash
npm run dev
```

---

## Instalasi Production (Shared Hosting)

Metode ini untuk hosting tanpa akses SSH/terminal.

### Langkah 1: Download Release

Download paket release terbaru dari:
- GitHub Releases: https://github.com/wizdam/framework/releases
- Atau clone dan build lokal lalu upload

### Langkah 2: Upload File

Upload SEMUA file ke hosting Anda via FTP/SFTP atau File Manager.

Struktur yang disarankan:
```
/home/username/
├── wizdam/           # Semua file aplikasi
│   ├── core/
│   ├── app/
│   ├── public/
│   └── ...
└── public_html/      # Symlink ke public/
    └── index.php -> ../wizdam/public/index.php
```

**Alternatif**: Upload semua ke `public_html/` langsung (kurang aman).

### Langkah 3: Setup Database

Via cPanel/phpMyAdmin:

1. Buat database baru (misal: `username_wizdam`)
2. Buat user database dengan password kuat
3. Grant ALL PRIVILEGES ke user tersebut

Catat informasi:
- Database name: `username_wizdam`
- Username: `username_wizdamuser`
- Password: `********`
- Host: `localhost` (atau server DB yang diberikan)

### Langkah 4: Konfigurasi Environment

Rename file `.env.example` menjadi `.env`:

```bash
# Via File Manager atau FTP client
.env.example → .env
```

Edit `.env` dengan informasi database production:

```ini
APP_NAME="Wizdam Production"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://journal.domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_wizdam
DB_USERNAME=username_wizdamuser
DB_PASSWORD=your_strong_password

# Security
APP_KEY=generate_random_32_char_key

# Performance
CACHE_DRIVER=file
SESSION_DRIVER=database
LOG_LEVEL=error
```

**PENTING**: 
- Set `APP_DEBUG=false` untuk production!
- Generate `APP_KEY` unik untuk keamanan session

### Langkah 5: Set Permissions

Via File Manager atau FTP, set permissions:

```
storage/          → 755 (directories), 644 (files)
storage/logs/     → 775 (writable)
storage/cache/    → 775 (writable)
storage/files/    → 775 (writable)
public/           → 755
config/config.inc.php → 644 (writable saat install)
```

Via SSH (jika tersedia):
```bash
chmod -R 755 storage/
chmod -R 775 storage/logs storage/cache storage/files
find storage -type f -exec chmod 644 {} \;
```

### Langkah 6: Jalankan Web Installer

Akses domain Anda:
```
https://journal.domain.com
```

Installer akan memandu Anda melalui:
1. Verifikasi prasyarat sistem
2. Konfigurasi database
3. Setup admin account
4. Konfigurasi jurnal pertama

### Langkah 7: Keamanan Tambahan

Setelah instalasi selesai:

1. **Hapus/rename installer**:
   ```
   scripts/install.php → scripts/install.php.bak
   ```

2. **Lock config file**:
   ```
   config/config.inc.php → chmod 444
   ```

3. **Buat file .htaccess** di root (jika Apache):
   ```apache
   # Block access to sensitive files
   <FilesMatch "^\.">
       Order allow,deny
       Deny from all
   </FilesMatch>
   
   # Block direct access to config
   <Files "config.inc.php">
       Order allow,deny
       Deny from all
   </Files>
   ```

---

## Instalasi Production (VPS/Dedicated Server)

### Opsi A: Manual Installation

Ikuti langkah seperti [Instalasi Development](#instalasi-development-local), kemudian:

1. **Setup Web Server** (Apache contoh):

```apache
<VirtualHost *:80>
    ServerName journal.domain.com
    DocumentRoot /var/www/wizdam/public
    
    <Directory /var/www/wizdam/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/wizdam_error.log
    CustomLog ${APACHE_LOG_DIR}/wizdam_access.log combined
</VirtualHost>
```

2. **Enable mod_rewrite**:
```bash
a2enmod rewrite
systemctl restart apache2
```

3. **Setup SSL** (Let's Encrypt):
```bash
certbot --apache -d journal.domain.com
```

### Opsi B: Docker Deployment

```bash
# Build dan run dengan Docker Compose
docker-compose up -d
```

File `docker-compose.yml` (contoh):
```yaml
version: '3.8'
services:
  app:
    image: php:8.4-apache
    volumes:
      - .:/var/www/html
    ports:
      - "80:80"
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html/public
  
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: wizdam
    volumes:
      - db_data:/var/lib/mysql
  
volumes:
  db_data:
```

---

## Konfigurasi Database

### MySQL/MariaDB Optimization

Tambahkan ke `my.cnf`:
```ini
[mysqld]
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
innodb_log_file_size = 256M
innodb_buffer_pool_size = 512M
max_connections = 200
```

### PostgreSQL Configuration

Edit `postgresql.conf`:
```conf
shared_buffers = 256MB
work_mem = 16MB
maintenance_work_mem = 128MB
```

---

## Troubleshooting

### Error: "Class not found"

**Solusi**:
```bash
composer dump-autoload --optimize
```

### Error: "Permission denied" pada storage/

**Solusi**:
```bash
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

### Error: "Database connection failed"

Periksa:
1. Kredensial di `.env` sudah benar
2. Database sudah dibuat
3. User database punya akses
4. Host database benar (`localhost` vs IP)

### Error: "mod_rewrite not enabled"

**Apache**:
```bash
a2enmod rewrite
systemctl restart apache2
```

**Nginx**: Pastikan konfigurasi includes:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### Blank page setelah install

Cek log error:
```bash
tail -f storage/logs/error.log
tail -f /var/log/apache2/error.log
```

Aktifkan debug mode sementara di `.env`:
```ini
APP_DEBUG=true
LOG_LEVEL=debug
```

### Composer timeout

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install --no-interaction
```

---

## Verifikasi Instalasi

Jalankan diagnostic script:
```bash
php scripts/diagnostic.php
```

Atau akses via web:
```
https://journal.domain.com/index.php/info/serverInfo
```

Semua item harus menunjukkan ✅ hijau.

---

## Langkah Selanjutnya

Setelah instalasi berhasil:

1. **Login sebagai Admin** di `/index.php/login`
2. **Setup Jurnal Pertama** via Dashboard
3. **Konfigurasi Email** di Settings > Website > Email
4. **Install Plugin** yang diperlukan
5. **Customize Theme** sesuai branding
6. **Backup Strategy** - setup automated backup

---

## Bantuan Lebih Lanjut

- **Dokumentasi**: https://docs.wizdam.framework.id
- **Forum**: https://community.wizdam.framework.id
- **GitHub Issues**: https://github.com/wizdam/framework/issues

---

© 2024 Wizdam Framework Team
