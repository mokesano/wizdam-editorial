<?php
declare(strict_types=1);

namespace App\Domain\Signoff;


/**
 * @file core.Modules.signoff/SignoffDAO.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SignoffDAO
 * @ingroup signoff
 * @see Signoff
 *
 * @brief Operations for retrieving and modifying Signoff objects.
 */

import('app.Domain.Signoff.CoreSignoffDAO');

class SignoffDAO extends CoreSignoffDAO {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function SignoffDAO() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error('Class ' . get_class($this) . ' uses deprecated constructor parent::SignoffDAO(). Please refactor to parent::__construct().', E_USER_DEPRECATED);
        }
        self::__construct();
    }
}

?>