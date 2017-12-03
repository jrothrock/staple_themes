<?php
/**
 * template Plugins Activation
 *
 * @package template
 */

require get_template_directory() . '/lib/tgm/tgm-plugin-activation.php';

/**
 * Register Required Plugins
 */

if ( ! function_exists( 'template_register_required_plugins' ) ) :

function template_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
	 $plugins = array(

		// This is an example of how to include a plugin bundled with a theme.

		array(
			'name'               => esc_html__( 'Template Theme Extensions', 'template' ), 
			'slug'               => 'templatetheme_extensions', 
			'source'             =>  get_template_directory() . '/lib/plugins/templatetheme.zip', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),	

		array(
			'name'               => esc_html__( 'Favicon Generator', 'template' ),
			'slug'               => 'favicon-by-realfavicongenerator', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),

		array(
			'name'               => esc_html__( 'Contact Form 7', 'template' ),
			'slug'               => 'contact-form-7', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),
		array(
			'name'               => esc_html__( 'MailChimp for WordPress', 'template' ),
			'slug'               => 'mailchimp-for-wp', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),
		array(
			'name'               => esc_html__( 'ACF RGBA Color Picker', 'template' ),
			'slug'               => 'acf-rgba-color-picker', 
			'force_activate'	 => false,
			'force_deactivation' => false,
			'required'           => true, 
			'version'            => '', 
			'external_url'		 => ''
		),
		array(
			'name'               => esc_html__( 'One Click Demo Import', 'template' ),
			'slug'               => 'one-click-demo-import', 
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

add_action( 'tgmpa_register', 'template_register_required_plugins' );