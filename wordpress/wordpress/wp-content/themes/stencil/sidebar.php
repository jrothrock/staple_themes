<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Stencil
 */

global $stencil_options;

$home_layout = $stencil_options['homepage-layout'];
$class = '';
if($home_layout == 'sidebar_left'){
	$class = 'left';
} elseif($home_layout == 'no_sidebar'){
	$class = 'none';
}

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area <?php echo $class ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
