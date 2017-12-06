<?php
/**
 * stencil functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package stencil
 */

require_once get_template_directory() .'/lib/tgm/template.php';
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( ! function_exists( 'stencil_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function stencil_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on stencil, use a find and replace
	 * to change 'stencil' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'stencil', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'stencil-featured-image', 640, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top_menu' => esc_html__( 'Top', 'stencil' ),
		'footer_menu' => esc_html__( 'Footer', 'stencil' )
		) );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}
endif;
add_action( 'after_setup_theme', 'stencil_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */


function stencil_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'stencil_content_width', 640 );
}
add_action( 'after_setup_theme', 'stencil_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
function stencil_the_custom_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		the_custom_logo();
	}
}

/*
	Remove the 'Customize' from the admin bar, as we now have Redux.
*/
function remove_some_nodes_from_admin_top_bar_menu( $wp_admin_bar ) {
    $wp_admin_bar->remove_menu( 'customize' );
}
add_action( 'admin_bar_menu', 'remove_some_nodes_from_admin_top_bar_menu', 999 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function stencil_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'stencil' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
}
add_action( 'widgets_init', 'stencil_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function stencil_scripts() {
	
	wp_enqueue_style( 'materialize', get_template_directory_uri() . '/assets/stylesheets/materialize.min.css' );

	wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
	
	wp_enqueue_style( 'stencil-style', get_stylesheet_uri() );

	wp_enqueue_script( 'stencil-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'stencil-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'materialize', get_template_directory_uri() . '/assets/js/materialize.min.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_plugin_active( 'stencil-extensions/stencil_extensions.php' ) ) {
		require_once get_template_directory() . '/inc/stencil_color_options.php';
	}
}
add_action( 'wp_enqueue_scripts', 'stencil_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 *  Register Custom Navigation Walker (for Materialize)
 */
require_once get_template_directory() . '/inc/materialize_navwalker.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

