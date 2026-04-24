<?php
declare(strict_types=1);

namespace App\Controllers\Grid\Citation;


/**
 * @file controllers/grid/citation/CitationGridHandler.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CitationGridHandler
 * @ingroup controllers_grid_citation
 *
 * @brief Handle Wizdam specific parts of citation grid requests.
 * [WIZDAM EDITION] Refactored for PHP 8.x
 */

import('core.Modules.controllers.grid.citation.CoreCitationGridHandler');

// import validation classes
import('core.Modules.handler.validation.HandlerValidatorJournal');
import('core.Modules.handler.validation.HandlerValidatorRoles');

class CitationGridHandler extends CoreCitationGridHandler {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->addRoleAssignment(
            [ROLE_ID_EDITOR, ROLE_ID_SECTION_EDITOR],
            [
                'fetchGrid', 'addCitation', 'editCitation', 'updateRawCitation',
                'checkCitation', 'updateCitation', 'deleteCitation', 'exportCitations',
                'fetchCitationFormErrorsAndComparison', 'sendAuthorQuery'
            ]
        );
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function CitationGridHandler() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor. Please refactor to parent::__construct().", 
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
    public function authorize($request, &$args, $roleAssignments) {
        // Make sure the user can edit the submission in the request.
        import('core.Modules.security.authorization.AppSubmissionAccessPolicy');
        $this->addPolicy(new AppSubmissionAccessPolicy($request, $args, $roleAssignments, 'assocId'));
        return parent::authorize($request, $args, $roleAssignments);
    }

    /**
     * @see CoreHandler::initialize()
     * @param CoreRequest $request
     * @param array|null $args
     */
    public function initialize($request, $args = null) {
        // Associate the citation editor with the authorized article.
        $this->setAssocType(ASSOC_TYPE_ARTICLE);
        $article = $this->getAuthorizedContextObject(ASSOC_TYPE_ARTICLE);
        
        // [WIZDAM] Use instanceof for cleaner type checking
        if (!$article instanceof Article) {
            fatalError('Authorized context object is not an instance of Article!');
        }
        
        $this->setAssocObject($article);

        parent::initialize($request, $args);
    }

    //
    // Override methods from CoreCitationGridHandler
    //

    /**
     * @see CoreCitationGridHandler::exportCitations()
     * @param array $args
     * @param CoreRequest $request
     */
    public function exportCitations($args, $request) {
        $dispatcher = $this->getDispatcher();
        $articleMetadataUrl = $dispatcher->url($request, ROUTE_PAGE, null, 'editor', 'viewMetadata', $this->getAssocId());
        
        $noCitationsFoundMessage = __("submission.citations.editor.pleaseImportCitationsFirst", ['articleMetadataUrl' => $articleMetadataUrl]);
        
        return parent::exportCitations($args, $request, $noCitationsFoundMessage);
    }
}

?>