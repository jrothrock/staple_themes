<?php
/**
 * @package Components
 */

// Access global variable directly to adjust the content width for portfolio single page
if ( isset( $GLOBALS['content_width'] ) ) {
	$GLOBALS['content_width'] = 1100;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php echo get_the_term_list( $post->ID, 'jetpack-portfolio-type', '<span class="portfolio-entry-meta">', esc_html_x(', ', 'Used between list items, there is a space after the comma.', 'stencil' ), '</span>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'   => '<div class="page-links clear">',
				'after'    => '</div>',
				'pagelink' => '<span class="page-link">%</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_term_list( $post->ID, 'jetpack-portfolio-tag', '', esc_html__( ', ', 'stencil' ) );
			if ( $tags_list ) :
		?>
			<span class="tags-links"><?php printf( esc_html__( 'Tagged %1$s', 'stencil' ), $tags_list ); ?></span>
		<?php endif; ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'stencil' ), esc_html__( '1 Comment', 'stencil' ), esc_html__( '% Comments', 'stencil' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( esc_html__( 'Edit', 'stencil' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
