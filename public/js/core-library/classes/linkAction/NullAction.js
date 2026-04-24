/**
 * @file js/classes/linkAction/NullAction.js
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class NullAction
 * @ingroup js_classes_linkAction
 *
 * @brief A simple action request that doesn't.
 */
(function($) {


	/**
	 * @constructor
	 *
	 * @extends $.core.classes.linkAction.LinkActionRequest
	 *
	 * @param {jQuery} $linkActionElement The element the link
	 *  action was attached to.
	 * @param {Object} options Configuration of the link action
	 *  request.
	 */
	$.core.classes.linkAction.NullAction =
			function($linkActionElement, options) {

		this.parent($linkActionElement, options);
	};
	$.core.classes.Helper.inherits(
			$.core.classes.linkAction.NullAction,
			$.core.classes.linkAction.LinkActionRequest);


	//
	// Public methods
	//
	/**
	 * @inheritDoc
	 */
	$.core.classes.linkAction.NullAction.prototype.activate =
			function(element, event) {

		return this.parent('activate', element, event);
	};


/** @param {jQuery} $ jQuery closure. */
})(jQuery);
