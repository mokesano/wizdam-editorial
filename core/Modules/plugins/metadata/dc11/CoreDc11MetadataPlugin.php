<?php
declare(strict_types=1);

/**
 * @defgroup plugins_metadata_dc11
 */

/**
 * @file plugins/metadata/dc11/CoreDc11MetadataPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CoreDc11MetadataPlugin
 * @ingroup plugins_metadata_dc11
 *
 * @brief Abstract base class for Dublin Core version 1.1 metadata plugins
 */


import('core.Modules.plugins.MetadataPlugin');

class CoreDc11MetadataPlugin extends MetadataPlugin {

	/**
	 * Constructor
	 */
    function __construct() {
        parent::__construct();
    }


	//
	// Override protected template methods from CorePlugin
	//
	/**
	 * @see CorePlugin::getName()
	 */
	function getName(): string {
		return 'Dc11MetadataPlugin';
	}

	/**
	 * @see CorePlugin::getDisplayName()
	 */
	function getDisplayName(): string {
		return __('plugins.metadata.dc11.displayName');
	}

	/**
	 * @see CorePlugin::getDescription()
	 */
	function getDescription(): string {
		return __('plugins.metadata.dc11.description');
	}
}

?>