<?php
declare(strict_types=1);

/**
 * @defgroup plugins_reports_subscription
 */
 
/**
 * @file plugins/reports/subscriptions/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_reports_subscription
 * @brief Wrapper for subscription report plugin.
 *
 */

require_once('SubscriptionReportPlugin.inc.php');

return new SubscriptionReportPlugin();