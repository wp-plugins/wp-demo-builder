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
<form name="WP_Demo_Builder_Select_Site" action="<?php echo esc_url( admin_url( 'admin-ajax.php?action=wp-demo-builder&state=authenticate' ) ); ?>" method="POST" class="form-horizontal" autocomplete="off">
	<div class="alert alert-info">
		<?php _e( 'You already have base site in WP Demo Builder server. Please select the base site you want to work with.', WPDB_TEXT ); ?>
	</div>
	<ul class="thumbnails clearfix">
		<?php foreach ( (array) $request->response as $id => $data ) : ?>
		<li class="thumbnail pull-left">
			<div class="site-thumbnail <?php echo sanitize_html_class( $data->label ); ?>">
				<?php if ( ! empty( $data->thumb ) ) : ?>
				<img alt="<?php _e( $data->label ); ?>" src="<?php echo esc_url( $data->thumb ); ?>" />
				<?php endif; ?>
			</div>
			<div class="caption">
				<label><?php _e( $data->label ); ?></label>
			</div>
			<input type="radio" name="base_site_id" value="<?php echo esc_attr( $id ); ?>" class="hide" autocomplete="off" />
		</li>
		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="email" value="<?php echo esc_attr( isset( $_REQUEST['email'] ) ? $_REQUEST['email'] : '' ); ?>" />
	<input type="hidden" name="password" value="<?php echo esc_attr( isset( $_REQUEST['password'] ) ? $_REQUEST['password'] : '' ); ?>" />
	<input type="hidden" name="task" value="<?php echo esc_attr( isset( $_REQUEST['task'] ) ? $_REQUEST['task'] : '' ); ?>" />
</form>
<?php
// Exit immediately to prevent the plugin from generating and returning JSON status
exit;
