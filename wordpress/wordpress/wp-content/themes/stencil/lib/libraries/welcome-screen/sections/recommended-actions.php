<?php
/**
 * Template part for the recommended actions tab in welcome screen
 *
 * @package Epsilon Framework
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Actions required
 */

wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
$hooray = true;
?>

<div class="feature-section action-required demo-import-boxed" id="plugin-filter">
	<div>
		<h3><?php esc_html_e( 'Step 1 - Install Required Plugins', 'stencil' ); ?></h3>
		<p><?php esc_html_e( "If 'Theme Options' doesn't appear under 'About Stencil', install the required extensions plugin for this theme.", 'stencil' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( admin_url( 'admin.php?page=tgmpa-install-plugins' ) ); ?>"
			  class="button button-primary"><?php esc_html_e( 'Install Required Plugins', 'stencil' ); ?></a>
		</p>
	</div>
	<div>
		<h3><?php esc_html_e( 'Step 2 - Install Recommended Plugins', 'stencil' ); ?></h3>
		<p><?php esc_html_e( "Install the recommended plugins for this theme.", 'stencil' ); ?></p>
		<p><a href="<?php echo esc_url( admin_url( 'admin.php?page=stencil-welcome&tab=recommended_plugins' ) ); ?>"
			  class="button button-primary"><?php esc_html_e( 'Install Recommended Plugins', 'stencil' ); ?></a>
		</p>
	</div>
</div>
