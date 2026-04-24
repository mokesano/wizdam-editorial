/**
 * @file js/controllers/modal/CallbackConfirmationModalHandler.js
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CallbackConfirmationModalHandler
 * @ingroup js_controllers_modal
 *
 * @brief A confirmation modal that executes a JS callback function
 *  on confirmation.
 */
(function($) {


	/**
	 * @constructor
	 *
	 * @extends $.core.controllers.modal.ConfirmationModalHandler
	 *
	 * @param {jQuery} $handledElement The modal.
	 * @param {Object} options Non-default options to configure
	 *  the modal.
	 *
	 *  Options are:
	 *  - confirmationCallback function An callback to be executed
	 *    when the confirmation button has been clicked.
	 *  - All options from the ConfirmationModalHandler and ModalHandler
	 *    widgets.
	 *  - All options documented for the jQueryUI dialog widget,
	 *    except for the buttons parameter which is not supported.
	 */
	$.core.controllers.modal.CallbackConfirmationModalHandler =
			function($handledElement, options) {

		this.parent($handledElement, options);

		// Configure the callback to be called when the modal closes.
		this.confirmationCallback_ = options.confirmationCallback;
	};
	$.core.classes.Helper.inherits(
			$.core.controllers.modal.CallbackConfirmationModalHandler,
			$.core.controllers.modal.ConfirmationModalHandler);


	//
	// Private properties
	//
	/**
	 * A callback to be executed when the confirmation button
	 * has been clicked.
	 * @private
	 * @type {?function()}
	 */
	$.core.controllers.modal.CallbackConfirmationModalHandler.prototype.
			confirmationCallback_ = null;


	/**
	 * An internal state variable that triggers execution of the
	 * confirmation action when the dialog is closed.
	 * @private
	 * @type {boolean}
	 */
	$.core.controllers.modal.CallbackConfirmationModalHandler.prototype.
			triggerCallbackOnClose_ = false;


	//
	// Protected methods
	//
	/** @inheritDoc */
	$.core.controllers.modal.CallbackConfirmationModalHandler.prototype.
			checkOptions = function(options) {
		// Check the mandatory options of the ModalHandler handler.
		if (!this.parent('checkOptions', options)) {
			return false;
		}

		// Check for our own mandatory options.
		return $.isFunction(options.confirmationCallback);
	};


	//
	// Public methods
	//
	/**
	 * Callback that will be activated when the modal's
	 * confirm button is clicked.
	 *
	 * @param {HTMLElement} dialogElement The element the
	 *  dialog was created on.
	 */
	$.core.controllers.modal.CallbackConfirmationModalHandler.prototype.
			modalConfirm = function(dialogElement) {

		// Close the modal. We have to close the modal first because
		// otherwise many UI-based actions are be de-activated.
		this.triggerCallbackOnClose_ = true;
		this.modalClose(dialogElement);
	};


	/**
	 * @inheritDoc
	 */
	$.core.controllers.modal.CallbackConfirmationModalHandler.prototype.
			dialogClose = function(dialogElement) {

		// Call the configured confirmation callback after the
		// modal closes but before finishing the modal request.
		if (this.triggerCallbackOnClose_ === true) {
			this.triggerCallbackOnClose_ = false;
			this.confirmationCallback_();
		}

		this.parent('dialogClose', dialogElement);
	};


/** @param {jQuery} $ jQuery closure. */
})(jQuery);
