<?php
declare(strict_types=1);

/**
 * @file core.Modules.codelist/SubjectDAO.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SubjectDAO
 * @ingroup codelist
 * @see Subject
 *
 * @brief Operations for retrieving and modifying Subject Subject objects.
 *
 */

import('core.Modules.codelist.Subject');
import('core.Modules.codelist.CodelistItemDAO');

class SubjectDAO extends CodelistItemDAO {

    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function SubjectDAO() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor parent::'" . get_class($this) . "'. Please refactor to parent::__construct().", 
                E_USER_DEPRECATED
            );
        }
        self::__construct();
    }

    /**
     * Get the filename of the subject database
     * @param string $locale
     * @return string
     */
    public function getFilename(string $locale): string {
        if (!AppLocale::isLocaleValid($locale)) {
            $locale = AppLocale::MASTER_LOCALE;
        }
        return "lib/wizdam/locale/$locale/bic21subjects.xml";
    }

    /**
     * Get the base node name particular codelist database
     * This is also the node name in the XML.
     * @return string
     */
    public function getName(): string {
        return 'subject';
    }

    /**
     * Get the name of the CodelistItem class.
     * @return Subject
     */
    public function newDataObject(): Subject {
        return new Subject();
    }
}

?>