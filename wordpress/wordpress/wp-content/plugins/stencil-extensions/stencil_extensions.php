<?php

/*
Plugin Name: Stencil Extensions
Plugin URI: https://staplethemes.com
Description: This plugin is developed to enhance the capabilities of the Stencil WordPress Theme.
Author: Staple Themes
Version: 1.0.0
Author URI: https://staplethemes.com
License: GPL v2 and later
License URI: http://themeforest.net/licenses/standard
*/

    if ( file_exists( dirname( __FILE__ ) . '/stencil_theme_options/admin-init.php' ) ) {
        require_once dirname( __FILE__ ) . '/stencil_theme_options/admin-init.php';
    }

?>