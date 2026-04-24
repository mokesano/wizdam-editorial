<?php
declare(strict_types=1);

/**
 * @defgroup pages_payment
 */
 
/**
 * @file pages/payment/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_payment
 * @brief Handle requests for interactions between the payment system and external
 * sites/systems.
 */

switch ($op) {
	case 'plugin':
		define('HANDLER_CLASS', 'PaymentHandler');
		import('app.Pages.payment.PaymentHandler');
		break;
}

?>