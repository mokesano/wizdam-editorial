<?php
declare(strict_types=1);

/**
 * @defgroup plugins_citationFormats_bibtex
 */
 
/**
 * @file plugins/citationFormats/bibtex/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_citationFormats_bibtex
 * @brief Wrapper for BibTeX citation plugin.
 *
 */

require_once('BibtexCitationPlugin.inc.php');

return new BibtexCitationPlugin();