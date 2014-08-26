/**
 * @version    $Id$
 * @package    WPDB_Demo_Builder
 * @author     WPDemoBuilder Team <admin@wpdemobuilder.com>
 * @copyright  Copyright (C) 2014 WPDemoBuilder.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.wpdemobuilder.com
 */
 
 +function($) {
	
	var startAngle = -0.5 * Math.PI;
	var fullCircle = 2 * Math.PI;
	
	function getAngle(factor) {
		return startAngle + factor * fullCircle;
	}
	
	$.fn.circleProgressBar = function(options) {
		return this.each(function(i, el) {
			var canvas = $("<canvas>").attr({ width: 100, height: 100 });
			var content = $("<span>");
			var label = $("<label>").text($(el).attr("label"));
			$(el)
				.addClass("circle-progress-bar")
				.append(canvas)
				.append(content)
				.append(label);
		});
	};
	$.fn.circleProgressBarUpdate = function(options) {
		return this.each(function(i, el) {
			var value = options.value;
			var text = value == 100 ? $(el).addClass("done") && "" : value == 0 ? "..." : Math.round(value);
			
			$(el).find("span").text(text);
			
			var canvas = $(el).find("canvas").get(0);
			var ctx = canvas.getContext("2d");
			
			var cX = canvas.width / 2;
			var cY = canvas.height / 2;
			
			
			ctx.clearRect(0,0,canvas.width,canvas.height);
			
			/* ---------------- */
			ctx.strokeStyle = "#9ac764";
				
			ctx.lineWidth = 8;
			ctx.lineCap = "round";
			
			ctx.beginPath();
			ctx.arc(cX, cY, 31, startAngle, getAngle(value / 100));
			ctx.stroke();
		});
	};
	
	// Hide wordpress error messages
	$(".settings-error").hide();
	
}(jQuery);

