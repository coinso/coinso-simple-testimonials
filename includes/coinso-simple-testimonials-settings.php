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
if (! class_exists('CTS_Setting')){
    class CTS_Setting{

        private static $instance = null;

        public $cts_options;


        public static function get_instance(){

            if ( null == self::$instance ){
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function __construct() {
            if ( is_admin() ){

	            add_action( 'admin_menu', array( &$this, 'cts_options_menu_link') );
            }
        }


	    function cts_options_menu_link(){

		    add_submenu_page(
			    'edit.php?post_type=testimonials',
			    'Client Testimonials Options',
			    'Testimonials Options',
			    'manage_options',
			    'cts-options',
			    array( $this, 'cts_options_content')
		    );
	    }

	    function cts_options_content(){

		    if ( !current_user_can( 'manage_options' ) )  {
			    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		    }
// init global variable for options

		    global $cts_options;
            $select_options = array('true', 'false');
            $title_attr_options = array('h1', 'h2', 'h3', 'h4');
            $align = array('right', 'center', 'left');
            $play_icons = array('fas fa-play', 'fas fa-play-circle', 'far fa-play-circle', 'fab fa-youtube');
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
                                <input type="text" name="cts_settings[cts_section_title]" value="<?php echo $cts_options['cts_section_title'] ;?>" id="cts_settings[cts_section_title]" class="regular-text half-width" placeholder="Testimonials"/>
                                <p class="description">
								    <?php _e('Add Section Title', 'cts');?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_section_title_attr]">
                                    <?php _e('Testimonials Section Title Attribute', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <select name="cts_settings[cts_section_title_attr]" id="cts_settings[cts_section_title_attr]" class="wide">
                                    <?php foreach ( $title_attr_options as $option ) {
                                        $selected = ( $cts_options['cts_section_title_attr'] == $option ) ? 'selected="selected"' : '';
                                        echo '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_section_subtitle]">
                                    <?php _e('Testimonials Section Sub Title', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <textarea name="cts_settings[cts_section_subtitle]" value="<?php if (!empty($cts_options['cts_section_subtitle'])) echo $cts_options['cts_section_subtitle'];?>" id="cts_settings[cts_section_subtitle]" class="regular-text half-width" placeholder="Testimonials Subtitle" cols="30" rows="10"></textarea>

                                <p class="description">
                                    <?php _e('Add Section Sub Title', 'cts');?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_head_align]">
                                    <?php _e('Testimonials Align', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <select name="cts_settings[cts_head_align]" id="cts_settings[cts_head_align]" class="wide">
                                    <?php foreach ( $align as $option ) {
                                        $selected = ( $cts_options['cts_head_align'] == $option ) ? 'selected="selected"' : '';
                                        echo '<option value="'.$option.'" '.$selected.'>'.ucfirst( $option ).'</option>';
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_main_color]">
                                    <?php _e('Set Plugin Main Color', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <input type="text" name="cts_settings[cts_main_color]" value="<?php echo $cts_options['cts_main_color'] ;?>" id="cts_settings[cts_main_color]" class="cts-color-picker"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_secondary_color]">
                                    <?php _e('Set Plugin Secondary Color', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <input type="text" name="cts_settings[cts_secondary_color]" value="<?php echo $cts_options['cts_secondary_color'] ;?>" id="cts_settings[cts_secondary_color]" class="cts-color-picker"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_posts_count]">
			                        <?php _e('How Many Slides to Show?', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <input type="number" name="cts_settings[cts_posts_count]" value="<?php echo $cts_options['cts_posts_count'] ? $cts_options['cts_posts_count'] : 3 ;?>" id="cts_settings[cts_posts_count]" class="regular-text"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_autoplay]">
			                        <?php _e('Auto Play', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <select name="cts_settings[cts_autoplay]" id="cts_settings[cts_autoplay]" class="wide">
                                    <?php foreach ( $select_options as $option ) {
                                        $selected = ( $cts_options['cts_autoplay'] == $option ) ? 'selected="selected"' : '';
                                        echo '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
                                    }

                                    ?>
                                </select>
                                <!-- /# -->
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_autoplay_speed]">
			                        <?php _e('Auto Play Speed', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <input type="number" name="cts_settings[cts_autoplay_speed]" value="<?php echo $cts_options['cts_autoplay_speed'] ? $cts_options['cts_autoplay_speed'] : 2000 ;?>" id="cts_settings[cts_autoplay_speed]" class="regular-text"/>
                                <p class="description">
                                    <?php _e('Select Time in Milliseconds, for example 1000 = 1 Second.<br> Auto play must be set to True', 'cts');?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_infinite]">
			                        <?php _e('Infinite', 'cts');?>
                                </label>
                            </th>
                            <td>
                                <select name="cts_settings[cts_infinite]" id="cts_settings[cts_infinite]" class="wide">
		                            <?php foreach ( $select_options as $option ) {
			                            $selected = ( $cts_options['cts_infinite'] == $option ) ? 'selected="selected"' : '';
			                            echo '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
		                            }

		                            ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="cts_settings[cts_play_icon]">
			                        <?php _e('Select Play Icon', 'cts');?>
                                </label>
                            </th>
                            <td>
	                            <?php foreach ($play_icons as $icon) {
		                            $checked = ( $cts_options['cts_play_icon'] == $icon )? ' checked="checked" ' : '';
		                            echo '<input type="radio"'.$checked.'value="'.$icon.'" name="cts_settings[cts_play_icon]"/> <i class="'.$icon.' fa-2x"></i><br>' ;
	                            }?>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'cts') ;?>">
                    </p>
                </form>
                <p class="description">
                    <?php _e('Please copy this shortcode to your page ot template file <code>[cts-testimonials]</code>', 'cts');?>
                </p>
            </div>
		    <?php echo ob_get_clean();

	    }
    }

    CTS_Setting::get_instance();
}




