<?php
declare(strict_types=1);

namespace App\Domain\Core;


/**
 * @file core.Modules.core/Request.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Request
 * @ingroup core
 *
 * @brief Class providing operations associated with HTTP requests.
 * Requests are assumed to be in the format http://host.tld/index.php/<journal_id>/<page_name>/<operation_name>/<arguments...>
 * <journal_id> is assumed to be "index" for top-level site requests.
 * WIZDAM EDITION: PHP 8 Compatibility (Static & Strict Types)
 */

import('core.Kernel.CoreRequest');

class Request extends CoreRequest {
    
    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function Request() {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::Request(). Please refactor to parent::__construct().", 
            E_USER_DEPRECATED
        );
        self::__construct();
    }

    /**
     * Deprecated
     * @see CorePageRouter::getRequestedContextPath()
     */
    public static function getRequestedJournalPath() {
        static $journal;
        $instance = CoreRequest::_checkThis();

        if (!isset($journal)) {
            $journal = $instance->_delegateToRouter('getRequestedContextPath', 1);
            // WIZDAM: HookRegistry::dispatch.
            // Note: Keep & because $journal is a string primitive we might want to modify via plugin.
            HookRegistry::dispatch('Request::getRequestedJournalPath', array(&$journal));
        }

        return $journal;
    }

    /**
     * Deprecated
     * @see CorePageRouter::getContext()
     */
    public static function getJournal() {
        $instance = CoreRequest::_checkThis();
        $returner = $instance->_delegateToRouter('getContext', 1);
        return $returner;
    }

    /**
     * Deprecated
     * @see CorePageRouter::getRequestedContextPath()
     */
    public static function getRequestedContextPath($contextLevel = null) {
        $instance = CoreRequest::_checkThis();

        // Emulate the old behavior of getRequestedContextPath for
        // backwards compatibility.
        if (is_null($contextLevel)) {
            return $instance->_delegateToRouter('getRequestedContextPaths');
        } else {
            return array($instance->_delegateToRouter('getRequestedContextPath', $contextLevel));
        }
    }

    /**
     * Deprecated
     * @see CorePageRouter::getContext()
     * Note: Parameter $level default value makes it slightly different from Parent, 
     * but since it is static, it shadows the parent method.
     */
    public static function getContext($level = 1) {
        $instance = CoreRequest::_checkThis();
        $returner = $instance->_delegateToRouter('getContext', $level);
        return $returner;
    }

    /**
     * Deprecated
     * @see CorePageRouter::getContextByName()
     */
    public static function getContextByName($contextName) {
        $instance = CoreRequest::_checkThis();
        $returner = $instance->_delegateToRouter('getContextByName', $contextName);
        return $returner;
    }

    /**
     * Deprecated
     * @see CorePageRouter::url()
     */
    public static function url($journalPath = null, $page = null, $op = null, $path = null,
            $params = null, $anchor = null, $escape = false) {
        $instance = CoreRequest::_checkThis();
        return $instance->_delegateToRouter('url', $journalPath, $page, $op, $path,
            $params, $anchor, $escape);
    }

    /**
     * Deprecated
     * @see PageRouter::redirectHome()
     */
    public static function redirectHome() {
        $instance = CoreRequest::_checkThis();
        return $instance->_delegateToRouter('redirectHome');
    }
}

?>