<?php
declare(strict_types=1);

/**
 * @defgroup plugins_generic_browse
 */
 
/**
 * @file plugins/generic/browse/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_browse
 * @brief Wrapper for browse plugin.
 */

require_once('BrowsePlugin.inc.php');

return new BrowsePlugin();