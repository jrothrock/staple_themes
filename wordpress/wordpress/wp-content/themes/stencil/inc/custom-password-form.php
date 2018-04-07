<?php
function my_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post', 'stencil' ) ) . '" method="post">
    ' . __( "To view this protected post, enter the password below:", 'stencil') . '
    <label for="' . $label . '">' . __( "Password:", 'stencil' ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /><i class="btn waves-effect waves-light waves-input-wrapper" style="color:white"><input type="submit" name="Submit" class="waves-button-input" value="' . esc_attr__( "Submit", 'stencil' ) . '" style="color:white"></i>
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'my_password_form' );
?>
