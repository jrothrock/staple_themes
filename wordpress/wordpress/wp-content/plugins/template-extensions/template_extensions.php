<?php

/*
Plugin Name: Template Extensions
Plugin URI: https://staplethemes.com
Description: This plugin is developed to enhance capabilities of the Template WordPress Themes.
Author: Staple Themes
Version: 1.0.0
Author URI: https://staplethemes.com
License: Themeforest Standard Licenses
License URI: http://themeforest.net/licenses/standard
*/

    if ( file_exists( dirname( __FILE__ ) . '/template_theme_options/admin-init.php' ) ) {
        require_once dirname( __FILE__ ) . '/template_theme_options/admin-init.php';
    }

?>