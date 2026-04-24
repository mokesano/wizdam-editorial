<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationOutput_mla
 */

/**
 * @file plugins/citationOutput/mla/MlaCitationOutputPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class MlaCitationOutputPlugin
 * @ingroup plugins_citationOutput_mla
 *
 * @brief MLA citation style plug-in.
 */

import('core.Modules.plugins.citationOutput.mla.CoreMlaCitationOutputPlugin');

class MlaCitationOutputPlugin extends CoreMlaCitationOutputPlugin {
    
	/**
	 * Constructor
	 */
    function __construct() {
        parent::__construct();
    }
}

?>