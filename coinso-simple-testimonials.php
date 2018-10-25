<?php
/*
Plugin Name: Coinso Testimonials
Plugin URI: https://github.com/coinso
Description: A short description of your plugin
Author: Ido @ Coindo
Author URI: http://coinso.com/project/ido-barnea
Version: 1.0
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: https://github.com/barbareshet/plugin-path
*/

if (!defined('ABSPATH')) {
    exit;
}

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
require_once (plugin_dir_path(__FILE__) . '/includes/coinso-simple-testimonials-scripts-styles.php');

//Content
