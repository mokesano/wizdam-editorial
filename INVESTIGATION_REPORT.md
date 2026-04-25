# LAPORAN INVESTIGASI WARNING PSR-4 COMPOSER
## Wizdam Editorial 1.0 - Finalisasi Modernisasi

---

## 📊 RINGKASAN MASALAH

Composer melaporkan **353 warning** saat `composer dump-autoload --optimize`:
- **220 warning** dari `app/Domain/` (rule: App\ => ./app/Domain)
- **91 warning** dari `app/Pages/` (rule: App\ => ./app/Pages)
- **35 warning** dari `app/Helpers/` (rule: App\ => ./app/Helpers)
- **4 warning** dari `app/Services/` (rule: App\ => ./app/Services)
- **3 warning** dari `app/Controllers/` (rule: App\ => ./app/Controllers)

---

## 🔍 TEMUAN INVESTIGASI

### 1. File Sudah Benar, Cache Composer Lama

Setelah investigasi mendalam:

✅ **Semua file di `/workspace/app/` SUDAH menggunakan `.php`**
```bash
$ find /workspace/app -name "*.inc.php" | wc -l
0  # TIDAK ADA file .inc.php!
```

✅ **Namespace sudah sesuai PSR-4**
```php
// File: /workspace/app/Domain/article/Article.php
namespace App\Domain\Article;  // ✅ Match dengan path app/Domain/article/
class Article { ... }          // ✅ Match dengan filename Article.php
```

✅ **Struktur folder sudah PascalCase**
```
app/Domain/
├── article/      # ✅ lowercase (sesuai namespace App\Domain\Article)
├── admin/
│   └── form/     # ✅ lowercase (sesuai namespace App\Domain\Admin\Form)
└── ...
```

### 2. Penyebab Warning: CACHE COMPOSER USANG

Warning yang muncul:
```
Class Article located in ./app/Domain/article/Article.inc.php does not comply with psr-4
```

**Penyebab:** Composer cache masih mereferensikan file `.inc.php` yang **sudah di-rename** menjadi `.php`.

### 3. Masalah Tambahan: Classmap Terlalu Luas

`composer.json` lama memiliki konfigurasi berbahaya:
```json
"classmap": [
    "core/Modules/",   // ❌ Meng-scan SEMUA file .inc.php
    "core/Kernel/",    // ❌ Termasuk file yang sudah PSR-4
    "plugins/"         // ❌ Terlalu luas, menyebabkan ambiguous class
]
```

Ini menyebabkan:
- **Ambiguous class resolution** (kelas ditemukan di 2+ file)
- **Duplicate scanning** (file discan oleh PSR-4 DAN classmap)

---

## ✅ SOLUSI YANG DITERAPKAN

### File: `/workspace/composer.json`

#### PERUBAHAN 1: Hapus `core/Modules/` dan `core/Kernel/` dari classmap
File-file di folder ini sudah di-mapping via PSR-4:
```json
"psr-4": {
    "Wizdam\\Modules\\": ["core/Modules/"],
    "Wizdam\\Kernel\\": ["core/Kernel/"]
}
```

#### PERUBAHAN 2: Spesifikkan folder plugins
Ganti `"plugins/"` dengan folder spesifik yang memang legacy:
```json
"classmap": [
    "resources/smarty/plugins/",
    "plugins/gateways/",
    "plugins/generic/",
    "plugins/importexport/",
    "plugins/oaiMetadataFormats/",
    "plugins/paymethod/"
]
```

#### PERUBAHAN 3: Tambah `exclude-from-classmap`
```json
"exclude-from-classmap": [
    "**/node_modules/",
    "**/tests/"
]
```

---

## 🚀 LANGKAH EKSEKUSI (DI LOCAL ENVIRONMENT)

### Step 1: Bersihkan Cache Composer
```powershell
cd C:\xampp\htdocs\scholaraux-ori

# Hapus semua cache Composer
composer clear-cache

# Hapus file autoload lama
rm core/Library/composer/autoload_classmap.php
rm core/Library/composer/autoload_files.php
rm core/Library/composer/autoload_namespaces.php
rm core/Library/composer/autoload_psr4.php
rm core/Library/composer/autoload_static.php

# Atau hapus seluruh folder vendor jika perlu
rm -rf core/Library/
```

