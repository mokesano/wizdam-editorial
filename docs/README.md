# 📰 Wizdam Editorial 1.0

### Platform Manajemen Editorial & Penerbitan Ilmiah Modern

**Wizdam Editorial** adalah platform open‑source untuk manajemen editorial dan penerbitan ilmiah yang dibangun dengan arsitektur **Publisher‑Centric** modern, fleksibel, dan skalabel.

> *“Empowering Publishers with Modern Technology”*

---

<p align="center">
  <a href="https://github.com/mokesano/wizdam-editorial">
    <img src="https://img.shields.io/badge/PHP-^8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  </a>
  <a href="https://github.com/mokesano/wizdam-editorial/blob/main/docs/LICENSE">
    <img src="https://img.shields.io/badge/license-GPL%203.0--only-blue?style=for-the-badge" alt="License">
  </a>
  <a href="https://packagist.org/packages/wizdam/wizdam-editorial">
    <img src="https://img.shields.io/badge/packagist-wizdam%2Fwizdam--editorial-F28D1A?style=for-the-badge&logo=packagist&logoColor=white" alt="Packagist">
  </a>
  <a href="https://github.com/mokesano/wizdam-editorial/actions">
    <img src="https://img.shields.io/badge/build-passing-brightgreen?style=for-the-badge&logo=github-actions&logoColor=white" alt="Build Status">
  </a>
  <a href="https://github.com/mokesano/wizdam-editorial/security/advisories">
    <img src="https://img.shields.io/badge/security-policy-important?style=for-the-badge&logo=github" alt="Security Policy">
  </a>
  <a href="https://github.com/mokesano/wizdam-editorial/releases">
    <img src="https://img.shields.io/badge/release-v1.0.0--alpha-lightgrey?style=for-the-badge" alt="Release">
  </a>
</p>

<br>

<p align="center">
  <em>📄 Submission → 👀 Review → 🏭 Production → 📡 Publish</em>
</p>

---

## 📖 Tentang Wizdam Editorial

Wizdam Editorial 1.0 merupakan hasil **refactoring dan modernisasi total** dari basis kode **OJS 2.x**, dirancang ulang dengan prinsip‑prinsip pengembangan perangkat lunak terkini. Platform ini mengubah paradigma dari *Journal‑Centric* menjadi **Publisher‑Centric**, memungkinkan satu instalasi menaungi banyak penerbit (*multi‑publisher*) – bukan hanya banyak jurnal.

Dibangun di atas fondasi **Wizdam Kernel**, platform ini memisahkan secara jelas antara *Core Engine*, *Modules*, dan *Library Eksternal*, serta mengadopsi standar industri seperti Composer, PSR‑4 Autoloading, dan konfigurasi berbasis environment variable (`.env`). Hasilnya adalah sistem yang **ringkas, mudah dipahami, dan siap produksi**.

---

## ✨ Mengapa Wizdam Editorial?

| 🔧 Aspek | 🟡 OJS 2.x (Legacy) | 🟢 Wizdam 1.0 (Modern) |
| :--- | :--- | :--- |
| **Struktur** | `lib/pkp/`, `lib/ojs/`, `classes/` | **Flat & Modular**: `core/Kernel/`, `core/Modules/`, `app/` |
| **Paradigma** | Journal‑Centric (`Journal`, `Site`) | **Publisher‑Centric** (`Press`, `CorePublisher`) |
| **Dependencies** | Manual includes | **Composer + PSR‑4 Autoloading** |
| **Konfigurasi** | `config.inc.php` saja | **`.env`** + config bridge |
| **Library** | Nested `vendor/` | **Flat structure** di `core/Library/` |
| **PHP** | ≤ 7.x | **≥ 8.4** (native type‑safe) |

---

## 🚀 Quick Start

### 🔧 Prasyarat

| Perangkat Lunak | Versi Minimum |
| :--- | :--- |
| **PHP** | 8.1+ (direkomendasikan **8.4**) |
| **Database** | MySQL 5.7+ / MariaDB 10.3+ / PostgreSQL 11+ |
| **Composer** | 2.x |
| **Node.js** | 18+ (untuk kompilasi asset) |
| **Web Server** | Apache / Nginx dengan `mod_rewrite` |

### 💻 Instalasi Development

```bash
# 1. Clone repository
git clone https://github.com/mokesano/wizdam-editorial.git
cd wizdam-editorial

# 2. Install dependencies PHP
composer install

# 3. Install dependencies Node (opsional, untuk kompilasi asset)
npm install

# 4. Setup environment
cp .env.example .env
# ✏️ Edit file .env sesuai konfigurasi Anda

# 5. Buat database
mysql -u root -p -e "CREATE DATABASE wizdam CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Jalankan installer
php scripts/install.php

# 7. Start development server
php -S localhost:8000 -t public/

# 🌐 Akses aplikasi di http://localhost:8000
```

