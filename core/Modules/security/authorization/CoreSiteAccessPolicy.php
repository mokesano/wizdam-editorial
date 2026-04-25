<?php
declare(strict_types=1);

/**
 * @file core.Modules.security/authorization/CoreSiteAccessPolicy.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CoreSiteAccessPolicy
 * @ingroup security_authorization
 *
 * @brief Class to that makes sure that a user is logged in.
 */

define('SITE_ACCESS_ALL_ROLES', 0x01);

import('core.Modules.security.authorization.PolicySet');

class CoreSiteAccessPolicy extends PolicySet {
    /** @var CoreRequest */
    public $_request;

    /**
     * Constructor
     */
    public function __construct($request, $operations, $roleAssignments, $message = 'user.authorization.loginRequired') {
        parent::__construct();
        $this->_request = $request;

        $siteRolePolicy = new PolicySet(COMBINING_PERMIT_OVERRIDES);
        
        if(is_array($roleAssignments)) {
            import('core.Modules.security.authorization.RoleBasedHandlerOperationPolicy');
            foreach($roleAssignments as $role => $operations) {
                $siteRolePolicy->addPolicy(new RoleBasedHandlerOperationPolicy($request, $role, $operations));
            }
        } elseif ($roleAssignments === SITE_ACCESS_ALL_ROLES) {
            import('core.Modules.security.authorization.CorePublicAccessPolicy');
            $siteRolePolicy->addPolicy(new CorePublicAccessPolicy($request, $operations));
        } else {
            fatalError('Invalid role assignments!');
        }
        $this->addPolicy($siteRolePolicy);
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function CoreSiteAccessPolicy($request, $operations, $roleAssignments, $message = 'user.authorization.loginRequired') {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::CoreSiteAccessPolicy(). Please refactor to use parent::__construct().",
            E_USER_DEPRECATED
        );
        self::__construct($request, $operations, $roleAssignments, $message);
    }

    /**
     * Return the request.
     * @return CoreRequest
     */
    public function getRequest() {
        return $this->_request;
    }

    //
    // Implement template methods from AuthorizationPolicy
    //
    /**
     * @see AuthorizationPolicy::effect()
     */
    public function effect() {
        // Retrieve the user from the session.
        // Removed & from references
        $request = $this->getRequest();
        $user = $request->getUser();

        if (!($user instanceof User)) {
            return AUTHORIZATION_DENY;
        }

        // Execute handler operation checks.
        return parent::effect();
    }
}
?>