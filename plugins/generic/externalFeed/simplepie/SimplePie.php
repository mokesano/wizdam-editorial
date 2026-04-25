<?php
/**
 * Wrapper SimplePie untuk Wizdam Editorial 1.0
 * Menjembatani kode legacy Wizdam dengan SimplePie Modern (Namespaced) dari core/Library
 * 
 * Menggunakan library SimplePie terpusat di: ./core/Library/simplepie/simplepie/
 */

// Path ke root aplikasi (4 level ke atas dari plugins/generic/externalFeed/simplepie)
// simplepie -> externalFeed -> generic -> plugins -> workspace = 4 level
$wizdamRoot = dirname(dirname(dirname(dirname(__DIR__))));

// Path ke library SimplePie terpusat
$coreSimplePiePath = $wizdamRoot . '/core/Library/simplepie/simplepie/';

/** 
 * 1. Panggil Autoloader SimplePie dari Library Pusat
 */ 
$autoloaderPath = $coreSimplePiePath . 'autoloader.php';

if (file_exists($autoloaderPath)) {
    require_once($autoloaderPath);
} else {
    // Logging error jika autoloader hilang
    error_log('SimplePie Wrapper: autoloader.php tidak ditemukan di ' . $autoloaderPath);
    return;
}

/**
 * 2. MAPPING NAMESPACE (Kunci Kompatibilitas)
 * Kita cek apakah class 'SimplePie\\SimplePie' tersedia lewat autoloader
 * Jika ya, kita buat alias menjadi 'SimplePie' (tanpa namespace) agar kode legacy Wizdam bisa menggunakannya.
 */ 
if (class_exists('SimplePie\\SimplePie')) {
    if (!class_exists('SimplePie')) {
        class_alias('SimplePie\\SimplePie', 'SimplePie');
    }
} 

/**
 * 3. FALLBACK MANUAL (Jaga-jaga jika autoloader gagal)
 * SimplePie Master biasanya menaruh file utama di folder /src/SimplePie.php
 * Folder src sudah di-link sebagai symlink dari wrapper ini
 */ 
else {
    // Coba via symlink lokal
    $manualSource = __DIR__ . '/src/SimplePie.php';
    if (file_exists($manualSource)) {
        require_once($manualSource);
        // Cek lagi dan buat alias
        if (class_exists('SimplePie\\SimplePie') && !class_exists('SimplePie')) {
            class_alias('SimplePie\\SimplePie', 'SimplePie');
        }
    }
}

// Verifikasi class SimplePie tersedia
if (!class_exists('SimplePie')) {
    error_log('SimplePie Wrapper: Gagal memuat class SimplePie dari library pusat');
}
?>
