<?php
    global $stencil_options;
    $stencil_javascript = "";
    if($stencil_options['stencil-javascript-editor'] && (str_replace(array("\n", "\t", "\r"), "", $stencil_options['stencil-javascript-editor']) != "jQuery(document).ready(function(){});")){
        $stencil_javascript .= $stencil_options['stencil-javascript-editor'];
    }
    if($stencil_options['site-analytics']){
        if (strpos($stencil_options['site-analytics'], 'UA-') !== false) {
            $analytics_string = $stencil_options['site-analytics'];
        } else {
            if($stencil_options['site-analytics'][0] != "-"){
                $analytics_string = "UA-" . $stencil_options['site-analytics'];
            } else {
                $analytics_string = "UA" . $stencil_options['site-analytics'];
            }
        }
        $stencil_javascript.="(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '" . $analytics_string . "', 'auto');
        ga('send', 'pageview');";

    }
    if($stencil_javascript){
        wp_add_inline_script( 'main-js' , $stencil_javascript, 'after' );
    }
?>