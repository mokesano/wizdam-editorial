<?php
declare(strict_types=1);

/**
 * @file core.Modules.announcement/AnnouncementDAO.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AnnouncementDAO
 * @ingroup announcement
 * @see Announcement
 *
 * @brief Operations for retrieving and modifying Announcement objects.
 *
 * WIZDAM MODERNIZATION:
 * - PHP 8.x Compatibility (Constructor)
 * - Strict SHIM
 * - Visibility explicit
 */


import('core.Modules.announcement.Announcement');
import('core.Modules.announcement.CoreAnnouncementDAO');

class AnnouncementDAO extends CoreAnnouncementDAO {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function AnnouncementDAO() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error('Class AnnouncementDAO uses deprecated constructor parent::AnnouncementDAO(). Please refactor to parent::__construct().', E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * @see CoreAnnouncementDAO::newDataObject
     * @return Announcement
     */
    public function newDataObject() {
        return new Announcement();
    }
}

?>