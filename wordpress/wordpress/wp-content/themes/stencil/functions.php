<?php
/**
 * stencil functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package stencil
 */

require_once get_template_directory() . '/lib/tgm/template.php';
require_once get_template_directory() . '/lib/libraries/epsilon-framework/class-epsilon-autoloader.php';
require_once get_template_directory() . '/lib/libraries/class-stencil-helper.php' ;
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$args = array(
	'controls' => array( 'slider', 'toggle', 'upsell', 'text-editor' ), // array of controls to load
	'sections' => array( 'recommended-actions' ), // array of sections to load
	'path'     => '/lib/libraries', // path to your epsilon framework in your theme, e.g. theme-name*/inc/libraries*/epsilon-framework
	'backup'   => false,
);

new Epsilon_Framework( $args );

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

	add_theme_support( 'title-tag' );
	
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

function about_stencil(){
			if ( is_admin() ) {

			global $stencil_required_actions, $stencil_recommended_plugins;
			require_once get_template_directory() . '/lib/libraries/class-stencil-notify-system.php';
			require_once get_template_directory() . '/lib/libraries/welcome-screen/inc/class-epsilon-import-data.php';

			$stencil_recommended_plugins = array(
				'favicon-by-realfavicongenerator' => array(
					'recommended' => true,
				),
				'contact-form-7' => array(
					'recommended' => true,
				),
				'mailchimp-for-wp' => array(
					'recommended' => true,
				),
				'acf-rgba-color-picker' => array(
					'recommended' => true,
				),
				'one-click-demo-import' => array(
					'recommended' => true,
				),
				'better-wp-security' => array(
					'recommended' => true,
				),
			);

			/*
             * id - unique id; required
             * title
             * description
             * check - check for plugins (if installed)
             * plugin_slug - the plugin's slug (used for installing the plugin)
             *
             */
			$stencil_required_actions  = array(
				array(
					'id'          => 'stencil-import-data',
					'title'       => esc_html__( 'Easy 1-click theme setup', 'stencil' ),
					'description' => esc_html__( 'Clicking the button below will add settings/widgets and recommended plugins to your WordPress installation. Click advanced to customize the import process.', 'stencil' ),
					'help'        => array( Epsilon_Import_Data::get_instance(), 'generate_import_data_container' ),
					'check'       => Stencil_Notify_System::check_installed_data(),
				),
				array(
					'id'          => 'stencil-fix-homepage',
					'title'       => esc_html__( 'Fix Homepage', 'stencil' ),
					'description' => esc_html__( 'We have made some changes to how the Homepage works in stencil. Now you need to create a page and use the "Homepage Template" and set it as a static front page. You can also make this automatically by pushing the button below.', 'stencil' ),
					'help'        => '<p><a id="stencil-fix-homepage" href="#" class="button button-primary" style="text-decoration: none;"> ' . esc_html__( 'Fix Homepage', 'stencil' ) . '</a><span class="spinner" style="float:none"></span></p>',
					'check'       => Stencil_Notify_System::show_fix_action(),
				),
			);

			if ( is_customize_preview() ) {
				$url                                = 'themes.php?page=%1$s-welcome&tab=%2$s';
				$stencil_required_actions[0]['help'] = '<a class="button button-primary" id="" href="' . esc_url( admin_url( sprintf( $url, 'stencil', 'recommended-actions' ) ) ) . '">' . __( 'Easy 1-click theme setup', 'stencil' ) . '</a>';
			}

			require get_template_directory() . '/lib/libraries/welcome-screen/class-stencil-welcome-screen.php';
		}// End if().
}
add_action( 'after_setup_theme', 'about_stencil' );


/**
*
*	Exclude pages from WordPress Search
*
*/

if (!is_admin()) {
	function wpb_search_filter($query) {
	if ($query->is_search) {
	$query->set('post_type', 'post');
	}
	return $query;
	}
	add_filter('pre_get_posts','wpb_search_filter');
}

/**
*
*	Remove <p> tags that wrap images, scripts, and iframes.
*
*/

function remove_some_ptags( $content ) {
  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  $content = preg_replace('/<p>\s*(<script.*>*.<\/script>)\s*<\/p>/iU', '\1', $content);
  $content = preg_replace('/<p>\s*(<iframe.*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
  return $content;
}
add_filter( 'the_content', 'remove_some_ptags' );

/**
*
* Move Comment Form Body Field To The Bottom
*
**/

function stencil_move_comment_body_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
 
add_filter( 'comment_form_fields', 'stencil_move_comment_body_field_to_bottom' );

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
	
	wp_enqueue_style( 'materialize', get_template_directory_uri() . '/assets/stylesheets/materialize.min.css', array(), '1.0.0' );

	wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '1.0.0' );
	
	wp_enqueue_style( 'stencil-style', get_stylesheet_uri(), array(), '1.0.0' );

	wp_enqueue_script( 'stencil-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.0.0', true );

	wp_enqueue_script( 'materialize', get_template_directory_uri() . '/assets/js/materialize.min.js', array('jquery'), '1.0.0' );

	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_plugin_active( 'stencil-extensions/stencil_extensions.php' ) ) {
		require_once get_template_directory() . '/inc/stencil_css_options.php';
		require_once get_template_directory() . '/inc/stencil_javascript_options.php';
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

/**
* Load Custom Password Form
*/

require get_template_directory() . '/inc/custom-password-form.php';
