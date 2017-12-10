<?php
/**
 * Stencil Plugins Activation
 *
 * @package Stencil
 */

require get_template_directory() . '/lib/tgm/tgm-plugin-activation.php';

/**
 * Register Required Plugins
 */

if ( ! function_exists( 'stencil_register_required_plugins' ) ) :

function stencil_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
	 $plugins = array(

		// This is an example of how to include a plugin bundled with a theme.

		array(
			'name'               => esc_html__( 'Stencil Theme Extensions', 'stencil' ), 
			'slug'               => 'stencil_extensions', 
			'source'             =>  get_template_directory() . '/lib/plugins/stencil_extensions.zip', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),	
		array(
			'name'               => esc_html__( 'Favicon Generator', 'stencil' ),
			'slug'               => 'favicon-by-realfavicongenerator', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),

		array(
			'name'               => esc_html__( 'Contact Form 7', 'stencil' ),
			'slug'               => 'contact-form-7', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),
		array(
			'name'               => esc_html__( 'MailChimp for WordPress', 'stencil' ),
			'slug'               => 'mailchimp-for-wp', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),
		array(
			'name'               => esc_html__( 'ACF RGBA Color Picker', 'stencil' ),
			'slug'               => 'acf-rgba-color-picker', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),
		array(
			'name'               => esc_html__( 'One Click Demo Import', 'stencil' ),
			'slug'               => 'one-click-demo-import', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),
		array(
			'name'               => esc_html__( 'iThemes Security (formerly Better WP Security)', 'stencil' ),
			'slug'               => 'better-wp-security', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		)

	);

    tgmpa( $plugins );
}
endif;

add_action( 'tgmpa_register', 'stencil_register_required_plugins' );