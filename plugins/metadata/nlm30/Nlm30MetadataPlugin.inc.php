<?php
declare(strict_types=1);

/**
 * @defgroup plugins_metadata_nlm30
 */

/**
 * @file plugins/metadata/nlm30/Nlm30MetadataPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Nlm30MetadataPlugin
 * @ingroup plugins_metadata_nlm30
 *
 * @brief NLM 3.0 metadata plugin
 */


import('core.Modules.plugins.metadata.nlm30.CoreNlm30MetadataPlugin');

class Nlm30MetadataPlugin extends CoreNlm30MetadataPlugin {
    
	/**
	 * Constructor
	 */
    function __construct() {
        parent::__construct();
    }
}

?>