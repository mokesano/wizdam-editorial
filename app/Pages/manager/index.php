<?php
declare(strict_types=1);

/**
 * @defgroup pages_manager
 */

/**
 * @file pages/manager/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_manager
 * @brief Handle requests for journal management functions.
 *
 */

switch ($op) {
	//
	// Setup
	//
	case 'setup':
	case 'saveSetup':
	case 'setupSaved':
	case 'downloadLayoutTemplate':
	case 'resetPermissions':
		define('HANDLER_CLASS', 'SetupHandler');
		import('app.Pages.manager.SetupHandler');
		break;
	//
	// People Management
	//
	case 'people':
	case 'showNoRole':
	case 'enrollSearch':
	case 'enroll':
	case 'unEnroll':
	case 'enrollSyncSelect':
	case 'enrollSync':
	case 'createUser':
	case 'suggestUsername':
	case 'mergeUsers':
	case 'disableUser':
	case 'enableUser':
	case 'removeUser':
	case 'editUser':
	case 'updateUser':
	case 'userProfile':
		define('HANDLER_CLASS', 'PeopleHandler');
		import('app.Pages.manager.PeopleHandler');
		break;
	//
	// Section Management
	//
	case 'sections':
	case 'createSection':
	case 'editSection':
	case 'updateSection':
	case 'deleteSection':
	case 'moveSection':
		define('HANDLER_CLASS', 'SectionHandler');
		import('app.Pages.manager.SectionHandler');
		break;
	//
	// Review Form Management
	//
	case 'reviewForms':
	case 'createReviewForm':
	case 'editReviewForm':
	case 'updateReviewForm':
	case 'previewReviewForm':
	case 'deleteReviewForm':
	case 'activateReviewForm':
	case 'deactivateReviewForm':
	case 'copyReviewForm':
	case 'moveReviewForm':
	case 'reviewFormElements':
	case 'createReviewFormElement':
	case 'editReviewFormElement':
	case 'deleteReviewFormElement':
	case 'updateReviewFormElement':
	case 'moveReviewFormElement':
	case 'copyReviewFormElement':
		define('HANDLER_CLASS', 'ReviewFormHandler');
		import('app.Pages.manager.ReviewFormHandler');
		break;
	//
	// E-mail Management
	//
	case 'emails':
	case 'createEmail':
	case 'editEmail':
	case 'updateEmail':
	case 'deleteCustomEmail':
	case 'resetEmail':
	case 'exportEmails':
	case 'uploadEmails':
	case 'disableEmail':
	case 'enableEmail':
	case 'resetAllEmails':
		define('HANDLER_CLASS', 'EmailHandler');
		import('app.Pages.manager.EmailHandler');
		break;
	//
	// Languages
	//
	case 'languages':
	case 'saveLanguageSettings':
	case 'reloadLocalizedDefaultSettings':
		define('HANDLER_CLASS', 'JournalLanguagesHandler');
		import('app.Pages.manager.JournalLanguagesHandler');
		break;
	//
	// Files Browser
	//
	case 'files':
	case 'fileUpload':
	case 'fileMakeDir':
	case 'fileDelete':
		define('HANDLER_CLASS', 'FilesHandler');
		import('app.Pages.manager.FilesHandler');
		break;
	//
	// Subscription Policies
	//
	case 'subscriptionPolicies':
	case 'saveSubscriptionPolicies':
	//
	// Subscription Types
	//
	case 'subscriptionTypes':
	case 'deleteSubscriptionType':
	case 'createSubscriptionType':
	case 'selectSubscriber':
	case 'editSubscriptionType':
	case 'updateSubscriptionType':
	case 'moveSubscriptionType':
	//
	// Subscriptions
	//
	case 'subscriptions':
	case 'subscriptionsSummary':
	case 'deleteSubscription':
	case 'renewSubscription':
	case 'createSubscription':
	case 'editSubscription':
	case 'updateSubscription':
	case 'resetDateReminded':
		define('HANDLER_CLASS', 'SubscriptionHandler');
		import('app.Pages.manager.SubscriptionHandler');
		break;
	//
	// Import/Export
	//
	case 'importexport':
		define('HANDLER_CLASS', 'ImportExportHandler');
		import('app.Pages.manager.ImportExportHandler');
		break;
	//
	// Plugin Management
	//
	case 'plugins':
	case 'plugin':
		define('HANDLER_CLASS', 'PluginHandler');
		import('app.Pages.manager.PluginHandler');
		break;
	case 'managePlugins':
		define('HANDLER_CLASS', 'PluginManagementHandler');
		import('app.Pages.manager.PluginManagementHandler');
		break;
	//
	// Group Management
	//
	case 'groups':
	case 'createGroup':
	case 'updateGroup':
	case 'deleteGroup':
	case 'editGroup':
	case 'groupMembership':
	case 'addMembership':
	case 'deleteMembership':
	case 'setBoardEnabled':
	case 'moveGroup':
	case 'moveMembership':
		define('HANDLER_CLASS', 'GroupHandler');
		import('app.Pages.manager.GroupHandler');
		break;
	//
	// Statistics Functions
	//
	case 'statistics':
	case 'saveStatisticsSettings':
	case 'savePublicStatisticsList':
	case 'report':
	case 'reportGenerator':
	case 'generateReport':
		define('HANDLER_CLASS', 'StatisticsHandler');
		import('app.Pages.manager.StatisticsHandler');
		break;
	//
	// Payment
	//
	case 'payments':
	case 'savePaymentSettings':
	case 'payMethodSettings':
	case 'savePayMethodSettings':
	case 'viewPayments':
	case 'viewPayment':
		define('HANDLER_CLASS', 'ManagerPaymentHandler');
		import('app.Pages.manager.ManagerPaymentHandler');
		break;
	//
	//	announcements
	//
	case 'announcements':
	case 'deleteAnnouncement':
	case 'createAnnouncement':
	case 'editAnnouncement':
	case 'updateAnnouncement':
	//
	//	announcement Types
	//
	case 'announcementTypes':
	case 'deleteAnnouncementType':
	case 'createAnnouncementType':
	case 'editAnnouncementType':
	case 'updateAnnouncementType':
		define('HANDLER_CLASS', 'AnnouncementHandler');
		import('app.Pages.manager.AnnouncementHandler');
		break;
	case 'index':
	case 'email':
		define('HANDLER_CLASS', 'ManagerHandler');
		import('app.Pages.manager.ManagerHandler');
}

?>