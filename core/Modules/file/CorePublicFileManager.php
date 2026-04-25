<?php
declare(strict_types=1);

/**
 * @file core.Modules.file/CorePublicFileManager.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CorePublicFileManager
 * @ingroup file
 *
 * @brief Wrapper class for uploading files to a site/journal's public directory.
 */

import('core.Modules.file.FileManager');

class CorePublicFileManager extends FileManager {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function CorePublicFileManager() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error('Class ' . get_class($this) . ' uses deprecated constructor parent::CorePublicFileManager(). Please refactor to parent::__construct().', E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * Get the path to the site public files directory.
     * @return string
     */
    public function getSiteFilesPath() {
        return Config::getVar('files', 'public_files_dir') . '/site';
    }

    /**
     * Upload a file to the site's public directory.
     * Note: This uses the secured FileManager::uploadFile() which enforces extension whitelists.
     * @param $fileName string the name of the file in the upload form
     * @param $destFileName string the destination file name
     * @return boolean
     */
    public function uploadSiteFile($fileName, $destFileName) {
        return $this->uploadFile($fileName, $this->getSiteFilesPath() . '/' . $destFileName);
    }

    /**
     * Delete a file from the site's public directory.
     * @param $fileName string the target file name
     * @return boolean
     */
    public function removeSiteFile($fileName) {
        return $this->deleteFile($this->getSiteFilesPath() . '/' . $fileName);
    }
}

?>