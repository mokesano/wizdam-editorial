# Wizdam Platform - Legacy Libraries Migration

## Overview
This document describes the migration from legacy manual libraries to Composer/NPM managed dependencies.

## Migrated Libraries

### PHP Libraries (Composer)

| Library | Old Version | New Version | Package Name | Status |
|---------|-------------|-------------|--------------|--------|
| **ADOdb** | 4.90 (2006) | 5.21+ | `adodb/adodb-php` | ✅ Migrated |
| **Smarty** | 2.6.31 (2008) | 4.x | `smarty/smarty` | ✅ Migrated |
| **HTMLPurifier** | 4.x | 4.17+ | `ezyang/htmlpurifier` | ✅ Migrated |
| **lessphp** | Legacy | 3.x | `wikimedia/less.php` | ✅ Migrated |
| **SimplePie** | 1.x (bundled) | 1.6+ | `simplepie/simplepie` | ✅ Migrated |
| **phpUtf8** | Legacy | - | `symfony/polyfill-mbstring` | ✅ Replaced |
| **pqp** | Debug Tool | - | `symfony/var-dumper` | ✅ Replaced |
| **SwordAppv2** | Legacy | Check compatibility | Manual/Separate | ⚠️ Review Needed |

### JavaScript Libraries (NPM)

| Library | Old Version | New Version | Package Name | Status |
|---------|-------------|-------------|--------------|--------|
| **TinyMCE** | 3.x (legacy) | 6.x | `tinymce/tinymce` | ✅ NPM Build |

### Custom Libraries

| Library | Description | Status |
|---------|-------------|--------|
| **JatsEngine** | JATS XML Parser/Builder for Wizdam | ✅ Composer Package Ready |

## Installation Instructions

### For Development (with Composer & NPM)

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies and build assets
npm install
# This will automatically run the build script to copy TinyMCE

# Verify installation
composer dump-autoload --optimize
```

### For Production (Shared Hosting - No SSH)

1. **Pre-built Package**: Download the complete package including `core/Library/` with all dependencies already installed.
2. **Upload**: Upload all files to your hosting via FTP/cPanel.
3. **Configure**: Copy `.env.example` to `.env` and adjust settings.
4. **Install**: Access `yourdomain.com/public/index.php` to complete installation.

**Note**: The production package includes the `core/Library/` folder with all Composer dependencies pre-installed, so no `composer install` command is needed on the server.

## JatsEngine Custom Package

The JatsEngine library has been converted to a proper Composer package:

### Structure
```
core/Library/JatsEngine/
├── composer.json      # Package definition
├── src/               # PSR-4 autoloaded code
│   ├── Builders/
│   └── Parsers/
└── ...
```

### To Use as Separate Package

1. **Publish to GitHub**:
   ```bash
   cd core/Library/JatsEngine
   git init
   git add .
   git commit -m "Initial release"
   git remote add origin https://github.com/wizdam/jats-engine.git
   git push -u origin main
   ```

2. **Register on Packagist**: Visit https://packagist.org and submit your GitHub repository.

3. **Update Main composer.json**:
   ```json
   {
     "repositories": [
       {
         "type": "vcs",
         "url": "https://github.com/wizdam/jats-engine"
       }
     ],
     "require": {
       "wizdam/jats-engine": "^1.0"
     }
   }
   ```

## Breaking Changes & Migration Notes

### Smarty 2.x → 4.x
- `{php}` tags are **removed** in Smarty 4+. Use custom plugins or logic in PHP.
- Some deprecated functions may need updating.
- Template syntax remains largely compatible.

### ADOdb 4.x → 5.x
- Minor API changes, check for deprecated methods.
- Improved PHP 8.x compatibility.

### HTMLPurifier
- Namespace changed to `HTMLPurifier` (PSR-4 compliant).
- Update include paths if using manual requires.

### SimplePie
- Moved to proper namespace `SimplePie\`.
- Update plugin code to use Composer autoloader.

### phpUtf8 → Symfony Polyfill
- Replace `utf8_*` functions with `mb_*` equivalents.
- Example: `utf8_strlen()` → `mb_strlen()`

### pqp → Symfony VarDumper
- Replace `d()` or `pq()` calls with `dd()` or `dump()`.
- Better debugging experience with Symfony VarDumper.

## File Cleanup

The following folders have been **removed** from `core/Library/`:
- ❌ `adodb/` (now via Composer)
- ❌ `smarty/` (now via Composer)
- ❌ `htmlpurifier/` (now via Composer)
- ❌ `lessphp/` (now via Composer)
- ❌ `phputf8/` (replaced by Symfony)
- ❌ `pqp/` (replaced by Symfony VarDumper)
- ❌ `swordappv2/` (to be reviewed)

The following folders remain as **custom/local**:
- ✅ `JatsEngine/` (being converted to package)
- ✅ Payment gateways (`midtrans/`, `xendit/`) - custom integration
- ✅ Other custom libraries

## Verification

After installation, verify with:

```bash
# Check Composer autoload
composer dump-autoload --optimize

# Test PHP syntax
find core/ app/ -name "*.php" -exec php -l {} \;

# Run tests (if available)
composer test
```

## Support

For issues related to this migration:
- GitHub Issues: https://github.com/wizdam/wizdam/issues
- Documentation: https://docs.wizdam.sangia.org/
