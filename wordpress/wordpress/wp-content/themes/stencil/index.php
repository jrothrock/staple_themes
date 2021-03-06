<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Components
 */

global $stencil_options;

$home_layout = $stencil_options['sidebar-layout'];
$class = '';
if($home_layout == 'sidebar_left' && $stencil_options['sidebar-pages']){
	$class = 'right';
} elseif($home_layout == 'no_sidebar' || !$stencil_options['sidebar-pages']){
	$class = 'full';
}


get_header(); ?>
	<div id="primary" class="content-area <?php echo $class ?>">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php
			endif;
			?>
			<div class='posts-container'>
				<?php 
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part( 'components/post/content', get_post_format() );

					endwhile;
				?>
			</div>
			<?php

				the_posts_navigation();

		else :

			get_template_part( 'components/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if($stencil_options['sidebar-pages']){
	get_sidebar();
}
get_footer();
