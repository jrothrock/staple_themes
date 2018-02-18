<?php

class Stencil_Lite_Helper {

	public static $stencil_settings;
	public static $stencil_fields = array(
		'stencil_subheader_features_show',
		'stencil_features_general_title',
		'stencil_features_general_description',
		'stencil_features_general_button_text',
		'stencil_features_general_button_url',
		'stencil_features_feature1_title',
		'stencil_features_feature1_description',
		'stencil_features_feature1_buttonurl',
		'stencil_features_feature2_title',
		'stencil_features_feature2_description',
		'stencil_features_feature2_buttonurl',
		'stencil_features_feature3_title',
		'stencil_features_feature3_description',
		'stencil_features_feature3_buttonurl',
		'stencil_features_feature4_title',
		'stencil_features_feature4_description',
		'stencil_features_feature4_buttonurl',
		'stencil_ourteam_general_show',
		'stencil_ourteam_general_title',
		'stencil_ourteam_general_description',
		'stencil_ourteam_teammember1_image',
		'stencil_ourteam_teammember1_name',
		'stencil_ourteam_teammember1_description',
		'stencil_ourteam_teammember1_position',
		'stencil_ourteam_teammember1_buttonurl',
		'stencil_ourteam_teammember2_image',
		'stencil_ourteam_teammember2_name',
		'stencil_ourteam_teammember2_description',
		'stencil_ourteam_teammember2_position',
		'stencil_ourteam_teammember2_buttonurl',
		'stencil_ourteam_teammember3_image',
		'stencil_ourteam_teammember3_name',
		'stencil_ourteam_teammember3_description',
		'stencil_ourteam_teammember3_position',
		'stencil_ourteam_teammember3_buttonurl',
		'stencil_ourteam_teammember4_image',
		'stencil_ourteam_teammember4_name',
		'stencil_ourteam_teammember4_description',
		'stencil_ourteam_teammember4_position',
		'stencil_ourteam_teammember4_buttonurl',
		'stencil_testimonials_general_show',
		'stencil_testimonials_general_image1',
		'stencil_testimonials_general_image2',
		'stencil_testimonials_general_image3',
		'stencil_testimonials_general_image4',
		'stencil_testimonials_testimonial1_description',
		'stencil_testimonials_testimonial1_image',
		'stencil_testimonials_testimonial1_name',
		'stencil_testimonials_testimonial1_position',
		'stencil_testimonials_testimonial2_description',
		'stencil_testimonials_testimonial2_image',
		'stencil_testimonials_testimonial2_name',
		'stencil_testimonials_testimonial2_position',
		'stencil_testimonials_testimonial3_description',
		'stencil_testimonials_testimonial3_image',
		'stencil_testimonials_testimonial3_name',
		'stencil_testimonials_testimonial3_position',
		'stencil_testimonials_testimonial4_description',
		'stencil_testimonials_testimonial4_image',
		'stencil_testimonials_testimonial4_name',
		'stencil_testimonials_testimonial4_position',
		'stencil_testimonials_testimonial5_description',
		'stencil_testimonials_testimonial5_image',
		'stencil_testimonials_testimonial5_name',
		'stencil_testimonials_testimonial5_position',
		'stencil_speak_general_show',
		'stencil_speak_general_title',
		'stencil_speak_general_description',
		'stencil_speak_general_buttonurl',
	);


	public static function parse_stencil_settings() {

		$stencil_settings = get_post_meta( Stencil_Lite_Helper::get_setting_page_id(), 'stencil-settings', true );

		if ( is_array( $stencil_settings ) ) {
			return $stencil_settings;
		}
		return array();

	}

	public static function get_stencil_setting( $setting, $default = false ) {

		if ( in_array( $setting, Stencil_Lite_Helper::$stencil_fields ) ) {
			$stencil_settings = Stencil_Lite_Helper::parse_stencil_settings();
			if ( isset( $stencil_settings[ $setting ] ) ) {
				return $stencil_settings[ $setting ];
			} else {
				return false;
			}
		} else {
			return false;
		}

	}

	// static method in order to get settings from page
	// use $arguments[0] if value doesn't exist.
	public static function __callStatic( $name, $arguments ) {

		$settings_id = str_replace( '_get_', '', $name );
		$setting_value = Stencil_Lite_Helper::get_stencil_setting( $settings_id );

		if ( false === $setting_value ) {
			return $arguments[0];
		} else {
			return $setting_value;
		}

	}

