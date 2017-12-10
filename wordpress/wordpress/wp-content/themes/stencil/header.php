<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Stencil
 */

global $stencil_options;
$title = $stencil_options['site-title'] ? $stencil_options['site-title'] : get_bloginfo('name');
$description = $stencil_options['site-description'] ? $stencil_options['site-description'] : get_bloginfo('description');
switch ($stencil_options['layout-nav-menu']) {
    case '1':
        $logo = '';
		$nav_menu = 'right';
        break;
    case '2':
        $logo = 'center';
		$nav_menu = 'left';
        break;
    case '3':
        $logo = 'center';
		$nav_menu = 'right';
        break;
	case '4':
        $logo = 'right';
		$nav_menu = 'left';
        break;
}

add_filter( 'body_class', function( $classes ) {
	global $stencil_options;

    return array_merge( $classes, array( $stencil_options['sidebar-layout'], ($stencil_options['sidebar-pages'] ? 'sidebar-pages' : 'no-sidebar-pages' ), ($stencil_options['sidebar-posts'] ? 'sidebar-posts' : 'no-sidebar-posts' ), ($stencil_options['sidebar-shop'] ? 'sidebar-shop' : 'no-sidebar-shop' ), ($stencil_options['sidebar-archive'] ? 'sidebar-archive' : 'no-sidebar-archive' ) ) );
} );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<title><?php echo "${title} | ${description}" ?></title>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'stencil' ); ?></a>
		<?php if( $stencil_options['top-nav-menu']): ?>
			<header id="masthead" class="site-header" role="banner">

				<!-- components/header/site-branding.php -->

				<!--<?php stencil_the_custom_logo(); ?>-->

				<!-- components/navigation/navigation-top.php -->

				<!--<?php stencil_social_menu(); ?>-->
				<div class='<?php echo ($stencil_options['fixed-nav-menu'] ? "navbar-fixed" : "" ) ?>'>
					<nav class='top-main'>
						<div class="nav-wrapper">
							<a href="#" data-activates="mobile-demo" class="button-collapse">
								<div class='nav-icon'>
  									<span></span>
  									<span></span>
  									<span></span>
								</div>
							</a>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-logo <?php echo $logo ?>" title="<?php bloginfo('name'); ?>">
								<?php if( !empty( $stencil_options['stencil-logo']['url'] ) ) : ?>
									<?php echo '<img src="' . esc_url( $stencil_options['stencil-logo']['url'] ) . '"'; ?> alt="<?php get_bloginfo('name'); ?>">
								<?php elseif ($stencil_options['logo-nav-menu']) : ?>
									<?php echo get_bloginfo('name'); ?>
								<?php endif; ?>
							</a>
							
								<?php 
									if(has_nav_menu('top_menu')) {
										wp_nav_menu( array( 
											'theme_location' => 'top_menu', 
											'menu_class' =>  $nav_menu . ' hide-on-med-and-down', 
											'walker'=> new Materialize_Walker_Desktop_Nav_Menu() 
										) );
									} else {
										echo '<div class="no-menu-container"><ul class="' . $nav_menu . ' hide-on-med-and-down"><li><a href="/wp-admin/nav-menus.php?action=edit&menu=0">' . esc_html__( 'No menu assigned!', 'stencil' ) . '</a></li></ul></div>';
									}
								?>
								
								<?php 
									if(has_nav_menu('top_menu')) {
										wp_nav_menu( array( 
											'theme_location' => 'top_menu', 
											'menu_class' => 'side-nav', 
											'menu_id' => 'mobile-demo',
											'depth' => 1,
										) );
									} else {
										echo '<div class="no-menu-container"><ul class="side-nav" id="mobile-demo"><li><a href="/wp-admin/nav-menus.php?action=edit&menu=0">' . esc_html__( 'No menu assigned!', 'stencil' ) . '</a></li></ul></div>';
									} 
								?>
								

						</div>
					</nav>
				</div>

			</header><!-- #masthead -->
		<?php
			endif;
		?>

	<div id="content" class="site-content">
