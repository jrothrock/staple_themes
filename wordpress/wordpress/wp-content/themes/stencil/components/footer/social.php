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


    $socials = array('website', 'website-2', 'facebook', 'twitter', 'yelp', 'linkedin', 'google-plus', 'youtube', 'tumblr', 'instagram', 'reddit', 'flickr', 'dribble', 'vimeo', 'soundcloud', 'vk', 'behance', 'github');

    foreach($socials as $social){
        if(!empty( $stencil_options[$social])){
            if($social === 'website' || $social === 'website-2'){
                $social_links .= getLinkTags(esc_url($stencil_options[$social]), 'globe');
            } else {
                $social_links .= getLinkTags(esc_url($stencil_options[$social]), $social);
            }

        }
    }
     
    echo $social_links;


?>