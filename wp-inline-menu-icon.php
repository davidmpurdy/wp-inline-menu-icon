<?php
/**
 * Plugin Name: Inline Menu Icon
 * Description: Add icons to menu items
 * Version: 0.1
 * Requires at least: 5.2
 * Requires PHP: 5.6
 * Author: David Purdy
 * Author URI: https://clang.co
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: wp-inline-menu-icon
 *
 * @package Inline Menu Icon
 */

 
// save ACF fields for this plugin to the folder inside this plugin
require_once ('inc/acf-json-location.php');
new ACF_JSON_Location( plugin_dir_path(__FILE__).'/acf-json/', array("key" => "group_61d12882aa124") );


add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
/**
 * Display the icon in the menu title
 */
function my_wp_nav_menu_objects( $items, $args ) {
	
	// loop
	foreach( $items as &$item ) {
		
		// vars
		$icon = get_field('icon', $item);
		
		
		// append icon
		if( $icon && $icon['url'] ) {
			
            // set icon height
            $wrapper_height = '1.5em';
            $icon_height = get_field('icon_height', $item);
            $icon_height_units = get_field('icon_height_units', $item);
            if ($icon_height && $icon_height_units && in_array( $icon_height_units, array('px', 'em', 'rem')) ) {
                $wrapper_height = $icon_height . $icon_height_units;
            }

            // set icon position
            $icon_position_class = '';
            $icon_position = get_field( 'icon_position', $item );
            if ($icon_position && in_array( $icon_position, array( 'left', 'replace', 'right')) ) {
                $icon_position_class = 'icon-' . $icon_position;
            }


            $icon_source = '<span class="inline-menu-icon ' . $icon_position_class . '" style="height:' . $wrapper_height . '">' . file_get_contents($icon['url']) . '</span>';

            if ( $icon_position == 'left' ) {
			    $item->title = $icon_source . $item->title;
            }
            elseif ( $icon_position == 'replace' ) {
                $item->title = $icon_source;
            }
            elseif ( $icon_position = 'right' ) {
                $item->title = $item->title . $icon_source;
            }
			
		}
		
	}
	
	
	// return
	return $items;
	
}

add_action( 'wp_head', 'wp_inline_menu_icon_head_css');
/**
 * Add a little CSS to head to control icon position
 */
function wp_inline_menu_icon_head_css () {
    ?>

<style>
    .inline-menu-icon {
        display: inline-block;
    }

    .inline-menu-icon svg {
        vertical-align: middle;
        height: 100%;
        margin-bottom:2pt;
    }

    .inline-menu-icon.icon-right svg {
        margin-left: 25%;
    }
    .inline-menu-icon.icon-left svg {
        margin-left: -25%;
    }
</script>

    <?php 
}