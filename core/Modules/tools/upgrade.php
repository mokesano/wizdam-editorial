<?php
declare(strict_types=1);

/**
 * @file core/Modules/tools/upgrade.php
 *
 * Copyright (c) 2013-2025 Wizdam Editorial Contributors
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AppUpgradeTool
 * @ingroup tools
 *
 * @brief CLI tool for upgrading Wizdam.
 * [WIZDAM EDITION] Wizdam Upgrade Tool Implementation.
 */

require(__DIR__ . '/bootstrap.inc.php');

import('core.Modules.cliTool.UpgradeTool');

class AppUpgradeTool extends UpgradeTool {
    /**
     * Constructor.
     * @param array $argv command-line arguments
     */
    public function __construct(array $argv = []) {
        // [WIZDAM FIX] Call parent::__construct which handles command validation and argument parsing.
        parent::__construct($argv);
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function AppUpgradeTool($argv = []) {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor parent::" . get_class($this) . "(). Please refactor to use parent::__construct().",
                E_USER_DEPRECATED
            );
        }
        $args = func_get_args();
        call_user_func_array([$this, '__construct'], $args);
    }
}

// [WIZDAM] Safe instantiation
$tool = new AppUpgradeTool($argv ?? []);
$tool->execute();
?>