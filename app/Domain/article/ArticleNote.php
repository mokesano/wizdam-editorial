<?php
declare(strict_types=1);

namespace App\Domain\Article;


/**
 * @file core.Modules.article/ArticleNote.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ArticleNote
 * @ingroup article
 * @see ArticleNoteDAO
 *
 * @brief Class for ArticleNote.
 *
 * WIZDAM MODERNIZATION:
 * - PHP 8.x Compatibility (Constructor)
 * - Strict SHIM
 */

import('core.Modules.note.Note');

class ArticleNote extends Note {
    
    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function ArticleNote() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            // [CCTV] Untuk menangkap identitas Class Anak/Pemanggil
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor parent::ArticleNote(). Please refactor to parent::__construct().", 
                E_USER_DEPRECATED
            );
        }
        self::__construct();
    }
}

?>