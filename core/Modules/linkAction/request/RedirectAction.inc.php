<?php
declare(strict_types=1);

/**
 * @file core.Modules.linkAction/request/RedirectAction.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class RedirectAction
 * @ingroup linkAction_request
 *
 * @brief This action request redirects to another page.
 * [WIZDAM EDITION] Refactored for PHP 8.x
 */

import('core.Modules.linkAction.request.LinkActionRequest');

class RedirectAction extends LinkActionRequest {
    /** @var string The URL this action will invoke */
    protected string $_url;

    /**
     * Constructor
     * @param string $url Target URL
     */
    public function __construct(string $url) {
        parent::__construct();
        $this->_url = $url;
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function RedirectAction($url) {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor. Please refactor to __construct().", 
                E_USER_DEPRECATED
            );
        }
        self::__construct($url);
    }

    //
    // Getters and Setters
    //
    /**
     * Get the target URL.
     * @return string
     */
    public function getUrl(): string {
        return $this->_url;
    }


    //
    // Overridden protected methods from LinkActionRequest
    //
    /**
     * @see LinkActionRequest::getJSLinkActionRequest()
     * @return string
     */
    public function getJSLinkActionRequest(): string {
        return '$.wizdam.classes.linkAction.RedirectRequest';
    }

    /**
     * @see LinkActionRequest::getLocalizedOptions()
     * @return array
     */
    public function getLocalizedOptions(): array {
        return array('url' => $this->getUrl());
    }
}

?>