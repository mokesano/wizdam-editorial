<?php
declare(strict_types=1);

namespace App\Domain\Subscription;


/**
 * @defgroup subscription
 */
 
/**
 * @file core.Modules.subscription/IndividualSubscription.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class IndividualSubscription
 * @ingroup subscription 
 * @see IndividualSubscriptionDAO
 *
 * @brief Basic class describing an individual (non-institutional) subscription.
 * * MODERNIZED FOR WIZDAM FORK
 */

import('core.Modules.subscription.Subscription');

class IndividualSubscription extends Subscription {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function IndividualSubscription() {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::IndividualSubscription(). Please refactor to use parent::__construct().",
            E_USER_DEPRECATED
        );
        self::__construct();
    }

    /**
     * Check whether subscription is valid
     */
    public function isValid($check = SUBSCRIPTION_DATE_BOTH, $checkDate = null) {
        $subscriptionDao = DAORegistry::getDAO('IndividualSubscriptionDAO');
        return $subscriptionDao->isValidIndividualSubscription($this->getData('userId'), $this->getData('journalId'), $check, $checkDate);    
    }
}

?>