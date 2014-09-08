/**
 * @version    $Id$
 * @package    WPDB_Demo_Builder
 * @author     WPDemoBuilder Team <admin@wpdemobuilder.com>
 * @copyright  Copyright (C) 2014 WPDemoBuilder.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.wpdemobuilder.com
 */

(function($) {
	$.WPDB_Base_Site = {
		init: function(params) {
			var self = this;

			// Init parameters
			self.params = $.extend(true, self.params ? self.params : {
				url: 'admin-ajax.php?action=wp-demo-builder',
				text: {
					'Preparing to export database...': 'Preparing to export database...',
					'Not found any database table to export.': 'Not found any database table to export.',
					'Exporting %s...': 'Exporting %s...',
					'Database exported successfully.': 'Database exported successfully.',
					'Preparing to archive file...': 'Preparing to archive file...',
					'Archiving %s...': 'Archiving %s...',
					'All files archived successfully.': 'All files archived successfully.',
					'Base site package creation is canceled by user.': 'Base site package creation is canceled by user.',
					'Continue': 'Continue',
					'Reconnect': 'Reconnect',
					'Cancel': 'Cancel',
					'processing_icon': '<span class="glyphicon glyphicon-refresh"></span>',
					'completed_icon': '<span class="glyphicon glyphicon-ok"></span>'
				},
			}, params);

			// Get container
			self.container = $('#wp-demo-builder');

			// Get export database processing status
			self.exporting = self.container.find('#export-db-progress');

			// Get archive files processing status
			self.archiving = self.container.find('#archive-files-progress');

			// Get push package processing status
			self.pushing = self.container.find('#push-package-progress');

			// Get extract package processing status
			self.extracting = self.container.find('#extract-package-progress');

			// Setup button to create site package
			self.container.find('#create-site-package').click(function(event) {
				event.preventDefault();

				self.authenticate('push_site_package');
			});
			
			// Init circle progress bar elements
			self.container.find(".ui-circle-progress-bar").circleProgressBar();

			// Setup button to cancel current action
			self.container.find('#cancel-process').click(function(event) {
				event.preventDefault();

				// State that process is canceled
				self.canceled = true;

				// Show error message
				self.error(self.params.text['Base site package creation is canceled by user.']);

				// Send AJAX request
				$.ajax({
					url: self.params.url,
					data: {state: 'cancel', rand: self.rand_string},
					complete: function(response) {
						response = self.parse(response);

						// Toggle content
						self.error(self.params.text['Base site package creation is canceled by user.'], response.data);
					}
				});
			});

            // Initialized, set a flag to state that process can be run
            self.canceled = false;

            self.rand_string = self.random_string(5);

			$("#reload-button").click(function(e){
				e.preventDefault();
				window.location.reload();
			});
        },

		authenticate: function(task, modal) {
			var self = this,

			init_form = function(modal) {
				var form = modal.find('form');

				if (!form.length) {
					return;
				}

				// Generate reconnect button
				reconnect_button = $('<button type="button" class="btn btn-success" />').click(function(event) {
					event.preventDefault();
					var base_site_id = form.find('li.thumbnail.selected').find('input[type="radio"]').val();
					var sentData = {'email': self.authentication.email, 'password': self.authentication.password, 'base_site_id': base_site_id};
					// Send request to get re-connection
					$.ProcessingDialog.request({
						url: self.params.url  + '&state=re_connect' + '&rand=' + self.rand_string,
						data: sentData,
						method: 'POST',
						callback: function(response) {


                            }
                        });

                    }).text(self.params.text['Reconnect']).hide();

                    // Generate continue button
                    continue_button = $('<button type="button" class="btn btn-primary" />').click(function(event) {
                        event.preventDefault();
                        if (form.attr('name') == 'WP_Demo_Builder_Select_Site') {
                            // Store authentication data

                            // check is writable folder
                            if(self.params.isWriableUploadsDir === false) {
                                return $.ProcessingDialog.show({content : $("#writable-warning").text()});
                            }
self.authentication = self.authentication || {};

						$.each(form.serializeArray(), function(i, o) {
							self.authentication[o.name] = o.value;
						});

                            // Send data silently
                            $.ajax({
                                url: form.attr('action'),
                                data: self.authentication,
                                method: form.attr('method'),
                                complete: function(response) {
                                    // Store customer and base site data
                                    self.data = $.parseJSON(response.responseText);
                                }
                            });
                            // Hide processing dialog
                            $.ProcessingDialog.hide();

                            var site_code = form.find('li.thumbnail.selected').find('input[name="site_code"]').val();

                            // Start creating base site package
                            return self.create_site_package();
					    }

					// Store authentication data
					self.authentication = self.authentication || {};

					$.each(form.serializeArray(), function(i, o) {
						self.authentication[o.name] = o.value;
					});
					// Send authentication
					$.ProcessingDialog.request({
						url: form.attr('action'),
						data: self.authentication,
						method: form.attr('method'),
						callback: function(response) {

							if (response.substr(0, 1) != '{' || response.substr(-1) != '}') {
								return init_form(this.element);
							}
							// Parse and store response for further use
							self.data = $.parseJSON(response);

							// Hide processing dialog
							$.ProcessingDialog.hide();

							// Start creating base site package
							self.create_site_package();
						}
					});
				}).text(self.params.text['Continue']).addClass('disabled').attr('disabled', 'disabled');

				switch (form.attr('name')) {
					case 'WP_Demo_Builder_Authentication':
						// Track input fields
						form.find('input').keyup(function(event) {
							if (form.find('input[name="email"]').val() != '' && form.find('input[name="password"]').val() != '') {
								// Enable continue button
								continue_button.removeClass('disabled').removeAttr('disabled');
							} else {
								// Disabled continue button
								continue_button.addClass('disabled').attr('disabled', 'disabled');
							}

							if (event.keyCode == 13 && !continue_button.hasClass('disabled')) {
								// Trigger click on continue button
								return continue_button.trigger('click');
							}
						});
					break;

					case 'WP_Demo_Builder_Select_Site':
						// Setup click action for site thumbnails
						form.find('li.thumbnail').click(function() {
							// Clear previous selection
							$(this).parent().children('li.thumbnail').removeClass('selected').find('input[type="radio"]').removeAttr('checked');

							// Mark selection
							$(this).addClass('selected').find('input[type="radio"]').attr('checked', 'checked');

                                if (parseInt($(this).find('input[type="radio"]').val()) > 0)
                                {
                                    reconnect_button.show();
                                }
                                else
                                {
                                    reconnect_button.hide();
                                }
                                // Enable continue button
                                continue_button.removeClass('disabled').removeAttr('disabled');
                            });
                            break;
                        case 'WP_Demo_Builder_Select_MultiSites' :
                            if(typeof $('input[type="radio"]:checked') !== 'undefined') {
                                continue_button.removeClass('disabled').removeAttr('disabled');
                            }
                            form.find('input[type="radio"]').click(function(){
                                continue_button.removeClass('disabled').removeAttr('disabled');
                            });
                            break;
                    }

				if (form.attr('name') == 'WP_Demo_Builder_Select_Site') {
					modal.find('.modal-footer').append(reconnect_button);
				}
				
				modal.find('.modal-footer').append(continue_button);
				// Change label for close button
				modal.find('.modal-footer button[data-dismiss="modal"]').text(self.params.text['Cancel']);
			};

			if (modal) {
				return init_form(modal);
			}

            // Get authentication form
            $.ProcessingDialog.request({
				title: "Input WPDemoBuilder account",
                url: self.params.url + '&state=authenticate&task=' + task,
                callback: function() {
                    init_form(this.element);
                }
            });
        },
        create_site_package: function(prepare_file) {
            var self = this;

            $("#create-site-package").addClass("hide");
            $("#cancel-process").removeClass("hide");
            var dataValue = (self.params.multisite !== false) ? {blog_id : self.params.blog_id} : {};
            if (!prepare_file) {

                // Send AJAX request
                $.ajax({
                    url: self.params.url,
                    data: $.extend(dataValue,{state: 'prepare_db'}),
                    complete: function(response) {
                        response = self.parse(response);

						if (response.status == 'success') {
							self.export_db(response.data);
						} else {
							self.error(response.data);
						}
					},
				});
			} else {

                // Send AJAX request
                $.ajax({
                    url: self.params.url,
                    data: $.extend(dataValue,{state: 'prepare_files'}),
                    complete: function(response) {
                        response = self.parse(response);

						if (response.status == 'success') {
							self.archive_files(response.data);
						} else {
							self.error(response.data);
						}
					},
				});
			}
		},

		export_db: function(data) {
			var self = this;

			// Check if process is canceled
			if (self.canceled) {
				return;
			}
			
			// Open the progress bars container and display all progress bars
			$(".progress-container").addClass("open");
			$(".ui-circle-progress-bar").addClass("zoomFull");

			// Update progress bar
			var percent = (data.current *100) / data.total;
			
			self.progress(self.exporting, percent, self.params.text['Database exported successfully.']);

			// Check if database exporting is complete
			if (percent == 100) {
				return self.create_site_package(true);
			}

            // Update processing state
            self.exporting.find('.processing-state').text(self.params.text['Exporting %s...'].replace('%s', data.name));
            // Send AJAX request
            var dataValue = (self.params.multisite !== false) ? {blog_id : self.params.blog_id} : {};

            $.ajax({
                url: self.params.url,
                data: $.extend(dataValue,{state: 'export_db', from: data.name, rand: self.rand_string}) ,
                complete: function(response) {

                    response = self.parse(response);

					if (response.status == 'success') {
                        setTimeout(function(){
                            self.export_db(response.data);
                        }, 500);
					} else {
						self.error(response.data);
					}
				},
			});
		},

		archive_files: function(data) {
			var self = this;

			// Check if process is canceled
			if (self.canceled) {
				return;
			}

			// Update progress bar
			var percent = (data.current *100) / data.total;

			self.progress(self.archiving, percent, self.params.text['All files archived successfully.']);

			// Check if files archiving is complete
			if (percent == 100) {
				// Generate params to push site package
				data = $.extend(self.authentication, self.data);

				return self.push_package(data);
			}

			// Update processing state
			self.archiving.find('.processing-state').text(self.params.text['Archiving %s...'].replace('%s', data.name || ''));

            // Send AJAX request
            var dataValue = (self.params.multisite !== false) ? {blog_id : self.params.blog_id} : {};

            $.ajax({
                url: self.params.url,
                data: $.extend(dataValue,{state: 'archive_files', from: data.current, rand: self.rand_string}) ,
                complete: function(response) {

                    response = self.parse(response);

					if (response.status == 'success') {
                        setTimeout(function(){
                            self.archive_files(response.data);
                        }, 500);
					} else {
						self.error(response.data);
					}
				},
			});
		},

        push_package: function(params) {
            var self = this;
            // Get token key
            $.ajax({
                url: self.params.url + '&state=push_package' + '&rand=' + self.rand_string,
                data: self.authentication,
                method: 'POST',
                complete: function(response) {

                    response = self.parse(response);

					if(response.hasOwnProperty('status') && response.status == 'failure'){
						self.error(response.data);
					}
                    var socket = io.connect('wpdemobuilder.com:3000');
                    // Update params
                    params = $.extend(params, response.data);

                    // Init socket
                    socket.on('error', console.log.bind(console));

					socket.once('connect', function() {
						socket.emit('authen_data', params);

                        socket.on('authen_fail', function(response) {
                            if(typeof response != 'object') {
                                response = JSON.parse(response);
                            }
                            self.pushing.addClass("error");
                            return $.Notification.show({style:'danger',message : response.message});
                        });

                        socket.on('authen_success', function() {
                            socket.emit('client_data', params);
                        });

                        socket.on('push_fail', function() {
                            if(typeof response != 'object') {
                                response = JSON.parse(response);
                            }
                            self.pushing.addClass("error");
                            return $.Notification.show({style:'danger',message : response.message});
                        });

                        socket.on('progress', function(data) {
                            self.progress(self.pushing, data.download);
                            self.progress(self.extracting, data.extract);

                            return;
                        });

                        socket.on('download-error', function(response) {
                            if(typeof response != 'object') {
                                response = JSON.parse(response);
                            }
                            self.pushing.addClass("error");
                            return $.Notification.show({style:'danger',message : response.message});
                        });

                        socket.on('download-complete', function() {
                            setTimeout(function() {
                                self.progress(self.pushing, 100);
                            }, 500);
                        });

                        socket.on('zipfile-invalid', function(response) {
                            self.extracting.addClass("error");
                            return $.Notification.show({style:'danger',message : response.message});
                        });

                        socket.on('error', function(response) {
                            self.extracting.addClass("error");
                            return $.Notification.show({style:'danger',message : response.message});
                        });

                        socket.on('extract-complete', function(response) {
                            setTimeout(function() {
                                self.progress(self.extracting, 100);
                            }, 500);
                        });

                        socket.on('final-error', function(response) {
                            // Destroy socket
                            socket.destroy();

                            self.extracting.addClass("error");
                            return $.Notification.show({style:'danger',message : response.message});
                        });

                        socket.on('final-success', function(data) {

							// Update base site ID
							if (params.base_site_id != data.base_site_id) {
								params.base_site_id = data.base_site_id;
							}
							// Get embed code
							self.embed_code(params);
                            self.confirm_remote_address(params);
                            if((params.hasOwnProperty('site_code') && params.site_code != '') || (data.hasOwnProperty('site_code') && data.site_code != '')) {
                                var site_code = params.site_code ? params.site_code : data.site_code;
                                socket.emit('create-reserve-sites', {'site_code' : site_code});
                                socket.on('create-reserve-sites-error', function() {
                                    socket.destroy();
                                });
                                socket.on('create-reserve-sites-success', function() {
                                    socket.destroy();
                                });
                            }
                            // Destroy socket
                            socket.destroy();
                        });
                    });
                },
            });
        },

		embed_code: function(params) {
			var self = this;

			// Prepare data to post
			var data = $.extend(self.authentication, params, {task: 'get_embed_code'});

			$.ajax({
				url: self.params.url + '&state=authenticate',
				data: data,
				method: 'POST',
				complete: function(response) {
					if (response.responseText.indexOf('<form ') > -1) {
						return $.ProcessingDialog.show({
							content: response.responseText,
							callback: function() {
								// Init authentication form
								self.authenticate('get_embed_code', this.element);
							}
						});
					}

					// Parse response
					response = $.parseJSON(response.responseText);

					if (!response.success) {
						return self.authenticate('get_embed_code');
					}

					// Show success message
					self.complete(response);
				}
			});
		},

        confirm_remote_address: function(params){
            var self = this;
            var data = $.extend(self.authentication, params, {task: 'confirm_remote_address'});
            $.ajax({
                url: self.params.url + '&state=authenticate',
                data: data,
                method: 'POST',
                complete: function(response) {

                    // Parse response
                    response = $.parseJSON(response.responseText);

                    if (!response.success) {
                        return self.authenticate('get_embed_code');
                    }
                }
            });
        },
		progress: function(element, percent, message) {
			var self = this;

			// Update progress bar
			element.circleProgressBarUpdate({ value: percent });
			return;
			if (percent == 100) {
				element.find('.progress-label').addClass('label-success').html(self.params.text['completed_icon']);
				element.find('.progress-bar').addClass('progress-bar-success');
				element.find('.processing-state').text(message);
			}
		},

		parse: function(response) {
			// Parse response data
			var responseText = response.responseText;

			if (response = response.responseText.match(/\{"status":"[^"]+","data":.+\}$/)) {
				response = $.parseJSON(response[0]);
			} else {
				response = {status: 'failure', data: responseText};
			}

			return response;
		},

		error: function(message, data) {
			var self = this;

			if (data) {
				data = $(data.content);
			}

			// Hide processing status
			self.container.find('.state-running').addClass('hide');

            // Schedule hiding error message after 5 seconds
            self.timer && clearTimeout(self.timer);

			// Show error message
			return $.Notification.show({style: 'danger', message: message});
        },

        failure: function() {

        },

		complete: function(params) {
			var self = this;

			//Delete the just-created package
			
			self.delete_package();
			
			// Allow some timeout for the progress bar increasement complete
			self.timer && clearTimeout(self.timer);

			self.timer = setTimeout(function() {
				// Hide processing status
				self.container.find('.state-running').addClass('hide');

				
				/// Hide all progress bars
				$(".progress-container").removeClass("open");
				$(".ui-circle-progress-bar").removeClass("zoomFull");
				
				// Show complete message
				$("#cancel-process").addClass("hide");
				$('#config-embed-code').removeClass("hide")
				
				// Set href for the link to go to base site manager
				$('#manage-base-site').removeClass("hide").click(function(event) {
					event.preventDefault();

					// Show processing modal
					$.ProcessingDialog.show();

					// Create an iframe to load WP Demo Builder login form
					var iframe = $('<iframe id="wpdb-login-submit" name="wpdb-login-submit" src="about:blank" class="hide" />').appendTo(document.body);

					// Handle iframe's load event
					iframe.load(function() {
						if (!iframe.submitted) {
							// Update login form then submit
							var form = iframe.contents().find('form');

                            form.find('input[name="email"]').val(self.authentication.email);
                            form.find('input[name="password"]').val(self.authentication.password);

							form.submit();

							// State that form is submitted
							iframe.submitted = true;
						} else {
							window.location.href = params.server + 'customer/site/' + params.base_site_id;
						}
					});

					// Load WP Demo Builder login form
					iframe.attr('src', self.params.url + '&state=login_form');
				});
			}, 500);
		},
		
		random_string: function(len, char_set) {
		    char_set = char_set || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		    var random_string = '';
		    for (var i = 0; i < len; i++) {
		    	var random_poz = Math.floor(Math.random() * char_set.length);
		    	random_string += char_set.substring(random_poz, random_poz + 1);
		    }
		    return random_string;
		},
		
		delete_package: function () {
			var self = this;
			// Send AJAX request
			$.ajax({
				url: self.params.url,
				data: {state: 'delete_package', rand: self.rand_string},
				complete: function(response) {
				}
			});			
		},
	};
})(jQuery);
