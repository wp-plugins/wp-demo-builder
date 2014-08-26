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

// Check if settings has just been saved
if ( isset ( $save ) && true === $save ) {
	$type = 'success';
	$msg  = __( 'Successfully saved settings.', WPDB_TEXT );
}
?>
<div id="wpdb-embed-settings" class="wrap wpdb-bootstrap">
	<h2>
		<?php _e( 'Demo Builder Settings', WPDB_TEXT ); ?>
	</h2>
	<?php if ( isset( $type ) && isset( $msg ) ) : ?>
		<div class="updated settings-<?php echo esc_attr( $type ); ?>">
			<p><strong><?php echo esc_html( $msg ); ?></strong></p>
		</div>
	<?php endif; ?>
	<form action="<?php echo esc_url( admin_url( 'admin.php?page=wpdb-embed-settings' ) ); ?>" method="POST" class="form-horizontal" role="form">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="button-label"><?php _e( 'Demo Builder Button', WPDB_TEXT ); ?></label>
					</th>
					<td>
						<label>
							<input type="radio" name="enable_button" value="1" <?php checked( 1, $settings['enable_button'] ); ?> />
							<?php _e( 'Show', WPDB_TEXT ); ?>
						</label>
						<label>
							<input type="radio" name="enable_button" value="0" <?php checked( 0, $settings['enable_button'] ); ?> />
							<?php _e( 'Hide', WPDB_TEXT ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="button-label"><?php _e( 'Button Label', WPDB_TEXT ); ?></label>
					</th>
					<td>
						<input type="text" name="button_label" class="regular-text" id="button-label" value="<?php echo esc_attr( $settings['button_label'] ); ?>" placeholder="<?php _e( 'Build Your Demo', WPDB_TEXT ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label><?php _e( 'Button Position', WPDB_TEXT ); ?></label>
					</th>
					<td>
						<label<?php if ( checked( 'left', $settings['button_position'], false ) ) echo ' class="wpdb_selected"'; ?>>
							<input type="radio" name="button_position" class="wpdb_hide" value="left" <?php checked( 'left', $settings['button_position'] ); ?> />
							<img style="vertical-align: middle;" src="<?php echo site_url() . '/wp-content/plugins/wp-demo-builder/assets/images/positions/option-pos-left.png'; ?>" />
						</label>
						<label<?php if ( checked( 'right', $settings['button_position'], false ) ) echo ' class="wpdb_selected"'; ?>>
							<input type="radio" name="button_position" class="wpdb_hide" value="right" <?php checked( 'right', $settings['button_position'] ); ?> />
							<img style="vertical-align: middle;" src="<?php echo site_url() . '/wp-content/plugins/wp-demo-builder/assets/images/positions/option-pos-right.png'; ?>" />
						</label>
						<label<?php if ( checked( 'bottom-left', $settings['button_position'], false ) ) echo ' class="wpdb_selected"'; ?>>
							<input type="radio" name="button_position" class="wpdb_hide" value="bottom-left" <?php checked( 'bottom-left', $settings['button_position'] ); ?> />
							<img style="vertical-align: middle;" src="<?php echo site_url() . '/wp-content/plugins/wp-demo-builder/assets/images/positions/option-pos-bottom-left.png'; ?>" />
						</label>
						<label<?php if ( checked( 'bottom-right', $settings['button_position'], false ) ) echo ' class="wpdb_selected"'; ?>>
							<input type="radio" name="button_position" class="wpdb_hide" value="bottom-right" <?php checked( 'bottom-right', $settings['button_position'] ); ?> />
							<img style="vertical-align: middle;" src="<?php echo site_url() . '/wp-content/plugins/wp-demo-builder/assets/images/positions/option-pos-bottom-right.png'; ?>" />
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="button-style"><?php _e( 'Button Style', WPDB_TEXT ); ?></label>
					</th>
					<td>
						<label<?php if ( checked( 'dark', $settings['button_style'], false ) ) echo ' class="wpdb_selected"'; ?>>
							<input type="radio" name="button_style" class="wpdb_hide" value="dark" <?php checked( 'dark', $settings['button_style'] ); ?> />
							<img style="vertical-align: middle;" src="<?php echo site_url() . '/wp-content/plugins/wp-demo-builder/assets/images/styles/option-style-dark.png'; ?>" />
						</label>
						<label<?php if ( checked( 'light', $settings['button_style'], false ) ) echo ' class="wpdb_selected"'; ?>>
							<input type="radio" name="button_style" class="wpdb_hide" value="light" <?php checked( 'light', $settings['button_style'] ); ?> />
							<img style="vertical-align: middle;" src="<?php echo site_url() . '/wp-content/plugins/wp-demo-builder/assets/images/styles/option-style-light.png'; ?>" />
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="button-style"><?php _e( 'Icon', WPDB_TEXT ); ?></label>
					</th>
					<td>
						<div id="icon-selector">
							<div class="wpdb-iconselector">
								<ul class="wpdb-items-list">
								<li class="wpdb-item<?php echo ( (string) $settings['button_icon'] == '' ) ? ' active': ''?>">
									<a class="icons-item" href="javascript:void(0)" data-value="">
										<i class="icon-"></i><?php _e( 'None', WPDB_TEXT ); ?>
									</a>
								</li>
							<?php
								foreach ( $icon_moons as $key => $icon_moon ) {
									$active = '';
									if ( $key == (string) $settings['button_icon'] )
									{
										$active = " active";
									}

							?>
								<li class="wpdb-item<?php echo $active; ?>">
									<a class="icons-item" href="javascript:void(0)" data-value="<?php echo $key; ?>">
										<i class="<?php echo $key; ?>"></i><?php echo $icon_moon; ?>
									</a>
								</li>
							<?php
								}
							?>
								</ul>
							</div>
						</div>
						<input type="hidden" id="button-icon-hidden-input" name="button_icon" value="<?php echo esc_attr( $settings['button_icon'] ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<button type="submit" class="button button-primary">
				<?php _e( 'Save', WPDB_TEXT ); ?>
			</button>
		</p>
	</form>
</div>