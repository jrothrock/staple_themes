<?php
    global $stencil_options;
    $stencil_javascript = "";
    if($stencil_options['stencil-javascript-editor'] && (str_replace(array("\n", "\t", "\r"), "", $stencil_options['stencil-javascript-editor']) != "jQuery(document).ready(function(){});")){
        $stencil_javascript .= $stencil_options['stencil-javascript-editor'];
    }

    if($stencil_options['site-analytics']){
        
        $stencil_javascript.="(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '" . $stencil_options["site-analytics"] . "', 'auto');
        ga('send', 'pageview');";

    }
    if($stencil_options['preloader']){
        $stencil_javascript .= "
                                var start_time = new Date().getTime()
                                jQuery(window).ready(function(){
                                    var load_time = new Date().getTime()
                                    var difference_time = 1000 - (load_time - start_time)
                                    setTimeout(function(){
                                        jQuery('body').removeClass('preloader-body');
                                        jQuery('.preloader-container').remove();
                                    },difference_time)
                                })
                                ";
    }
    if($stencil_javascript){
        wp_add_inline_script( 'main-js' , $stencil_javascript, 'after' );
    }
?>