	public static function create_content_from_options() {

		$data = get_post_meta( Stencil_Lite_Helper::get_setting_page_id(), 'stencil-settings', true );

		$sections = array(
			array(
				'title' => __( 'Services Section', 'stencil' ),
				'fields' => array(
					'stencil_subheader_features_show' => __( 'Sho/Hide Services Section', 'stencil' ),
					'stencil_features_general_title' => __( 'Section Title', 'stencil' ),
					'stencil_features_general_description' => __( 'Section Description', 'stencil' ),
					'stencil_features_general_button_text' => __( 'Section Button Text', 'stencil' ),
					'stencil_features_general_button_url' => __( 'Section Button URL', 'stencil' ),
					'stencil_features_feature1_title' => __( 'Service 1 Title', 'stencil' ),
					'stencil_features_feature1_description' => __( 'Service 1 Description', 'stencil' ),
					'stencil_features_feature1_buttonurl' => __( 'Service 1 Button URL', 'stencil' ),
					'stencil_features_feature2_title' => __( 'Service 2 Title', 'stencil' ),
					'stencil_features_feature2_description' => __( 'Service 2 Description', 'stencil' ),
					'stencil_features_feature2_buttonurl' => __( 'Service 2 Button URL', 'stencil' ),
					'stencil_features_feature3_title' => __( 'Service 3 Title', 'stencil' ),
					'stencil_features_feature3_description' => __( 'Service 3 Description', 'stencil' ),
					'stencil_features_feature3_buttonurl' => __( 'Service 3 Button URL', 'stencil' ),
					'stencil_features_feature4_title' => __( 'Service 4 Title', 'stencil' ),
					'stencil_features_feature4_description' => __( 'Service 4 Description', 'stencil' ),
					'stencil_features_feature4_buttonurl' => __( 'Service 4 Button URL', 'stencil' ),
				),
			),
			array(
				'title' => __( 'Our Team Section', 'stencil' ),
				'fields' => array(
					'stencil_ourteam_general_show' => __( 'Sho/Hide Section', 'stencil' ),
					'stencil_ourteam_general_title' => __( 'Section Title', 'stencil' ),
					'stencil_ourteam_general_description' => __( 'Section Description', 'stencil' ),
					'stencil_ourteam_teammember1_image' => __( 'Member 1 Image', 'stencil' ),
					'stencil_ourteam_teammember1_name' => __( 'Member 1 Name', 'stencil' ),
					'stencil_ourteam_teammember1_description' => __( 'Member 1 Description', 'stencil' ),
					'stencil_ourteam_teammember1_buttonurl' => __( 'Member 1 Button URL', 'stencil' ),
					'stencil_ourteam_teammember2_image' => __( 'Member 2 Image', 'stencil' ),
					'stencil_ourteam_teammember2_name' => __( 'Member 2 Name', 'stencil' ),
					'stencil_ourteam_teammember2_description' => __( 'Member 2 Description', 'stencil' ),
					'stencil_ourteam_teammember2_buttonurl' => __( 'Member 2 Button URL', 'stencil' ),
					'stencil_ourteam_teammember3_image' => __( 'Member 3 Image', 'stencil' ),
					'stencil_ourteam_teammember3_name' => __( 'Member 3 Name', 'stencil' ),
					'stencil_ourteam_teammember3_description' => __( 'Member 3 Description', 'stencil' ),
					'stencil_ourteam_teammember3_buttonurl' => __( 'Member 3 Button URL', 'stencil' ),
					'stencil_ourteam_teammember4_image' => __( 'Member 4 Image', 'stencil' ),
					'stencil_ourteam_teammember4_name' => __( 'Member 4 Name', 'stencil' ),
					'stencil_ourteam_teammember4_description' => __( 'Member 4 Description', 'stencil' ),
					'stencil_ourteam_teammember4_buttonurl' => __( 'Member 4 Button URL', 'stencil' ),
				),
			),
			array(
				'title' => __( 'Testimonials Section', 'stencil' ),
				'fields' => array(
					'stencil_testimonials_general_show' => __( 'Sho/Hide Section', 'stencil' ),
					'stencil_testimonials_general_image1' => __( 'Gallery Image 1', 'stencil' ),
					'stencil_testimonials_general_image2' => __( 'Gallery Image 2', 'stencil' ),
					'stencil_testimonials_general_image3' => __( 'Gallery Image 3', 'stencil' ),
					'stencil_testimonials_general_image4' => __( 'Gallery Image 4', 'stencil' ),
					'stencil_testimonials_testimonial1_description' => __( 'Testimonial 1 Content', 'stencil' ),
					'stencil_testimonials_testimonial1_image' => __( 'Testimonial 1 Image', 'stencil' ),
					'stencil_testimonials_testimonial1_name' => __( 'Testimonial 1 Person Name', 'stencil' ),
					'stencil_testimonials_testimonial1_position' => __( 'Testimonial 1 Person Position', 'stencil' ),
					'stencil_testimonials_testimonial2_description' => __( 'Testimonial 2 Content', 'stencil' ),
					'stencil_testimonials_testimonial2_image' => __( 'Testimonial 2 Image', 'stencil' ),
					'stencil_testimonials_testimonial2_name' => __( 'Testimonial 2 Person Name', 'stencil' ),
					'stencil_testimonials_testimonial2_position' => __( 'Testimonial 2 Person Position', 'stencil' ),
					'stencil_testimonials_testimonial3_description' => __( 'Testimonial 3 Content', 'stencil' ),
					'stencil_testimonials_testimonial3_image' => __( 'Testimonial 3 Image', 'stencil' ),
					'stencil_testimonials_testimonial3_name' => __( 'Testimonial 3 Person Name', 'stencil' ),
					'stencil_testimonials_testimonial3_position' => __( 'Testimonial 3 Person Position', 'stencil' ),
					'stencil_testimonials_testimonial4_description' => __( 'Testimonial 4 Content', 'stencil' ),
					'stencil_testimonials_testimonial4_image' => __( 'Testimonial 4 Image', 'stencil' ),
					'stencil_testimonials_testimonial4_name' => __( 'Testimonial 4 Person Name', 'stencil' ),
					'stencil_testimonials_testimonial4_position' => __( 'Testimonial 4 Person Position', 'stencil' ),
					'stencil_testimonials_testimonial5_description' => __( 'Testimonial 5 Content', 'stencil' ),
					'stencil_testimonials_testimonial5_image' => __( 'Testimonial 5 Image', 'stencil' ),
					'stencil_testimonials_testimonial5_name' => __( 'Testimonial 5 Person Name', 'stencil' ),
					'stencil_testimonials_testimonial5_position' => __( 'Testimonial 5 Person Position', 'stencil' ),
				),
			),
			array(
				'title' => __( 'Recent Works Section', 'stencil' ),
				'fields' => array(
					'stencil_speak_general_show' => __( 'Sho/Hide Section', 'stencil' ),
					'stencil_speak_general_title' => __( 'Section Title', 'stencil' ),
					'stencil_speak_general_description' => __( 'Section Description', 'stencil' ),
					'stencil_speak_general_buttonurl' => __( 'Section Button URL', 'stencil' ),
				),
			),
		);

		$content = '';
		foreach ( $sections as $section ) {
			$section_content = '';
			foreach ( $section['fields'] as $field_key => $field_name ) {
				if ( isset( $data[ $field_key ] ) && '' != $field_key ) {
					$section_content .= $field_name . ': ' . $data[ $field_key ] . '<br>';
				}
			}
			if ( '' != $section_content ) {
				if ( '' != $content ) {
					$content .= '<br>';
				}
				$content .= $section['title'] . '<br><br>';
				$content .= $section_content;
			}
		}

		if ( '' != $content ) {
			$stencil_settings_page_args = array(
				'ID'           => Stencil_Lite_Helper::get_setting_page_id(),
				'post_content' => $content,
			);
			wp_update_post( $stencil_settings_page_args );
		}

	}

