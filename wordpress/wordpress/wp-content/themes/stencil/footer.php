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
			<footer class="page-footer">
			<div class="container">
				<div class="row">
					<div class="col l6 s12">
						<h5 class="white-text"><?php echo esc_html( $stencil_options['footer-text-title'] ) ?></h5>
						<p class="grey-text text-lighten-4"><?php echo esc_html( $stencil_options['footer-text'] ) ?></p>
					</div>
					<div class="col l4 offset-l2 s12">
						<h5 class="white-text"><?php echo esc_html( $stencil_options['footer-links-title'] ) ?></h5>
						<?php
							
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
								echo '<ul class="footer-menu"><li><a href="/wp-admin/nav-menus.php?action=edit&menu=0">' . esc_html__( 'No menu assigned!', 'stencil' ) . '</a></li></ul>';
							}
							// main menu END
						?>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
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
				<i class="fa fa-angle-up"></i>
				<div class="rippler-effect rippler-div" style="width: 0px; height: 0px; left: 6px; top: 23px;"></div>
			</a>
		<?php
			endif;
		?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>