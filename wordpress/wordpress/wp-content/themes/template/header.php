<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Components
 */

global $template_options;
$title = $template_options['site-title'] ? $template_options['site-title'] : get_bloginfo('name');
$description = $template_options['site-description'] ? $template_options['site-description'] : get_bloginfo('description');
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
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'components' ); ?></a>
		<?php if( $template_options['top-nav-menu']): ?>
			<header id="masthead" class="site-header" role="banner">

				<!-- components/header/site-branding.php -->

				<!--<?php components_the_custom_logo(); ?>-->

				<!-- components/navigation/navigation-top.php -->

				<!--<?php components_social_menu(); ?>-->

				<nav>
					<div class="nav-wrapper">
						<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-navicon" style='font-size:1.6em;color:white'></i></a>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-logo" title="<?php bloginfo('name'); ?>">
							<?php if( !empty( $template_options['template-logo']['url'] ) ) : ?>
								<?php echo '<img src="' . esc_url( $template_options['template-logo']['url'] ) . '"'; ?> alt="<?php get_bloginfo('name'); ?>">
							<?php else : ?>
								<?php echo get_bloginfo('name'); ?>
							<?php endif; ?>
						</a>
						
							<?php wp_nav_menu( array( 
									'theme_location' => 'top_menu', 
									'menu_class' => 'right hide-on-med-and-down', 
									'walker'=> new Materialize_Walker_Desktop_Nav_Menu() 
							) ); ?>
							<?php wp_nav_menu( array( 
									'theme_location' => 'top_menu', 
									'menu_class' => 'side-nav', 
									'menu_id' => 'mobile-demo',
									'depth' => 1,
							) ); ?>
							

					</div>
				</nav>

			</header><!-- #masthead -->
		<?php
			endif;
		?>

	<div id="content" class="site-content">
