<?php
	global $template_options;
	$copyright = '';
	$copyright .= esc_html__( 'Copyright &copy; ', 'trendy-pro' );
	if( !empty( $template_options['template-copyright'] ) ){
		$copyright_msg .= $template_options['template-copyright'];
	} else {
		$copyright .= get_bloginfo('name');
		$copyright .= ' ';
		$copyright .= date('Y');
		$copyright .= esc_html__( '. All rights reserved.', 'trendy-pro' );
	}							
?>
<div class="copyright-footer"><?php echo esc_html( $copyright ); ?></div>