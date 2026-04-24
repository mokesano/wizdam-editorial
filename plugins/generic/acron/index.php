<?php
declare(strict_types=1);

/**
 * @defgroup plugins_generic_acron
 */

/**
 * @file plugins/generic/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @brief Wrapper for acron plugin
 *
 * @ingroup plugins_generic_acron
 */

require_once('AcronPlugin.inc.php');

return new AcronPlugin();