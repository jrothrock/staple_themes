<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "template_options";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'template_options',
        'display_name' => 'Template Theme Options',
        'display_version' => '1.0.0',
        'page_slug' => 'template_options',
        'page_title' => 'Theme Options',
        'update_notice' => TRUE,
        'admin_bar' => TRUE,
        'menu_type' => 'menu',
        'menu_title' => 'Theme Options',
        'menu_icon' => 'dashicons-art',
        'allow_sub_menu' => TRUE,
        'page_parent_post_type' => 'your_post_type',
        'page_priority' => '25',
        'customizer' => TRUE,
        'default_show' => TRUE,
        'default_mark' => '*',
        'class' => 'template-options',
        'hints' => array(
            'icon' => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color' => '#66abe8',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'dark',
                'style' => 'bootstrap',
            ),
            'tip_position' => array(
                'my' => 'top center',
                'at' => 'top left',
            ),
            'tip_effect' => array(
                'show' => array(
                    'effect' => 'slide',
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'effect' => 'slide',
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
		'disable_tracking' => TRUE,
		'dev_mode' => FALSE
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'template-extensions' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'template-extensions' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'template-extensions' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'template-extensions' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'template-extensions' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */
	
	// header settings START
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'General', 'template-extensions' ),
        'desc'       => esc_html__( 'General settings.', 'template-extensions' ),
        'id'         => 'page-header',
        'icon'   => 'el el-adjust-alt',
		'fields'     => array(
             array(
                'id'       => 'site-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Site Title', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your site title here.', 'template-extensions' ),
                'default' => get_bloginfo('name'),
                'desc' => "Unless this field is blank, this will be used instead of customizers."
             ),
            array(
                'id'       => 'site-description',
                'type'     => 'textarea',
                'title'    => esc_html__( 'Site Description', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your site description here.', 'template-extensions' ),
                'default' => get_bloginfo('description'),
                'desc' => "Unless this field is blank, this will be used instead of customizers."
            )
		)
     ));
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Logo', 'template-extensions' ),
        'desc'       => esc_html__( 'Upload logo here.', 'template-extensions' ),
        'id'         => 'page-logo',
        'subsection' => true,
        'icon'   => 'el el-bulb',
		'fields'     => array(
             array(
                'id'       => 'template-logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Header Logo', 'template-extensions' ),
				'desc'     => esc_html__( 'Recomended logo size is 440x120 pixels.', 'template-extensions' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'Upload your logo in JPG, PNG or GIF format.', 'template-extensions' )
            )
		)
     ));
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Navigation Menu', 'template-extensions' ),
        'desc'       => esc_html__( 'Options to show/hide top navigation bar elements.', 'template-extensions' ),
        'id'         => 'page-top-nav',
        'subsection' => true,
        'icon'   => 'el el-bulb',
		'fields'     => array(
			array(
                'id'       => 'top-nav-menu',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show or Hide Entire Top Nav Menu ', 'template-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable entire top nav menu section from here.', 'template-extensions' ),
                'default'  => 1,
                'on'       => 'SHOW',
                'off'      => 'HIDE',
            )
		)
     ));
     Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Miscellaneous Menu', 'template-extensions' ),
        'desc'       => esc_html__( 'Miscellaenous options', 'template-extensions' ),
        'id'         => 'page-miscellaneous',
        'subsection' => true,
        'icon'   => 'el el-bulb',
		'fields'     => array(
			array(
                'id'       => 'to-top-button',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show or Hide Back To The Top Button ', 'template-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable the back to the button here .', 'template-extensions' ),
                'default'  => 1,
                'on'       => 'SHOW',
                'off'      => 'HIDE',
            )
		)
     ));
	// header settings END
	
	// homepage settings START
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Home Page', 'template-extensions' ),
        'desc'       => esc_html__( 'All homepage related settings.', 'template-extensions' ),
        'id'         => 'home-page',
        'icon'   => 'el el-website',
		'fields'     => array(
             array(
				'id'       => 'homepage-layout',
				'type'     => 'select',
				'title'    => esc_html__( 'Home Page Layout', 'template-extensions' ),
				'subtitle' => esc_html__( 'Choose your prefered homepage layout.', 'template-extensions' ),
				'options'  => array(
					'sidebar_left' => 'Sidebar Left',
					'sidebar_right' => 'Sidebar Right',
					'no_sidebar' => 'No Sidebar'
				),
				'default'  => 'sidebar_right',
			)
		)
     ));


	// footer settings START
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Footer', 'template-extensions' ),
        'desc'       => esc_html__( 'All footer related settings can be done from here.', 'template-extensions' ),
        'id'         => 'page-footer',
        'icon'   => 'el el-photo',
		'fields'     => array(
			array(
                'id'       => 'footer-social',
                'type'     => 'switch',
                'title'    => esc_html__( 'Footer Social Icons', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enable or disable social icons in footer section.', 'template-extensions' ),
                'default'  => 1,
                'on'       => 'ON',
                'off'      => 'OFF',
            ),
			array(
                'id'       => 'template-footer',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show or Hide Entire Footer', 'template-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable entire footer section from here.', 'template-extensions' ),
                'default'  => 1,
                'on'       => 'SHOW',
                'off'      => 'HIDE',
            ),
            array(
                'id'       => 'footer-text-title',
                'type'     => 'text',
				'required' => array( 'template-footer', '=', '1' ),
                'title'    => esc_html__( 'Footer Description Title', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter the title for the footer description.', 'template-extensions' ),
                'default' => "About",
                'desc' => esc_html__( 'If left empty, no title will appear.', 'template-extensions' ),
            ),
			array(
                'id'       => 'footer-text',
                'type'     => 'textarea',
				'required' => array( 'template-footer', '=', '1' ),
                'title'    => esc_html__( 'Footer Description Text', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter text explaing your blog and/or about yourself.', 'template-extensions' ),
            ),
            array(
                'id'       => 'footer-links-title',
                'type'     => 'text',
				'required' => array( 'template-footer', '=', '1' ),
                'title'    => esc_html__( 'Footer Description Title', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter the title for the footer description.', 'template-extensions' ),
                'default' => "Links",
                'desc' => esc_html__( 'If left empty, no title will appear.', 'template-extensions' ),
            ),
			array(
                'id'       => 'template-copyright',
                'type'     => 'text',
				'required' => array( 'template-footer', '=', '1' ),
                'title'    => esc_html__( 'Copyright Text', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your custom copyright text here.', 'template-extensions' ),
                'desc'     => esc_html__( 'No need to include © character.', 'template-extensions' )
            )
		)
    ) );
	// footer settings END
	
	// social links START
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Social Links', 'template-extensions' ),
        'desc'       => esc_html__( 'All social network links should be added from here.', 'template-extensions' ),
        'id'         => 'social',
        'icon'   => 'dashicons dashicons-share',
		'fields'     => array(
            array(
                'id'       => 'website',
                'type'     => 'text',
                'title'    => esc_html__( 'Website', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your website link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
            array(
                'id'       => 'website_2',
                'type'     => 'text',
                'title'    => esc_html__( 'Website - 2', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your website link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'facebook',
                'type'     => 'text',
                'title'    => esc_html__( 'Facebook', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your facebook profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'twitter',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your twitter profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'linkedin',
                'type'     => 'text',
                'title'    => esc_html__( 'Linkedin', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your linkedin profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'pinterest',
                'type'     => 'text',
                'title'    => esc_html__( 'Pinterest', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your pinterest profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'google-plus',
                'type'     => 'text',
                'title'    => esc_html__( 'Google Plus', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your google+ profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'youtube',
                'type'     => 'text',
                'title'    => esc_html__( 'Youtube', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your youtube profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'tumblr',
                'type'     => 'text',
                'title'    => esc_html__( 'Tumblr', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your tumblr profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'instagram',
                'type'     => 'text',
                'title'    => esc_html__( 'Instagram', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your instagram profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'reddit',
                'type'     => 'text',
                'title'    => esc_html__( 'Reddit', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your reddit profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'flickr',
                'type'     => 'text',
                'title'    => esc_html__( 'Flickr', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your flickr profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'dribbble',
                'type'     => 'text',
                'title'    => esc_html__( 'Dribbble', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your dribbble profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'vimeo',
                'type'     => 'text',
                'title'    => esc_html__( 'Vimeo', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your vimeo profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'soundcloud',
                'type'     => 'text',
                'title'    => esc_html__( 'Soundcloud', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your soundcloud profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'vk',
                'type'     => 'text',
                'title'    => esc_html__( 'vk', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your vk profile link here.', 'template-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'behance',
                'type'     => 'text',
                'title'    => esc_html__( 'Behance', 'template-extensions' ),
                'subtitle' => esc_html__( 'Enter your behance profile link here.', 'template-extensions' ),
                'validate' => 'url',
            )
		)
    ) );
	// social links END
	
	
	// theme color options START
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Colors', 'template-extensions' ),
        'id'         => 'template-theme-colors',
        'desc'       => esc_html__( 'You can select your preferred theme color here.', 'template-extensions' ),
        'icon'  => 'el el-brush',
        'fields'     => array(
            array(
                'id'       => 'template-theme-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Theme Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom color.', 'template-extensions' ),
                'default'  => '#F26D75',
            ), 
            array(
                'id'       => 'template-nav-footer-link-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Nav and Footer Link Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom navigation and footer links color.', 'template-extensions' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'template-background-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Background Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom background color.', 'template-extensions' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'template-link-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Link Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom link color.', 'template-extensions' ),
                'default'  => '#43C6E4',
            ),
            array(
                'id'       => 'template-link-visited-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Visited Link Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom visited link color.', 'template-extensions' ),
                'default'  => '#9E52EA',
            ),
            array(
                'id'       => 'template-button-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Button Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom button color.', 'template-extensions' ),
                'default'  => '#313baa',
            ),
            array(
                'id'       => 'template-menu-drop-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Background Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred drop down background color.', 'template-extensions' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'template-menu-drop-hover-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Hover Background Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom button color.', 'template-extensions' ),
                'default'  => '#a0a0aa',
            ),
            array(
                'id'       => 'template-menu-drop-link-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Link Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred drop down link color.', 'template-extensions' ),
                'default'  => '#9E52EA',
            ),
            array(
                'id'       => 'template-menu-drop-link-hover-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Link Hover Color', 'template-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred drop down link hover color.', 'template-extensions' ),
                'default'  => '#9E52EA',
            )
        ),
    ) );
	
	
	// theme typography settings
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Typography', 'template-extensions' ),
        'id'     => 'typography',
        'desc'   => esc_html__( 'Typography options allows you to enable and choose custom google fonts for your website.', 'template-extensions' ),
        'icon'   => 'el el-font',
        'fields' => array(
            array(
                'id'       => 'template-custom-fonts',
                'type'     => 'switch',
                'title'    => esc_html__( 'Custom Google Fonts', 'template-extensions' ),
                'subtitle' => esc_html__( 'You can enable custom google fonts for your theme here.', 'template-extensions' ),
                'default'  => 0,
                'on'       => 'Custom Fonts',
                'off'      => 'Default Fonts',
            ),
			array(
                'id'			=> 'template-default-font',
                'type'			=> 'typography',
				'required' => array( 'template-custom-fonts', '=', '1' ),
                'title'			=> esc_html__( 'Body Font', 'template-extensions' ),
                'subtitle' 		=> esc_html__( 'This is default font for most of the page elements.', 'template-extensions' ),
                'output'      	=> array( 'body, blockquote cite' ),
                'units'       	=> 'px',
                'google'		=> true,
				'all_styles'	=> true,
				'font-size'     => false,
				'font-style'    => false,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'font-weight'	=> false
            ),
			array(
                'id'			=> 'template-alt-font',
                'type'			=> 'typography',
				'required' => array( 'template-custom-fonts', '=', '1' ),
                'title'			=> esc_html__( 'Alternate Font', 'template-extensions' ),
                'subtitle' 		=> esc_html__( 'This font will be used for italics, blockquote etc.', 'template-extensions' ),
				'desc'       => esc_html__( 'You can apply this font style to your markup using "alt-font" class and for italics us "em" class.', 'template-extensions' ),
                'output'      	=> array( '.alt-font, .em, em, blockquote > p' ),
                'units'       	=> 'px',
                'google'		=> true,
				'all_styles'	=> true,
				'font-size'     => false,
				'font-style'    => false,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'font-weight'	=> false
            ),
			array(
                'id'			=> 'template-heading-font',
                'type'			=> 'typography',
				'required' => array( 'template-custom-fonts', '=', '1' ),
                'title'			=> esc_html__( 'Headings Font', 'template-extensions' ),
                'subtitle' 		=> esc_html__( 'This font will apply on all headings from H1 to H6.', 'template-extensions' ),
				'desc'       => esc_html__( 'You can also apply heading font styles to any text element using .h1, .h2, .h3, .h4, .h5, .h6 heading classes.', 'template-extensions' ),
                'output'      	=> array( 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6' ),
                'units'       	=> 'px',
                'google'		=> true,
				'all_styles'	=> true,
				'font-size'     => false,
				'font-style'    => false,
				'line-height'   => false,
				'color'         => false,
				'text-align'    => false,
				'font-weight'	=> false
            )
        )
    ) );
	
	// custom css
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Custom CSS', 'template-extensions' ),
        'id'         => 'template-custom-css',
        'icon'  => 'el el-edit',
        'desc'       => esc_html__( 'This section allows you to enter your own custom CSS styles.', 'template-extensions' ),
        'fields'     => array(
            array(
                'id'       => 'template-css-editor',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'CSS Code', 'template-extensions' ),
                'subtitle' => esc_html__( 'Paste your CSS code here.', 'template-extensions' ),
                'mode'     => 'css',
                'theme'    => 'monokai',
            )
        )
    ) );

    /*
     * <--- END SECTIONS
     */
