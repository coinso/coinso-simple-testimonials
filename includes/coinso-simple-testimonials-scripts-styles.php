<?php
/**
 * Created by PhpStorm.
 * User: ido
 * Date: 10/25/2018
 * Time: 08:16
 */

function cts_styles_scripts(){
    wp_enqueue_style('cts-fa-5', 'https://use.fontawesome.com/releases/v5.0.10/css/all.css', array(), microtime(), 'all');
    wp_enqueue_style('cts-slick', plugins_url(). '/coinso-simple-testimonials/assets/vendor/slick/slick.css', array(), microtime(), 'all');
    wp_enqueue_style('cts-slick-theme', plugins_url(). '/coinso-simple-testimonials/assets/vendor/slick/slick-theme.css', array(), microtime(), 'all');
    wp_enqueue_style('cts-style', plugins_url(). '/coinso-simple-testimonials/assets/css/cts-style.css', array(), microtime(), 'all');
    wp_enqueue_script('cts-slick', plugins_url(). '/coinso-simple-testimonials/assets/vendor/slick/slick.min.js', array('jquery'), microtime(), true);
    wp_enqueue_script('cts-script', plugins_url(). '/coinso-simple-testimonials/assets/js/cts-script.js', array('jquery'), microtime(), true);
}

add_action('wp_enqueue_scripts','cts_styles_scripts');