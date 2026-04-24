<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationOutput_vancouver
 */

/**
 * @file plugins/citationOutput/vancouver/VancouverCitationOutputPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class VancouverCitationOutputPlugin
 * @ingroup plugins_citationOutput_vancouver
 *
 * @brief Vancouver citation style plug-in.
 */

import('core.Modules.plugins.citationOutput.vancouver.CoreVancouverCitationOutputPlugin');

class VancouverCitationOutputPlugin extends CoreVancouverCitationOutputPlugin {
    
	/**
	 * Constructor
	 */
    function __construct() {
        parent::__construct();
    }
}

?>