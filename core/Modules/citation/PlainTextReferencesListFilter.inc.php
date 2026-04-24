<?php
declare(strict_types=1);

/**
 * @file core.Modules.citation/PlainTextReferencesListFilter.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PlainTextReferencesListFilter
 * @ingroup classes_citation
 *
 * @brief Class that converts a submission to a plain text references list
 * based on the configured ordering type and citation output filter.
 *
 * [WIZDAM EDITION] Refactored for PHP 8.1+ Strict Compliance
 */

import('core.Modules.citation.TemplateBasedReferencesListFilter');
import('core.Modules.citation.PlainTextReferencesList');

class PlainTextReferencesListFilter extends TemplateBasedReferencesListFilter {
    
    /**
     * Constructor
     * @param FilterGroup $filterGroup
     */
    public function __construct($filterGroup) {
        // Add the persistable filter settings.
        import('core.Modules.filter.SetFilterSetting');
        $this->addSetting(new SetFilterSetting('ordering', null, null,
                [REFERENCES_LIST_ORDERING_ALPHABETICAL, REFERENCES_LIST_ORDERING_NUMERICAL]));

        parent::__construct($filterGroup);
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function PlainTextReferencesListFilter() {
        if (Config::getVar('debug', 'deprecation_warnings')) {
            trigger_error(
                "Class '" . get_class($this) . "' uses deprecated constructor parent::" . get_class($this) . "(). Please refactor to use parent::__construct().",
                E_USER_DEPRECATED
            );
        }
        $args = func_get_args();
        call_user_func_array([$this, '__construct'], $args);
    }

    //
    // Implement template methods from TemplateBasedReferencesListFilter
    //
    /**
     * @see TemplateBasedReferencesListFilter::getCitationOutputFilterTypeDescriptions()
     * @return array
     */
    public function getCitationOutputFilterTypeDescriptions() {
        return [
                'metadata::core.Modules.plugins.metadata.nlm30.schema.Nlm30CitationSchema(CITATION)',
                'primitive::string'
        ];
    }

    //
    // Implement template methods from PersistableFilter
    //
    /**
     * @see PersistableFilter::getClassName()
     * @return string
     */
    public function getClassName() {
        return 'core.Modules.citation.PlainTextReferencesListFilter';
    }

    //
    // Implement template methods from Filter
    //
    /**
     * @see Filter::process()
     * @param mixed $input
     * @return PlainTextReferencesList
     */
    public function process($input) {
        $output = parent::process($input);
        // [WIZDAM FIX] Explicit casting for strict type compliance
        $referencesList = new PlainTextReferencesList((string) $output, (int) $this->getData('ordering'));
        return $referencesList;
    }

    //
    // Implement template methods from TemplateBasedFilter
    //
    /**
     * @see TemplateBasedFilter::addTemplateVars()
     * @param CoreTemplateManager $templateMgr
     * @param Submission $submission
     * @param CoreRequest $request
     * @param string $locale
     */
    public function addTemplateVars($templateMgr, $submission, $request, $locale) {
        parent::addTemplateVars($templateMgr, $submission, $request, $locale);

        // Add the ordering type to the template.
        $templateMgr->assign('ordering', $this->getData('ordering'));
    }

    /**
     * @see TemplateBasedFilter::getTemplateName()
     * @return string
     */
    public function getTemplateName() {
        return 'references-list.tpl';
    }

    /**
     * @see TemplateBasedFilter::getBasePath()
     * @return string
     */
    public function getBasePath() {
        return dirname(__FILE__);
    }
}

?>