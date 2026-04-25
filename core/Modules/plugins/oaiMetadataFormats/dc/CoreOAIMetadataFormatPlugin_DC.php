<?php
declare(strict_types=1);

/**
 * @file plugins/oaiMetadata/dc/CoreOAIMetadataFormatPlugin_DC.inc.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CoreOAIMetadataFormatPlugin_DC
 * @see OAI
 *
 * @brief dc metadata format plugin for OAI.
 * * REFACTORED: Wizdam Edition (PHP 7.4 - 8.x Modernization)
 */

import('core.Modules.plugins.OAIMetadataFormatPlugin');

class CoreOAIMetadataFormatPlugin_DC extends OAIMetadataFormatPlugin {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * [SHIM] Backward Compatibility
     */
    public function CoreOAIMetadataFormatPlugin_DC() {
        trigger_error(
            "Class '" . get_class($this) . "' uses deprecated constructor parent::CoreOAIMetadataFormatPlugin_DC(). Please refactor to use parent::__construct().",
            E_USER_DEPRECATED
        );
        self::__construct();
    }
    
    /**
     * Get the name of this plugin. The name must be unique within
     * its category.
     * @return String name of plugin
     */
    public function getName(): string {
        return 'OAIMetadataFormatPlugin_DC';
    }

    /**
     * Get the display name of this plugin.
     * @return String
     */
    public function getDisplayName(): string {
        return __('plugins.oaiMetadata.dc.displayName');
    }

    /**
     * Get the description of this plugin.
     * @return String name of plugin
     */
    public function getDescription(): string {
        return __('plugins.oaiMetadata.dc.description');
    }

    /**
     * @copydoc OAIMetadataFormatPlugin::getFormatClass()
     * @return string
     */
    public function getFormatClass() {
        return 'OAIMetadataFormat_DC';
    }

    /**
     * @copydoc OAIMetadataFormatPlugin::getMetadataPrefix()
     * @return string
     */
    public function getMetadataPrefix() {
        return 'oai_dc';
    }

    /**
     * @copydoc OAIMetadataFormatPlugin::getSchema()
     * @return string
     */
    public function getSchema() {
        return 'http://www.openarchives.org/OAI/2.0/oai_dc.xsd';
    }

    /**
     * @copydoc OAIMetadataFormatPlugin::getNamespace()
     * @return string
     */
    public function getNamespace() {
        return 'http://www.openarchives.org/OAI/2.0/oai_dc/';
    }
}

?>