/**
 * @file js/classes/features/OrderGridItemsFeature.js
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2000-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class OrderGridItemsFeature
 * @ingroup js_classes_features
 *
 * @brief Feature for ordering grid items.
 */
(function($) {


	/**
	 * @constructor
	 * @inheritDoc
	 */
	$.core.classes.features.OrderGridItemsFeature =
			function(gridHandler, options) {
		this.parent(gridHandler, options);
	};
	$.core.classes.Helper.inherits(
			$.core.classes.features.OrderGridItemsFeature,
			$.core.classes.features.OrderItemsFeature);


	//
	// Extended methods from OrderItemsFeature.
	//
	/**
	 * @inheritDoc
	 */
	$.core.classes.features.OrderGridItemsFeature.prototype.setupSortablePlugin =
			function() {
		this.applySortPlgOnElements(
				this.getGridHtmlElement(), 'tr.orderable', null);
	};


	/**
	 * @inheritDoc
	 */
	$.core.classes.features.OrderGridItemsFeature.prototype.saveOrderHandler =
			function() {
		this.parent('saveOrderHandler');
		var stringifiedData = JSON.stringify(this.getItemsDataId());
		var saveOrderCallback = this.callbackWrapper(
				this.saveOrderResponseHandler_, this);
		$.post(this.options_.saveItemsSequenceUrl, {data: stringifiedData},
				saveOrderCallback, 'json');
		return false;

	};


	//
	// Protected methods to be overriden by subclasses
	//
	/**
	 * Get all items data id in a sequence array.
	 * @return {array} List of all items data.
	 */
	$.core.classes.features.OrderGridItemsFeature.prototype.getItemsDataId =
			function() {
		return this.getRowsDataId(this.getGridHtmlElement());
	};


	//
	// Private helper methods.
	//
	/**
	 * Save order response handler.
	 * @private
	 *
	 * @param {Object} ajaxContext The AJAX request context.
	 * @param {Object} jsonData A parsed JSON response object.
	 */
	$.core.classes.features.OrderGridItemsFeature.prototype.
			saveOrderResponseHandler_ = function(ajaxContext, jsonData) {
		jsonData = this.gridHandler_.handleJson(jsonData);
		this.toggleState(false);
	};


/** @param {jQuery} $ jQuery closure. */
})(jQuery);
