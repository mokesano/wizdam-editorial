<?php
declare(strict_types=1);

/**
 * @defgroup plugins_metadata_mods34
 */

/**
 * @file plugins/metadata/mods34/CoreMods34MetadataPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CoreMods34MetadataPlugin
 * @ingroup plugins_metadata_mods34
 *
 * @brief Abstract base class for MODS metadata plugins
 */


import('core.Modules.plugins.MetadataPlugin');

class CoreMods34MetadataPlugin extends MetadataPlugin {

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
		return 'Mods34MetadataPlugin';
	}

	/**
	 * @see CorePlugin::getDisplayName()
	 */
	function getDisplayName(): string {
		return __('plugins.metadata.mods34.displayName');
	}

	/**
	 * @see CorePlugin::getDescription()
	 */
	function getDescription(): string {
		return __('plugins.metadata.mods34.description');
	}
}

?>