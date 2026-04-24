<?php
declare(strict_types=1);

/**
 * @file core.Modules.security/authorization/internal/CopyeditorSubmissionAssignmentPolicy.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2000-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CopyeditorSubmissionAssignmentPolicy
 * @ingroup security_authorization_internal
 *
 * @brief Class to control access of copyeditors to submissions.
 *
 * NB: This policy expects a previously authorized copyeditor submission in the
 * authorization context.
 * * MODERNIZED FOR WIZDAM FORK
 */

import('core.Modules.security.authorization.AuthorizationPolicy');

class CopyeditorSubmissionAssignmentPolicy extends AuthorizationPolicy {
    /** @var CoreRequest */
    public $_request;

    /**
     * Constructor
     * @param $request CoreRequest
     */
    public function __construct($request) {
        parent::__construct('user.authorization.copyeditorAssignmentMissing');
        $this->_request = $request;
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function CopyeditorSubmissionAssignmentPolicy($request) {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::CopyeditorSubmissionAssignmentPolicy(). Please refactor to use parent::__construct().",
            E_USER_DEPRECATED
        );
        self::__construct($request);
    }

    //
    // Implement template methods from AuthorizationPolicy
    //
    /**
     * @see AuthorizationPolicy::effect()
     */
    public function effect() {
        // Get the user
        $user = $this->_request->getUser();
        // [MODERNISASI] is_a -> instanceof
        if (!($user instanceof CoreUser)) return AUTHORIZATION_DENY;

        // Get the copyeditor submission
        $copyeditorSubmission = $this->getAuthorizedContextObject(ASSOC_TYPE_ARTICLE);
        // [MODERNISASI] is_a -> instanceof
        if (!($copyeditorSubmission instanceof CopyeditorSubmission)) return AUTHORIZATION_DENY;

        // Copyeditors can only access submissions
        // they have been explicitly assigned to.
        if ($copyeditorSubmission->getUserIdBySignoffType('SIGNOFF_COPYEDITING_INITIAL') != $user->getId()) return AUTHORIZATION_DENY;

        return AUTHORIZATION_PERMIT;
    }
}

?>