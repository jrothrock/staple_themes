<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Getting started template
 */
$customize_url = admin_url() . 'admin.php?page=stencil_options&tab=1';
$count          = $this->count_actions();
?>

<div class="feature-section three-col">
	<div class="col">
		<h3><?php esc_html_e( 'Step 1 - Implement recommended actions', 'stencil' ); ?></h3>
		<p><?php esc_html_e( 'We\'ve compiled a list of steps for you, to take make sure the experience you\'ll have using one of our products is very easy to follow.', 'stencil' ); ?></p>
		<?php if ( 0 == $count ) { ?>
			<p><span class="dashicons dashicons-yes"></span>
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=stencil-welcome&tab=recommended_actions' ) ); ?>"><?php esc_html_e( 'No recommended actions left to perform', 'stencil' ); ?></a>
			</p>
		<?php } else { ?>
			<p><span class="dashicons dashicons-no-alt"></span> <a
					href="<?php echo esc_url( admin_url( 'themes.php?page=stencil-welcome&tab=recommended_actions' ) ); ?>"><?php esc_html_e( 'Check recommended actions', 'stencil' ); ?></a>
			</p> 
			<?php
};
?>
	</div><!--/.col-->

	<div class="col">
		<h3><?php esc_html_e( 'Step 2 - Check our documentation', 'stencil' ); ?></h3>
		<p><?php esc_html_e( 'Even if you\'re a long-time WordPress user, we still believe you should give our documentation a quick glance.', 'stencil' ); ?></p>
		<p>
			<a target="_blank"
			   href="<?php echo esc_url( 'https://docs.staplethemes.com/' ); ?>"><?php esc_html_e( 'Full documentation', 'stencil' ); ?></a>
		</p>
	</div><!--/.col-->

	<div class="col">
		<h3><?php esc_html_e( 'Step 3 - Customize everything', 'stencil' ); ?></h3>
		<p><?php esc_html_e( "Using the Theme's Customizer, you can easily customize many aspects of the theme.", 'stencil' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( $customize_url ); ?>"
			  class="button button-primary"><?php esc_html_e( 'Go to Theme Options', 'stencil' ); ?></a>
		</p>
	</div><!--/.col-->
</div><!--/.feature-section-->
