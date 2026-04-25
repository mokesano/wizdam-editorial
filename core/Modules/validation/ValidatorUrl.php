<?php
declare(strict_types=1);

/**
 * @file core.Modules.validation/ValidatorUrl.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ValidatorUrl
 * @ingroup validation
 * @see Validator
 *
 * @brief Validation check for URLs.
 * * REFACTORED: Wizdam Edition (PHP 8 Constructor, Explicit Static Methods)
 */

import('core.Modules.validation.ValidatorUri');

class ValidatorUrl extends ValidatorUri {
    
    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct(self::_getAllowedSchemes());
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function ValidatorUrl() {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::ValidatorUrl(). Please refactor to use parent::__construct().",
            E_USER_DEPRECATED
        );
        self::__construct();
    }

    //
    // Public static methods
    //
    /**
     * @see ValidatorUri::getRegexp()
     * @return string
     */
    public static function getRegexp($allowedSchemes = null) {
        return parent::getRegexp(self::_getAllowedSchemes());
    }

    //
    // Private static methods
    //
    /**
     * Return allowed schemes (PHP4 workaround for
     * a private static field).
     * @return array
     */
    private static function _getAllowedSchemes() {
        return array('http', 'https', 'ftp');
    }
}

?>