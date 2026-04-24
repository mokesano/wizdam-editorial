<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationParser_freecite
 */

/**
 * @file plugins/citationParser/freecite/CoreFreeciteCitationParserPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CoreFreeciteCitationParserPlugin
 * @ingroup plugins_citationParser_freecite
 *
 * @brief Cross-application FreeCite citation parser
 *
 * [WIZDAM REFACTOR]
 * - PHP 8.1+ Strict Compliance
 * - Explicit Visibility & Return Types
 */

import('core.Modules.plugins.Plugin');

class CoreFreeciteCitationParserPlugin extends Plugin {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    //
    // Override protected template methods from CorePlugin
    //
    
    /**
     * @see CorePlugin::register()
     * @param string $category
     * @param string $path
     */
    public function register(string $category, string $path, $mainContextId = null): bool {
        if (!parent::register($category, $path, $mainContextId)) {
            return false;
        }
        $this->addLocaleData();
        return true;
    }

    /**
     * @see CorePlugin::getName()
     * @return string
     */
    public function getName(): string {
        return 'FreeciteCitationParserPlugin';
    }

    /**
     * @see CorePlugin::getDisplayName()
     * @return string
     */
    public function getDisplayName(): string {
        return __('plugins.citationParser.freecite.displayName');
    }

    /**
     * @see CorePlugin::getDescription()
     * @return string
     */
    public function getDescription(): string {
        return __('plugins.citationParser.freecite.description');
    }
}
?>