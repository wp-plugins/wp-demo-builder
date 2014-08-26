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
<div id="wp-demo-builder" class="wrap" style='font-family: "Titillium Web"'>
	<div class="container-fluid text-center">
		<?php if ( !$isWriableUploadsDir ) { ?>
		<div id="writable-warning" class="alert alert-warning" role="alert"><?php printf( __('Folder <strong>%s</strong> is Unwritable. Please set Writable permission for it before performing any operations', WPDB_TEXT ), $apppath ); ?></div>
		<?php } ?>
		<h1><?php _e( 'Great! Just one last step.', WPDB_TEXT ); ?></h1>
		<hr>
		<p><?php _e( 'Now, we will make a copy of your demo website and set it as "base site" on WPDemoBuidler server.', WPDB_TEXT ); ?></p>
		<p><?php _e( 'After that, your potential customers will be able to generate their own instance of that "base site" and use it the way they wish.', WPDB_TEXT ); ?></p>
		<div class="progress-container">
			<span id="export-db-progress" class="ui-circle-progress-bar" label="1. Export Database"></span>
			<span id="archive-files-progress" class="ui-circle-progress-bar" label="2. Archive Files"></span>
			<span id="push-package-progress" class="ui-circle-progress-bar" label="3. Transmit Package"></span>
			<span id="extract-package-progress" class="ui-circle-progress-bar" label="4. Process Package"></span>
		</div>
        <div id="notification-wrapper" style="width: 50%;text-align: center;"></div>
		<button id="create-site-package" class="btn btn-primary btn-lg" ><?php _e( 'Start', WPDB_TEXT ); ?></button>
		<button id="cancel-process" class="btn btn-danger btn-lg hide"><?php _e( 'Cancel', WPDB_TEXT ); ?></button>
		<button id="reload-button" class="btn btn-info btn-lg hide"><?php _e( 'Retry', WPDB_TEXT ); ?></button>
		<button id="manage-base-site" class="btn btn-primary btn-lg hide"><?php _e( 'Manage Base Site', WPDB_TEXT ); ?></button>
		<a id="config-embed-code" class="btn btn-default btn-lg hide" href="<?php echo esc_url( admin_url( 'admin.php?page=wpdb-embed-settings' ) ); ?>">
			<?php _e( 'Configure Appearance Settings', WPDB_TEXT ); ?>
		</a>
	</div>
</div>
<script type="text/javascript">
	(function($) {
		$(document).ready(function() {
			$.WPDB_Base_Site.init({
				url: '<?php echo esc_url( admin_url( 'admin-ajax.php?action=wp-demo-builder' ) ); ?>',
				text: {
					'Preparing to export database...': '<?php _e( 'Preparing to export database...', WPDB_TEXT ); ?>',
					'Not found any database table to export.': '<?php _e( 'Not found any database table to export.', WPDB_TEXT ); ?>',
					'Exporting %s...': '<?php _e( 'Exporting %s...', WPDB_TEXT ); ?>',
					'Database exported successfully.': '<?php _e( 'Database exported successfully.', WPDB_TEXT ); ?>',
					'Preparing to archive file...': '<?php _e( 'Preparing to archive file...', WPDB_TEXT ); ?>',
					'Archiving %s...': '<?php _e( 'Archiving %s...', WPDB_TEXT ); ?>',
					'All files archived successfully.': '<?php _e( 'All files archived successfully.', WPDB_TEXT ); ?>',
					'Base site package creation is canceled by user.': '<?php _e( 'Base site package creation is canceled by user.', WPDB_TEXT ); ?>',
					'Continue': '<?php _e( 'Continue', WPDB_TEXT ); ?>',
					'Cancel': '<?php _e( 'Cancel', WPDB_TEXT ); ?>',
				},
                site_url : '<?php echo site_url();?>',
                isWriableUploadsDir : <?php if( !$isWriableUploadsDir ) { ?> false <?php } else { ?> true <?php } ?>,
                multisite : <?php if( !$multisiteEnabled ) { ?> false <?php } else { ?> true <?php } ?>,
                blog_id : '<?php echo get_current_blog_id();?>'
			});
		});
	})(jQuery);
</script>
<?php if( $multisiteEnabled ) :?>
    
<?php endif;?>