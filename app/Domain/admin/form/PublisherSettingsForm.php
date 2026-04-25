<?php
declare(strict_types=1);

namespace App\Domain\Admin\Form;


/**
 * @file app.Classes.admin.form.PublisherSettingsForm.inc.php
 *
 * Copyright (c) 2013-2025 Wizdam Editorial Project
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PublisherSettingsForm
 * @ingroup admin_form
 * @see CorePublisherSettingsForm
 *
 * @brief Form to edit publisher settings.
 * [WIZDAM EDITION] Refactored for PHP 8.x
 */

import('core.Modules.admin.form.CorePublisherSettingsForm');

class PublisherSettingsForm extends CorePublisherSettingsForm {
    
    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function PublisherSettingsForm() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor. Please refactor to parent::__construct().", 
                E_USER_DEPRECATED
            );
        }
        self::__construct();
    }

    /**
     * Display the form.
     * @param CoreRequest|null $request
     * @param string|null $template
     */
    public function display($request = null, $template = null) {
        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();

        $pressDao = DAORegistry::getDAO('PressDAO');
        $presses = $pressDao->getPressTitles();
        $templateMgr = TemplateManager::getManager($request);

        $allThemes = PluginRegistry::loadCategory('themes');
        $themes = [];
        
        // [WIZDAM] Simplified iteration
        if (!empty($allThemes)) {
            foreach ($allThemes as $plugin) {
                $themes[basename($plugin->getPluginPath())] = $plugin;
            }
        }
        
        $templateMgr->assign('themes', $themes);
        $templateMgr->assign('redirectOptions', $presses);

        $application = Application::get();
        $templateMgr->assign('availableMetricTypes', $application->getMetricTypes(true));

        return parent::display($request, $template);
    }

    /**
     * Initialize the form from the current settings.
     */
    public function initData() {
        parent::initData();

        $publisherDao = DAORegistry::getDAO('PublisherDAO');
        $publisher = $publisherDao->getPublisher();

        $this->_data['useAlphalist'] = $publisher->getSetting('useAlphalist');
        $this->_data['usePaging'] = $publisher->getSetting('usePaging');
        $this->_data['defaultMetricType'] = $publisher->getSetting('defaultMetricType');
        $this->_data['preventManagerPluginManagement'] = $publisher->getSetting('preventManagerPluginManagement');
    }

    /**
     * Assign user-submitted data to form.
     * @param bool $callHooks
     */
    public function readInputData($callHooks = true) {
        $this->readUserVars(['useAlphalist', 'usePaging', 'defaultMetricType', 'preventManagerPluginManagement']);
        return parent::readInputData($callHooks);
    }

    /**
     * Save the from parameters.
     * @param object|null $object
     */
    public function execute($object = null) {
        parent::execute($object);

        /** @var PublisherSettingsDAO $publisherSettingsDao */
        $publisherSettingsDao = $this->publisherSettingsDao; 
        
        $publisherSettingsDao->updateSetting('useAlphalist', (bool) $this->getData('useAlphalist'), 'bool');
        $publisherSettingsDao->updateSetting('usePaging', (bool) $this->getData('usePaging'), 'bool');
        $publisherSettingsDao->updateSetting('defaultMetricType', (string) $this->getData('defaultMetricType'), 'string');
        $publisherSettingsDao->updateSetting('preventManagerPluginManagement', (bool) $this->getData('preventManagerPluginManagement'), 'bool');
    }
}

?>