(function($) {
	// Helper functions for generate processing dialog, send request via Ajax with processing dialog, show error message if request fails
	$.ProcessingDialog = {
		html: '<div class="modal fade" id="please-wait-dialog" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><div class="modal-content"><div class="modal-header hide"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title">Modal title</h4></div><div class="modal-body"><div class="progress progress-striped active"><div class="progress-bar" role="progressbar" style="width: 100%"></div></div><div class="content hide"></div></div><div class="modal-footer hide"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>',

		show: function(params) {
			var params = $.extend({
				timeout: 0,
				title: null,
				content: null,
				callback: null,
				modal_class: null,
				centralize: false,
			}, params);

			// Backup current modal
			if (this.element) {
				this.previous_dialog = this.element;
			}

			// Instantiate modal
			this.element = $(this.html);
			
			if (params.title) {
				this.element.find(".modal-header").removeClass("hide").children(".modal-title").text(params.title);
			}
			
			if (params.content) {
				// If content has Javascript code, allow some timeout for script execution completes
				if (params.content.match(/<script[^>]*>/) && params.timeout == 0) {
					params.timeout = 300;
				}

				// Hide the progress bar
				this.element.find('.modal-body .progress').addClass('hide');

				// Set content then show it
				this.element.find('.modal-body .content').html(params.content).removeClass('hide');

				// Show the modal footer
				this.element.find('.modal-footer').removeClass('hide');
			} else {
				// Use small size for in-progress modal
				if (params.modal_class == null) {
					params.modal_class = 'modal-sm';
				}

				// Centralize the modal
				this.element.addClass('centralize');

				// Show the progress bar
				this.element.find('.modal-body .progress').removeClass('hide');

				// Empty the content then hide it
				this.element.find('.modal-body .content').html('').addClass('hide');

				// Hide the modal footer
				this.element.find('.modal-footer').addClass('hide');
			}

			// Set modal class
			this.element.children().attr('class', 'modal-dialog ' + params.modal_class);

			if (params.modal_class == 'modal-fluid' || params.centralize) {
				// Centralize the modal
				this.element.addClass('centralize');
			}

			// Execute callback function if specified
			if (params.callback) {
				$.proxy(params.callback, this)();
			}

			// Show the modal centralized
			this.centralize(params.timeout);
		},

		hide: function() {
			var self = this;

			if (self.previous_dialog) {
				// Hide the previous modal
				self.previous_dialog.modal('hide');

				delete self.previous_dialog;
			} else {
				// Hide the current modal
				self.element.modal('hide');

				delete self.element;
			}
		},

		confirm: function(question, ok_button, cancel_button) {
			var callback = function() {
				// Centralize the modal
				this.element.addClass('centralize');

				if (ok_button && ok_button.label) {
					this.element.find('.modal-footer').append(
						$('<button type="button" class="btn btn-primary" />').text(ok_button.label).click(function(event) {
							if (typeof ok_button.callback == 'function') {
								ok_button.callback(event);
							}
						})
					);
				}

				if (cancel_button && cancel_button.label) {
					this.element.find('.modal-footer button[data-dismiss="modal"]').text(cancel_button.label).click(function(event) {
						if (typeof cancel_button.callback == 'function') {
							cancel_button.callback(event);
						}
					})
				}
			};

			if (question.match(/^(https?:)*\/\/[^\s\t\r\n]+$/)) {
				this.request({
					url: question,
					callback: callback,
				});
			} else {
				this.show({
					content: question,
					callback: callback,
				});
			}
		},

		request: function(params) {
			var params = $.extend({
				url: null,
				data: null,
				method: 'GET',
				callback: null,
				modal_class: null,
				centralize: false,
			}, params);

			// Show processing dialog
			this.show();

			// Send a request via Ajax
			$.ajax({
				url: params.url,
				data: params.data,
				type: params.method,
				complete: $.proxy(function(request, status) {
					if (parseInt(request.responseText) === 1) {
						// Hide processing dialog
						this.hide();
					} else {
						var response;

						if (response = request.responseText.match(/\{("type":"[^"]+","message":"[^"]+")\}/i)) {
							response = $.parseJSON(response[0]);

							// Generate alert block
							response = '<div class="alert alert-' + response.type + '">' + response.message + '</div>';
						} else if (request.responseText.substr(0, 1) != '{' && request.responseText.substr(-1) != '}') {
							response = request.responseText;
						}

						if (response) {
							// Show the response
							this.show({
								content: response,
								modal_class: params.modal_class,
								centralize: params.centralize,
							});
						}
					}

					// Execute callback function if specified
					if (params.callback) {
						$.proxy(params.callback, this)(request.responseText);
					}
				}, this)
			});
		},

		centralize: function(timeout) {
			timeout = typeof timeout == 'undefined' ? 0 : timeout;

			// Clear previous timer
			if (this.timer) {
				clearTimeout(this.timer);
			}

			// Show the modal
			this.timer = setTimeout($.proxy(function() {
				// Check if this is the first time the modal being shown
				if (!this.element.parent().length) {
					// Append the modal to document body
					this.element.appendTo(document.body);
				}

				// Centralize the modal
				if (this.element.hasClass('centralize')) {
					this.element.css('display', 'block').children().css({
						'margin-top': '-' + (this.element.children().height() / 2) + 'px',
						'margin-left': '-' + (this.element.children().width() / 2) + 'px',
					});
				}

				// Then, show it
				this.element.on('hidden.bs.modal', function(event) {
					$(event.target).remove();
				}).modal();

				// And, hide previous modal
				if (this.previous_dialog) {
					this.hide();
				}
			}, this), timeout);
		},
	};
    $.Notification = {
        init: function() {
            if (this._initiated)
                return;
            var self = this;

            self.params = {
                style: "warning",
                icon: "<i class='glyphicon glyphicon-exclamation-sign'>",
                message: "",
            }
            self.element = $("#notification-wrapper");

            this._initiated = true;

        },
        show: function(params) {
            var self = this;
            if (typeof params === "string")
                params = { message: params }
            var params = $.extend({}, this.params, params);
            var $el = $("<div class='alert alert-"+params.style+"'>")
                .append(params.message);
            self.element.html($el);
        }
    }
    $.Notification.init();
})(jQuery);