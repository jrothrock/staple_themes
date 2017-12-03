<?php
	
    
	global $template_options;
	$template_options_css = '';

    function hex2rgba($hex,$alpha=1) {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = "rgba({$r},{$g},{$b},$alpha)";
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
	
	$template_theme_color = $template_options['template-theme-color'];
    $template_nav_footer_link_color = $template_options['template-nav-footer-link-color'];
    $template_background_color = $template_options['template-background-color'];
    $template_link_color = $template_options['template-link-color'];
    $template_link_visited_color = $template_options['template-link-visited-color'];
    $template_button_color = $template_options['template-button-color'];
    $template_menu_link_color = $template_options['template-menu-drop-link-color'];
    $template_menu_link_hover_color = $template_options['template-menu-drop-link-hover-color'];
	$template_menu_drop_hover_color = $template_options['template-menu-drop-hover-color'];
    $template_menu_drop_color = $template_options['template-menu-drop-color'];
	
	/* options panel generated css styles */	
	$template_options_css .= 'body{background:' . $template_background_color . ';}' ;
    $template_options_css .= 'a{color:' . $template_link_color . ';} ';
    $template_options_css .= 'a:hover{color:' . hex2rgba($template_link_color,'0.65') . ';} ';
    $template_options_css .= 'a:visited{color:' . $template_link_visited_color . ';} ';
    $template_options_css .= 'a:visited:hover{color:' . hex2rgba($template_link_visited_color, '0.65') . ';} ';
    $template_options_css .= 'nav,.page-footer,.back-to-top:hover{background-color:' . $template_theme_color . ';}';
    $template_options_css .= '.back-to-top{background-color:' . hex2rgba($template_theme_color,'0.8') . ';}';
    $template_options_css .= 'nav > div > a, nav > div > div > ul > li > a, nav > div > div > ul > li > a:visited, nav > div > div > ul > li > a:visited:hover, nav > div > div > ul > li > a:hover, .footer-social-icons > a, .footer-copyright > div > a, nav .brand-logo, nav .brand-logo:hover, nav .brand-logo:visited:hover, nav .brand-logo:visited{color:' . $template_nav_footer_link_color . ';} ';
    $template_options_css .= '.btn{background-color:' . $template_button_color . ';} ';
    $template_options_css .= '.btn:hover{background-color:' . hex2rgba($template_button_color,'0.82') . ';} ';
    $template_options_css .= '.dropdown-content li>a, .dropdown-content li>span{color:' . $template_menu_link_color . ';} ';
    $template_options_css .= '.dropdown-content li>a:hover, .dropdown-content li>span:hover{color:' . $template_menu_link_hover_color . ';} ';
    $template_options_css .= 'dropdown-content li, .dropdown-content li, .dropdown-content li{background-color:' . $template_menu_drop_color . ';} ';
    $template_options_css .= 'dropdown-content li:hover, .dropdown-content li.active, .dropdown-content li.selected{background-color:' . $template_menu_drop_hover_color . ';} ';
	$template_options_css .= 'input:not([type]):focus:not([readonly]), input[type=text]:not(.browser-default):focus:not([readonly]), input[type=password]:not(.browser-default):focus:not([readonly]), input[type=email]:not(.browser-default):focus:not([readonly]), input[type=url]:not(.browser-default):focus:not([readonly]), input[type=time]:not(.browser-default):focus:not([readonly]), input[type=date]:not(.browser-default):focus:not([readonly]), input[type=datetime]:not(.browser-default):focus:not([readonly]), input[type=datetime-local]:not(.browser-default):focus:not([readonly]), input[type=tel]:not(.browser-default):focus:not([readonly]), input[type=number]:not(.browser-default):focus:not([readonly]), input[type=search]:not(.browser-default):focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]) {border-bottom: 1px solid ' . $template_button_color . ';-webkit-box-shadow: 0 1px 0 0 ' . $template_button_color . ';box-shadow: 0 1px 0 0 ' . $template_button_color . ';} '; 
    

	
	// custom css editor styles ( user entered styles )
	if( !empty( $template_options['template-css-editor'] ) ){
		$template_options_css .= $template_options['template-css-editor'];
	}
	
wp_add_inline_style( 'components-style', $template_options_css );

?>