<?php
	
    
	global $stencil_options;
	$stencil_options_css = '';

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
	
	$stencil_theme_color = $stencil_options['stencil-theme-color'];
    $stencil_nav_footer_link_color = $stencil_options['stencil-nav-footer-link-color'];
    $stencil_background_color = $stencil_options['stencil-background-color'];
    $stencil_link_color = $stencil_options['stencil-link-color'];
    $stencil_link_visited_color = $stencil_options['stencil-link-visited-color'];
    $stencil_button_color = $stencil_options['stencil-button-color'];
    $stencil_menu_link_color = $stencil_options['stencil-menu-drop-link-color'];
    $stencil_menu_link_hover_color = $stencil_options['stencil-menu-drop-link-hover-color'];
	$stencil_menu_drop_hover_color = $stencil_options['stencil-menu-drop-hover-color'];
    $stencil_menu_drop_color = $stencil_options['stencil-menu-drop-color'];
	
	/* options panel generated css styles */	
	$stencil_options_css .= 'body{background:' . $stencil_background_color . ';}' ;
    $stencil_options_css .= 'a, a:focus, a:active,  .post-navigation .nav-next a, .post-navigation .nav-previous a, .posts-navigation .nav-next a, .posts-navigation .nav-previous a, .comment-navigation .nav-next a, .comment-navigation .nav-previous a{color:' . $stencil_link_color . ';} ';
    $stencil_options_css .= 'a:hover, .post-navigation .nav-next a:hover, .post-navigation .nav-previous a:hover, .posts-navigation .nav-next a:hover, .posts-navigation .nav-previous a:hover, .comment-navigation .nav-next a:hover, .comment-navigation .nav-previous a:hover{color:' . hex2rgba($stencil_link_color,'0.65') . ';} ';
    $stencil_options_css .= 'a:visited{color:' . $stencil_link_visited_color . ';} ';
    $stencil_options_css .= 'a:visited:hover{color:' . hex2rgba($stencil_link_visited_color, '0.65') . ';} ';
    $stencil_options_css .= 'nav,.page-footer,.back-to-top:hover, .post .share-icons a:hover li i{background-color:' . $stencil_theme_color . ';}';
    $stencil_options_css .= '.back-to-top{background-color:' . hex2rgba($stencil_theme_color,'0.8') . ';}';
    $stencil_options_css .= 'nav > div > a, nav > div > div > ul > li > a, nav > div > div > ul > li > a:focus, nav > div > div > ul > li > a:active, nav > div > div > ul > li > a:visited, nav > div > div > ul > li > a:visited:hover, nav > div > div > ul > li > a:hover, .footer-social-icons > a, .footer-social-icons > a:visited:hover, .footer-copyright > div > a, nav .brand-logo, nav .brand-logo:hover, nav .brand-logo:visited:hover, nav .brand-logo:visited, .not-found-recent-posts {color:' . $stencil_nav_footer_link_color . ';} ';
    $stencil_options_css .= '.btn, .btn:focus{background-color:' . $stencil_button_color . ';} ';
    $stencil_options_css .= '.btn:hover{background-color:' . hex2rgba($stencil_button_color,'0.82') . ';} ';
    $stencil_options_css .= '.dropdown-content li>a, .dropdown-content li>span{color:' . $stencil_menu_link_color . ';} ';
    $stencil_options_css .= '.dropdown-content li>a:hover, .dropdown-content li>span:hover{color:' . $stencil_menu_link_hover_color . ';} ';
    $stencil_options_css .= '.dropdown-content li, .dropdown-content li, .dropdown-content li{background-color:' . $stencil_menu_drop_color . ';} ';
    $stencil_options_css .= '.dropdown-content li:hover, .dropdown-content li.active, .dropdown-content li.selected{background-color:' . $stencil_menu_drop_hover_color . ';} ';
    $stencil_options_css .= 'blockquote{border-left:5px solid ' . $stencil_button_color .';}';
	$stencil_options_css .= 'input:not([type]):focus:not([readonly]), input[type=text]:not(.browser-default):focus:not([readonly]), input[type=password]:not(.browser-default):focus:not([readonly]), input[type=email]:not(.browser-default):focus:not([readonly]), input[type=url]:not(.browser-default):focus:not([readonly]), input[type=time]:not(.browser-default):focus:not([readonly]), input[type=date]:not(.browser-default):focus:not([readonly]), input[type=datetime]:not(.browser-default):focus:not([readonly]), input[type=datetime-local]:not(.browser-default):focus:not([readonly]), input[type=tel]:not(.browser-default):focus:not([readonly]), input[type=number]:not(.browser-default):focus:not([readonly]), input[type=search]:not(.browser-default):focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]) {border-bottom: 1px solid ' . $stencil_button_color . ';-webkit-box-shadow: 0 1px 0 0 ' . $stencil_button_color . ';box-shadow: 0 1px 0 0 ' . $stencil_button_color . ';} '; 
    $stencil_options_css .= '.not-found-recent-posts{background-color:' . $stencil_theme_color . ';}';


	
	// custom css editor styles ( user entered styles )
	if( !empty( $stencil_options['stencil-css-editor'] ) ){
		$stencil_options_css .= $stencil_options['stencil-css-editor'];
	}
	
wp_add_inline_style( 'stencil-style', $stencil_options_css );

?>