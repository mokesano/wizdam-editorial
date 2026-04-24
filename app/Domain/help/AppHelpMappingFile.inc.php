<?php
declare(strict_types=1);

/**
 * @file core.Modules.help/AppHelpMappingFile.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AppHelpMappingFile
 * @ingroup help
 *
 * @brief Abstracts the built-in help mapping XML file.
 * * MODERNIZED FOR WIZDAM FORK
 */

import('core.Modules.help.HelpMappingFile');

class AppHelpMappingFile extends HelpMappingFile {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct('help/help.xml');
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function AppHelpMappingFile() {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor AppHelpMappingFile(). Please refactor to use __construct().",
            E_USER_DEPRECATED
        );
        self::__construct();
    }

    /**
     * Return the filename for a built-in Wizdam help TOC filename.
     * @param $tocId string
     * @return string
     */
    public function getTocFilename($tocId) {
        $help = Help::getHelp();
        return sprintf('help/%s/%s.xml', $help->getLocale(), $tocId);
    }

    /**
     * Return the filename for a built-in Wizdam help topic filename.
     * @param $topicId string
     * @return string
     */
    public function getTopicFilename($topicId) {
        $help = Help::getHelp();
        return sprintf('help/%s/%s.xml', $help->getLocale(), $topicId);
    }

    /**
     * Return the topic ID for a built-in Wizdam help topic filename.
     * @param $filename string
     * @return string
     */
    public function getTopicIdForFilename($filename) {
        $parts = explode('/', str_replace('\\', '/', $filename));
        array_shift($parts); // Knock off "help"
        array_shift($parts); // Knock off locale
        return substr(join('/', $parts), 0, -4); // Knock off .xml
    }

    /**
     * Get the search path for built-in Wizdam help files.
     * @param $locale string
     * @return string
     */
    public function getSearchPath($locale = null) {
        if ($locale == '') {
            $help = Help::getHelp();
            $locale = $help->getLocale();
        }
        return 'help' . DIRECTORY_SEPARATOR . $locale;
    }
}

?>