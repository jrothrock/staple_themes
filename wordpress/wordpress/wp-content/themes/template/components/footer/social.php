<?php
    $social_links = "";
    global $template_options;

    function getLinkTags($url,$icon){
        $message = "
            <a href='" . $url . "'>
                <li>
                    <i class='fa fa-" . $icon . "'></i>
                </li>
            </a>
        ";
        echo $message;
    }

    if( !empty( $template_options['website'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['website']),'globe');
    }
    if( !empty( $template_options['website-2'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['website-2']),'globe');
    }

    if( !empty( $template_options['facebook'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['facebook']),'facebook');
    }

    if( !empty( $template_options['twitter'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['twitter']),'twitter');
    }

    if( !empty( $template_options['linkedin'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['linkedin']),'linkedin');
    }

    if( !empty( $template_options['google-plus'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['google-plus']),'google-plus');
    }

    if( !empty( $template_options['youtube'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['google-plus']),'google-plus');
    }

    if( !empty( $template_options['tumblr'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['tumblr']),'tumblr');
    }

    if( !empty( $template_options['instagram'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['instagram']),'instagram');
    }

    if( !empty( $template_options['reddit'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['reddit']),'reddit');
    }

    if( !empty( $template_options['flickr'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['flickr']),'flickr');
    }

    if( !empty( $template_options['dribble'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['dribble']),'dribble');
    }

    if( !empty( $template_options['vimeo'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['vimeo']),'vimeo');
    }

    if( !empty( $template_options['soundcloud'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['soundcloud']),'soundcloud');
    }

    if( !empty( $template_options['vk'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['vk']),'vk');
    }

    if( !empty( $template_options['behance'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['behance']),'behance');
    }

    if( !empty( $template_options['github'] ) ){
        $social_links .= getLinkTags(esc_url($template_options['github']),'github');
    }
     
    echo $social_links;

?>

