# Wizdam Framework 1.0

## Platform Manajemen Editorial & Penerbitan Modern

**Wizdam Framework** adalah platform open-source untuk manajemen editorial dan penerbitan ilmiah dengan arsitektur **Publisher-Centric** yang modern, fleksibel, dan skalabel.

---

## 🎯 Tentang Wizdam

Wizdam Framework 1.0 merupakan hasil refactoring dan modernisasi total dari basis kode OJS 2.x, dirancang ulang dengan prinsip-prinsip pengembangan perangkat lunak modern:

- **Arsitektur Modular**: Pemisahan jelas antara Core Engine, Modules, dan Library Eksternal
- **Publisher-Centric**: Mendukung multi-publisher dalam satu instalasi (bukan hanya jurnal)
- **Standar Industri**: Composer, PSR-4 Autoloading, Environment Variables (.env)
- **PHP 8.4+ Ready**: Dioptimalkan untuk performa dan keamanan terbaru
- **Flat Structure**: Struktur direktori yang ringkas dan mudah dipahami

---

## 🏗️ Arsitektur

```
/workspace/
├── core/
│   ├── Kernel/           # Inti framework (CoreApplication, CoreRouter, dll)
│   ├── Modules/          # Modul fungsional (DB, Form, User, Auth, dll)
│   ├── Includes/         # Bootstrap & helper functions
│   ├── Library/          # Library eksternal (FLAT - tanpa vendor/)
│   └── Services/         # Custom services (GeoLocation, dll)
│
├── app/
│   ├── Classes/          # Logika bisnis aplikasi (AppPublisher, Submission, dll)
│   ├── Pages/            # Request handlers
│   └── Services/         # Application services
│
├── public/               # Web root (index.php, assets)
├── config/               # Konfigurasi aplikasi
├── resources/            # Views, templates, locale
├── database/             # Migrations & seeders
├── storage/              # Cache, logs, uploads
├── plugins/              # Plugin system
└── docs/                 # Dokumentasi
```

### Perbedaan Utama dari OJS 2.x

| Aspek | OJS 2.x (Legacy) | Wizdam 1.0 (Modern) |
|-------|------------------|---------------------|
| **Struktur** | `lib/pkp/`, `lib/ojs/`, `classes/` | `core/Kernel/`, `core/Modules/`, `app/` |
| **Naming** | `PKP*`, `OJS*` | `Core*`, `App*` |
| **Paradigma** | Journal-Centric (`Journal`, `Site`) | Publisher-Centric (`Press`, `CorePublisher`) |
| **Dependencies** | Manual includes | Composer + PSR-4 Autoloading |
| **Config** | `config.inc.php` only | `.env` + config bridge |
| **Library** | Nested `vendor/` | Flat structure di `core/Library/` |

---

## 🚀 Quick Start

### Prasyarat

- PHP 8.1 atau lebih tinggi (direkomendasikan: 8.4)
- MySQL 5.7+ / MariaDB 10.3+ / PostgreSQL 11+
- Composer 2.x
- Node.js 18+ (untuk asset compilation)
- Web server (Apache/Nginx) dengan mod_rewrite

### Instalasi Development

```bash
# 1. Clone repository
git clone https://github.com/wizdam/framework.git
cd framework

# 2. Install dependencies PHP
composer install

# 3. Install dependencies Node (opsional, untuk asset compilation)
npm install

# 4. Setup environment
cp .env.example .env
# Edit file .env sesuai konfigurasi Anda

# 5. Buat database
mysql -u root -p -e "CREATE DATABASE wizdam CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Jalankan installer
php scripts/install.php

# 7. Start development server
php -S localhost:8000 -t public/

# Akses aplikasi di http://localhost:8000
```

### Instalasi Production (Shared Hosting)

Untuk deployment di shared hosting tanpa akses SSH:

1. Upload semua file via FTP/SFTP
2. Copy `.env.example` menjadi `.env` dan edit konfigurasi
3. Pastikan folder `storage/` dan `public/` writable
4. Akses domain Anda untuk menjalankan installer web-based

Lihat [docs/INSTALLATION.md](docs/INSTALLATION.md) untuk panduan lengkap.

---

## 📦 Fitur Utama

### Core Features
- ✅ Multi-publisher support (satu instalasi, banyak publisher)
- ✅ Workflow editorial fleksibel (submission → review → production → publish)
- ✅ Peer review management (blind, double-blind, open)
- ✅ User & role management dengan permission granular
- ✅ Notification system (email, in-app)
- ✅ Full-text search & indexing
- ✅ Statistics & analytics dashboard
- ✅ REST API untuk integrasi eksternal

