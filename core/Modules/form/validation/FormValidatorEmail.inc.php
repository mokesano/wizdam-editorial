<?php
declare(strict_types=1);

/**
 * @file core.Modules.form/validation/FormValidatorEmail.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class FormValidatorEmail
 * @ingroup form_validation
 * @see FormValidator
 *
 * @brief Form validation check for email addresses.
 * [WIZDAM EDITION] Refactored for PHP 8.x
 */

import('core.Modules.form.validation.FormValidatorRegExp');
import('core.Modules.validation.ValidatorEmail');

class FormValidatorEmail extends FormValidator {
    
    /**
     * Constructor.
     * @param Form $form the associated form
     * @param string $field the name of the associated field
     * @param string $type the type of check, either "required" or "optional"
     * @param string $message the error message for validation failures (i18n key)
     */
    public function __construct($form, $field, $type, $message) {
        $validator = new ValidatorEmail();
        parent::__construct($form, $field, $type, $message, $validator);
        
        // [WIZDAM] PHP 8 Safety: Ensure the array key exists before pushing
        if (!isset($form->cssValidation[$field])) {
            $form->cssValidation[$field] = [];
        }
        array_push($form->cssValidation[$field], 'email');
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function FormValidatorEmail($form, $field, $type, $message) {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor. Please refactor to parent::__construct().", 
                E_USER_DEPRECATED
            );
        }
        self::__construct($form, $field, $type, $message);
    }
}

?>