<?php
declare(strict_types=1);

/**
 * @defgroup plugins_generic_googleAnalytics
 */
 
/**
 * @file plugins/generic/googleAnalytics/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_googleAnalytics
 * @brief Wrapper for Google Analytics plugin.
 *
 */

require_once('GoogleAnalyticsPlugin.inc.php');

return new GoogleAnalyticsPlugin();