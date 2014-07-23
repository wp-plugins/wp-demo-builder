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
		<div class="alert alert-warning" role="alert"><?php printf( __('Folder <strong>%s</strong> is Unwritable. Please set Writable permission for it before performing any operations', WPDB_TEXT ), $path['basedir'] ); ?></div>
		<?php } ?>
		<h2><?php _e( 'Great! So now you have the plugin installed.', WPDB_TEXT ); ?></h2>
		<h4><?php _e( 'Let we handle the rest and get your demo site up and running. All you have to do is to click the Start button.', WPDB_TEXT ); ?></h4>
		<div class="progress-container">
			<span id="export-db-progress" class="ui-circle-progress-bar" label="1. Export Database"></span>
			<span id="archive-files-progress" class="ui-circle-progress-bar" label="2. Archiving Files"></span>
			<span id="push-package-progress" class="ui-circle-progress-bar" label="3. Transmit Package"></span>
			<span id="extract-package-progress" class="ui-circle-progress-bar" label="4. Processing Package"></span>
		</div>
		<button id="create-site-package" class="btn btn-primary btn-lg"<?php echo (!$isWriableUploadsDir) ? ' disabled="disabled" ' : '';?>><?php _e( 'Start', WPDB_TEXT ); ?></button>
		<button id="cancel-process" class="btn btn-danger btn-lg hide"><?php _e( 'Cancel', WPDB_TEXT ); ?></button>
		<button id="manage-base-site" class="btn btn-primary btn-lg hide"><?php _e( 'Manage Base Site', WPDB_TEXT ); ?></button>
		<a id="config-embed-code" class="btn btn-default btn-lg hide" href="<?php echo esc_url( admin_url( 'admin.php?page=wpdb-embed-settings' ) ); ?>">
			<?php _e( 'Configure Embed Code', WPDB_TEXT ); ?>
		</a>

		<!--

		<div class="state-default">
			<?php if ( empty( $file ) ) : ?>
			<div class="col-sm-9">
				<div class="alert alert-info">
					<?php _e( 'Click generate to start creating your base site package and push to WP Demo Builder server. The entire process should take less than a minute, but in some cases it may take up to 10 mins depending on your resources. Please be patient.', WPDB_TEXT ); ?>
				</div>
			</div>
			<div class="col-sm-3">
				<button id="create-site-package" class="btn btn-block btn-primary">
					<span class="glyphicon glyphicon-compressed"></span>
					&nbsp; &nbsp; <?php _e( 'Generate and Push', WPDB_TEXT ); ?>
				</button>
			</div>
			<?php else : ?>
			<div class="col-sm-9">
				<div class="alert alert-success">
					<h4>
						<span class="glyphicon glyphicon-briefcase"></span>
						<?php _e( 'Package', WPDB_TEXT ); ?>:
						<?php printf( __( '<b>%1$s</b> created on <b>%2$s</b>', WPDB_TEXT ), $file['size'], $file['time'] ); ?>
					</h4>
					<hr />
					<p>
						<?php _e( 'If your site has been updated, click "Regenerate and Push" button to recreate your base site package and push to WP Demo Builder server. The entire process should take less than a minute, but in some cases it may take up to 10 mins depending on your resources. Please be patient.', WPDB_TEXT ); ?>
					</p>
				</div>
			</div>
			<div class="col-sm-3">
				<button id="create-site-package" class="btn btn-block btn-primary">
					<span class="glyphicon glyphicon-compressed"></span>
					&nbsp; &nbsp; <?php _e( 'Regenerate and Push', WPDB_TEXT ); ?>
				</button>
			</div>
			<?php endif; ?>
		</div>

		<div class="state-running hide">
			<div class="col-sm-9">
				<div class="well well-md">
					<div id="export-db-progress">
						<h5>
							<b><?php _e( 'PHASE 1: EXPORT DATABASE', WPDB_TEXT ); ?></b>
							<span class="label label-default progress-label"><?php _e( 'pending', WPDB_TEXT ); ?></span>
						</h5>
						<div class="progress">
							<span class="progress-bar"></span>
						</div>
						<div class="processing-state"></div>
					</div>
					<div id="archive-files-progress">
						<h5>
							<b><?php _e( 'PHASE 2: ARCHIVE FILES', WPDB_TEXT ); ?></b>
							<span class="label label-default progress-label"><?php _e( 'pending', WPDB_TEXT ); ?></span>
						</h5>
						<div class="progress">
							<span class="progress-bar"></span>
						</div>
						<div class="processing-state"></div>
					</div>
					<div id="push-package-progress">
						<h5>
							<b><?php _e( 'PHASE 3: PUSH PACKAGE', WPDB_TEXT ); ?></b>
							<span class="label label-default progress-label"><?php _e( 'pending', WPDB_TEXT ); ?></span>
						</h5>
						<div class="progress">
							<span class="progress-bar"></span>
						</div>
						<div class="processing-state"></div>
					</div>
					<div id="extract-package-progress">
						<h5>
							<b><?php _e( 'PHASE 4: EXTRACT PACKAGE', WPDB_TEXT ); ?></b>
							<span class="label label-default progress-label"><?php _e( 'pending', WPDB_TEXT ); ?></span>
						</h5>
						<div class="progress">
							<span class="progress-bar"></span>
						</div>
						<div class="processing-state"></div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<button id="cancel-process" class="btn btn-block btn-danger">
					<?php _e( 'Cancel', WPDB_TEXT ); ?>
				</button>
			</div>
		</div>

		<div id="synchronizing-site-package-success" class="hide">
			<div class="col-sm-9">
				<div class="alert alert-success">
					<?php _e( 'Base site package is generated and pushed successfully to WP Demo Builder server.', WPDB_TEXT ); ?>
				</div>
			</div>
			<div class="col-sm-3">
				<a id="manage-base-site" class="btn btn-block btn-primary">
					<?php _e( 'Manage Base Site', WPDB_TEXT ); ?>
				</a>
				<a id="config-embed-code" class="btn btn-block btn-success" href="<?php echo esc_url( admin_url( 'admin.php?page=wpdb-embed-settings' ) ); ?>">
					<?php _e( 'Configure Embed Code', WPDB_TEXT ); ?>
				</a>
			</div>
		</div>
		<div id="synchronizing-site-package-fail" class="alert alert-danger hide"></div>

		-->
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
                site_url : '<?php echo site_url();?>'
			});
		});
	})(jQuery);
</script>