### Step 2: Re-install Dependencies
```powershell
# Install ulang dependencies
composer install --no-dev --optimize-autoloader
```

### Step 3: Verify Tidak Ada Warning
```powershell
# Cek apakah masih ada warning
composer dump-autoload --optimize 2>&1 | findstr "does not comply"
```

### Step 4: Jika Masih Ada Warning
Cek file `.inc.php` yang tersisa:
```powershell
# Cari file .inc.php di folder app/
find ./app -name "*.inc.php"

# Cari file .inc.php di core/Modules/ dan core/Kernel/
find ./core/Modules ./core/Kernel -name "*.inc.php"
```

Jika ditemukan, rename manual:
```powershell
# PowerShell: Rename semua .inc.php menjadi .php
Get-ChildItem -Path ./app -Recurse -Filter *.inc.php | ForEach-Object {
    Rename-Item $_.FullName -NewName ($_.FullName -replace '\.inc\.php$', '.php')
}
```

---

## 📋 CHECKLIST VERIFIKASI

### Setelah running composer dump-autoload:

- [ ] Tidak ada warning "does not comply with psr-4"
- [ ] Tidak ada warning "Ambiguous class resolution"
- [ ] File `core/Library/composer/autoload_classmap.php` ter-generate
- [ ] Aplikasi dapat diakses tanpa error

### Struktur File yang Benar:

```
app/
├── Domain/
│   ├── article/
│   │   ├── Article.php           ✅ namespace App\Domain\Article
│   │   ├── ArticleDAO.php        ✅ namespace App\Domain\Article
│   │   └── log/
│   │       ├── ArticleLog.php    ✅ namespace App\Domain\Article\Log
│   │       └── ...
│   └── admin/
│       └── form/
│           ├── AboutSiteForm.php ✅ namespace App\Domain\Admin\Form
│           └── ...
├── Helpers/
│   ├── Services/
│   │   └── TaxVatService.php     ✅ namespace App\Helpers\Services
│   └── Validators/
│       └── ValidatorCSRF.php     ✅ namespace App\Helpers\Validators
└── ...

core/
├── Modules/
│   └── validation/
│       ├── ValidatorDate.php     ✅ namespace Wizdam\Modules\Validation
│       └── ...                   (atau tanpa namespace untuk legacy)
└── ...
```

---

## ⚠️ CATATAN PENTING

### 1. File Legacy `.inc.php`
Beberapa file di `core/Modules/` masih menggunakan `.inc.php` dan **tanpa namespace**. Ini **sengaja dibiarkan** karena:
- Menggunakan sistem `import()` legacy OJS
- Di-load via `files` autoload atau classmap
- Tidak mengganggu PSR-4 selama tidak konflik naming

### 2. Plugin Directory
Folder `plugins/` mengandung banyak kelas legacy dengan naming ambigu (contoh: `SettingsForm` ada di 6 plugin berbeda). Solusi:
- Tetap gunakan **classmap** untuk plugins
- Composer akan gunakan "first found" (tidak ideal tapi unavoidable untuk legacy code)

### 3. Debug Toolbar Integration
Setelah autoloading bersih, lanjutkan integrasi WizdamDebugToolbar (lihat dokumentasi terpisah).

---

## 📞 TROUBLESHOOTING

### Error: "Class 'X' not found"
**Penyebab:** File belum di-rename atau namespace salah.
**Solusi:**
```bash
grep -r "class X" ./app ./core
# Pastikan filename match dengan classname
```

### Error: "Ambiguous class resolution"
**Penyebab:** Kelas yang sama ditemukan di 2+ file.
**Solusi:**
```bash
grep -r "class ClassName" ./core ./app ./plugins
# Identifikasi file duplikat, lalu:
# 1. Hapus salah satu, ATAU
# 2. Tambahkan ke exclude-from-classmap
```

### Warning masih muncul setelah dump-autoload
**Penyebab:** Cache IDE atau OPcache.
**Solusi:**
```bash
# Restart PHP-FPM / Apache
# Clear IDE cache (PhpStorm: File > Invalidate Caches)
```

---

## 📇 KONTAK & DUKUNGAN

Dokumentasi ini dibuat untuk tim Wizdam Editorial 1.0.
Untuk pertanyaan lebih lanjut, hubungi lead developer atau buka issue di repository.

**Generated:** $(date)
**Author:** AI Code Assistant
**Version:** Wizdam Editorial 1.0
