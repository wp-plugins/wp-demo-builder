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
?>
<form name="WP_Demo_Builder_Authentication" action="<?php echo esc_url( admin_url( 'admin-ajax.php?action=wp-demo-builder&state=authenticate' ) ); ?>" method="POST" class="form-horizontal" autocomplete="off">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title"><?php _e( "Input WPDemoBuilder account", WPDB_TEXT )?></h4>
	<hr>
	<?php if ( isset( $error ) ) : ?>
	<div class="alert alert-danger text-center">
		<?php echo '' . $error; ?>
	</div>
	<?php endif; ?>
	<div class="form-group clearfix">
		<label class="col-sm-3 control-label" for="email"><?php _e( 'Email / Username', WPDB_TEXT ); ?>:</label>
		<div class="col-sm-9">
			<input type="text" value="" class="form-control" id="email" name="email" autocomplete="off" />
		</div>
	</div>
	<div class="form-group clearfix">
		<label class="col-sm-3 control-label" for="password"><?php _e( 'Password', WPDB_TEXT ); ?>:</label>
		<div class="col-sm-9">
			<input type="password" value="" class="form-control" id="password" name="password" autocomplete="off" />
		</div>
	</div>
	<input type="hidden" name="task" value="<?php echo esc_attr( isset( $_REQUEST['task'] ) ? $_REQUEST['task'] : '' ); ?>" />
	<div><?php printf( __('Please enter your WP Demo Builder account to authenticate with WP Demo Builder server. If you don\'t have any account yet, you can sign up for free <a href="%s" target="_blank">here</a>', WPDB_TEXT ), self::$server . 'customer/login#register' ); ?></div>
</form>
