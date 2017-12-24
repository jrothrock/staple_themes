<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Components
 */

global $stencil_options;

$home_layout = $stencil_options['homepage-layout'];
$class = '';
if($home_layout == 'sidebar_left'){
	$class = 'right';
} elseif($home_layout == 'no_sidebar'){
	$class = 'full';
}

get_header(); ?>

	<section id="primary" class="content-area <?php echo $class?>">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'stencil' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'components/post/content', 'search' );

			endwhile;

			the_posts_navigation();

		else : ?>

			<div class="page-header">
				<h1 class="page-title">No results Found</h1>
				<p>
					It seems we can’t find what you’re looking for.
					Perhaps you should try again with a different search term.
				</p>
			</div>
			<div class="well">
				<?php get_search_form(); ?>
			</div>

		<?php endif; ?> 

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