### 🌍 Instalasi Production (Shared Hosting)

1. Upload semua file via FTP/SFTP
2. Copy `.env.example` menjadi `.env` dan edit konfigurasi
3. Pastikan folder `storage/` dan `public/` **writable**
4. Akses domain Anda untuk menjalankan installer web‑based

> 📘 Panduan lengkap: [docs/INSTALLATION.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/INSTALLATION.md)

---

## 🧩 Fitur Utama

### 📋 Fitur Editorial

| Fitur | Deskripsi |
| :--- | :--- |
| 🏢 **Multi‑Publisher** | Satu instalasi, banyak penerbit — bukan hanya banyak jurnal |
| 🔄 **Workflow Fleksibel** | Submission → Review → Production → Publish |
| 👥 **Peer Review** | Blind, Double‑Blind, dan Open Review |
| 👤 **User & Role** | Manajemen pengguna dengan permission granular |
| 🔔 **Notifikasi** | Email dan in‑app notification |
| 📊 **Statistik** | Dashboard analytics & reporting |
| 🔍 **Search** | Full‑text search & indexing |

### ⚙️ Fitur Teknis

| Fitur | Deskripsi |
| :--- | :--- |
| 📦 **PSR‑4 Autoloading** | Composer‑based, struktur namespace modern |
| 🌐 **REST API** | Integrasi eksternal via API endpoint |
| 🧩 **Plugin System** | Arsitektur plugin modular |
| 🎨 **Template Engine** | Smarty 5+ untuk tampilan |
| 🌍 **Multi‑Language** | Dukungan penuh via locale files |
| 🗄️ **Database Migration** | Sistem migrasi database terintegrasi |
| ⚡ **Caching** | File, database, dan Redis‑ready |

### 🔗 Integrasi

| Integrasi | Deskripsi |
| :--- | :--- |
| 💳 **Payment Gateway** | Midtrans, Xendit |
| 🆔 **ORCID** | Integrasi identitas peneliti |
| 📄 **CrossRef DOI** | Registrasi DOI otomatis |
| 🎓 **Google Scholar** | Optimasi indexing |
| 📡 **SWORD** | Protocol deposit |
| 🌾 **OAI‑PMH** | Metadata harvesting |

---

## 🏗️ Sekilas Arsitektur

Wizdam Editorial mengadopsi arsitektur **layered modular** yang memisahkan *core engine*, *business logic*, dan *presentation layer*:

```
Core Kernel   →   App Domain   →   Pages / API
( Framework )     ( Business )     ( Presentation )
```

| Layer | Deskripsi |
| :--- | :--- |
| **Core Kernel** | Inti framework: `CoreApplication`, `CoreRouter`, dll. |
| **Core Modules** | Modul fungsional: Database, Form, User, Auth, dll. |
| **App Domain** | Logika bisnis: Submission, Publisher, Review, dll. |
| **App Pages** | Request handler untuk halaman web |
| **Plugins** | Sistem plugin yang dapat diperluas |
| **Themes** | Template Smarty untuk kustomisasi tampilan |

> 🧠 Detail lengkap: [docs/ARCHITECTURE.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/ARCHITECTURE.md)

---

## 💻 Contoh Penggunaan

```php
<?php

use Wizdam\Core\CoreApplication;
use Wizdam\App\Domain\publisher\AppPublisher;
use Wizdam\App\Domain\submission\AppSubmission;

// Inisialisasi aplikasi
$app = CoreApplication::getInstance();

// Ambil data publisher
$publisher = AppPublisher::getById(1);
echo "Penerbit: {$publisher->getName()}\n";

// Buat submission baru
$submission = new AppSubmission();
$submission->setTitle('Judul Artikel');
$submission->setPublisherId(1);
$submission->save();

echo "✅ Submission berhasil dibuat dengan ID: {$submission->getId()}";
```

---

## 🧪 Development & Testing

```bash
# Unit tests
vendor/bin/phpunit

# Integration tests
vendor/bin/phpunit --testsuite=integration

# Code style check (PSR-12)
vendor/bin/phpcs --standard=PSR12 core/ app/

# Static analysis
vendor/bin/phpstan analyse --level max core/ app/

# Compile assets
npm run build

# Watch mode untuk development
npm run dev
```

---

## 📚 Dokumentasi

Dokumentasi lengkap tersedia di folder `docs/`:

