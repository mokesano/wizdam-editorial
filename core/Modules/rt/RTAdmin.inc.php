<?php
declare(strict_types=1);

/**
 * @file core.Modules.rt/RTAdmin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class RTAdmin
 * @ingroup rt
 *
 * @brief Class to process and respond to Reading Tools administration requests.
 * * REFACTORED: Wizdam Edition (PHP 8 Constructor, Visibility, Annotations)
 */

import('core.Modules.rt.RTStruct');

class RTAdmin {

    /**
     * Constructor.
     */
    public function __construct() {
        // Empty constructor
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function RTAdmin() {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::RTAdmin(). Please refactor to use parent::__construct().",
            E_USER_DEPRECATED
        );
        self::__construct();
    }

    /**
     * Import Reading Tool versions.
     * This function serves as a placeholder for version import logic.
     *
     * @return void
     */
    public function importVersions() { 
        // Empty implementation
    }
}

?>