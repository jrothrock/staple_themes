<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Components
 */

global $stencil_options;

$home_layout = $stencil_options['homepage-layout'];
$class = '';
if($home_layout == 'sidebar_left' && $stencil_options['sidebar-pages']){
	$class = 'right';
} elseif($home_layout == 'no_sidebar' || !$stencil_options['sidebar-pages']){
	$class = 'full';
}

get_header(); 
?>


	<div id="primary" class="content-area <?php echo $class?>">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'components/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if($stencil_options['sidebar-pages']){
	get_sidebar();
}
get_footer();
