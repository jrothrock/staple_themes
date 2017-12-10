<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Components
 */
global $stencil_options;

$home_layout = $stencil_options['homepage-layout'];
$class = '';
if($home_layout == 'sidebar_left' && $stencil_options['sidebar-posts']){
	$class = 'right';
} elseif($home_layout == 'no_sidebar' || !$stencil_options['sidebar-posts']){
	$class = 'full';
}

get_header(); ?>

	<div id="primary" class="content-area <?php echo $class?>">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'components/post/content', get_post_format() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if($stencil_options['sidebar-posts']){
	get_sidebar();
}
get_footer();
