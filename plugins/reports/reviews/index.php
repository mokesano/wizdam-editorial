<?php
declare(strict_types=1);

/**
 * @defgroup plugins_reports_reviews
 */
 
/**
 * @file plugins/reports/reviews/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @brief Wrapper for review report plugin.
 *
 * @ingroup plugins_reports_reviews
 */

require_once('ReviewReportPlugin.inc.php');

return new ReviewReportPlugin();