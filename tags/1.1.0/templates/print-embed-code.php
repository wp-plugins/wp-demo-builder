<?php
/**
 * @version    $Id$
 * @package    WPDB_Demo_Builder
 * @author     WPDemoBuilder Team <admin@wpdemobuilder.com>
 * @copyright  Copyright (C) 2014 WPDemoBuilder.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.wpdemobuilder.com
 */

// Render demo builder settings
?>
<script type="text/javascript">
	<?php foreach ( $settings as $key => $value ) : ?>
	var wpdb_<?php echo esc_js( $key ); ?> = '<?php echo esc_attr( $value ); ?>';
	<?php endforeach; ?>
</script>
<?php
// Print embed code
echo $embed_code;

if ( !empty( $embed_code ) ) {
?>
<script type="text/javascript">
	/**
	* Init some necessary things
	*/
    if (!window.addEventListener) {

        window.attachEvent("onload", function() {
            wpdb_client_init();

        });
    } else {
        window.addEventListener("load", function() {
           wpdb_client_init();
        }, false);
    }

	/**
	 * Initial function
	 */
	function wpdb_client_init() {

		var elements = wpdb_client_get_elements_by_class_name('wpdb-button-trigger');
		var i, len = elements.length;

		if (len) {
			for (i = 0; i < len; i++) {
				var elem = elements[i];

				if (!elem.addEventListener) {
					elem.attachEvent("onclick", function(e) {
						wpdb_client_stop_event(e);

						if (document.getElementById("wpdb-button") != null)
						{
							wpdb_client_fire_event("wpdb-button", "click");
						}
						else
						{
							wpdb_client_fire_event("wpdb-demo-builder-button", "click");
						}

					});
				} else {
					elem.addEventListener("click", function(e) {
						wpdb_client_stop_event(e);

						if (document.getElementById("wpdb-button") != null)
						{
							wpdb_client_fire_event("wpdb-button", "click");
						}
						else
						{
							wpdb_client_fire_event("wpdb-demo-builder-button", "click");
						}
					}, false);
				}
			}
		}
	}

	/**
	*
	* Get elements by Class name
	*/
	function wpdb_client_get_elements_by_class_name(_className, startElem, filterTag) {

		if (typeof _className === 'string') {
			_className = new RegExp('(^| )' + _className + '( |$)');
		}

		startElem = startElem || document;

		filterTag = filterTag || '*';
		var arr = [];
		var tags;

		if (typeof startElem.all != 'undefined' && filterTag == '*') {
			tags = startElem.all;
		} else {
			tags = startElem.getElementsByTagName(filterTag);
		}

		var i, len = tags.length;
		for (i = 0; i < len; i++) {
			var elem = tags[i];
			if (_className.test(elem.className)) {
				arr.push(elem);
			}
		}
		return arr;
	}

	/**
	*
	* Manually trigger a DOM event
	*/
	function wpdb_client_fire_event (element, event) {

		var evt;

		var isString = function(it) {
			return typeof it == "string" || it instanceof String;
		}

		element = (isString(element)) ? document.getElementById(element) : element;

		if (document.createEventObject) {
			if (wpdb_client_is_ie() < 9) {
				// dispatch for IE <=9
				evt = document.createEventObject();
				return element.fireEvent('on' + event, evt)
			} else {
				evt = document.createEvent("HTMLEvents");
				evt.initEvent(event, true, true);
				return !element.dispatchEvent(evt);
			}
		} else {
			// dispatch for firefox + others
			evt = document.createEvent("HTMLEvents");
			evt.initEvent(event, true, true);
			return !element.dispatchEvent(evt);
		}
	}

	/**
	*
	* Prevent default event of a DOM element
	*/
	function wpdb_client_stop_event(e) {

		if(!e) return false;

		//e.cancelBubble is supported by IE -
		// this will kill the bubbling process.
		e.cancelBubble = true;
		e.returnValue = false;

		//e.stopPropagation works only in Firefox.
		if ( e.stopPropagation ) e.stopPropagation();
		if ( e.preventDefault ) e.preventDefault();

		return false;
	}

	/**
	*
	* Get Browser version of IE
	*/
	function wpdb_client_is_ie()
	{
	  var myNav = navigator.userAgent.toLowerCase();
	  return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
	}
</script>
<?php
}
