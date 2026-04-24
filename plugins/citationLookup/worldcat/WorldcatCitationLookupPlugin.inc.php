<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationLookup_worldcat
 */

/**
 * @file plugins/citationLookup/worldcat/WorldcatCitationLookupPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class WorldcatCitationLookupPlugin
 * @ingroup plugins_citationLookup_worldcat
 *
 * @brief WorldCat citation database connector plug-in.
 */

import('core.Modules.plugins.citationLookup.worldcat.CoreWorldcatCitationLookupPlugin');

class WorldcatCitationLookupPlugin extends CoreWorldcatCitationLookupPlugin {
    
	/**
	 * Constructor
	 */
    function __construct() {
        parent::__construct();
    }
}

?>