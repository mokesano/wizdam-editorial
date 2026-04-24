<?php

/**
 * @defgroup pages_reviewer
 */
 
/**
 * @file pages/reviewer/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_reviewer
 * @brief Handle requests for reviewer functions. 
 *
 */

switch ($op) {
	//
	// Submission Tracking
	//
	case 'submission':
	case 'confirmReview':
	case 'saveCompetingInterests':
	case 'recordRecommendation':
	case 'viewMetadata':
	case 'uploadReviewerVersion':
	case 'deleteReviewerVersion':
	//
	// Misc.
	//
	case 'downloadFile':
	//
	// Submission Review Form
	//
	case 'editReviewFormResponse':
	case 'saveReviewFormResponse':
		define('HANDLER_CLASS', 'SubmissionReviewHandler');
		import('app.Pages.reviewer.SubmissionReviewHandler');
		break;
	//
	// Submission Comments
	//
	case 'viewPeerReviewComments':
	case 'postPeerReviewComment':
	case 'editComment':
	case 'saveComment':
	case 'deleteComment':
		define('HANDLER_CLASS', 'SubmissionCommentsHandler');
		import('app.Pages.reviewer.SubmissionCommentsHandler');
		break;
	case 'index':
		define('HANDLER_CLASS', 'ReviewerHandler');
		import('app.Pages.reviewer.ReviewerHandler');
		break;
}

?>