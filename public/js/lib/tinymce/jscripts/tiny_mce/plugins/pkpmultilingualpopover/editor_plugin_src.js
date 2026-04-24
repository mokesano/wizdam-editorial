/**
 * editor_plugin_src.js
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2000-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 */

(function() {
	tinymce.create('tinymce.plugins.CoreMultilingualPopover', {
		init : function(ed, url) {
			var t = this;
			if(top.$.core.controllers.form.MultilingualInputHandler.receiveEditorEvent) {
				ed.onInit.add(function(ed) { t.blurEvent(ed); });

				ed.onEvent.add(function(ed, event) {
					top.$.core.controllers.form.MultilingualInputHandler.receiveEditorEvent(ed.editorId, event);
				});
			}
		},

		blurEvent : function(ed) {
			tinyMCE.dom.Event.add(ed.getWin(), "blur", function(event) {
					top.$.core.controllers.form.MultilingualInputHandler.receiveEditorEvent(ed.editorId, event);
				});
			},

		getInfo : function() {
			return {
				longname : 'CoreMultilingualPopover',
				author : 'Wizdam Editorial Project',
				authorurl : 'https://wizdam.editorial',
				infourl : 'https://wizdam.editorial',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('pkpmultilingualpopover', tinymce.plugins.CoreMultilingualPopover);
})();
