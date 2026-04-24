<?php
declare(strict_types=1);

/**
 * @defgroup plugins_gateways_resolver
 */
 
/**
 * @file plugins/gateways/resolver/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_gateways_resolver
 * @brief Wrapper for Resolver gateway plugin.
 *
 */

require_once('ResolverPlugin.inc.php');

return new ResolverPlugin();