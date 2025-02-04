/**
 * Reservation status codes context menu.
 */
(function($, w) {
	'use strict';

	/**
	 * Define object to easily access the supported status codes.
	 * The codes will be grouped by category: 1 for restaurant
	 * codes and 2 for take-away codes.
	 *
	 * @var object
	 */
	if (typeof w.VIKRESTAURANTS_STATUS_CODES_MAP === 'undefined') {
		w.VIKRESTAURANTS_STATUS_CODES_MAP = {};
	}

	/**
	 * Click event implementor for context menu buttons.
	 *
	 * @param 	object  handle  The popup handler.
	 * @param 	Event   event   The triggered event.
	 *
	 * @return 	void
	 */
	const statusCodesPopupButtonClicked = function(handle, event) {
		// get selected order
		let id_order = parseInt($(handle).attr('data-id'));
		// get selected code
		let code = parseInt($(handle).attr('data-code'));

		// do not go ahead if the code didn't change
		if (code == this.id) {
			return false;
		}

		// keep previous HTML
		let prev_html = $(handle).html();

		// replace HTML with loading icon
		$(handle).html('<i class="fas fa-sync-alt fa-spin big"></i>');

		// make request
		UIAjax.do(
			this.controller,
			{
				id:      id_order,
				id_code: this.id,
			},
			(resp) => {
				resp = resp || {};

				// inject ID order in response
				resp.id_order = id_order;

				let html;

				if (!resp.icon)
				{
					html = resp.code ? resp.code : '--';
				}
				else
				{
					html = '<img src="' + resp.iconURI + '" title="' + resp.code + '" />';
				}

				$(handle).html(html);

				// update root with new code
				$(handle).attr('data-code', parseInt(resp.id));

				// trigger change method, if supported
				if (this.onChange) {
					this.onChange(resp, handle);
				}

				// trigger status code changed event
				$(window).trigger('statuscode.changed', [resp, handle]);
			},
			(error) => {
				// trigger status code error event
				$(window).trigger('statuscode.error', [error, handle]);

				// restore previous HTML
				$(handle).html(prev_html);
			}
		);
	};

	/**
	 * Register jQuery plugin.
	 *
	 * @param 	mixed 	method  A configuration object or a method to invoke.
	 *
	 * @return 	self    The given root to support chaining.
	 */
	$.fn.statusCodesPopup = function(method) {
		let root = this;

		if (!method) {
			method = {};
		}

		// initialize popup events
		if (typeof method === 'object') {
			// create default object
			let data = $.extend({
				controller: null,
				group:      null,
				onShow:     null,
				onHide:     null,
				onChange:   null,
			}, method);

			// iterate all elements
			$(root).each(function() {
				let buttons = [];

				// check if we have some codes for this group
				if (VIKRESTAURANTS_STATUS_CODES_MAP.hasOwnProperty(data.group)) {
					// iterate all status codes
					$.each(VIKRESTAURANTS_STATUS_CODES_MAP[data.group], function(i, code) {
						// create new button
						let btn = {
							id:         parseInt(code.id),
							text:       code.text,
							icon:       code.icon,
							action:     statusCodesPopupButtonClicked,
							controller: data.controller,
							onChange:   data.onChange,
							disabled:   function(handle, config) {
								// get selected code
								var code = parseInt($(handle).attr('data-code'));

								// disable in case the status code is already assigned
								return this.id == code;
							},
						};

						// add button to list
						buttons.push(btn);
					});

					// take the last registered button and add a separator
					buttons[buttons.length - 1].separator = true;

					// add button to clear the selected code
					buttons.push({
						id:         0,
						text:       Joomla.JText._('VRRESCODENOSTATUS'),
						icon:       'fas fa-times',
						class:      'danger',
						action:     statusCodesPopupButtonClicked,
						controller: data.controller,
						onChange:   data.onChange,
						visible:    function(handle, config) {
							// display remove button only in case of a selection
							return parseInt($(handle).attr('data-code')) ? true : false;
						},
					});
				}

				// init context menu
				$(this).vikContextMenu({
					buttons: buttons,
					class:   'rescodes-context-menu',
					onShow:  data.onShow,
					onHide:  data.onHide,
				});
			});
		}
		// check if we should dismiss the popup
		else if (typeof method === 'string' && method.match(/^(close|dismiss|hide)$/i)) {
			$(this).vikContextMenu('hide');
		}
		// otherwise open the popup
		else {
			$(this).vikContextMenu('show');
		}

		return this;
	};
})(jQuery, window);