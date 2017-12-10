<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Stencil
 */

	global $stencil_options;

?>

	</div><!-- #content -->

		<!-- components/footer/site-info.php -->
		<?php if( $stencil_options['stencil-footer'] ) : ?>
			<footer class="page-footer <?php echo ( $stencil_options['stencil-footer-top'] ? 'top' : '') ?>">
			<?php if( $stencil_options['stencil-footer-top'] ) : ?>
				<div class="container">
					<div class="row">
						<div class="col l5 s12">
							<h5 class="white-text"><?php echo esc_html__( $stencil_options['footer-left-title'], 'dentist' ) ?></h5>
							<?php
								if($stencil_options['footer-left-layout'] === 'hours'){
									get_template_part('/components/footer/hours', 'footer-hours');
								} elseif($stencil_options['footer-left-layout'] === 'text'){
									echo "<p class='grey-text text-lighten-4'>" . esc_html__( $stencil_options['footer-left-text'], 'dentist' ) . "</p>";
								} else {
									if(has_nav_menu('footer_menu')) {
										$args = array(
											'theme_location'	=> 'footer_menu',
											'menu_class'		=> 'footer-menu',
											'container'			=> 'false',
											'depth'				=> 1
										);
										wp_nav_menu( $args );
									}
									else {
										echo '<ul class="footer-menu"><li><a href="/wp-admin/nav-menus.php?action=edit&menu=0">' . esc_html__( 'No menu assigned!', 'dentist' ) . '</a></li></ul>';
									}
								}
							?>
						</div>
						<div class="col l5 offset-l2 s12">
							<h5 class="white-text"><?php echo esc_html__( $stencil_options['footer-right-title'], 'dentist' ) ?></h5>
							<?php
								if($stencil_options['footer-right-layout'] === 'hours'){
									get_template_part('/components/footer/hours', 'footer-hours');
								} elseif($stencil_options['footer-right-layout'] === 'text'){
									echo "<p class='grey-text text-lighten-4'>" . esc_html__( $stencil_options['footer-right-text'], 'dentist' ) . "</p>";
								} else {
									if(has_nav_menu('footer_menu')) {
										$args = array(
											'theme_location'	=> 'footer_menu',
											'menu_class'		=> 'footer-menu',
											'container'			=> 'false',
											'depth'				=> 1
										);
										wp_nav_menu( $args );
									}
									else {
										echo '<ul class="footer-menu"><li><a href="/wp-admin/nav-menus.php?action=edit&menu=0">' . esc_html__( 'No menu assigned!', 'dentist' ) . '</a></li></ul>';
									}
								}
							?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<div class="footer-copyright <?php echo ( $stencil_options['footer-social'] ? '' : 'center' ) ?>">
				<div class="container">
					<?php get_template_part('/components/footer/copyright','copyright'); ?>

					<div class="grey-text text-lighten-4 right footer-social-icons">
						<?php 
							if( $stencil_options['footer-social'] ){
								get_template_part( '/components/footer/social', 'footer-social' );
							}
						?>
					</div>
				</div>
			</div>
			</footer>
		<?php
			endif;
		?>
		<?php if( $stencil_options['to-top-button']): ?>
			<a href="#" id="back-to-top" class="rippler rippler-bs-default back-to-top" style='display:none'>
				<i class="waves-effect waves-light fa fa-angle-up"></i>
			</a>
		<?php
			endif;
		?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