### Technical Features
- ✅ PSR-4 autoloading dengan Composer
- ✅ Environment-based configuration (.env)
- ✅ Modular plugin system
- ✅ Template engine (Smarty 4+)
- ✅ Multi-language support (locale files)
- ✅ Theme customization
- ✅ Database migration system
- ✅ Caching layer (file, database, Redis-ready)

### Integrations
- ✅ Payment gateways (Midtrans, Xendit)
- ✅ ORCID integration
- ✅ CrossRef DOI registration
- ✅ Google Scholar indexing
- ✅ SWORD protocol for deposit
- ✅ OAI-PMH harvesting

---

## 📖 Dokumentasi

Dokumentasi lengkap tersedia di folder `docs/`:

| Dokumen | Deskripsi |
|---------|-----------|
| [INSTALLATION.md](docs/INSTALLATION.md) | Panduan instalasi lengkap (dev & production) |
| [ARCHITECTURE.md](docs/ARCHITECTURE.md) | Detail arsitektur & struktur direktori |
| [MIGRATION.md](docs/MIGRATION.md) | Migrasi dari OJS 2.x ke Wizdam 1.0 |
| [CONTRIBUTING.md](docs/CONTRIBUTING.md) | Panduan kontribusi developer |
| [API.md](docs/API.md) | REST API documentation |
| [PLUGINS.md](docs/PLUGINS.md) | Pengembangan plugin |
| [THEMING.md](docs/THEMING.md) | Panduan tema & template |
| [DEPLOYMENT.md](docs/DEPLOYMENT.md) | Best practices deployment |
| [SECURITY.md](docs/SECURITY.md) | Keamanan & hardening |

---

## 🔧 Development

### Struktur Kode

```php
// Contoh penggunaan namespace Wizdam
use Wizdam\Core\CoreApplication;
use Wizdam\Modules\db\DBConnection;
use Wizdam\App\Classes\publisher\AppPublisher;

// Inisialisasi aplikasi
$app = CoreApplication::getInstance();
$publisher = AppPublisher::getById(1);
```

### Running Tests

```bash
# Unit tests
vendor/bin/phpunit

# Integration tests
vendor/bin/phpunit --testsuite=integration

# Code style check
vendor/bin/phpcs --standard=PSR12 core/ app/
```

### Build Assets

```bash
# Compile CSS/JS
npm run build

# Watch untuk development
npm run dev
```

---

## 🤝 Kontribusi

Kami menyambut kontribusi dari komunitas! Lihat [CONTRIBUTING.md](docs/CONTRIBUTING.md) untuk:

- Cara setup development environment
- Coding standards (PSR-12)
- Proses pull request
- Bug reporting guidelines
- Feature request process

### Code of Conduct

Proyek ini mengikuti [Code of Conduct](docs/CODE_OF_CONDUCT.md) untuk memastikan lingkungan yang inklusif dan ramah.

---

## 📄 Lisensi

Wizdam Framework dilisensikan di bawah **GNU General Public License v3.0** (GPL-3.0).

Lihat file [LICENSE](LICENSE) untuk teks lengkap lisensi.

### Ringkasan Lisensi
- ✅ Bebas digunakan untuk keperluan komersial maupun non-komersial
- ✅ Bebas dimodifikasi dan didistribusikan
- ⚠️ Derivative work harus menggunakan lisensi yang sama (copyleft)
- ⚠️ Harus menyertakan sumber kode jika didistribusikan

---

## 👥 Tim & Komunitas

### Core Team
- Lead Developer: Wizdam Team
- Architecture: Wizdam Framework Team
- Documentation: Community Contributors

### Kontributor

Terima kasih kepada semua kontributor yang telah membantu mengembangkan Wizdam Framework!

[Lihat daftar kontributor lengkap](https://github.com/wizdam/framework/graphs/contributors)

---

## 🔗 Tautan Penting

- **Website Resmi**: https://wizdam.framework.id
- **Dokumentasi**: https://docs.wizdam.framework.id
- **Issue Tracker**: https://github.com/wizdam/framework/issues
- **Community Forum**: https://community.wizdam.framework.id
- **Packagist**: https://packagist.org/packages/wizdam/framework
- **Twitter**: @WizdamFramework
- **Discord**: https://discord.gg/wizdam

---

## 📬 Support

Butuh bantuan? 

- **Dokumentasi**: Cek [docs/](docs/) terlebih dahulu
- **Forum Komunitas**: https://community.wizdam.framework.id
- **GitHub Issues**: https://github.com/wizdam/framework/issues
- **Email Support**: support@wizdam.framework.id (untuk enterprise)

---

## 🙏 Acknowledgments

Wizdam Framework dibangun di atas fondasi yang diletakkan oleh:
- Public Knowledge Project (PKP) - OJS 2.x
- Komunitas open source global
- Berbagai library dan framework PHP modern

---

**Wizdam Framework 1.0** - *Empowering Publishers with Modern Technology*

© 2024 Wizdam Framework Team
