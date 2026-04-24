<?php
declare(strict_types=1);

/**
 * @file core.Modules.security/authorization/AppSubmissionAccessPolicy.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AppSubmissionAccessPolicy
 * @ingroup security_authorization
 *
 * @brief Class to control access to Wizdam's submission editing components
 * * MODERNIZED FOR WIZDAM FORK
 */

import('core.Modules.security.authorization.internal.JournalPolicy');
import('core.Modules.security.authorization.RoleBasedHandlerOperationPolicy');

class AppSubmissionAccessPolicy extends JournalPolicy {
    
    /**
     * Constructor
     * @param $request CoreRequest
     * @param $args array
     * @param $roleAssignments array
     * @param $submissionParameterName string
     */
    public function __construct($request, $args, $roleAssignments, $submissionParameterName = 'articleId') {
        parent::__construct($request);

        // Create a "permit overrides" policy set that specifies
        // editor and copyeditor access to submissions.
        $submissionEditingPolicy = new PolicySet(COMBINING_PERMIT_OVERRIDES);

        //
        // Editor roles (Editor and Section Editor) policy
        //
        $editorsPolicy = new PolicySet(COMBINING_DENY_OVERRIDES);

        // Editorial components can only be called if there's a
        // valid section editor submission in the request.
        // FIXME: We should find a way to check whether the user actually
        // is a (section) editor before we execute this expensive policy.
        import('core.Modules.security.authorization.internal.SectionEditorSubmissionRequiredPolicy');
        $editorsPolicy->addPolicy(new SectionEditorSubmissionRequiredPolicy($request, $args, $submissionParameterName));

        $editorRolesPolicy = new PolicySet(COMBINING_PERMIT_OVERRIDES);

        // Editors can access all operations.
        $editorRolesPolicy->addPolicy(new RoleBasedHandlerOperationPolicy($request, ROLE_ID_EDITOR, $roleAssignments[ROLE_ID_EDITOR]));

        // Section editors
        $sectionEditorPolicy = new PolicySet(COMBINING_DENY_OVERRIDES);
        // 1) Section editors can access all remote operations ...
        $sectionEditorPolicy->addPolicy(new RoleBasedHandlerOperationPolicy($request, ROLE_ID_SECTION_EDITOR, $roleAssignments[ROLE_ID_SECTION_EDITOR]));

        // 2) ... but only if the requested submission has been explicitly assigned to them.
        import('core.Modules.security.authorization.internal.SectionSubmissionAssignmentPolicy');
        $sectionEditorPolicy->addPolicy(new SectionSubmissionAssignmentPolicy($request));
        $editorRolesPolicy->addPolicy($sectionEditorPolicy);

        $editorsPolicy->addPolicy($editorRolesPolicy);

        $submissionEditingPolicy->addPolicy($editorsPolicy);


        //
        // Copyeditor policy
        //
        $copyeditorPolicy = new PolicySet(COMBINING_DENY_OVERRIDES);

        // 1) Copyeditors can only access editorial components when a valid
        //    copyeditor submission is in the request ...
        import('core.Modules.security.authorization.internal.CopyeditorSubmissionRequiredPolicy');
        $copyeditorPolicy->addPolicy(new CopyeditorSubmissionRequiredPolicy($request, $args, $submissionParameterName));

        // 2) ... If that's the case then copyeditors can access all remote operations ...
        $copyeditorPolicy->addPolicy(new RoleBasedHandlerOperationPolicy($request, ROLE_ID_COPYEDITOR, $roleAssignments[ROLE_ID_SECTION_EDITOR]));

        // 3) ... but only if the requested submission has been explicitly assigned to them.
        import('core.Modules.security.authorization.internal.CopyeditorSubmissionAssignmentPolicy');
        $copyeditorPolicy->addPolicy(new CopyeditorSubmissionAssignmentPolicy($request));

        $submissionEditingPolicy->addPolicy($copyeditorPolicy);


        // Add the submission editing policies to this policy set.
        $this->addPolicy($submissionEditingPolicy);
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function AppSubmissionAccessPolicy($request, $args, $roleAssignments, $submissionParameterName = 'articleId') {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::AppSubmissionAccessPolicy(). Please refactor to use parent::__construct().",
            E_USER_DEPRECATED
        );
        self::__construct($request, $args, $roleAssignments, $submissionParameterName);
    }
}

?>