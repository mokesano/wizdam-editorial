<?php
declare(strict_types=1);

/**
 * @file ready.php
 * 
 * WIZDAM System Ready Endpoint
 * This script provides a simple JSON response indicating the system status,
 * the application name, the PHP version, and the current server time.
 *
 * Usage: Access this script via a web browser or HTTP client to get the status.
 */
 
define('INDEX_FILE_LOCATION', __FILE__);
header('Content-Type: application/json');

// Matikan display error agar output JSON bersih
ini_set('display_errors', '0'); 

try {
    // 1. Set direktori kerja ke Root
    chdir(dirname(__FILE__)); 

    // 2. Load Bootstrap
    if (!file_exists('./lib/wizdam/includes/bootstrap.inc.php')) {
        throw new Exception("Bootstrap file missing.");
    }
    require './core/Includes/bootstrap.inc.php';

    // 3. Tes Koneksi Real (Query Sederhana)
    // Panggil memastikan DB tidak hanya "terhubung" tapi bisa "mengambil data".
    $versionDao = DAORegistry::getDAO('VersionDAO');
    $currentVersion = $versionDao->getCurrentVersion();
    
    if (!$currentVersion) {
        throw new Exception("Database connected but failed to retrieve Version data.");
    }

    // 4. Ambil Objek ADOdb untuk Diagnostik (FIXED)
    // Menggunakan Singleton DBConnection lalu panggil method getConn()
    $dbConnection = DBConnection::getInstance();
    $connObject = $dbConnection->getConn();

    // 5. Ambil Versi ADOdb
    global $ADODB_vers;
    $adodbVerString = isset($ADODB_vers) ? $ADODB_vers : 'Unknown';

    // 6. Cek Tipe Objek
    $refStatus = 'Unknown';
    $connClass = 'Not Connected';

    if (is_object($connObject)) {
        $connClass = get_class($connObject);
        // Jika classnya ADODB_mysqli, berarti driver modern aktif
        $refStatus = 'Object (Modern Standard)';
    } else {
        $refStatus = 'Null (Connection Failed)';
    }

    // 7. Output JSON
    $response = [
        'status' => 'ready',
        'app' => 'Wizdam Editorial Systems',
        'version' => $currentVersion->getVersionString(), // Versi dari DB
        'driver_config' => Config::getVar('database', 'driver'),
        'connection_object' => $connClass,
        'integrity_check' => $refStatus,
        'library_version' => $adodbVerString,
    ];

    http_response_code(200);
    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    handleError($e);
} catch (Exception $e) {
    handleError($e);
}

function handleError($e) {
    http_response_code(503);
    echo json_encode([
        'status' => 'not_ready',
        'error' => $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ], JSON_PRETTY_PRINT);
    exit;
}
?>