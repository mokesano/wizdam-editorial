# Arsitektur Wizdam Editorial 1.0

Dokumentasi lengkap tentang arsitektur, struktur direktori, dan desain sistem Wizdam Editorial.

---

## 📋 Daftar Isi

- [Overview](#overview)
- [Struktur Direktori](#struktur-direktori)
- [Kernel Framework](#kernel-framework)
- [Modules System](#modules-system)
- [Library Management](#library-management)
- [Application Layer](#application-layer)
- [Autoloading & Namespaces](#autoloading--namespaces)
- [Request Flow](#request-flow)

---

## Overview

Wizdam Editorial 1.0 dibangun dengan prinsip **Separation of Concerns** dan **Modular Design**, memisahkan dengan jelas antara:

1. **Core Engine** - Framework inti yang tidak bergantung pada bisnis logic spesifik
2. **Application Layer** - Logika bisnis spesifik untuk manajemen publikasi
3. **External Libraries** - Dependencies pihak ketiga yang dikelola via Composer

### Prinsip Desain

- **Publisher-Centric**: Mendukung multi-publisher, bukan hanya jurnal tunggal
- **Flat Structure**: Struktur direktori dangkal untuk kemudahan navigasi
- **PSR-4 Compliance**: Autoloading standar untuk interoperabilitas
- **Backward Compatibility Bridge**: Legacy support untuk migrasi bertahap

---

## Struktur Direktori

```
/workspace/
│
├── core/                          # WIZDAM FRAMEWORK ENGINE
│   ├── Kernel/                    # Inti framework (tidak boleh ada dependency ke app/)
│   │   ├── Core.inc.php           # Class utama CoreApplication
│   │   ├── CorePublisher.inc.php  # Entitas Publisher (multi-tenant)
│   │   ├── CoreRouter.inc.php     # Routing system
│   │   ├── CoreRequest.inc.php    # HTTP Request wrapper
│   │   ├── CoreResponse.inc.php   # HTTP Response handler
│   │   └── ...                    # Core utilities lainnya
│   │
│   ├── Modules/                   # Modul fungsional framework
│   │   ├── db/                    # Database abstraction layer
│   │   ├── form/                  # Form builder & validation
│   │   ├── user/                  # User management
│   │   ├── auth/                  # Authentication system
│   │   ├── file/                  # File management
│   │   ├── mail/                  # Email system
│   │   ├── security/              # Authorization & policies
│   │   └── ...                    # 59 modul lainnya
│   │
│   ├── Includes/                  # Bootstrap & global functions
│   │   ├── bootstrap.inc.php      # Application bootstrap
│   │   ├── functions.inc.php      # Helper functions (import(), dll)
│   │   └── fatalError.inc.php     # Error handler
│   │
│   ├── Library/                   # EXTERNAL LIBRARIES ONLY (FLAT)
│   │   ├── adodb/                 # Database abstraction (legacy)
│   │   ├── smarty/                # Template engine
│   │   ├── htmlpurifier/          # HTML sanitization
│   │   ├── guzzlehttp/            # HTTP client (Composer)
│   │   ├── vlucas/                # PHP-Dotenv (Composer)
│   │   ├── symfony/               # Symfony components (Composer)
│   │   ├── midtrans/              # Payment gateway
│   │   ├── xendit/                # Payment gateway
│   │   └── ...                    # Semua library flat, TANPA vendor/
│   │
│   └── Services/                  # Custom services
│       └── geo_location/          # GeoIP lookup service
│
├── app/                           # APPLICATION LAYER (Business Logic)
│   ├── Classes/                   # Business logic classes
│   │   ├── publisher/             # AppPublisher, Press management
│   │   ├── submission/            # Submission workflow
│   │   ├── review/                # Peer review system
│   │   ├── payment/               # Payment processing
│   │   └── ...                    # Domain-specific classes
│   │
│   ├── Pages/                     # Page controllers/handlers
│   │   ├── admin/                 # Admin pages
│   │   ├── dashboard/             # User dashboard
│   │   ├── article/               # Article viewing
│   │   └── ...                    # Route handlers
│   │
│   └── Services/                  # Application services
│       ├── Analytics/             # Analytics service
│       ├── Search/                # Search indexing
│       └── ...                    # Domain services
│
├── public/                        # WEB ROOT (hanya folder ini yang accessible)
│   ├── index.php                  # Main entry point
│   ├── ready.php                  # Alternative entry point
│   ├── css/                       # Compiled CSS
│   ├── js/                        # JavaScript assets
│   ├── images/                    # Static images
│   └── .htaccess                  # Apache rewrite rules
│
├── config/                        # CONFIGURATION
│   ├── config.TEMPLATE.inc.php    # Template konfigurasi
│   └── config.inc.php             # Active configuration (git-ignored)
│
├── resources/                     # VIEWS & LOCALIZATION
│   ├── templates/                 # Smarty templates
│   │   ├── frontend/              # Frontend themes
│   │   ├── backend/               # Admin backend
│   │   └── emails/                # Email templates
│   │
│   └── locale/                    # Translation files
│       ├── en_US/
│       ├── id_ID/
│       └── ...
│
├── database/                      # DATABASE MIGRATIONS
│   ├── migrations/                # Schema migrations
│   └── seeds/                     # Data seeders
│
├── storage/                       # RUNTIME STORAGE
│   ├── cache/                     # Compiled templates, data cache
│   ├── logs/                      # Application logs
│   ├── files/                     # User uploads
│   └── sessions/                  # Session files
│
├── plugins/                       # PLUGIN SYSTEM
│   ├── generic/                   # Generic plugins
│   ├── themes/                    # Theme plugins
│   ├── importexport/              # Import/export plugins
│   └── ...                        # Plugin categories
│
├── scripts/                       # COMMAND LINE SCRIPTS
│   ├── install.php                # Installer CLI
│   ├── migrate.php                # Migration runner
│   └── tools/                     # Maintenance tools
│
├── .env.example                   # Environment template
├── .gitignore                     # Git ignore rules
├── composer.json                  # PHP dependencies
├── package.json                   # Node.js dependencies
└── README.md                      # Project overview
```

---

## Kernel Framework

Folder `core/Kernel/` berisi inti framework yang **tidak bergantung** pada logika bisnis aplikasi.

### Komponen Utama

| File | Deskripsi |
|------|-----------|
| `CoreApplication.inc.php` | Singleton utama, bootstrap aplikasi |
| `CorePublisher.inc.php` | Manajemen entitas Publisher (multi-tenant) |
| `CoreRouter.inc.php` | Routing system (page, component, API) |
| `CoreRequest.inc.php` | HTTP Request wrapper |
| `CoreResponse.inc.php` | HTTP Response handler |
| `CoreSession.inc.php` | Session management |
| `CoreTemplateManager.inc.php` | Template engine integration |
| `CoreLocale.inc.php` | Internationalization system |

### Contoh Penggunaan

```php
use Wizdam\Core\CoreApplication;
use Wizdam\Core\CoreRequest;

// Get application instance
$app = CoreApplication::getInstance();

// Get current request
$request = $app->getRequest();

// Get publisher context
$publisher = $app->getPublisher($request);
```

---

## Modules System

Folder `core/Modules/` berisi modul-modul fungsional yang dapat digunakan oleh aplikasi.

### Kategori Modules

#### Data Access Layer
- `db/` - Database connection, DAO pattern
- `cache/` - Caching abstraction (file, database, Redis)

#### User Management
- `user/` - User entity, UserDAO
- `group/` - User groups & roles
- `session/` - Session handling

#### Content Management
- `submission/` - Submission workflow
- `file/` - File management
- `metadata/` - Metadata schemas

#### Security
- `security/authorization/` - Access policies
- `security/` - Authentication, encryption

#### UI Components
- `form/` - Form builder
- `controllers/` - Grid controllers
- `linkAction/` - Action links

#### System
- `config/` - Configuration management
- `i18n/` - Localization
- `log/` - Logging system
- `notification/` - Notification queue

### Contoh DAO Pattern

```php
use Wizdam\Modules\db\DBConnection;
use Wizdam\Modules\user\UserDAO;

// Get DAO instance
$userDao = new UserDAO();

// Retrieve user
$user = $userDao->getById($userId);

// Update user
$user->setDisplayName('New Name');
$userDao->update($user);
```

---

## Library Management

### Flat Structure Philosophy

`core/Library/` menggunakan struktur **FLAT** tanpa folder `vendor/` nested:

```
✅ BENAR:
core/Library/guzzlehttp/guzzle/
core/Library/vlucas/phpdotenv/
core/Library/adodb/

❌ SALAH:
core/Library/vendor/guzzlehttp/guzzle/
core/Library/vendor/vlucas/phpdotenv/
```

### Kategori Library

#### Legacy Libraries (Manual)
Library warisan yang belum memiliki Composer package:

| Library | Versi | Status |
|---------|-------|--------|
| ADOdb | 5.x | Akan diganti dengan Doctrine/DBAL |
| Smarty | 4.x | Template engine utama |
| HTMLPurifier | 4.x | HTML sanitization |

#### Composer Packages
Library modern yang dikelola Composer:

| Package | Purpose |
|---------|---------|
| `guzzlehttp/guzzle` | HTTP client |
| `vlucas/phpdotenv` | Environment variables |
| `symfony/console` | CLI commands |
| `symfony/http-foundation` | HTTP abstractions |
| `mpdf/mpdf` | PDF generation |
| `midtrans/midtrans-php` | Payment gateway |
| `xendit/xendit-php` | Payment gateway |

### Composer Configuration

```json
{
  "config": {
    "vendor-dir": "core/Library"
  },
  "autoload": {
    "psr-4": {
      "Wizdam\\Core\\": "core/Kernel/",
      "Wizdam\\Modules\\": "core/Modules/",
      "Wizdam\\App\\": "app/Domain/"
    },
    "classmap": [
      "core/Library/adodb/",
      "core/Library/smarty/"
    ]
  }
}
```

---

## Application Layer

Folder `app/` berisi logika bisnis spesifik aplikasi Wizdam.

### Naming Convention

| Legacy (OJS 2.x) | Modern (Wizdam 1.0) |
|------------------|---------------------|
| `PKPApplication` | `CoreApplication` |
| `PKPSite` | `CorePublisher` |
| `OJSSite` | `AppPublisher` |
| `Journal` | `Press` |
| `PKP*` classes | `Core*` classes |
| `OJS*` classes | `App*` classes |

### Architecture Layers

```
app/
├── Classes/           # Domain Logic
│   ├── publisher/     # Publisher business logic
│   ├── submission/    # Submission workflow
│   └── ...
│
├── Pages/             # Controllers (handle HTTP requests)
│   ├── admin/         # Admin panel
│   ├── dashboard/     # User dashboard
│   └── ...
│
└── Services/          # Application Services
    ├── Analytics/     # Analytics service
    └── ...
```

---

## Autoloading & Namespaces

### PSR-4 Mapping

| Namespace | Path | Purpose |
|-----------|------|---------|
| `Wizdam\Core\` | `core/Kernel/` | Framework core |
| `Wizdam\Modules\` | `core/Modules/` | Framework modules |
| `Wizdam\App\` | `app/Domain/` | Application classes |
| `App\` | `app/` | Application root |

### Legacy Import Function

Untuk backward compatibility, fungsi `import()` masih didukung:

```php
// Legacy style (masih bekerja)
import('classes.core.CoreApplication');
import('modules.db.DBConnection');

// Modern style (direkomendasikan)
use Wizdam\Core\CoreApplication;
use Wizdam\Modules\db\DBConnection;
```

Mapping fungsi `import()`:

```php
// core/Includes/functions.inc.php
function import($path) {
    $mapping = [
        'classes.' => 'Wizdam\\Modules\\',
        'core.' => 'Wizdam\\Core\\',
        // ... mapping lainnya
    ];
    
    // Convert legacy path to namespace
    foreach ($mapping as $old => $new) {
        if (strpos($path, $old) === 0) {
            $namespace = str_replace('.', '\\', $path);
            $namespace = str_replace($old, $new, $namespace);
            class_exists($namespace); // Trigger autoload
            return;
        }
    }
}
```

---

## Request Flow

### Alur Request HTTP

```
1. User mengakses URL
   ↓
2. public/index.php (entry point)
   ↓
3. Load .env (vlucas/phpdotenv)
   ↓
4. Load composer/autoload.php
   ↓
5. Include core/Includes/bootstrap.inc.php
   ↓
6. CoreApplication::initialize()
   ↓
7. CoreRouter::route($request)
   ↓
8. Page Handler (app/Pages/*)
   ↓
9. Business Logic (app/Domain/*)
   ↓
10. Database Query (via DAO)
    ↓
11. Template Rendering (Smarty)
    ↓
12. Response dikirim ke browser
```

### Entry Point Code

```php
// public/index.php

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// Load Composer autoloader
require_once __DIR__ . '/../core/Library/autoload.php';

// Bootstrap application
require_once __DIR__ . '/../core/Includes/bootstrap.inc.php';

// Initialize and run
CoreApplication::getInstance()->execute();
```

---

## Security Considerations

### Directory Protection

File `.htaccess` di folder sensitif:

```apache
# core/.htaccess
Deny from all

# config/.htaccess
<FilesMatch "\.(inc\.php|conf)$">
    Deny from all
</FilesMatch>

# storage/.htaccess
<FilesMatch "\.(php|phtml)$">
    Deny from all
</FilesMatch>
```

### Best Practices

1. **Input Validation**: Gunakan `Form` classes untuk validasi
2. **SQL Injection**: Selalu gunakan prepared statements via DAO
3. **XSS Prevention**: Output escaping otomatis di Smarty
4. **CSRF Protection**: Token validation di semua form POST
5. **Access Control**: Policy-based authorization di setiap handler

---

## Performance Optimization

### Caching Layers

```
Level 1: OPcache (PHP bytecode)
Level 2: Template cache (Smarty compiled)
Level 3: Data cache (file/database/Redis)
Level 4: HTTP cache (browser, CDN)
```

### Lazy Loading

Modules dan libraries di-load secara lazy saat dibutuhkan:

```php
// Tidak di-load sampai digunakan
$db = CoreApplication::getConnection(); // Lazy init
```

---

## Extensibility

### Plugin System

Wizdam mendukung plugin melalui hooks system:

```php
// Register hook
HookRegistry::register('ArticleView::display', function($hookName, $args) {
    $article = $args[0];
    $templateMgr = $args[1];
    
    // Modify output
    $templateMgr->assign('customData', getData($article));
});
```

### Service Providers

Extend functionality dengan service providers:

```php
class AnalyticsServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->singleton('analytics', function($app) {
            return new AnalyticsService();
        });
    }
}
```

---

© 2024 Wizdam Editorial Team
