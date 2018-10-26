<?php
/**
 * Created by PhpStorm.
 * User: ido
 * Date: 10/25/2018
 * Time: 08:16
 */
if (!defined('ABSPATH')) {
    exit;
}
function cts_styles_scripts(){
    wp_enqueue_style('cts-fa-5', 'https://use.fontawesome.com/releases/v5.0.10/css/all.css', array(), microtime(), 'all');
    wp_enqueue_style('cts-slick', plugins_url( '/assets/vendor/slick/slick.css', plugin_basename( __DIR__)), array(), microtime(), 'all');
    wp_enqueue_style('cts-slick-theme', plugins_url('/assets/vendor/slick/slick-theme.css', plugin_basename( __DIR__) ), array(), microtime(), 'all');
    wp_enqueue_style('cts-style', plugins_url( 'assets/css/cts-style.css', plugin_basename( __DIR__)), array(), microtime(), 'all');
    wp_enqueue_script('cts-slick', plugins_url('/assets/vendor/slick/slick.min.js', plugin_basename( __DIR__)), array('jquery'), microtime(), true);
    wp_enqueue_script('cts-script', plugins_url( '/assets/js/cts-script.js', plugin_basename( __DIR__)), array('jquery'), microtime(), true);
}

add_action('wp_enqueue_scripts','cts_styles_scripts');

function cts_admin_styles_scripts(){

	if ( is_admin() ){
		wp_enqueue_style('cts-fa-5-admin', 'https://use.fontawesome.com/releases/v5.0.10/css/all.css', array(), microtime(), 'all');
		// Add the color picker css file
		wp_enqueue_style( 'wp-color-picker' );

		// Include our custom jQuery file with WordPress Color Picker dependency
		wp_enqueue_script( 'cts-admin-script', plugins_url( '/assets/js/cts-admin-script.js', plugin_basename( __DIR__)), array( 'jquery', 'wp-color-picker' ), false, true );
	}
}

add_action( 'admin_enqueue_scripts', 'cts_admin_styles_scripts' );