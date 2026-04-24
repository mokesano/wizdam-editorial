/**
 * @defgroup js_classes_linkAction
 */
/**
 * @file js/classes/linkAction/LinkActionRequest.js
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class LinkActionRequest
 * @ingroup js_classes_linkAction
 *
 * @brief Base class for all link action requests.
 */
(function($) {

	/** @type {Object} */
	$.core.classes.linkAction = $.core.classes.linkAction || {};



	/**
	 * @constructor
	 *
	 * @extends $.core.classes.ObjectProxy
	 *
	 * @param {jQueryObject} $linkActionElement The element the link
	 *  action was attached to.
	 * @param {Object} options Configuration of the link action
	 *  request.
	 */
	$.core.classes.linkAction.LinkActionRequest =
			function($linkActionElement, options) {

		// Save the reference to the link action element.
		this.$linkActionElement = $linkActionElement;

		// Save the link action request options.
		this.options = options;

		// If the link action element is an actual link
		// and we find a URL in the options then set the
		// link of the link action for better documentation
		// and easier debugging in the DOM and for other
		// JS to easily access the target if required.
		if ($linkActionElement.is('a') && options.url) {
			$linkActionElement.attr('href', options.url);
		}
	};


	//
	// Protected properties
	//
	/**
	 * The element the link action was attached to.
	 * @protected
	 * @type {Object}
	 */
	$.core.classes.linkAction.LinkActionRequest.prototype.
			$linkActionElement = null;


	/**
	 * The link action request options.
	 * @protected
	 * @type {Object}
	 */
	$.core.classes.linkAction.LinkActionRequest.prototype.options = null;


	//
	// Public methods
	//
	/**
	 * Callback that will be bound to the link action element.
	 * @param {HTMLElement} element The element that triggered the link
	 *  action activation event.
	 * @param {Event} event The event that activated the link action.
	 * @return {boolean} Should return false to stop event propagation.
	 */
	/*jslint unparam: true*/
	$.core.classes.linkAction.LinkActionRequest.prototype.activate =
			function(element, event) {

		this.getLinkActionElement().trigger('actionStart');
		return false;
	};
	/*jslint unparam: false*/


	/**
	 * Callback that will be bound to the 'action finished' event of the
	 * link action.
	 *
	 * @return {boolean} Should return false to stop event propagation.
	 */
	$.core.classes.linkAction.LinkActionRequest.prototype.finish =
			function() {

		// Execute the finish callback if there is one.
		if (this.options.finishCallback) {
			this.options.finishCallback();
		}

		this.getLinkActionElement().trigger('actionStop');
		return false;
	};


	/**
	 * Get the link action request url.
	 * @return {?string} The link action request url.
	 */
	$.core.classes.linkAction.LinkActionRequest.prototype.getUrl =
			function() {
		if (this.options.url) {
			return this.options.url;
		}

		return null;
	};


	//
	// Protected methods
	//
	/**
	 * Retrieve the link action request options.
	 * @return {Object} The link action request options.
	 */
	$.core.classes.linkAction.LinkActionRequest.prototype.getOptions = function() {
		return this.options;
	};


	/**
	 * Retrieve the element the link action was attached to.
	 * @return {Object} The element the link action was attached to.
	 */
	$.core.classes.linkAction.LinkActionRequest.prototype.
			getLinkActionElement = function() {

		return this.$linkActionElement;
	};


	/** @param {jQuery} $ jQuery closure. */
}(jQuery));
