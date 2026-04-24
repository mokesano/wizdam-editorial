<?php
declare(strict_types=1);

/**
 * @file core.Modules.form/validation/FormValidatorLocaleUrl.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class FormValidatorLocaleUrl
 * @ingroup form_validation
 * @see FormValidatorLocale
 *
 * @brief Form validation check for URL addresses.
 * [WIZDAM EDITION] Refactored for PHP 8.x
 */

import('core.Modules.form.validation.FormValidatorLocale');
import('core.Modules.validation.ValidatorUrl');

class FormValidatorLocaleUrl extends FormValidatorLocale {
    
    /**
     * Constructor.
     * @param Form $form the associated form
     * @param string $field the name of the associated field
     * @param string $type the type of check, either "required" or "optional"
     * @param string $message the error message for validation failures (i18n key)
     * @param string|null $requiredLocale The symbolic name of the required locale
     */
    public function __construct($form, $field, $type, $message, $requiredLocale = null) {
        $validator = new ValidatorUrl();
        parent::__construct($form, $field, $type, $message, $requiredLocale, $validator);
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function FormValidatorLocaleUrl($form, $field, $type, $message, $requiredLocale = null) {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor. Please refactor to parent::__construct().", 
                E_USER_DEPRECATED
            );
        }
        self::__construct($form, $field, $type, $message, $requiredLocale);
    }
}

?>