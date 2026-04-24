<?php
declare(strict_types=1);

/**
 * @file plugins/generic/stopForumSpam/StopForumSpamPlugin.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class StopForumSpamPlugin
 * @ingroup plugins_generic_stopForumSpam
 *
 * @brief Stop Forum Spam plugin class
 *
 * @edition Wizdam Edition (PHP 8.x Compatible)
 */

define('STOP_FORUM_SPAM_API_ENDPOINT', 'http://www.stopforumspam.com/api?');

import('core.Modules.plugins.GenericPlugin');

class StopForumSpamPlugin extends GenericPlugin {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function StopForumSpamPlugin() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error("Class '" . get_class($this) . "' uses deprecated constructor parent::StopForumSpamPlugin(). Please refactor to parent::__construct().", E_USER_DEPRECATED);
        }
        $args = func_get_args();
        call_user_func_array(array($this, '__construct'), $args);
    }

    /**
     * Called as a plugin is registered to the registry
     * @param string $category Name of category plugin was registered to
     * @param string $path
     * @return boolean True iff plugin initialized successfully; if false,
     * the plugin will not be registered.
     */
    public function register(string $category, string $path): bool {
        $success = parent::register($category, $path);
        if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
        if ($success && $this->getEnabled()) {
            // Hook for validate in registration form
            HookRegistry::register('registrationform::validate', [$this, 'validateExecute']);
        }
        return $success;
    }

    /**
     * Get display name
     * @return string
     */
    public function getDisplayName(): string {
        return __('plugins.generic.stopForumSpam.displayName');
    }

    /**
     * Get description
     * @return string
     */
    public function getDescription(): string {
        return __('plugins.generic.stopForumSpam.description');
    }

    /**
     * Extend the {url ...} smarty to support this plugin.
     * @param array $params
     * @param object $smarty
     * @return string
     */
    public function smartyPluginUrl(array $params, $smarty): string {
        $path = [$this->getCategory(), $this->getName()];
        if (is_array($params['path'])) {
            $params['path'] = array_merge($path, $params['path']);
        } elseif (!empty($params['path'])) {
            $params['path'] = array_merge($path, [$params['path']]);
        } else {
            $params['path'] = $path;
        }

        if (!empty($params['id'])) {
            $params['path'] = array_merge($params['path'], [$params['id']]);
            unset($params['id']);
        }
        return $smarty->smartyUrl($params, $smarty);
    }

    /**
     * Set the page's breadcrumbs, given the plugin's tree of items
     * to append.
     * @param boolean $isSubclass
     */
    public function setBreadcrumbs($isSubclass = false) {
        $templateMgr = TemplateManager::getManager();
        $pageCrumbs = [
            [
                Request::url(null, 'user'),
                'navigation.user'
            ],
            [
                Request::url(null, 'manager'),
                'user.role.manager'
            ]
        ];
        if ($isSubclass) $pageCrumbs[] = [
            Request::url(null, 'manager', 'plugins'),
            'manager.plugins'
        ];

        $templateMgr->assign('pageHierarchy', $pageCrumbs);
    }

    /**
     * Display verbs for the management interface.
     * @param array $verbs An array of management verbs
     * @param Request $request
     * @return array
     */
    public function getManagementVerbs(array $verbs = [], $request = null): array {
        $verbs = parent::getManagementVerbs($verbs, $request);
        if ($this->getEnabled($request)) {
            $verbs[] = ['settings', __('plugins.generic.stopForumSpam.manager.settings')];
        }
        return $verbs;
    }

    /**
     * Provides a hook against the validate() method in the RegistrationForm class.
     * This function initiates a curl() call to the Stop Forum Spam API and submits
     * the new user data for querying.  If there is a positive match, the method
     * inserts a form validation error and returns true, preventing the form from
     * validating successfully.
     *
     * The first element in the $params array is the form object being submitted.
     *
     * @param string $hookName
     * @param array $params
     * @return boolean
     */
    public function validateExecute($hookName, $params) {

        $form = $params[0];

        // Prepare HTTP session.
        $curlCh = curl_init();
        if ($httpProxyHost = Config::getVar('proxy', 'http_host')) {
            curl_setopt($curlCh, CURLOPT_PROXY, $httpProxyHost);
            curl_setopt($curlCh, CURLOPT_PROXYPORT, Config::getVar('proxy', 'http_port', '80'));
            if ($username = Config::getVar('proxy', 'username')) {
                curl_setopt($curlCh, CURLOPT_PROXYUSERPWD, $username . ':' . Config::getVar('proxy', 'password'));
            }
        }
        curl_setopt($curlCh, CURLOPT_RETURNTRANSFER, true);
        // [SECURITY FIX] Add timeout
        curl_setopt($curlCh, CURLOPT_TIMEOUT, 10);

        // assemble the URL with our parameters.
        $url = STOP_FORUM_SPAM_API_ENDPOINT;

        $journal = Request::getJournal();
        $journalId = $journal->getId();

        // By including all three possibilities in the URL, we always get an XML document back from the API call.
        $ip = (bool)$this->getSetting($journalId, 'checkIp') ? urlencode(Request::getRemoteAddr()) : '';
        $url .= 'ip=' . $ip . '&';

        $email = (bool)$this->getSetting($journalId, 'checkEmail') ? urlencode($form->getData('email')) : '';
        $url .= 'email=' . $email . '&';

        $username = (bool)$this->getSetting($journalId, 'checkUsername') ? urlencode($form->getData('username')) : '';
        $url .= 'username=' . $username;

        // Make the request.
        curl_setopt($curlCh, CURLOPT_URL, $url);

        $response = curl_exec($curlCh);

        // The API call returns a small XML document that contains an <appears> element for each search parameter.
        // A sample result would be:

        //    <response success="true">
        //    <type>ip</type>
        //    <appears>no</appears>
        //    <type>email</type>
        //    <appears>yes</appears>
        //    <lastseen>2009-06-25 00:24:29</lastseen>
        //    </response>

        // We can simply look for the element.  It isn't important which parameter matches.  Parameters that are
        // empty always produce <appears>no</appears> elements.

        if ($response && preg_match('/<appears>yes<\/appears>/', $response)) {
            $form->addError(__('plugins.generic.stopForumSpam.checkName'), __('plugins.generic.stopForumSpam.checkMessage'));
            return true;
        }

        return false;
    }

    /**
     * Execute a management verb on this plugin
     * @param string $verb
     * @param array $args
     * @param string $message Result status message
     * @param array $messageParams Parameters for the message key
     * @return boolean
     */
    public function manage(string $verb, array $args, string $message, array $messageParams, $request = null): bool {
        if (!parent::manage($verb, $args, $message, $messageParams, $request)) return false;

        if (!$request) $request = Registry::get('request');

        switch ($verb) {
            case 'settings':
                $templateMgr = TemplateManager::getManager();
                $templateMgr->register_function('plugin_url', [$this, 'smartyPluginUrl']);
                $journal = $request->getJournal();

                $this->import('StopForumSpamSettingsForm');
                $form = new StopForumSpamSettingsForm($this, $journal->getId());
                if (Request::getUserVar('save')) {
                    $form->readInputData();
                    if ($form->validate()) {
                        $form->execute();
                        $request->redirect(null, 'manager', 'plugins', $this->getCategory());
                        return false;
                    } else {
                        $this->setBreadcrumbs(true);
                        $form->display();
                    }
                } else {
                    $this->setBreadcrumbs(true);
                    $form->initData();
                    $form->display();
                }
                return true;
            default:
                // Unknown management verb
                assert(false);
                return false;
        }
    }
}
?>