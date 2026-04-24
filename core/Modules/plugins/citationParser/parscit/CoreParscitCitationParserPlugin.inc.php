<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationParser_parscit
 */

/**
 * @file plugins/citationParser/parscit/CoreParscitCitationParserPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CoreParscitCitationParserPlugin
 * @ingroup plugins_citationParser_parscit
 *
 * @brief Cross-application ParsCit citation parser
 *
 * [WIZDAM REFACTOR]
 * - PHP 8.1+ Strict Compliance
 * - Explicit Visibility & Return Types
 */

import('core.Modules.plugins.Plugin');

class CoreParscitCitationParserPlugin extends Plugin {
    
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
        return 'ParscitCitationParserPlugin';
    }

    /**
     * @see CorePlugin::getDisplayName()
     * @return string
     */
    public function getDisplayName(): string {
        return __('plugins.citationParser.parscit.displayName');
    }

    /**
     * @see CorePlugin::getDescription()
     * @return string
     */
    public function getDescription(): string {
        return __('plugins.citationParser.parscit.description');
    }
}
?>