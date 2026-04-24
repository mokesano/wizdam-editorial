# Wizdam Platform - Setup Instructions

## Quick Start

### For Developers (Local Development)

Prerequisites:
- PHP 8.4+
- Composer 2.x
- Node.js 18+ and NPM

```bash
# Clone the repository
git clone https://github.com/wizdam/wizdam.git
cd wizdam

# Install PHP dependencies
composer install

# Install JavaScript dependencies and build assets
npm install

# Copy environment file
cp .env.example .env

# Configure your database in .env file
# DB_HOST=localhost
# DB_DATABASE=wizdam
# DB_USERNAME=root
# DB_PASSWORD=secret

# Set proper permissions
chmod -R 775 storage/
chmod -R 775 public/

# Access via browser
# http://localhost/public/index.php
```

### For Production (Shared Hosting - No SSH/Composer)

**Option 1: Pre-built Package (Recommended)**

1. Download the complete release package from GitHub Releases (includes all dependencies).
2. Upload all files to your hosting via FTP/cPanel File Manager.
3. Ensure `core/Library/` folder is uploaded completely (contains all Composer dependencies).
4. Copy `.env.example` to `.env` and edit with your database credentials.
5. Set folder permissions:
   - `storage/` → 775 or 777
   - `public/` → 755
   - `config/` → 644
6. Access `yourdomain.com/public/index.php` to start installation.

**Option 2: Build Locally, Deploy to Server**

1. On your local machine with Composer:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install --production
   npm run build
   ```

2. Upload the entire project including `core/Library/` folder to your server.

3. Configure `.env` file on the server.

4. Access the installation wizard.

## Folder Structure

```
wizdam/
├── app/                    # Application business logic
├── core/
│   ├── Kernel/            # Core framework classes
│   ├── Modules/           # Framework modules
│   ├── Includes/          # Bootstrap & functions
│   └── Library/           # ALL dependencies (Composer managed)
├── public/                # Web root (point your domain here)
├── config/                # Configuration files
├── resources/             # Views, locales, assets
├── storage/               # Logs, cache, uploads
├── plugins/               # Plugin system
├── docs/                  # Documentation
├── composer.json          # PHP dependencies
├── package.json           # JavaScript dependencies
└── .env                   # Environment configuration
```

## Important Notes

### Composer Dependencies

All PHP dependencies are installed to `core/Library/` (not standard `vendor/`). This allows:
- ✅ Deployment to shared hosting without SSH access
- ✅ All dependencies included in the distribution package
- ✅ Single-folder deployment

**Do NOT delete the `core/Library/` folder** after `composer install`. It contains all required dependencies.

### TinyMCE Build Process

TinyMCE is managed via NPM and automatically built/copied to `public/js/lib/tinymce/` during:
- `npm install`
- `npm run build`

If you need to rebuild manually:
```bash
npm run build
```

### JatsEngine Custom Package

JatsEngine is a custom library located at `core/Library/JatsEngine/`. To use it as a separate package:

1. Publish to GitHub (see `docs/MIGRATION_LIBRARIES.md`)
2. Register on Packagist
3. Add to main `composer.json` repositories

Currently, it's autoloaded directly from the folder.

## Troubleshooting

### "Class not found" errors

Run:
```bash
composer dump-autoload --optimize
```

### Permission denied errors

```bash
chmod -R 775 storage/
chown -R www-data:www-data storage/  # Adjust user/group as needed
```

### TinyMCE not loading

Rebuild assets:
```bash
npm install
npm run build
```

### Database connection errors

Check your `.env` file:
```ini
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=wizdam
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

## Next Steps

After successful installation:
1. Run the installation wizard at `yourdomain.com/public/index.php`
2. Configure your journal/press settings
3. Install necessary plugins
4. Customize themes and templates

## Support

- Documentation: https://docs.wizdam.sangia.org/
- Issues: https://github.com/wizdam/wizdam/issues
- Forum: https://forum.wizdam.sangia.org/
