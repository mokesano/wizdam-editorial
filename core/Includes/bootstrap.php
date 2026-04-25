<?php
declare(strict_types=1);

/**
 * @defgroup index
 */

/**
 * @file includes/bootstrap.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup index
 *
 * @brief Core system initialization code.
 * [WIZDAM EDITION] Modernized Kernel Bootstrap.
 */

/**
 * Basic initialization (pre-classloading).
 */

// [WIZDAM] Use Native PHP Constants
// PHP 7.4+ guarantees DIRECTORY_SEPARATOR and PATH_SEPARATOR exist.
// We map ENV_SEPARATOR to PATH_SEPARATOR for legacy compatibility throughout the codebase.
define('ENV_SEPARATOR', PATH_SEPARATOR);

// Define System Root
define('BASE_SYS_DIR', dirname(INDEX_FILE_LOCATION));
chdir(BASE_SYS_DIR);

// [WIZDAM] Optimized Path Configuration
// We define paths in an array for readability, then implode them.
$includePaths = [
    BASE_SYS_DIR . '/app/Domain',
    BASE_SYS_DIR . '/app/Pages',
    BASE_SYS_DIR . '/core/Library',
    BASE_SYS_DIR . '/core/Library/adodb',
    BASE_SYS_DIR . '/core/Library/phputf8',
    BASE_SYS_DIR . '/core/Library/pqp/classes',
    BASE_SYS_DIR . '/core/Library/smarty',
    BASE_SYS_DIR . '/core/Modules',
    BASE_SYS_DIR . '/core/Kernel',
    BASE_SYS_DIR . '/app/Helpers',
    ini_get('include_path') // Append existing system paths
];

ini_set('include_path', implode(ENV_SEPARATOR, $includePaths));

// System-wide functions (Global Helper Functions)
// Loads import(), String wrapper, etc.
require(BASE_SYS_DIR . '/core/Includes/functions.php');

// Initialize the application environment
// [WIZDAM] We use the import function to load the core Application class.
import('app.Domain.core.Application');

// [WIZDAM MODERNISASI PSR-4] Use fully qualified class name
// Since Application is now in namespace App\Domain\Core, we must reference it properly.
use App\Domain\Core\Application;

// [WIZDAM] Instantiate the Application Singleton.
// The constructor of Application registers itself to the Registry.
// This prepares system for the Application::get()->execute() call in index.php.
new Application();