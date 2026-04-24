<?php
declare(strict_types=1);

/**
 * @defgroup plugins_metadata_openurl10
 */

/**
 * @file plugins/metadata/openurl10/Openurl10MetadataPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Openurl10MetadataPlugin
 * @ingroup plugins_metadata_openurl10
 *
 * @brief OpenURL 1.0 metadata plugin
 */


import('core.Modules.plugins.metadata.openurl10.CoreOpenurl10MetadataPlugin');

class Openurl10MetadataPlugin extends CoreOpenurl10MetadataPlugin {
    
	/**
	 * Constructor
	 */
    function __construct() {
        parent::__construct();
    }
}

?>