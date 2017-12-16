<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Components
 */

global $stencil_options;

$home_layout = $stencil_options['homepage-layout'];
$class = '';
if($home_layout == 'sidebar_left' && $stencil_options['sidebar-archive']){
	$class = 'right';
} elseif($home_layout == 'no_sidebar' || !$stencil_options['sidebar-archive']){
	$class = 'full';
}

get_header(); ?>

	<div id="primary" class="content-area <?php echo $class?>">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h2 class="page-title center">', '</h2>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

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

			the_posts_navigation();

		else :

			get_template_part( 'components/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if($stencil_options['sidebar-archive']){
	get_sidebar();
}
get_footer();
