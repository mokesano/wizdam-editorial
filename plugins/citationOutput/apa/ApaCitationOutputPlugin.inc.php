<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationOutput_apa
 */

/**
 * @file plugins/citationOutput/apa/ApaCitationOutputPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ApaCitationOutputPlugin
 * @ingroup plugins_citationOutput_apa
 *
 * @brief APA citation style plug-in.
 */

import('core.Modules.plugins.citationOutput.apa.CoreApaCitationOutputPlugin');

class ApaCitationOutputPlugin extends CoreApaCitationOutputPlugin {
    
	/**
	 * Constructor
	 */
    function __construct() {
        parent::__construct();
    }
}

?>