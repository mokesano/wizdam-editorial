<?php
declare(strict_types=1);

namespace App\Pages\Trends;


/**
 * @file pages/trends/MostPopularHandler.inc.php
 *
 * Copyright (c) 2017-2026 Sangia Publishing House
 * Copyright (c) 2017-2026 Rochmady
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * [WIZDAM] - Standalone Handler for Most Popular Module.
 * URL Target: /{context}/trends/popular ATAU /index/trends/popular
 */

import('app.Domain.Handler.Handler');

class MostPopularHandler extends Handler {

    public function authorize($request, $args, $roleAssignments) {
        import('app.Domain.Security.authorization.ContextRequiredPolicy');
        // Set context required false, agar bisa diakses di site level maupun journal level
        $this->addPolicy(new ContextRequiredPolicy($request, 'user.authorization.noContext', false));
        return parent::authorize($request, $args, $roleAssignments);
    }

    // Nama method WAJIB "popular" sesuai parameter $op
    public function popular(array $args, CoreRequest $request) {
        $this->setupTemplate($request);
        $templateMgr = TemplateManager::getManager($request);
        $journal = $request->getJournal();

        // Validasi opsional jika berada di dalam jurnal
        if ($journal) {
            $this->addCheck(new HandlerValidatorJournal($this));
        }

        // [WIZDAM] Eksekusi WIZDAM Trends Manager
        import('lib.wizdam.trends.WizdamTrendsManager');
        WizdamTrendsManager::assignMostPopularPayload($templateMgr, $journal, $request);

        // Path ke template yang menyatukan header/footer WIZDAM dan most_popular.tpl
        return $templateMgr->display('trends/most_popular.tpl');
    }
}
?>