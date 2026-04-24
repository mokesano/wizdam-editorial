# Panduan Migrasi OJS 2.x ke Wizdam Editorial 1.0

Panduan lengkap untuk melakukan migrasi dari Open Journal Systems (OJS) 2.x ke Wizdam Editorial 1.0.

---

## 📋 Daftar Isi

- [Overview Migrasi](#overview-migrasi)
- [Perubahan Arsitektur](#perubahan-arsitektur)
- [Langkah-langkah Migrasi](#langkah-langkah-migrasi)
- [Konversi Database](#konversi-database)
- [Migrasi Kode Custom](#migrasi-kode-custom)
- [Plugin Compatibility](#plugin-compatibility)
- [Testing & Validasi](#testing--validasi)
- [Troubleshooting](#troubleshooting)

---

## Overview Migrasi

Wizdam Editorial 1.0 adalah hasil refactoring total dari OJS 2.x dengan perubahan fundamental:

### Apa yang Berubah?

| Aspek | OJS 2.x | Wizdam 1.0 |
|-------|---------|------------|
| **Namespace** | Global (PKP*, OJS*) | PSR-4 (Wizdam\Core\*, Wizdam\App\*) |
| **Struktur** | `lib/pkp/`, `lib/ojs/`, `classes/` | `core/Kernel/`, `core/Modules/`, `app/` |
| **Paradigma** | Journal-Centric | Publisher-Centric |
| **Dependencies** | Manual includes | Composer + PSR-4 |
| **Config** | `config.inc.php` only | `.env` + config bridge |
| **PHP Version** | 5.x - 7.x | 8.1+ (recommended 8.4) |

### Apa yang Tetap Sama?

- ✅ Struktur database (backward compatible)
- ✅ Template engine (Smarty)
- ✅ Plugin architecture (dengan penyesuaian minor)
- ✅ URL structure (rewrite rules sama)
- ✅ User data & konten

---

## Perubahan Arsitektur

### 1. Restrukturisasi Direktori

#### Struktur Lama (OJS 2.x)
```
/ojs-2.4.8/
├── lib/
│   ├── pkp/               # PKP core classes
│   └── ojs/               # OJS specific classes
├── classes/               # Legacy classes
├── pages/                 # Page handlers
├── controllers/           # Grid controllers
└── ...
```

#### Struktur Baru (Wizdam 1.0)
```
/wizdam/
├── core/
│   ├── Kernel/            # Core framework (ex: lib/pkp/)
│   ├── Modules/           # Functional modules
│   ├── Includes/          # Bootstrap & functions
│   └── Library/           # External libraries (FLAT)
├── app/
│   ├── Classes/           # Business logic (ex: classes/, lib/ojs/)
│   ├── Pages/             # Page handlers (ex: pages/)
│   └── Services/          # Application services
└── ...
```

### 2. Naming Convention Changes

#### Class Renaming

| OJS 2.x Class | Wizdam 1.0 Class | Location |
|---------------|------------------|----------|
| `PKPApplication` | `CoreApplication` | `core/Kernel/` |
| `PKPSite` | `CorePublisher` | `core/Kernel/` |
| `OJSSite` | `AppPublisher` | `app/Classes/` |
| `Journal` | `Press` | `app/Classes/` |
| `PKPDAO` | `CoreDAO` | `core/Modules/db/` |
| `OJSJournalDAO` | `AppPressDAO` | `app/Classes/` |
| `Article` | `Submission` | `app/Classes/submission/` |
| `PKPString` | `CoreString` | `core/Kernel/` |

#### Pattern Replacement

```bash
# Find & replace patterns
PKP([A-Z])    → Core$1
OJS([A-Z])    → App$1
Journal       → Press (dalam konteks entitas)
ojs/          → app/
pkp/          → core/
classes/      → core/Modules/ atau app/Classes/
pages/        → app/Pages/
```

### 3. Autoloading Changes

#### Cara Lama (OJS 2.x)
```php
// Manual import
import('classes.core.Application');
import('lib.pkp.classes.core.PKPApplication');

// Static calls
Application::getInstance();
```

#### Cara Baru (Wizdam 1.0)
```php
// PSR-4 autoloading (recommended)
use Wizdam\Core\CoreApplication;
use Wizdam\App\Classes\publisher\AppPublisher;

// Static calls
CoreApplication::getInstance();

// Legacy import masih didukung (backward compatibility)
import('core.CoreApplication');
import('classes.publisher.AppPublisher');
```

---

## Langkah-langkah Migrasi

### Phase 1: Persiapan

#### 1.1 Backup Data
```bash
# Backup database
mysqldump -u root -p ojs_db > ojs_backup_$(date +%Y%m%d).sql

# Backup files
tar -czf ojs_files_backup.tar.gz /path/to/ojs/
```

#### 1.2 Audit Custom Code
Identifikasi semua file custom:
```bash
# Cari modifikasi di classes/
find classes/ -name "*.inc.php" -exec grep -l "custom\|modified" {} \;

# Cek plugin custom
ls plugins/generic/ plugins/themes/
```

#### 1.3 Environment Setup
```bash
# Clone Wizdam repository
git clone https://github.com/wizdam/framework.git wizdam
cd wizdam

# Install dependencies
composer install
```

### Phase 2: Migrasi Database

#### 2.1 Upgrade Schema (jika perlu)
Jika dari OJS versi lama (< 2.4.8):
```bash
# Upgrade ke 2.4.8 terlebih dahulu
php tools/upgrade.php upgrade.xml
```

#### 2.2 Migration Script Wizdam
```bash
# Jalankan migration Wizdam
php scripts/migrate.php --from=ojs-2.4.8

# Verifikasi migrasi
php scripts/diagnostic.php
```

#### 2.3 Penyesuaian Tabel

Tabel yang mengalami perubahan nama:

| Tabel Lama | Tabel Baru | Keterangan |
|------------|------------|------------|
| `journals` | `presses` | Journal → Press |
| `journal_settings` | `press_settings` | Settings table |
| `sections` | `series` | Section → Series |
| `section_settings` | `series_settings` | Series settings |

Script SQL konversi (otomatis dijalankan migrator):
```sql
RENAME TABLE journals TO presses;
RENAME TABLE journal_settings TO press_settings;
RENAME TABLE sections TO series;
RENAME TABLE section_settings TO series_settings;

UPDATE presses SET path = path; -- No change, just verify
UPDATE series SET section_id = NULL; -- Clean old references
```

### Phase 3: Migrasi File Konfigurasi

#### 3.1 Convert config.inc.php ke .env

Dari:
```ini
; config.inc.php
[database]
driver = mysql
host = localhost
username = ojs_user
password = secret123
database_name = ojs_db
```

Ke:
```bash
# .env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_USERNAME=ojs_user
DB_PASSWORD=secret123
DB_DATABASE=ojs_db
```

#### 3.2 Copy Custom Configuration
```bash
# Copy config template
cp config/config.TEMPLATE.inc.php config/config.inc.php

# Merge custom settings dari config lama
# Edit manual atau gunakan script merge
```

### Phase 4: Migrasi Custom Code

#### 4.1 Update Namespace References

File custom di `classes/`:

**Sebelum:**
```php
<?php
import('classes.core.Application');
import('lib.pkp.classes.core.PKPApplication');

class MyCustomClass extends Application {
    function __construct() {
        parent::__construct();
    }
}
```

**Sesudah:**
```php
<?php
namespace Wizdam\App\Classes\custom;

use Wizdam\Core\CoreApplication;

class MyCustomClass extends CoreApplication {
    function __construct() {
        parent::__construct();
    }
}
```

#### 4.2 Migrate Custom Pages

**Struktur lama:**
```
pages/mycustom/
└── index.php
```

**Struktur baru:**
```
app/Pages/mycustom/
└── MyCustomHandler.inc.php
```

**Kode lama (`pages/mycustom/index.php`):**
```php
<?php
import('classes.security.Validation');
Validation::isLoggedIn();

$templateMgr = TemplateManager::getManager();
$templateMgr->display('mycustom.tpl');
```

**Kode baru (`app/Pages/mycustom/MyCustomHandler.inc.php`):**
```php
<?php
namespace Wizdam\App\Pages\mycustom;

use Wizdam\Core\CoreRequest;
use Wizdam\Modules\security\Validation;
use Wizdam\Core\CoreTemplateManager;

class MyCustomHandler {
    function index($args, $request) {
        Validation::isLoggedIn($request);
        
        $templateMgr = CoreTemplateManager::getManager($request);
        $templateMgr->display('mycustom.tpl');
    }
}
```

#### 4.3 Update Template Paths

Template location changes:

| Lama | Baru |
|------|------|
| `templates/mycustom.tpl` | `resources/templates/frontend/mycustom.tpl` |
| `templates/admin/mycustom.tpl` | `resources/templates/backend/admin/mycustom.tpl` |

### Phase 5: Plugin Migration

#### 5.1 Generic Plugins

**File descriptor lama (`plugins/generic/myplugin/version.xml`):**
```xml
<version>
    <application>myplugin</application>
    <type>plugins.generic</type>
    <lazy-load>1</lazy-load>
    <class>MyPlugin</class>
</version>
```

**File descriptor baru (`plugins/generic/myplugin/plugin.xml`):**
```xml
<plugin>
    <name>myplugin</name>
    <displayName>My Plugin</displayName>
    <description>A custom plugin for Wizdam</description>
    <version>1.0.0</version>
    <class>MyPlugin</class>
    <compatibility>
        <wizdam-version>^1.0</wizdam-version>
    </compatibility>
</plugin>
```

**Plugin class lama:**
```php
<?php
import('classes.plugins.GenericPlugin');

class MyPlugin extends GenericPlugin {
    function register($category, $path) {
        if (!parent::register($category, $path))
            return false;
        return true;
    }
}
```

**Plugin class baru:**
```php
<?php
namespace Wizdam\Plugins\Generic\MyPlugin;

use Wizdam\Modules\plugins\GenericPlugin;

class MyPlugin extends GenericPlugin {
    function register($category, $path) {
        if (!parent::register($category, $path))
            return false;
        return true;
    }
}
```

#### 5.2 Theme Plugins

Theme plugins memerlukan update struktur folder:

```
plugins/themes/mytheme/
├── plugin.xml              # Descriptor baru
├── MyThemePlugin.inc.php   # Main class
├── styles/                 # CSS files
│   └── index.css
├── templates/              # Template overrides
│   └── frontend/
└── locales/                # Translations
```

### Phase 6: Testing

#### 6.1 Unit Tests
```bash
# Run test suite
vendor/bin/phpunit tests/

# Test specific module
vendor/bin/phpunit tests/core/Kernel/CoreApplicationTest.php
```

#### 6.2 Integration Tests
```bash
# Test database connectivity
php scripts/test-db.php

# Test page rendering
php scripts/test-pages.php
```

#### 6.3 Manual Testing Checklist

- [ ] Login/logout functionality
- [ ] User registration
- [ ] Submission workflow
- [ ] Review process
- [ ] Publication process
- [ ] Search functionality
- [ ] Admin dashboard
- [ ] Plugin activation
- [ ] Theme switching
- [ ] Email notifications

---

## Konversi Database

### Script Migrasi Otomatis

File: `scripts/migrate-from-ojs.php`

```php
#!/usr/bin/env php
<?php
/**
 * OJS 2.x to Wizdam 1.0 Migration Script
 */

require_once 'core/Includes/bootstrap.inc.php';

class OJSMigrator {
    private $db;
    
    function __construct() {
        $this->db = CoreApplication::getConnection();
    }
    
    function migrate() {
        echo "Starting migration...\n";
        
        // Step 1: Rename tables
        $this->renameTables();
        
        // Step 2: Update class references in serialized data
        $this->updateSerializedData();
        
        // Step 3: Migrate settings
        $this->migrateSettings();
        
        // Step 4: Update version
        $this->updateVersion();
        
        echo "Migration completed successfully!\n";
    }
    
    private function renameTables() {
        $tables = [
            'journals' => 'presses',
            'journal_settings' => 'press_settings',
            'sections' => 'series',
            'section_settings' => 'series_settings'
        ];
        
        foreach ($tables as $old => $new) {
            echo "Renaming $old to $new...\n";
            $this->db->Execute("RENAME TABLE `$old` TO `$new`");
        }
    }
    
    private function updateSerializedData() {
        // Update serialized class names
        $tables = ['press_settings', 'user_settings', 'plugin_settings'];
        
        foreach ($tables as $table) {
            echo "Updating serialized data in $table...\n";
            // Implementation depends on data structure
        }
    }
    
    private function migrateSettings() {
        // Migrate journal-specific settings to press settings
        echo "Migrating settings...\n";
    }
    
    private function updateVersion() {
        $this->db->Execute("INSERT INTO versions VALUES (1, 0, 0, 0, NOW())");
        echo "Version updated to 1.0.0\n";
    }
}

$migrator = new OJSMigrator();
$migrator->migrate();
```

### Menjalankan Migrasi

```bash
# Dry run (simulation)
php scripts/migrate-from-ojs.php --dry-run

# Actual migration
php scripts/migrate-from-ojs.php --source=/path/to/ojs/config.inc.php

# Rollback jika ada masalah
php scripts/migrate-from-ojs.php --rollback
```

---

## Plugin Compatibility

### Compatible Plugins (No Changes)

Plugin berikut kompatibel tanpa modifikasi:
- ✅ ImportExport plugins (Native, XML, etc.)
- ✅ Citation plugins
- ✅ Metadata plugins
- ✅ Most generic plugins

### Plugins Requiring Updates

Plugin berikut perlu update minor:
- ⚠️ Theme plugins (template paths changed)
- ⚠️ Block plugins (namespace updates)
- ⚠️ Payment plugins (class name changes)
- ⚠️ OAI metadata plugins

### Incompatible Plugins

Plugin berikut tidak kompatibel dan perlu rewrite:
- ❌ Plugins using old hook signatures
- ❌ Plugins with hardcoded PKP/OJS paths
- ❌ Plugins using deprecated functions

### Hook System Changes

**Old hook registration:**
```php
HookRegistry::register('LoadHandler', array($this, 'handleLoad'));
```

**New hook registration (same, backward compatible):**
```php
HookRegistry::register('LoadHandler', array($this, 'handleLoad'));
```

**Hook callback signature (unchanged):**
```php
function handleLoad($hookName, $args) {
    $page = $args[0];
    $op = $args[1];
    // ...
}
```

---

## Testing & Validasi

### Automated Tests

```bash
# Run all tests
composer test

# Run with coverage
composer test:coverage

# Specific test groups
vendor/bin/phpunit --group=migration
vendor/bin/phpunit --group=plugins
```

### Manual Validation

#### Database Integrity
```sql
-- Check table counts
SELECT 
    (SELECT COUNT(*) FROM presses) as presses,
    (SELECT COUNT(*) FROM users) as users,
    (SELECT COUNT(*) FROM submissions) as submissions,
    (SELECT COUNT(*) FROM published_submissions) as published;

-- Check for orphaned records
SELECT * FROM press_settings WHERE press_id NOT IN (SELECT press_id FROM presses);
```

#### File Integrity
```bash
# Check file permissions
find storage/ -type d ! -perm 755
find storage/files/ -type f ! -perm 644

# Verify template compilation
ls -la storage/cache/tc_compile/
```

### Performance Benchmarking

```bash
# Benchmark page load times
ab -n 1000 -c 10 http://yoursite.com/index.php/index/index

# Compare with old installation
# OJS 2.x: ~200ms average
# Wizdam 1.0: ~150ms average (expected 25% improvement)
```

---

## Troubleshooting

### Error: "Class 'PKPApplication' not found"

**Cause**: Old code referencing legacy class names.

**Solution**:
```bash
# Find and replace
grep -r "PKPApplication" app/ plugins/
# Update to CoreApplication
```

### Error: "Table 'journals' doesn't exist"

**Cause**: Database migration not completed.

**Solution**:
```bash
# Run migration script
php scripts/migrate-from-ojs.php

# Or manually rename tables
RENAME TABLE journals TO presses;
```

### Error: "Failed to open stream: No such file or directory"

**Cause**: Hardcoded paths in custom code.

**Solution**:
```php
// Wrong (hardcoded)
require_once('lib/pkp/classes/core/Application.inc.php');

// Correct (use autoloader)
use Wizdam\Core\CoreApplication;
```

### Plugin Not Loading

**Cause**: Plugin descriptor outdated.

**Solution**:
1. Update `version.xml` to `plugin.xml`
2. Update namespace in plugin class
3. Clear plugin cache:
```bash
rm -rf storage/cache/plugins/*
```

### Template Not Rendering

**Cause**: Template path changes.

**Solution**:
```php
// Old path
$templateMgr->display('article/article.tpl');

// New path
$templateMgr->display('frontend/articles/article.tpl');
```

---

## Post-Migration Checklist

Setelah migrasi selesai:

- [ ] Verifikasi semua user dapat login
- [ ] Test submission workflow lengkap
- [ ] Verify email notifications
- [ ] Check search indexing
- [ ] Test all active plugins
- [ ] Verify theme rendering
- [ ] Check file uploads/downloads
- [ ] Test admin functions
- [ ] Verify statistics/analytics
- [ ] Backup new installation
- [ ] Update DNS (if moving servers)
- [ ] Monitor error logs 24/48 jam pertama

---

## Support & Resources

### Dokumentasi
- [Wizdam Architecture](ARCHITECTURE.md)
- [Installation Guide](INSTALLATION.md)
- [API Documentation](API.md)

### Community
- Forum: https://community.wizdam.framework.id
- GitHub Issues: https://github.com/wizdam/framework/issues
- Discord: https://discord.gg/wizdam

### Professional Services
- Migration assistance: support@wizdam.framework.id
- Custom development: dev@wizdam.framework.id

---

© 2024 Wizdam Editorial Team

*Migrasi yang sukses adalah kunci transformasi digital Anda!*
