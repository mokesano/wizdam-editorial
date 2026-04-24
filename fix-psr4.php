<?php
/**
 * WIZDAM EDITORIAL 1.0 - PSR-4 AUTOLOADING FIX SCRIPT
 * 
 * Script ini akan:
 * 1. Rename semua file .inc.php menjadi .php
 * 2. Menambahkan namespace yang benar sesuai path folder
 * 3. Mengupdate deklarasi class untuk PSR-4 compliance
 */

declare(strict_types=1);

$workspace = '/workspace';
$logFile = $workspace . '/psr4_fix_log.txt';
$dryRun = in_array('--dry-run', $argv, true);

$log = [];

function logMessage(string $message): void {
    global $log;
    $log[] = $message;
    echo $message . PHP_EOL;
}

function pathToNamespace(string $filepath, string $basePath): string {
    $relPath = str_replace($basePath . '/', '', $filepath);
    $dirPath = dirname($relPath);
    
    // Tentukan root namespace berdasarkan folder pertama
    $parts = explode('/', $dirPath);
    $firstFolder = $parts[0] ?? '';
    
    $baseNs = match($firstFolder) {
        'Domain' => 'App\\Domain',
        'Pages' => 'App\\Pages',
        'Controllers' => 'App\\Controllers',
        'Services' => 'App\\Services',
        'Helpers' => 'App\\Helpers',
        default => 'App',
    };
    
    if ($dirPath === '.' || empty($dirPath)) {
        return $baseNs;
    }
    
    // Capitalize setiap bagian path
    $nsParts = array_map(function($part) {
        return ucfirst($part);
    }, $parts);
    
    return $baseNs . '\\' . implode('\\', $nsParts);
}

function processFile(string $filepath, string $workspace): bool {
    if (!str_ends_with($filepath, '.inc.php')) {
        return false;
    }
    
    $newFilepath = substr($filepath, 0, -8) . '.php'; // Remove .inc.php, add .php
    $relPath = str_replace($workspace . '/', '', $filepath);
    $namespace = pathToNamespace($filepath, $workspace . '/app');
    $className = basename($filepath, '.inc.php');
    
    logMessage("Processing: $relPath");
    logMessage("  New name: " . str_replace($workspace . '/', '', $newFilepath));
    logMessage("  Namespace: $namespace");
    logMessage("  Class: $className");
    
    $content = file_get_contents($filepath);
    
    // Cek apakah sudah ada namespace
    if (preg_match('/^namespace\s+[^;]+;/m', $content)) {
        logMessage("  Status: SKIP (already has namespace)");
        logMessage("");
        return false;
    }
    
    // Tambahkan declare(strict_types=1) dan namespace setelah <?php
    $pattern = '/^<\?php\s*/';
    $replacement = "<?php\ndeclare(strict_types=1);\n\nnamespace {$namespace};\n\n";
    $content = preg_replace($pattern, $replacement, $content, 1);
    
    // Jika tidak ada declare(strict_types=1), tambahkan
    if (!str_contains($content, 'declare(strict_types=1)')) {
        $content = preg_replace(
            '/^<\?php\n/',
            "<?php\ndeclare(strict_types=1);\n\n",
            $content,
            1
        );
        // Sekarang tambahkan namespace
        $content = preg_replace(
            '/^(<\?php\ndeclare\(strict_types=1\);)\n/',
            "$1\n\nnamespace {$namespace};\n\n",
            $content,
            1
        );
    }
    
    if ($dryRun) {
        logMessage("  Status: DRY RUN (would write to $newFilepath)");
    } else {
        file_put_contents($newFilepath, $content);
        unlink($filepath);
        logMessage("  Status: DONE");
    }
    
    logMessage("");
    return true;
}

// Main execution
logMessage("========================================");
logMessage("WIZDAM PSR-4 FIX - Starting at " . date('Y-m-d H:i:s'));
logMessage("Dry Run: " . ($dryRun ? 'YES' : 'NO'));
logMessage("========================================");
logMessage("");

// Temukan semua file .inc.php di folder app/
logMessage("Finding all .inc.php files in app/...");
logMessage("");

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($workspace . '/app', RecursiveDirectoryIterator::SKIP_DOTS)
);

$fileCount = 0;
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getPathname(), '.inc.php')) {
        if (processFile($file->getPathname(), $workspace)) {
            $fileCount++;
        }
    }
}

logMessage("========================================");
logMessage("Completed: $fileCount files processed");
logMessage("Finished at " . date('Y-m-d H:i:s'));
logMessage("========================================");

// Write log file
file_put_contents($logFile, implode(PHP_EOL, $log));
logMessage("");
logMessage("Log saved to: $logFile");

