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
        <table class="form-table">
            <tbody>
                <th>
                    <?php _e('Client Testimonials Setting', 'cts');?>
                </th>
                <tr>
                    <th>
                        <label for="cts_settings[cts_section_title]">
                            <?php _e('Testimonials Section Title', 'cts');?>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="cts_settings[cts_section_title]" value="<?php echo $cts_options['cts_section_title'] ;?>" id="cts_settings[cts_section_title]" class="regular-text" placeholder="Testimonials"/>
                        <p class="description">
                            <?php _e('Add Section Title', 'cts');?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'cts') ;?>">
        </p>
    </form>
</div>
<?php echo ob_get_clean();

}