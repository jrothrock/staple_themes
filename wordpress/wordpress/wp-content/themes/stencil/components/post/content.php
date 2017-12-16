<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Stencil
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( '' != get_the_post_thumbnail()  && !is_single()) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'stencil-featured-image' ); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class='post-information'>
		<div class='post-date'>
			<i class='fa fa-calendar'></i> <?php echo get_the_date(); ?>
		</div>
		<div class='post-category'>
			<i class='fa fa-folder'></i> <a href="<?php $category = get_the_category(); echo get_category_link($category[0]->cat_ID) ?>"><?php $category = get_the_category(); $firstCategory = $category[0]->cat_name; echo $firstCategory; ?></a>
		</div>
	</div>

	<?php if ( '' != get_the_post_thumbnail() && is_single() ) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'stencil-featured-image' ); ?>
		</div>
	<?php endif; ?>

	<?php if(is_single()): ?>
		<div class="entry-content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'components' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'components' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	<?php else : ?>
		<div class='entry-excerpt'>
			<?php the_excerpt() ?>
		</div>
	<?php endif; ?>

	<?php if ( !is_single() ) : ?>
	
		<div class='post-read-more' style='width:100%;float:left;text-align:center;margin-bottom:20px;'>
			<a href="<?php echo esc_url( get_permalink() ) ?>"><button class='btn waves-effect waves-light'>Read More</button></a>
		</div>

	<?php endif; ?>

	<div class='share-container'>
		<ul class="share-icons">
			<!-- twitter -->
				<a href="https://twitter.com/share?text=<?php the_title() ?>&amp;url=<?php echo get_permalink() ?>" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;"><li><i class="fa fa-twitter waves-effect waves-light"></i></li></a>
			<!-- facebook -->
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink() ?>" onclick="window.open(this.href, 'facebook-share','width=580,height=296');return false;"><li><i class="fa fa-facebook waves-effect waves-light"></i></li></a>
			<!-- google plus -->
				<a href="https://plus.google.com/share?url=<?php echo get_permalink() ?>" onclick="window.open(this.href, 'google-plus-share', 'width=490,height=530');return false;"><li><i class="fa fa-google-plus waves-effect waves-light"></i></li></a>
			<!-- pinterest -->
				<a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><li><i class="fa fa-pinterest waves-effect waves-light"></i></li></a>
			<!-- linkedin -->
				<a href="https://www.linkedin.com/cws/share?url=<?php echo get_permalink() ?>%26source=<?php echo get_permalink() ?>" onclick="window.open(this.href, 'linkedin-share', 'width=490,height=530');return false;"><li><i class="fa fa-linkedin waves-effect waves-light"></i></li></a>
		</ul>
	</div>

</article><!-- #post-## -->