<?php

/**
 * License: GPLv3.0+
*/

if( ! class_exists( 'Materialize_Walker_Desktop_Nav_Menu' ) ) :

    class Materialize_Walker_Desktop_Nav_Menu extends Walker_Nav_Menu {

        private $curItem;

        /**
         * Starts the list before the elements are added.
         *
         * Adds classes to the unordered list sub-menus.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         */
        function start_lvl( &$output, $depth = 0, $args = array() ) {

            // Depth-dependent classes.
            $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
            $display_depth = ( $depth + 1); // because it counts the first submenu as 0
            $classes = array(
                'sub-menu',
                ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
                ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
                'menu-depth-' . $display_depth
            );
            $class_names = implode( ' ', $classes );

            // Build HTML for output.
            $output .= "\n" . $indent . '<ul id="' . $this->curItem->post_name . '-nav-menu" class="' . $class_names . ' dropdown-content">' . "\n";
        }

        /**
         * Start the element output.
         *
         * Adds main/sub-classes to the list items and links.
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item   Menu item data object.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   An array of arguments. @see wp_nav_menu()
         * @param int    $id     Current item ID.
         */
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            global $wp_query;
            global $stencil_options;
            $this->curItem = $item;
            $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

            // Depth-dependent classes.
            $depth_classes = array(
                ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
                ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
                ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
                'menu-item-depth-' . $depth
            );

            $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

            // Passed classes.
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

            // Build HTML.
            $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

            // Link attributes.
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

            if( in_array( 'menu-item-has-children', $item->classes ) ) 
                $attributes .= ' data-activates="' . $item->post_name . '-nav-menu"';

            $menu_right = (int)$stencil_options['layout-nav-menu'] % 2 === 1 ? true : false;

			$left_icon = ( $args->walker->has_children && 1 <= $depth && $menu_right ) ? ' <span class="fa fa-angle-left"></span> ' : '';
			$right_icon = ( $args->walker->has_children && 0 === $depth ) ? ' <span class="fa fa-angle-down"></span></a>' : '</a>';
            $right_icon = ( $args->walker->has_children && 1 <= $depth && !$menu_right ) ? ' <span class="fa fa-angle-right"></span></a>' : $right_icon;
            // Build HTML output and pass through the proper filter.
            $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s%6$s%7$s%8$s',
                $args->before,
                $attributes,
                $args->link_before,
				$left_icon,
                apply_filters( 'the_title', $item->title, $item->ID ),
                $args->link_after,
				$right_icon,
                $args->after
            );
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

endif;

?>