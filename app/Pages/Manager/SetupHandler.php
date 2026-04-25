<?php
declare(strict_types=1);

namespace App\Pages\Manager;


/**
 * @file pages/manager/SetupHandler.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SetupHandler
 * @ingroup pages_manager
 *
 * @brief Handle requests for journal setup functions.
 *
 * [WIZDAM EDITION] Refactored for PHP 8.1+ Strict Compliance
 */

import('app.Pages.manager.ManagerHandler');

class SetupHandler extends ManagerHandler {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function SetupHandler() {
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
     * Display journal setup form for the selected step.
     * Displays setup index page if a valid step is not specified.
     * @param array $args
     * @param CoreRequest $request
     */
    public function setup($args, $request) {
        $this->validate();
        $this->setupTemplate(true);

        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();

        $step = isset($args[0]) ? (int) $args[0] : 0;

        if ($step >= 1 && $step <= 5) {

            $formClass = "JournalSetupStep{$step}Form";
            import("core.Modules.manager.form.setup.$formClass");

            $setupForm = new $formClass();
            if ($setupForm->isLocaleResubmit()) {
                $setupForm->readInputData();
            } else {
                $setupForm->initData();
            }

            // [WIZDAM FIX] Root Cause Fixed.
            $setupForm->display($request);

        } else {
            $templateMgr = TemplateManager::getManager($request);
            $templateMgr->assign('helpTopicId', 'journal.managementPages.setup');
            $templateMgr->display('manager/setup/index.tpl');
        }
    }

