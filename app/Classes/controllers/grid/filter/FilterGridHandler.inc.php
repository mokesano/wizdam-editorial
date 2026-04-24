<?php
declare(strict_types=1);

/**
 * @file core.Modules.controllers/grid/filter/FilterGridHandler.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2000-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class FilterGridHandler
 * @ingroup classes_controllers_grid_filter
 *
 * @brief Handle Wizdam specific parts of filter grid requests.
 * [WIZDAM EDITION] Refactored for PHP 8.x
 */

import('core.Modules.controllers.grid.filter.CoreFilterGridHandler');

// import validation classes
import('core.Modules.handler.validation.HandlerValidatorJournal');
import('core.Modules.handler.validation.HandlerValidatorRoles');

class FilterGridHandler extends CoreFilterGridHandler {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->addRoleAssignment(
                [ROLE_ID_SITE_ADMIN, ROLE_ID_JOURNAL_MANAGER],
                ['fetchGrid', 'addFilter', 'editFilter', 'updateFilter', 'deleteFilter']
        );
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function FilterGridHandler() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor parent::'" . get_class($this) . "'. Please refactor to parent::__construct().", 
                E_USER_DEPRECATED
            );
        }
        self::__construct();
    }


    //
    // Implement template methods from CoreHandler
    //
    
    /**
     * @see CoreHandler::authorize()
     * @param CoreRequest $request
     * @param array $args
     * @param array $roleAssignments
     */
    public function authorize($request, $args, $roleAssignments) {
        // [WIZDAM] Singleton Fallback
        if (!$request) $request = Application::get()->getRequest();

        // Make sure the user can change the journal setup.
        import('core.Modules.security.authorization.AppJournalAccessPolicy');
        $this->addPolicy(new AppJournalAccessPolicy($request, $roleAssignments));
        return parent::authorize($request, $args, $roleAssignments);
    }
}

?>