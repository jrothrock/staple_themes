<?php 
/**
 * The template for the search form.
 *
 * @link https://codex.wordpress.org/Styling_Theme_Forms
 *
 * @package Stencil
 */
 global $stencil_options;
?>
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'stencil'  ) ?></span>
        <input type="search" class="search-field"
            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder', 'stencil' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label', 'stencil'  ) ?>" />
    </label>
    <i class="search-submit waves-effect waves-light btn waves-input-wrapper" style="">
        <input id='search-submit-input' type="submit" class="waves-button-input" value="<?php echo esc_attr_x( 'Search', 'submit button', 'stencil'  ) ?>">
    </i>
    <input id='search-submit-input-hidden' style='display:none' type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'stencil'  ) ?>">
</form>