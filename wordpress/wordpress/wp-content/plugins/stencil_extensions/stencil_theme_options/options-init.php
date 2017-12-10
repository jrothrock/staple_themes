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
    $opt_name = "stencil_options";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'stencil_options',
        'display_name' => 'Stencil Theme Options',
        'display_version' => '1.0.0',
        'page_slug' => 'stencil_options',
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
        'class' => 'stencil-options',
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
            'title'   => esc_html__( 'Theme Information 1', 'stencil-extensions' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'stencil-extensions' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'stencil-extensions' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'stencil-extensions' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'stencil-extensions' );
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
        'title'      => esc_html__( 'General', 'stencil-extensions' ),
        'desc'       => esc_html__( 'General settings.', 'stencil-extensions' ),
        'id'         => 'page-header',
        'icon'   => 'el el-adjust-alt',
		'fields'     => array(
             array(
                'id'       => 'site-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Site Title', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your site title here.', 'stencil-extensions' ),
                'default' => get_bloginfo('name'),
                'desc' => "Unless this field is blank, this will be used instead of customizers."
             ),
            array(
                'id'       => 'site-description',
                'type'     => 'textarea',
                'title'    => esc_html__( 'Site Description', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your site description here.', 'stencil-extensions' ),
                'default' => get_bloginfo('description'),
                'desc' => "Unless this field is blank, this will be used instead of customizers."
            )
		)
     ));
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Logo', 'stencil-extensions' ),
        'desc'       => esc_html__( 'Upload logo here.', 'stencil-extensions' ),
        'id'         => 'page-logo',
        'subsection' => true,
        'icon'   => 'el el-bulb',
		'fields'     => array(
             array(
                'id'       => 'stencil-logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Header Logo', 'stencil-extensions' ),
				'desc'     => esc_html__( 'Recomended logo size is 440x120 pixels.', 'stencil-extensions' ),
                'compiler' => 'true',
                'subtitle' => esc_html__( 'Upload your logo in JPG, PNG or GIF format.', 'stencil-extensions' )
            )
		)
     ));
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Navigation Menu', 'stencil-extensions' ),
        'desc'       => esc_html__( 'Options to show/hide top navigation bar elements.', 'stencil-extensions' ),
        'id'         => 'page-top-nav',
        'subsection' => true,
        'icon'   => 'el el-bulb',
		'fields'     => array(
			array(
                'id'       => 'top-nav-menu',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show or Hide Top Nav Menu', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable entire top nav menu section from here.', 'stencil-extensions' ),
                'default'  => 1,
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            ),
            array(
                'id'       => 'fixed-nav-menu',
                'type'     => 'switch',
                'required' => array( 'top-nav-menu', '=', '1' ),
                'title'    => esc_html__( 'Fixed Nav Menu', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable a fixed nav menu here.', 'stencil-extensions' ),
                'default'  => '1',
                '1'       => 'FIXED',
                '0'      => 'NOT',
            ),
            array(
                'id'       => 'logo-nav-menu',
                'type'     => 'switch',
                'required' => array( 'nav-menu', '=', '1' ),
                'title'    => esc_html__( 'Show Text Logo Nav Menu', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable the text logo here.', 'stencil-extensions' ),
                'default'  => '1',
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            ),
            array(
				'id'       => 'layout-nav-menu',
				'type'     => 'select',
                'required' => array( 'top-nav-menu', '=', '1' ),
				'title'    => esc_html__( 'Home Page Layout', 'stencil-extensions' ),
				'subtitle' => esc_html__( 'Choose Your Prefered Nav Menu Layout.', 'stencil-extensions' ),
				'options'  => array(
					'1' => 'Logo Left - Menu Right',
					'2' => 'Logo Center - Menu Left',
                    '3' => 'Logo Center - Menu Right',
					'4' => 'Logo Right - Menu Left'
				),
				'default'  => '1',
			)
		)
     ));
     Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Miscellaneous', 'stencil-extensions' ),
        'desc'       => esc_html__( 'Miscellaenous options', 'stencil-extensions' ),
        'id'         => 'page-miscellaneous',
        'subsection' => true,
        'icon'   => 'el el-bulb',
		'fields'     => array(
			array(
                'id'       => 'to-top-button',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show or Hide Back To The Top Button ', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable the back to the button here .', 'stencil-extensions' ),
                'default'  => 1,
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            )
		)
     ));
	// header settings END
	


    // footer settings START
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Footer', 'stencil-extensions' ),
        'desc'       => esc_html__( 'General footer related settings can be changed from here.', 'stencil-extensions' ),
        'id'         => 'page-footer',
        'icon'   => 'el el-photo',
		'fields'     => array(
            array(
                'id'       => 'stencil-footer',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show or Hide Entire Footer', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable entire footer section from here.', 'stencil-extensions' ),
                'default'  => 1,
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            ),
            array(
                'id'       => 'footer-social',
                'type'     => 'switch',
                'required' => array( 'stencil-footer', '=', '1' ),
                'title'    => esc_html__( 'Footer Social Icons', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enable or disable social icons in footer section.', 'stencil-extensions' ),
                'default'  => 1,
                '1'       => 'ON',
                '0'      => 'OFF',
            ),
            array(
                'id'       => 'stencil-footer-top',
                'type'     => 'switch',
                'required' => array( 'stencil-footer', '=', '1' ),
                'title'    => esc_html__( 'Show or Hide The Top Part Of The Footer', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'You can enable or disable the top part of the footer from here.', 'stencil-extensions' ),
                'default'  => 1,
                '1'       => 'ON',
                '0'      => 'OFF',
            ),
			array(
                'id'       => 'stencil-copyright',
                'type'     => 'text',
				'required' => array( 'stencil-footer', '=', '1' ),
                'title'    => esc_html__( 'Copyright Text', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your custom copyright text here.', 'stencil-extensions' ),
                'desc'     => esc_html__( 'No need to include © character.', 'stencil-extensions' )
            )
		)
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Footer Left', 'stencil-extensions' ),
        'desc'       => esc_html__( 'Left footer section related settings can be changed from here.', 'stencil-extensions' ),
        'id'         => 'page-footer-left',
        'subsection' => true,
        'icon'   => 'el el-photo',
		'fields'     => array(
            array(
				'id'       => 'footer-left-layout',
				'type'     => 'select',
				'title'    => esc_html__( 'Footer Left Layout', 'stencil-extensions' ),
				'subtitle' => esc_html__( 'Choose your prefered sidebar layout.', 'stencil-extensions' ),
				'options'  => array(
					'text' => 'Text',
					'menu' => 'Menu',
				),
				'default'  => 'text',
			),
            array(
                'id'       => 'footer-left-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Footer Description Title', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter the title for the footer description.', 'stencil-extensions' ),
                'default' => "About",
                'desc' => esc_html__( 'If left empty, no title will appear.', 'stencil-extensions' ),
            ),
			array(
                'id'       => 'footer-left-text',
                'type'     => 'textarea',
				'required' => array(array( 'stencil-footer-top', '=', '1' ),array( 'footer-left-layout', '=', 'text' ) ),
                'title'    => esc_html__( 'Footer Left Text', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter text For The Left For Section.', 'stencil-extensions' ),
                'default' => "Lorem Ipsum"
            )
		)
    ) );

      	// footer settings START
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Footer Right', 'stencil-extensions' ),
        'desc'       => esc_html__( 'Right footer section related settings can be changed from here.', 'stencil-extensions' ),
        'id'         => 'page-footer-right',
        'subsection' => true,
        'icon'   => 'el el-photo',
		'fields'     => array(
            array(
				'id'       => 'footer-right-layout',
				'type'     => 'select',
				'title'    => esc_html__( 'Footer Right Layout', 'stencil-extensions' ),
				'subtitle' => esc_html__( 'Choose your prefered sidebar layout.', 'stencil-extensions' ),
				'options'  => array(
					'text' => 'Text',
					'menu' => 'Menu'
				),
				'default'  => 'menu',
			),
            array(
                'id'       => 'footer-right-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Footer Right Title', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter the title for the footer right section.', 'stencil-extensions' ),
                'default' => "Links",
                'desc' => esc_html__( 'If left empty, no title will appear.', 'stencil-extensions' ),
            ),
			array(
                'id'       => 'footer-text-right',
                'type'     => 'textarea',
				'required' => array(array( 'stencil-footer-top', '=', '1' ),array( 'footer-right-layout', '=', 'text' ) ),
                'title'    => esc_html__( 'Footer Description Text', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter text explaing your blog and/or about yourself.', 'stencil-extensions' ),
                'default' => "Lorem Ipsum."
            ),
		)
    ) );

	// footer settings END

    	// sidebar settings START
		Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Sidebar', 'stencil-extensions' ),
        'desc'       => esc_html__( 'All sidebar related settings.', 'stencil-extensions' ),
        'id'         => 'home-page',
        'icon'   => 'el el-website',
		'fields'     => array(
             array(
				'id'       => 'sidebar-layout',
				'type'     => 'select',
				'title'    => esc_html__( 'Sidebar Layout', 'stencil-extensions' ),
				'subtitle' => esc_html__( 'Choose your prefered sidebar layout.', 'stencil-extensions' ),
				'options'  => array(
					'sidebar_left' => 'Sidebar Left',
					'sidebar_right' => 'Sidebar Right',
					'no_sidebar' => 'No Sidebar'
				),
				'default'  => 'sidebar_right',
			),
            array(
                'id'       => 'sidebar-pages',
                'type'     => 'switch',
                'required' => array( 'sidebar-layout', '!=', 'no_sidebar' ),
                'title'    => esc_html__( 'Show or Hide Sidebar For Pages', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'This includes the home page, and blog as well.', 'stencil-extensions' ),
                'default'  => '0',
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            ),
            array(
                'id'       => 'sidebar-shop',
                'type'     => 'switch',
                'required' => array( 'sidebar-layout', '!=', 'no_sidebar' ),
                'title'    => esc_html__( 'Show or Hide Sidebar For Woocomerce Shop', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enable or Disable the sidebar for the Woocomerce Shop page here.', 'stencil-extensions' ),
                'default'  => '1',
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            ),
            array(
                'id'       => 'sidebar-posts',
                'type'     => 'switch',
                'required' => array( 'sidebar-layout', '!=', 'no_sidebar' ),
                'title'    => esc_html__( 'Show or Hide Sidebar For Posts', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'This includes both posts and Woocomerce products.', 'stencil-extensions' ),
                'default'  => '1',
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            ),
            array(
                'id'       => 'sidebar-archive',
                'type'     => 'switch',
                'required' => array( 'sidebar-layout', '!=', 'no_sidebar' ),
                'title'    => esc_html__( 'Show or Hide Sidebar For Archive page', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enable or Disable the sidebar for the Archive page here.', 'stencil-extensions' ),
                'default'  => '1',
                '1'       => 'SHOW',
                '0'      => 'HIDE',
            ),
		)
     ));

    // sidebar settings end
	
	// social links START
	 Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Social Links', 'stencil-extensions' ),
        'desc'       => esc_html__( 'All social network links should be added from here.', 'stencil-extensions' ),
        'id'         => 'social',
        'icon'   => 'dashicons dashicons-share',
		'fields'     => array(
            array(
                'id'       => 'website',
                'type'     => 'text',
                'title'    => esc_html__( 'Website', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your website link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
            array(
                'id'       => 'website_2',
                'type'     => 'text',
                'title'    => esc_html__( 'Website - 2', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your website link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'facebook',
                'type'     => 'text',
                'title'    => esc_html__( 'Facebook', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your facebook profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'twitter',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your twitter profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
            array(
                'id'       => 'yelp',
                'type'     => 'text',
                'title'    => esc_html__( 'Yelp', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your yelp profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'linkedin',
                'type'     => 'text',
                'title'    => esc_html__( 'Linkedin', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your linkedin profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'pinterest',
                'type'     => 'text',
                'title'    => esc_html__( 'Pinterest', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your pinterest profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'google-plus',
                'type'     => 'text',
                'title'    => esc_html__( 'Google Plus', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your google+ profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'youtube',
                'type'     => 'text',
                'title'    => esc_html__( 'Youtube', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your youtube profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'tumblr',
                'type'     => 'text',
                'title'    => esc_html__( 'Tumblr', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your tumblr profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'instagram',
                'type'     => 'text',
                'title'    => esc_html__( 'Instagram', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your instagram profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'reddit',
                'type'     => 'text',
                'title'    => esc_html__( 'Reddit', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your reddit profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'flickr',
                'type'     => 'text',
                'title'    => esc_html__( 'Flickr', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your flickr profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'dribbble',
                'type'     => 'text',
                'title'    => esc_html__( 'Dribbble', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your dribbble profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'vimeo',
                'type'     => 'text',
                'title'    => esc_html__( 'Vimeo', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your vimeo profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'soundcloud',
                'type'     => 'text',
                'title'    => esc_html__( 'Soundcloud', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your soundcloud profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'vk',
                'type'     => 'text',
                'title'    => esc_html__( 'vk', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your vk profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            ),
			array(
                'id'       => 'behance',
                'type'     => 'text',
                'title'    => esc_html__( 'Behance', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Enter your behance profile link here.', 'stencil-extensions' ),
                'validate' => 'url',
            )
		)
    ) );
	// social links END
	
	
	// theme color options START
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Colors', 'stencil-extensions' ),
        'id'         => 'stencil-theme-colors',
        'desc'       => esc_html__( 'You can select your preferred theme color here.', 'stencil-extensions' ),
        'icon'  => 'el el-brush',
        'fields'     => array(
            array(
                'id'       => 'stencil-theme-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Theme Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom color.', 'stencil-extensions' ),
                'default'  => '#F26D75',
            ), 
            array(
                'id'       => 'stencil-nav-footer-link-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Nav and Footer Link Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom navigation and footer links color.', 'stencil-extensions' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'stencil-background-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Background Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom background color.', 'stencil-extensions' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'stencil-link-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Link Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom link color.', 'stencil-extensions' ),
                'default'  => '#43C6E4',
            ),
            array(
                'id'       => 'stencil-link-visited-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Visited Link Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom visited link color.', 'stencil-extensions' ),
                'default'  => '#9E52EA',
            ),
            array(
                'id'       => 'stencil-button-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Button Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom button color.', 'stencil-extensions' ),
                'default'  => '#313baa',
            ),
            array(
                'id'       => 'stencil-menu-drop-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Background Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred drop down background color.', 'stencil-extensions' ),
                'default'  => '#FFFFFF',
            ),
            array(
                'id'       => 'stencil-menu-drop-hover-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Hover Background Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred custom button color.', 'stencil-extensions' ),
                'default'  => '#ebebeb',
            ),
            array(
                'id'       => 'stencil-menu-drop-link-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Link Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred drop down link color.', 'stencil-extensions' ),
                'default'  => '#9E52EA',
            ),
            array(
                'id'       => 'stencil-menu-drop-link-hover-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Drop Down Link Hover Color', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Choose your preferred drop down link hover color.', 'stencil-extensions' ),
                'default'  => '#9E52EA',
            )
        ),
    ) );
	
	
	// theme typography settings
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Typography', 'stencil-extensions' ),
        'id'     => 'typography',
        'desc'   => esc_html__( 'Typography options allows you to enable and choose custom google fonts for your website.', 'stencil-extensions' ),
        'icon'   => 'el el-font',
        'fields' => array(
            array(
                'id'       => 'stencil-custom-fonts',
                'type'     => 'switch',
                'title'    => esc_html__( 'Custom Google Fonts', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'You can enable custom google fonts for your theme here.', 'stencil-extensions' ),
                'default'  => 0,
                'on'       => 'Custom Fonts',
                'off'      => 'Default Fonts',
            ),
			array(
                'id'			=> 'stencil-default-font',
                'type'			=> 'typography',
				'required' => array( 'stencil-custom-fonts', '=', '1' ),
                'title'			=> esc_html__( 'Body Font', 'stencil-extensions' ),
                'subtitle' 		=> esc_html__( 'This is default font for most of the page elements.', 'stencil-extensions' ),
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
                'id'			=> 'stencil-alt-font',
                'type'			=> 'typography',
				'required' => array( 'stencil-custom-fonts', '=', '1' ),
                'title'			=> esc_html__( 'Alternate Font', 'stencil-extensions' ),
                'subtitle' 		=> esc_html__( 'This font will be used for italics, blockquote etc.', 'stencil-extensions' ),
				'desc'       => esc_html__( 'You can apply this font style to your markup using "alt-font" class and for italics us "em" class.', 'stencil-extensions' ),
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
                'id'			=> 'stencil-heading-font',
                'type'			=> 'typography',
				'required' => array( 'stencil-custom-fonts', '=', '1' ),
                'title'			=> esc_html__( 'Headings Font', 'stencil-extensions' ),
                'subtitle' 		=> esc_html__( 'This font will apply on all headings from H1 to H6.', 'stencil-extensions' ),
				'desc'       => esc_html__( 'You can also apply heading font styles to any text element using .h1, .h2, .h3, .h4, .h5, .h6 heading classes.', 'stencil-extensions' ),
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
        'title'      => esc_html__( 'Analytics', 'stencil-extensions' ),
        'id'         => 'stencil-analytics',
        'icon'  => 'el el-graph',
        'desc'       => 'This section allows you to enter your Google Analytics Script. <br> To register your site, follow this video until the 5:00 mark, then paste the UA identifier in the field below: <br> <a href="https://www.youtube.com/watch?v=mXcQ7rVn3ro" target="_blank">https://www.youtube.com/watch?v=mXcQ7rVn3ro</a>',
        'fields'     => array(
            array(
                'id'       => 'site-analytics',
                'type'     => 'text',
                'title'    => esc_html__( 'Site Analytics', 'stencil-extensions' ),
                'subtitle' => esc_html__( "Enter your site's Google Analytics UA-XXXXX-X identifier here.", 'stencil-extensions' ),
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Custom CSS', 'stencil-extensions' ),
        'id'         => 'stencil-custom-css',
        'icon'  => 'el el-edit',
        'desc'       => esc_html__( 'This section allows you to enter your own custom CSS styles.', 'stencil-extensions' ),
        'fields'     => array(
            array(
                'id'       => 'stencil-css-editor',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'CSS Code', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Paste your CSS code here.', 'stencil-extensions' ),
                'mode'     => 'css',
                'theme'    => 'monokai',
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Custom JavaScript', 'stencil-extensions' ),
        'id'         => 'stencil-custom-javascript',
        'icon'  => 'el el-file-edit',
        'desc'       => esc_html__( 'This section allows you to enter your own custom JavaScript functions.', 'stencil-extensions' ),
        'fields'     => array(
            array(
                'id'       => 'stencil-javascript-editor',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'JavaScript Code', 'stencil-extensions' ),
                'subtitle' => esc_html__( 'Paste your JavaScript code here.', 'stencil-extensions' ),
                'mode'     => 'javascript',
                'theme'    => 'monokai',
                'default'  => "jQuery(document).ready(function(){\n\n});"
            )
        )
    ) );

    /*
     * <--- END SECTIONS
     */
