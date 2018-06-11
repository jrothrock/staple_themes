<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Stencil
 */

global $stencil_options;
$home_layout = $stencil_options['sidebar-layout'];
$class = '';
if($home_layout == 'sidebar_left' && $stencil_options['sidebar-404']){
	$class = 'right';
} elseif($home_layout == 'no_sidebar' || !$stencil_options['sidebar-404']){
	$class = 'full';
}
get_header(); ?>

	<div id="primary" class="content-area <?php echo $class?>">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<div class='not-found-search-container'>
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'wp-materialize' ); ?></h1>
					</header><!-- .page-header -->
					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'wp-materialize' ); ?></p>
						<div class='not-found-search'>
							<?php
								get_search_form();
							?>
						</div>
					</div>
				</div>
				<h5 class='not-found-other-header'>Check out some of our other content:</h5>
				<div class='not-found-other-content-container'>
					<div class='not-found-posts-container'>
						<div class='not-found-recent-posts'>
							<h4>Recent Posts:</h4>
						</div>
						<?php $query = new WP_Query(array(
  							'showposts' => '5',
  							'post__not_in' => get_option("sticky_posts"),
  							));
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ):
									$query->the_post();
								?>
								<div style="display:block;margin-top:5px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
									<?php
										the_title( '<h6 class="not-found-entry-title" style="display:inline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h6>');
										echo '<p style="display:inline;color:#7b7b7b;font-size:1.2em"> - ' . (wp_count_comments(get_the_ID())->approved) . ' Comment' . ((wp_count_comments(get_the_ID())->approved) != 1 ? "s" : "") . '</p>';
									?>
								</div>
								<?php
								endwhile;
								wp_reset_postdata();
							} else {
								esc_html_e( 'No Posts Were Found', 'wp-materialize' );
							}
						?>
					</div>
					<div class='not-found-posts-container'>
						<div class='not-found-recent-posts'>
							<h4>Most Commented:</h4>
						</div>
						<?php $query = new WP_Query(array(
							'orderby' => 'comment_count',
							'showposts' => '5',
  							'post__not_in' => get_option("sticky_posts"),
  							));
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ):
									$query->the_post();
								?>
								<div style="display:block;margin-top:5px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
									<?php
										the_title( '<h6 class="not-found-entry-title" style="display:inline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h6>');
										echo '<p style="display:inline;color:#7b7b7b;font-size:1.2em"> - ' . (wp_count_comments(get_the_ID())->approved) . ' Comment' . ((wp_count_comments(get_the_ID())->approved) != 1 ? "s" : "") . '</p>';
									?>
								</div>
								<?php
								endwhile;
								wp_reset_postdata();
							} else {
								esc_html_e( 'No Posts Were Found', 'wp-materialize' );
							}
						?>
					</div>
					<div class='not-found-posts-container'>
						<div class='not-found-recent-posts'>
							<h4>Recent Archives:</h4>
						</div>
						<ul class='not-found-recent-archives'>
							<?php $query = wp_get_archives('limit=5'); ?>
						</ul>
					</div>
				</div>
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if($stencil_options['sidebar-404']){
	get_sidebar();
}
get_footer();
