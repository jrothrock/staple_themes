<?php
    $social_links = "";
    global $stencil_options;

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

    if( !empty( $stencil_options['website'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['website']),'globe');
    }
    if( !empty( $stencil_options['website-2'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['website-2']),'globe');
    }

    if( !empty( $stencil_options['facebook'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['facebook']),'facebook');
    }

    if( !empty( $stencil_options['twitter'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['twitter']),'twitter');
    }

    if( !empty( $stencil_options['linkedin'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['linkedin']),'linkedin');
    }

    if( !empty( $stencil_options['google-plus'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['google-plus']),'google-plus');
    }

    if( !empty( $stencil_options['youtube'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['google-plus']),'google-plus');
    }

    if( !empty( $stencil_options['tumblr'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['tumblr']),'tumblr');
    }

    if( !empty( $stencil_options['instagram'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['instagram']),'instagram');
    }

    if( !empty( $stencil_options['reddit'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['reddit']),'reddit');
    }

    if( !empty( $stencil_options['flickr'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['flickr']),'flickr');
    }

    if( !empty( $stencil_options['dribble'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['dribble']),'dribble');
    }

    if( !empty( $stencil_options['vimeo'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['vimeo']),'vimeo');
    }

    if( !empty( $stencil_options['soundcloud'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['soundcloud']),'soundcloud');
    }

    if( !empty( $stencil_options['vk'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['vk']),'vk');
    }

    if( !empty( $stencil_options['behance'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['behance']),'behance');
    }

    if( !empty( $stencil_options['github'] ) ){
        $social_links .= getLinkTags(esc_url($stencil_options['github']),'github');
    }
     
    echo $social_links;

?>

