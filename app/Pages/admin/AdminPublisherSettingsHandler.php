<?php
declare(strict_types=1);

namespace App\Pages\Admin;


/**
 * @file pages.admin.AdminPublisherSettingsHandler.inc.php
 *
 * Copyright (c) 2013-2025 Wizdam Editorial Project
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AdminPublisherSettingsHandler
 * @ingroup pages_admin
 *
 * @brief Handle requests for changing publisher admin settings.
 *
 * [WIZDAM EDITION] Refactored for PHP 8.1+ Strict Compliance
 */

import('app.Pages.admin.AdminHandler');

class AdminPublisherSettingsHandler extends AdminHandler {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function AdminPublisherSettingsHandler() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor parent::" . get_class($this) . "(). Please refactor to use parent::__construct().",
                E_USER_DEPRECATED
            );
        }
        $args = func_get_args();
        call_user_func_array([$this, '__construct'], $args);
    }

    /**
     * Display form to modify publisher settings.
     * @param array $args
     * @param CoreRequest $request
     */
    public function settings($args = [], $request = null) {
        $this->validate();
        $this->setupTemplate(true);

        import('app.Classes.admin.form.PublisherSettingsForm');

        $settingsForm = new PublisherSettingsForm();
        if ($settingsForm->isLocaleResubmit()) {
            $settingsForm->readInputData();
        } else {
            $settingsForm->initData();
        }
        $settingsForm->display();
    }

    /**
     * Validate and save changes to site settings.
     * @param array $args
     * @param CoreRequest $request
     */
    public function saveSettings($args, $request) {
        $this->validate();
        $this->setupTemplate(true);
        
        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();
        
        $site = $request->getSite();

        import('core.Modules.admin.form.SiteSettingsForm');
        import('core.Modules.file.PublicFileManager'); // [WIZDAM] Explicit import

        $settingsForm = new SiteSettingsForm();
        $settingsForm->readInputData();

        if ((int) $request->getUserVar('uploadSiteStyleSheet')) {
            if (!$settingsForm->uploadSiteStyleSheet()) {
                $settingsForm->addError('siteStyleSheet', __('admin.settings.siteStyleSheetInvalid'));
            }
        } elseif ((int) $request->getUserVar('deleteSiteStyleSheet')) {
            $publicFileManager = new PublicFileManager();
            $publicFileManager->removeSiteFile($site->getSiteStyleFilename());
        } elseif ((int) $request->getUserVar('uploadPageHeaderTitleImage')) {
            if (!$settingsForm->uploadPageHeaderTitleImage($settingsForm->getFormLocale())) {
                $settingsForm->addError('pageHeaderTitleImage', __('admin.settings.homeHeaderImageInvalid'));
            }
        } elseif ((int) $request->getUserVar('deletePageHeaderTitleImage')) {
            $publicFileManager = new PublicFileManager();
            $setting = $site->getSetting('pageHeaderTitleImage');
            $formLocale = $settingsForm->getFormLocale();
            if (isset($setting[$formLocale])) {
                $publicFileManager->removeSiteFile($setting[$formLocale]['uploadName']);
                $setting[$formLocale] = [];
                $site->updateSetting('pageHeaderTitleImage', $setting, 'object', true);

                // Refresh site header
                $templateMgr = TemplateManager::getManager();
                $templateMgr->assign('displayPageHeaderTitle', $site->getLocalizedPageHeaderTitle());
            }
        } elseif ($settingsForm->validate()) {
            $settingsForm->execute();
            $user = $request->getUser();
            import('core.Modules.notification.NotificationManager');
            $notificationManager = new NotificationManager();
            $notificationManager->createTrivialNotification($user->getId());
            $request->redirect(null, null, 'index');
        }
        $settingsForm->display();
    }
}
?>