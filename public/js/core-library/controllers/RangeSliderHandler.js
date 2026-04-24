/**
 * @file js/controllers/RangeSliderHandler.js
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class RangeSliderHandler
 * @ingroup js_controllers
 *
 * @brief Core range slider handler (extends the functionality of the jqueryUI
 *  range slider)
 */
(function($) {


	/**
	 * @constructor
	 *
	 * @extends $.core.classes.Handler
	 *
	 * @param {jQuery} $rangeSliderField the wrapped HTML input element element.
	 * @param {Object} options options to be passed
	 *  into the jqueryUI slider plugin.
	 */
	$.core.controllers.RangeSliderHandler = function($rangeSliderField, options) {
		this.parent($rangeSliderField, options);

		// Check that our required options are included
		if (!options.min || !options.max) {
			throw Error(['The "min" and "max"',
				'settings are required in a RangeSliderHandler'].join(''));
		}

		// Get the container that will hold the actual slider.
		this.slider_ = $rangeSliderField.children(
				'.core_controllers_rangeSlider_slider'
				);

		// Get the container that will display the numeric values of the slider.
		this.label_ = $rangeSliderField.find(
				'.core_controllers_rangeSlider_sliderValue'
				);

		// Create slider settings.
		var opt = {};
		opt.min = options.min;
		opt.max = options.max;
		opt.values = [options.min, options.max];
		var rangeSliderOptions = $.extend({ },
				this.self('DEFAULT_PROPERTIES_'), opt);

		// Create the slider with the jqueryUI plug-in.
		this.slider_.slider(rangeSliderOptions);
		this.bind('slide', this.sliderAdjusted);
	};
	$.core.classes.Helper.inherits(
			$.core.controllers.RangeSliderHandler, $.core.classes.Handler);


	//
	// Private static properties
	//
	/**
	 * The container that will hold the actual slider.
	 * @private
	 * @type {HTMLElement}
	 */
	$.core.controllers.RangeSliderHandler.slider_ = null;


	/**
	 * The container that will display the numeric values of the slider.
	 * @private
	 * @type {HTMLElement}
	 */
	$.core.controllers.RangeSliderHandler.label_ = null;


	/**
	 * Default options
	 * @private
	 * @type {Object}
	 * @const
	 */
	$.core.controllers.RangeSliderHandler.DEFAULT_PROPERTIES_ = {
		// General settings
		range: true
	};


	//
	// Public Methods
	//
	/**
	 * Handle event triggered by adjusting a range slider value
	 *
	 * @param {HTMLElement} rangeSliderElement The element that triggered
	 *  the event.
	 * @param {Event} event The triggered event.
	 * @param {Object} ui The tabs ui data.
	 */
	$.core.controllers.RangeSliderHandler.prototype.sliderAdjusted =
			function(rangeSliderElement, event, ui) {

		// Set the label
		var $label = this.label_;
		$label.val(ui.values[0] + ' - ' + ui.values[1]);

		// Set the hidden inputs
		var $minVal = $(rangeSliderElement).children(
				'.core_controllers_rangeSlider_minInput'
				);
		$minVal.val(ui.values[0]);
		var $maxVal = $(rangeSliderElement).children(
				'.core_controllers_rangeSlider_maxInput'
				);
		$maxVal.val(ui.values[1]);
	};

/** @param {jQuery} $ jQuery closure. */
})(jQuery);
