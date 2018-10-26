<?php
/*
 * Plugin Name: Coinso Testimonials
 * Plugin URI: https://github.com/coinso/coinso-simple-testimonials
 * Description: A Simple Testimonials Slider
 * Author: Ido @ Coindo
 * Author URI: http://coinso.com/project/ido-barnea
 * Version: 1.5
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cts
 * Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/coinso/coinso-simple-testimonials/',
	__FILE__,
	'coinso-simple-testimonials'
);
$myUpdateChecker->setBranch('stable');

function cts_load_textdomain() {
	load_plugin_textdomain( 'cts', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'cts_load_textdomain' );
//register post type, taxonomies & metaboxes

require_once (plugin_dir_path(__FILE__) . '/includes/coinso-simple-testimonials-cpt-and-metabox.php');

//register shortcode

add_action('init', 'cts_register_shortcode');
function cts_register_shortcode(){

    add_shortcode('testimonials', 'cts_content');
}

function cts_content( $shortcode_args, $content = null ){
    global $testimonials_atts;
    $testimonials_atts = shortcode_atts( array(
        'testimonials_title'     =>     '',
        'testimonials_count'     =>     '',

    ), $shortcode_args);
    ob_start();
    require_once ( plugin_dir_path(__FILE__) . '/includes/coinso-simple-testimonials-content.php' );
    return ob_get_clean();
}

//Load Scripts and styles
require_once ( plugin_dir_path(__FILE__) . '/includes/coinso-simple-testimonials-scripts-styles.php');

// Settings

$cts_options = get_option('cts_settings');

function cts_register_settings(){

    register_setting('cts_settings_group', 'cts_settings');

}
if ( is_admin() ){

    add_action('admin_init', 'cts_register_settings');
}
//Load Settings only if on the admin side
if ( is_admin()){
    require_once ( plugin_dir_path(__FILE__) . '/includes/coinso-simple-testimonials-settings.php' );

}

function cts_add_settings_link( $links ) {
    $settings_link = '<a href="'.admin_url('edit.php?post_type=testimonials').'&page=cts-options">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'cts_add_settings_link' );