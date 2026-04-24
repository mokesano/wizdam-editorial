<?php
declare(strict_types=1);

/**
 * @file plugins/generic/staticPages/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Wrapper for StaticPages plugin.
 *
 * @package plugins.generic.staticPages
 *
 */

require_once('StaticPagesPlugin.inc.php');

return new StaticPagesPlugin();