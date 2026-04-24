<?php
declare(strict_types=1);

/**
 * @file core.Modules.user/User.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class User
 * @ingroup user
 * @see UserDAO
 *
 * @brief Basic class describing users existing in the system.
 */

import('core.Modules.user.CoreUser');

class User extends CoreUser {

	/**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function User() {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::User(). Please refactor to parent::__construct().", 
            E_USER_DEPRECATED
        );
        self::__construct();
    }
    
    /**
	 * Retrieve array of user settings.
	 * @param journalId int
	 * @return array
	 */
	public function getSettings($journalId = null) {
		$userSettingsDao = DAORegistry::getDAO('UserSettingsDAO');
		$settings = $userSettingsDao->getSettingsByJournal($this->getId(), $journalId);
		return $settings;
	}

	/**
	 * Retrieve a user setting value.
	 * @param $name
	 * @param $journalId int
	 * @return mixed
	 */
	public function getSetting($name, $journalId = null) {
		$userSettingsDao = DAORegistry::getDAO('UserSettingsDAO');
		$setting = $userSettingsDao->getSetting($this->getId(), $name, $journalId);
		return $setting;
	}

	/**
	 * Set a user setting value.
	 * @param $name string
	 * @param $value mixed
	 * @param $type string optional
	 */
	public function updateSetting($name, $value, $type = null, $journalId = null) {
		$userSettingsDao = DAORegistry::getDAO('UserSettingsDAO');
		return $userSettingsDao->updateSetting($this->getId(), $name, $value, $type, $journalId);
	}
}
?>