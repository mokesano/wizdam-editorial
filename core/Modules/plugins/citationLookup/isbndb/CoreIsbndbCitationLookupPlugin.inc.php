<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationLookup_isbndb
 */

/**
 * @file plugins/citationLookup/isbndb/CoreIsbndbCitationLookupPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CoreIsbndbCitationLookupPlugin
 * @ingroup plugins_citationLookup_isbndb
 *
 * @brief Cross-application ISBNdb citation lookup plugin
 * * [WIZDAM REFACTOR]
 * - PHP 8.1+ Strict Compliance
 * - Explicit Type Hinting & Return Types
 */

import('core.Modules.plugins.Plugin');

class CoreIsbndbCitationLookupPlugin extends Plugin {
    
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
     * @param int|null $mainContextId
     * @return bool
     * [WIZDAM] Added explicit type hinting and return type
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
     * [WIZDAM] Added explicit return type
     */
    public function getName(): string {
        return 'IsbndbCitationLookupPlugin';
    }

    /**
     * @see CorePlugin::getDisplayName()
     * @return string
     * [WIZDAM] Added explicit return type
     */
    public function getDisplayName(): string {
        return __('plugins.citationLookup.isbndb.displayName');
    }

    /**
     * @see CorePlugin::getDescription()
     * @return string
     * [WIZDAM] Added explicit return type
     */
    public function getDescription(): string {
        return __('plugins.citationLookup.isbndb.description');
    }
}
?>