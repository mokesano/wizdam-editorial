<?php
declare(strict_types=1);

namespace App\Domain\Announcement;


/**
 * @file core.Modules.announcement/AnnouncementTypeDAO.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AnnouncementTypeDAO
 * @ingroup announcement
 * @see AnnouncementType
 *
 * @brief Operations for retrieving and modifying AnnouncementType objects.
 *
 * WIZDAM MODERNIZATION:
 * - PHP 8.x Compatibility (Constructor)
 * - Strict SHIM
 * - Visibility explicit
 */

import('core.Modules.announcement.AnnouncementType');
import('core.Modules.announcement.CoreAnnouncementTypeDAO');

class AnnouncementTypeDAO extends CoreAnnouncementTypeDAO {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function AnnouncementTypeDAO() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error('Class AnnouncementTypeDAO uses deprecated constructor parent::AnnouncementTypeDAO(). Please refactor to parent::__construct().', E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * @see CoreAnnouncementTypeDAO::newDataObject
     * @return AnnouncementType
     */
    public function newDataObject() {
        return new AnnouncementType();
    }
}

?>