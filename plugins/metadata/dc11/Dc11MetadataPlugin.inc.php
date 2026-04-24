<?php
declare(strict_types=1);

/**
 * @defgroup plugins_metadata_dc11
 */

/**
 * @file plugins/metadata/dc11/Dc11MetadataPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Dc11MetadataPlugin
 * @ingroup plugins_metadata_dc11
 *
 * @brief Dublin Core version 1.1 metadata plugin
 */

import('core.Modules.plugins.metadata.dc11.CoreDc11MetadataPlugin');

class Dc11MetadataPlugin extends CoreDc11MetadataPlugin {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
}

?>