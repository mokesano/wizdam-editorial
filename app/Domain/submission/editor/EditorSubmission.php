<?php
declare(strict_types=1);

namespace App\Domain\Submission\Editor;


/**
 * @file core.Modules.submission/editor/EditorSubmission.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class EditorSubmission
 * @ingroup submission
 * @see EditorSubmissionDAO
 *
 * @brief EditorSubmission class.
 *
 * [WIZDAM EDITION] Refactored for PHP 8.1+ Strict Compliance
 */

import('core.Modules.submission.sectionEditor.SectionEditorSubmission');

class EditorSubmission extends SectionEditorSubmission {

    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function EditorSubmission() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor parent::" . get_class($this) . "(). Please refactor to use parent::__construct().",
                E_USER_DEPRECATED
            );
        }
        $args = func_get_args();
        call_user_func_array([$this, '__construct'], $args);
    }
}
?>