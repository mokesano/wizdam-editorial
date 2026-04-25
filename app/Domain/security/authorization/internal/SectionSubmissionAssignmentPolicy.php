<?php
declare(strict_types=1);

namespace App\Domain\Security\Authorization\Internal;


/**
 * @file core.Modules.security/authorization/internal/SectionSubmissionAssignmentPolicy.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SectionSubmissionAssignmentPolicy
 * @ingroup security_authorization_internal
 *
 * @brief Class to control access to journal sections.
 *
 * NB: This policy expects a previously authorized section editor
 * submission in the authorization context.
 * * MODERNIZED FOR WIZDAM FORK
 */

import('core.Modules.security.authorization.AuthorizationPolicy');

class SectionSubmissionAssignmentPolicy extends AuthorizationPolicy {
    /** @var CoreRequest */
    public $_request;

    /**
     * Constructor
     * @param $request CoreRequest
     */
    public function __construct($request) {
        parent::__construct('user.authorization.sectionAssignment');
        $this->_request = $request;
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function SectionSubmissionAssignmentPolicy($request) {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::SectionSubmissionAssignmentPolicy(). Please refactor to use parent::__construct().",
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
        // [MODERNISASI] is_a() -> instanceof
        if (!($user instanceof CoreUser)) return AUTHORIZATION_DENY;

        // Get the section editor submission.
        $sectionEditorSubmission = $this->getAuthorizedContextObject(ASSOC_TYPE_ARTICLE);
        // [MODERNISASI] is_a() -> instanceof
        if (!($sectionEditorSubmission instanceof SectionEditorSubmission)) return AUTHORIZATION_DENY;

        // Section editors can only access submissions in their series
        // that they have been explicitly assigned to.

        // 1) Retrieve the edit assignments
        $editAssignmentDao = DAORegistry::getDAO('EditAssignmentDAO');
        $editAssignments = $editAssignmentDao->getEditAssignmentsByArticleId($sectionEditorSubmission->getId());
        
        // [MODERNISASI] is_a() -> instanceof
        if (!($editAssignments instanceof DAOResultFactory)) return AUTHORIZATION_DENY;
        
        $editAssignmentsArray = $editAssignments->toArray();

        // 2) Check whether the user is the article's editor,
        //    otherwise deny access.
        $foundAssignment = false;
        foreach ($editAssignmentsArray as $editAssignment) {
            if ($editAssignment->getEditorId() == $user->getId()) {
                if ($editAssignment->getCanEdit()) $foundAssignment = true;
                break;
            }
        }

        if ($foundAssignment) {
            return AUTHORIZATION_PERMIT;
        } else {
            return AUTHORIZATION_DENY;
        }
    }
}

?>