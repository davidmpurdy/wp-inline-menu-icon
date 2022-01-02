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