| Dokumen | Deskripsi |
| :--- | :--- |
| [INSTALLATION.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/INSTALLATION.md) | Panduan instalasi lengkap (dev & production) |
| [ARCHITECTURE.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/ARCHITECTURE.md) | Detail arsitektur & struktur direktori |
| [MIGRATION.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/MIGRATION.md) | Migrasi dari OJS 2.x ke Wizdam 1.0 |
| [CONTRIBUTING.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/CONTRIBUTING.md) | Panduan kontribusi developer |
| [API.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/API.md) | REST API documentation |
| [PLUGINS.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/PLUGINS.md) | Pengembangan plugin |
| [THEMING.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/THEMING.md) | Panduan tema & template |
| [DEPLOYMENT.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/DEPLOYMENT.md) | Best practices deployment |
| [SECURITY.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/SECURITY.md) | Keamanan & hardening |

---

## 🤝 Kontribusi

Kami menyambut kontribusi dari komunitas! Lihat [CONTRIBUTING.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/CONTRIBUTING.md) untuk:

* Cara setup development environment
* Coding standards (**PSR‑12**)
* Proses pull request
* Bug reporting guidelines
* Feature request process

### Code of Conduct

Proyek ini mengikuti [Code of Conduct](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/CODE_OF_CONDUCT.md) untuk memastikan lingkungan yang inklusif dan ramah.

---

## 🔒 Keamanan

Keamanan adalah prioritas utama. **Jangan mengumbar kerentanan secara publik.**

* **Pelaporan**: Kirim laporan kerentanan ke [security@sangia.org](mailto:security@sangia.org)
* **Respons**: Pengelola utama akan merespons dalam **48 jam**
* **Advisori**: Dipublikasikan di [GitHub Security Advisories](https://github.com/mokesano/wizdam-editorial/security/advisories)

Detail lengkap: [SECURITY.md](https://github.com/mokesano/wizdam-editorial/blob/main/docs/docs/SECURITY.md)

---

## 📄 Lisensi

Wizdam Editorial dilisensikan di bawah **GNU General Public License v3.0** (GPL‑3.0). Lihat [LICENSE](https://github.com/mokesano/wizdam-editorial/blob/main/docs/LICENSE) untuk teks lengkap.

| Izin | Ketentuan |
| :--- | :--- |
| ✅ Bebas digunakan (komersial & non‑komersial) | ⚠️ Derivative work harus pakai lisensi yang sama (*copyleft*) |
| ✅ Bebas dimodifikasi & didistribusikan | ⚠️ Harus menyertakan kode sumber jika didistribusikan |

---

## 🌐 Tautan Penting

| 🔗 Tautan | Deskripsi |
| :--- | :--- |
| [Website Resmi](https://wizdam.sangia.org/) | Halaman utama Wizdam Platform |
| [Dokumentasi](https://docs.wizdam.sangia.org/) | Dokumentasi online |
| [Issue Tracker](https://github.com/mokesano/wizdam-editorial/issues) | Laporkan bug atau usulkan fitur |
| [Community Forum](https://community.wizdam.sangia.org/) | Diskusi komunitas |
| [Packagist](https://packagist.org/packages/wizdam/wizdam-editorial) | Paket Composer |
| [Demo Jurnal](https://journals.sangia.org/) | Contoh jurnal yang menggunakan Wizdam |

---

## 🙏 Ucapan Terima Kasih

Wizdam Editorial dibangun di atas fondasi yang diletakkan oleh:

| 🏷️ Atribusi | 🔗 Referensi |
| :--- | :--- |
| **Public Knowledge Project (PKP)** | [OJS 2.x](https://pkp.sfu.ca/ojs/) — sistem manajemen jurnal open‑source |
| **Sangia Publishing House** | [journals.sangia.org](https://journals.sangia.org/) |
| **Komunitas Open Source** | Berbagai library dan framework PHP modern |
| **Lead Developer** | [Rochmady (mokesano)](https://github.com/mokesano) |
| **Tim Wizdam** | [Wizdam Archon](https://github.com/archoun) |

---

## ⭐ Kontributor

Terima kasih kepada semua kontributor yang telah membantu mengembangkan Wizdam Editorial!

<a href="https://github.com/mokesano/wizdam-editorial/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=mokesano/wizdam-editorial" alt="Contributors" />
</a>

---

<p align="center">
  <br>
  <sub>Dibangun dengan ❤️ untuk memajukan penerbitan ilmiah Indonesia dan dunia</sub>
  <br><br>
  <a href="https://github.com/mokesano/wizdam-editorial/stargazers">
    <img src="https://img.shields.io/github/stars/mokesano/wizdam-editorial?style=social" alt="GitHub Stars">
  </a>
  <a href="https://github.com/mokesano/wizdam-editorial/network/members">
    <img src="https://img.shields.io/github/forks/mokesano/wizdam-editorial?style=social" alt="GitHub Forks">
  </a>
  <br><br>
  <sub>© 2025–2026 Rochmady & Wizdam Editorial Team. Dilisensikan di bawah GPL‑3.0.</sub>
</p>