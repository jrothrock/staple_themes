<?php
	global $stencil_options;
	$copyright = '';
	$copyright .= esc_html__( 'Copyright &copy; ', 'stencil' );
	if( !empty( $stencil_options['stencil-copyright'] ) ){
		$copyright_msg .= $stencil_options['stencil-copyright'];
	} else {
		$copyright .= get_bloginfo('name');
		$copyright .= ' ';
		$copyright .= date('Y');
		$copyright .= esc_html__( '. All rights reserved.', 'stencil' );
	}							
?>
<div class="copyright-footer"><?php echo esc_html( $copyright ); ?></div>