	public static function get_setting_page_id() {

		$page_id = get_option( 'stencil-settings-id' );
		if ( $page_id ) {
			return $page_id;
		} else {

			$page_args = array(
				'post_title' => 'stencil Settings',
				'post_status' => 'draft',
				'post_type' => 'page',
				'post_author' => 0,
			);

			$page_id = wp_insert_post( $page_args );

			if ( ! is_wp_error( $page_id ) ) {
				update_option( 'stencil-settings-id', $page_id );
				return $page_id;
			}
		}

	}

}

foreach ( Stencil_Lite_Helper::$stencil_fields as $stencil_setting ) {
	add_filter( "customize_sanitize_js_{$stencil_setting}", array( 'Stencil_Lite_Helper', "_get_{$stencil_setting}" ) );
	add_filter( "theme_mod_{$stencil_setting}", array( 'Stencil_Lite_Helper', "_get_{$stencil_setting}" ) );
}

add_action( 'customize_save_after', array( 'Stencil_Lite_Helper', 'create_content_from_options' ) );

add_action( 'add_meta_boxes', 'stencil_remove_editor_for_stencil_settings', 20, 2 );
function stencil_remove_editor_for_stencil_settings( $post_type, $post ) {

	if ( 'page' != $post_type ) {
		return;
	}

	$stencil_page_id = get_option( 'stencil-settings-id' );

	if ( $stencil_page_id && $stencil_page_id == $post->ID ) {
		add_action( 'edit_form_after_title', 'stencil_setting_page_notice' );
		remove_post_type_support( $post_type, 'editor' );
	}

}

function stencil_setting_page_notice() {
	echo '<div class="notice notice-warning inline"><p>' . __( 'You are currently editing the page that hold your theme settings. Please don\'t delete it', 'stencil' ) . '</p></div>';
}

add_filter( 'display_post_states', 'add_states_for_stencil_settings_page', 10, 2 );
function add_states_for_stencil_settings_page( $post_states, $post ) {

	if ( intval( get_option( 'stencil-settings-id' ) ) === $post->ID ) {
		$post_states['stencil_setting_page'] = __( 'Theme Settings Page. Don\'t delete it.', 'stencil' );
		unset( $post_states['draft'] );
	}

	return $post_states;

}

add_action( 'customize_update_epsilon_page', 'stencil_save_custom_setting', 10, 2 );
function stencil_save_custom_setting( $value, $setting ) {

	$existing_settings = Stencil_Lite_Helper::parse_stencil_settings();
	$key = $setting->id;

	$existing_settings[ $key ] = $value;

	update_post_meta( Stencil_Lite_Helper::get_setting_page_id(), 'stencil-settings', $existing_settings );

	return true;

}
