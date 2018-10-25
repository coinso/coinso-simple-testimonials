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

// Create the Menu link

function cts_options_menu_link(){
    add_menu_page( 'Client Testimonials', 'Client Testimonials', 'manage_options', 'cts-options', 'cts_options_content', 'dashicons-thumbs-up');
}
if ( is_admin() ){

    add_action('admin_menu','cts_options_menu_link');
}

function cts_options_content(){

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
// init global variable for options

    global $cts_options;

    ob_start();?>

<div class="wrap">
    <h2><?php _e('Client Testimonials Slider', 'cts') ;?></h2>
    <p>
        <?php _e('Settings For the Client Testimonials Slider Plugin', 'cts') ;?>
    </p>
    <form action="options.php" method="post">

        <?php settings_fields('cts_settings_group') ;?>
    </form>
</div>
<?php echo ob_get_clean();

}