    /**
     * Save changes to journal settings.
     * @param array $args
     * @param CoreRequest $request
     */
    public function saveSetup($args, $request) {
        $this->validate();

        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();

        $step = isset($args[0]) ? (int) $args[0] : 0;

        if ($step >= 1 && $step <= 5) {

            $this->setupTemplate(true);

            $formClass = "JournalSetupStep{$step}Form";
            import("core.Modules.manager.form.setup.$formClass");

            $setupForm = new $formClass();
            $setupForm->readInputData();
            $formLocale = $setupForm->getFormLocale();

            // Check for any special cases before trying to save
            switch ($step) {
                case 1:
                    if ((int) $request->getUserVar('addSponsor')) {
                        // Add a sponsor
                        $editData = true;
                        $sponsors = $setupForm->getData('sponsors');
                        array_push($sponsors, []);
                        $setupForm->setData('sponsors', $sponsors);

                    } elseif (($delSponsor = (array) $request->getUserVar('delSponsor')) && count($delSponsor) == 1) {
                        // Delete a sponsor
                        $editData = true;
                        list($delSponsor) = array_keys($delSponsor);
                        $delSponsor = (int) $delSponsor;
                        $sponsors = $setupForm->getData('sponsors');
                        array_splice($sponsors, $delSponsor, 1);
                        $setupForm->setData('sponsors', $sponsors);

                    } elseif ((int) $request->getUserVar('addContributor')) {
                        // Add a contributor
                        $editData = true;
                        $contributors = $setupForm->getData('contributors');
                        array_push($contributors, []);
                        $setupForm->setData('contributors', $contributors);

                    } elseif (($delContributor = (array) $request->getUserVar('delContributor')) && count($delContributor) == 1) {
                        // Delete a contributor
                        $editData = true;
                        list($delContributor) = array_keys($delContributor);
                        $delContributor = (int) $delContributor;
                        $contributors = $setupForm->getData('contributors');
                        array_splice($contributors, $delContributor, 1);
                        $setupForm->setData('contributors', $contributors);
                    }
                    break;

                case 2:
                    if ((int) $request->getUserVar('addCustomAboutItem')) {
                        // Add a custom about item
                        $editData = true;
                        $customAboutItems = $setupForm->getData('customAboutItems');
                        $customAboutItems[$formLocale][] = [];
                        $setupForm->setData('customAboutItems', $customAboutItems);

                    } elseif (($delCustomAboutItem = (array) $request->getUserVar('delCustomAboutItem')) && count($delCustomAboutItem) == 1) {
                        // Delete a custom about item
                        $editData = true;
                        list($delCustomAboutItem) = array_keys($delCustomAboutItem);
                        $delCustomAboutItem = (int) $delCustomAboutItem;
                        $customAboutItems = $setupForm->getData('customAboutItems');
                        if (!isset($customAboutItems[$formLocale])) $customAboutItems[$formLocale][] = [];
                        array_splice($customAboutItems[$formLocale], $delCustomAboutItem, 1);
                        $setupForm->setData('customAboutItems', $customAboutItems);
                    }
                    if ((int) $request->getUserVar('addReviewerDatabaseLink')) {
                        // Add a reviewer database link
                        $editData = true;
                        $reviewerDatabaseLinks = $setupForm->getData('reviewerDatabaseLinks');
                        array_push($reviewerDatabaseLinks, []);
                        $setupForm->setData('reviewerDatabaseLinks', $reviewerDatabaseLinks);

                    } elseif (($delReviewerDatabaseLink = (array) $request->getUserVar('delReviewerDatabaseLink')) && count($delReviewerDatabaseLink) == 1) {
                        // Delete a custom about item
                        $editData = true;
                        list($delReviewerDatabaseLink) = array_keys($delReviewerDatabaseLink);
                        $delReviewerDatabaseLink = (int) $delReviewerDatabaseLink;
                        $reviewerDatabaseLinks = $setupForm->getData('reviewerDatabaseLinks');
                        array_splice($reviewerDatabaseLinks, $delReviewerDatabaseLink, 1);
                        $setupForm->setData('reviewerDatabaseLinks', $reviewerDatabaseLinks);
                    }
                    break;

                case 3:
                    if ((int) $request->getUserVar('addChecklist')) {
                        // Add a checklist item
                        $editData = true;
                        $checklist = $setupForm->getData('submissionChecklist');
                        if (!isset($checklist[$formLocale]) || !is_array($checklist[$formLocale])) {
                            $checklist[$formLocale] = [];
                            $lastOrder = 0;
                        } else {
                            $lastOrder = $checklist[$formLocale][count($checklist[$formLocale])-1]['order'];
                        }
                        array_push($checklist[$formLocale], ['order' => $lastOrder+1]);
                        $setupForm->setData('submissionChecklist', $checklist);

                    } elseif (($delChecklist = (array) $request->getUserVar('delChecklist')) && count($delChecklist) == 1) {
                        // Delete a checklist item
                        $editData = true;
                        list($delChecklist) = array_keys($delChecklist);
                        $delChecklist = (int) $delChecklist;
                        $checklist = $setupForm->getData('submissionChecklist');
                        if (!isset($checklist[$formLocale])) $checklist[$formLocale] = [];
                        array_splice($checklist[$formLocale], $delChecklist, 1);
                        $setupForm->setData('submissionChecklist', $checklist);
                    }

                    if (!isset($editData)) {
                        // Reorder checklist items
                        $checklist = $setupForm->getData('submissionChecklist');
                        if (isset($checklist[$formLocale]) && is_array($checklist[$formLocale])) {
                            // [WIZDAM FIX] Replaced create_function with anonymous Closure
                            usort($checklist[$formLocale], function($a, $b) {
                                return $a['order'] <=> $b['order'];
                            });
                        } elseif (!isset($checklist[$formLocale])) {
                            $checklist[$formLocale] = [];
                        }
                        $setupForm->setData('submissionChecklist', $checklist);
                    }
                    break;

                case 4:
                    $router = $request->getRouter();
                    $journal = $router->getContext($request);
                    $templates = $journal->getSetting('templates');
                    import('app.Domain.File.JournalFileManager');
                    $journalFileManager = new JournalFileManager($journal);
                    if ((int) $request->getUserVar('addTemplate')) {
                        // Add a layout template
                        $editData = true;
                        if (!is_array($templates)) $templates = [];
                        $templateId = count($templates);
                        $originalFilename = $_FILES['template-file']['name'];
                        $fileType = $journalFileManager->getUploadedFileType('template-file');
                        $filename = "template-$templateId." . $journalFileManager->parseFileExtension($originalFilename);
                        $journalFileManager->uploadFile('template-file', $filename);
                        $templates[$templateId] = [
                            'originalFilename' => $originalFilename,
                            'fileType' => $fileType,
                            'filename' => $filename,
                            'title' => htmlspecialchars(trim((string) $request->getUserVar('template-title')), ENT_QUOTES, 'UTF-8')
                        ];
                        $journal->updateSetting('templates', $templates);
                        
                    } elseif (($delTemplate = (array) $request->getUserVar('delTemplate')) && count($delTemplate) == 1) {
                        // Delete a template
                        $editData = true;
                        list($delTemplate) = array_keys($delTemplate);
                        $delTemplate = (int) $delTemplate;
                        $template = $templates[$delTemplate];
                        $filename = "template-$delTemplate." . $journalFileManager->parseFileExtension($template['originalFilename']);
                        $journalFileManager->deleteFile($filename);
                        array_splice($templates, $delTemplate, 1);
                        $journal->updateSetting('templates', $templates);
                    }
                    $setupForm->setData('templates', $templates);
                    break;

                case 5:
                    if ((int) $request->getUserVar('uploadHomeHeaderTitleImage')) {
                        if ($setupForm->uploadImage('homeHeaderTitleImage', $formLocale)) {
                            $editData = true;
                        } else {
                            $setupForm->addError('homeHeaderTitleImage', __('manager.setup.homeTitleImageInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deleteHomeHeaderTitleImage')) {
                        $editData = true;
                        $setupForm->deleteImage('homeHeaderTitleImage', $formLocale);

                    } elseif ((int) $request->getUserVar('uploadHomeHeaderLogoImage')) {
                        if ($setupForm->uploadImage('homeHeaderLogoImage', $formLocale)) {
                            $editData = true;
                        } else {
                            $setupForm->addError('homeHeaderLogoImage', __('manager.setup.homeHeaderImageInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deleteHomeHeaderLogoImage')) {
                        $editData = true;
                        $setupForm->deleteImage('homeHeaderLogoImage', $formLocale);

                    } elseif ((int) $request->getUserVar('uploadJournalThumbnail')) {
                        if ($setupForm->uploadImage('journalThumbnail', $formLocale)) {
                            $editData = true;
                        } else {
                            $setupForm->addError('journalThumbnail', __('manager.setup.journalThumbnailInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deleteJournalThumbnail')) {
                        $editData = true;
                        $setupForm->deleteImage('journalThumbnail', $formLocale);

                    } elseif ((int) $request->getUserVar('uploadJournalFavicon')) {
                        if ($setupForm->uploadImage('journalFavicon', $formLocale)) {
                            $editData = true;
                        } else {
                            $setupForm->addError('journalFavicon', __('manager.setup.journalFaviconInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deleteJournalFavicon')) {
                        $editData = true;
                        $setupForm->deleteImage('journalFavicon', $formLocale);

                    } elseif ((int) $request->getUserVar('uploadPageHeaderTitleImage')) {
                        if ($setupForm->uploadImage('pageHeaderTitleImage', $formLocale)) {
                            $editData = true;
                        } else {
                            $setupForm->addError('pageHeaderTitleImage', __('manager.setup.pageHeaderTitleImageInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deletePageHeaderTitleImage')) {
                        $editData = true;
                        $setupForm->deleteImage('pageHeaderTitleImage', $formLocale);

                    } elseif ((int) $request->getUserVar('uploadPageHeaderLogoImage')) {
                        if ($setupForm->uploadImage('pageHeaderLogoImage', $formLocale)) {
                            $editData = true;
                        } else {
                            $setupForm->addError('pageHeaderLogoImage', __('manager.setup.pageHeaderLogoImageInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deletePageHeaderLogoImage')) {
                        $editData = true;
                        $setupForm->deleteImage('pageHeaderLogoImage', $formLocale);

                    } elseif ((int) $request->getUserVar('uploadHomepageImage')) {
                        if ($setupForm->uploadImage('homepageImage', $formLocale)) {
                            $editData = true;
                        } else {
                            $setupForm->addError('homepageImage', __('manager.setup.homepageImageInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deleteHomepageImage')) {
                        $editData = true;
                        $setupForm->deleteImage('homepageImage', $formLocale);
                    } elseif ((int) $request->getUserVar('uploadJournalStyleSheet')) {
                        if ($setupForm->uploadStyleSheet('journalStyleSheet')) {
                            $editData = true;
                        } else {
                            $setupForm->addError('journalStyleSheet', __('manager.setup.journalStyleSheetInvalid'));
                        }

                    } elseif ((int) $request->getUserVar('deleteJournalStyleSheet')) {
                        $editData = true;
                        $setupForm->deleteImage('journalStyleSheet');

                    } elseif ((int) $request->getUserVar('addNavItem')) {
                        // Add a navigation bar item
                        $editData = true;
                        $navItems = $setupForm->getData('navItems');
                        $navItems[$formLocale][] = [];
                        $setupForm->setData('navItems', $navItems);

                    } elseif (($delNavItem = (array) $request->getUserVar('delNavItem')) && count($delNavItem) == 1) {
                        // Delete a  navigation bar item
                        $editData = true;
                        list($delNavItem) = array_keys($delNavItem);
                        $delNavItem = (int) $delNavItem;
                        $navItems = $setupForm->getData('navItems');
                        if (is_array($navItems) && is_array($navItems[$formLocale])) {
                            array_splice($navItems[$formLocale], $delNavItem, 1);
                            $setupForm->setData('navItems', $navItems);
                        }
                    }
                    break;
            }

            if (!isset($editData) && $setupForm->validate()) {
                $setupForm->execute();
                $request->redirect(null, null, 'setupSaved', $step);
            } else {
                $setupForm->display($request);
            }

        } else {
            $request->redirect();
        }
    }

    /**
     * Display a "Settings Saved" message
     * @param array $args
     * @param CoreRequest $request
     */
    public function setupSaved($args, $request) {
        $this->validate();

        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();

        $step = isset($args[0]) ? (int) $args[0] : 0;

        if ($step >= 1 && $step <= 5) {
            $this->setupTemplate(true);

            $templateMgr = TemplateManager::getManager($request);
            $templateMgr->assign('setupStep', $step);
            $templateMgr->assign('helpTopicId', 'journal.managementPages.setup');
            $templateMgr->display('manager/setup/settingsSaved.tpl');
        } else {
            $request->redirect(null, 'index');
        }
    }

    /**
     * Download a layout template.
     * @param array $args
     * @param CoreRequest $request
     */
    public function downloadLayoutTemplate($args, $request) {
        $this->validate();

        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();

        $router = $request->getRouter();
        $journal = $router->getContext($request);
        $templates = $journal->getSetting('templates');
        import('app.Domain.File.JournalFileManager');
        $journalFileManager = new JournalFileManager($journal);
        $templateId = (int) array_shift($args);
        if ($templateId >= count($templates) || $templateId < 0) $request->redirect(null, null, 'setup');
        $template = $templates[$templateId];

        $filename = "template-$templateId." . $journalFileManager->parseFileExtension($template['originalFilename']);
        $journalFileManager->downloadFile($filename, $template['fileType']);
    }

    /**
     * Reset the license attached to article content.
     * @param array $args
     * @param CoreRequest $request
     */
    public function resetPermissions($args, $request) {
        $this->validate();

        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();

        $router = $request->getRouter();
        $journal = $router->getContext($request);

        $articleDao = DAORegistry::getDAO('ArticleDAO');
        $articleDao->resetPermissions($journal->getId());

        $request->redirect(null, null, 'setup', ['3']);
    }
}
?>