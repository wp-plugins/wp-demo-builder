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
	$(document).ready(function() {
		// Init tool-tips
		$('#wpdb-embed-settings a[data-toggle="tooltip"]').tooltip();

		// Setup button enable/disable switcher
		/*$('#wpdb-embed-settings .demo-builder-switcher .btn-group a').click(function(event) {
			event.preventDefault();

			// Clear previous selection
			$(this).closest('.btn-group').find('a.btn').removeClass('disabled').children('input').removeAttr('checked');

			// Mark selection
			$(this).addClass('disabled').children('input').attr('checked', 'checked');
		});*/

		// Setup button position selector
		
		$('#wpdb-embed-settings label').click(function(event) { 
			event.preventDefault();
			$(this).addClass("wpdb_selected").siblings().removeClass("wpdb_selected");
			$(this).find('input').removeAttr('checked');
			
			if ($(this).hasClass("wpdb_selected") == true )
			{
				$(this).find('input').attr('checked', 'checked');
			}
		});
		/*$('#wpdb-embed-settings .demo-builder-position td a').click(function(event) {
			event.preventDefault();

			// Clear previous selection
			$(this).closest('table').find('td a').removeClass('selected').parent().find('input').removeAttr('checked');

			// Mark selection
			$(this).addClass('selected').parent().find('input').attr('checked', 'checked');
		});*/

		// Mark currently selected position
		//$('#wpdb-embed-settings .form-group td a + input[checked]').prev().trigger('click');
		
		$('#wpdb-embed-settings').find('li.wpdb-item').click(function() {
			// Clear previous selection
			$(this).parent().children('li.wpdb-item').removeClass('active')
			
			// Mark selection
			$(this).addClass('active');
			$('#button-icon-hidden-input').val($(this).children('a.icons-item').attr('data-value'));
		});
	});
})(jQuery);
