<?php
/**
 * Created by PhpStorm.
 * User: ido
 * Date: 10/25/2018
 * Time: 08:16
 */


if (!class_exists('CTS_Testimonials')){
 class CTS_Testimonials{
        public function __construct(){

            add_action('init', array( $this, 'register_testimonials_post_types'));
            add_action('add_meta_boxes',array( $this, 'register_testimonials_metabox') );
            add_action('save_post', array( $this,'save_testimonials_metabox'));


        }


     function register_testimonials_post_types() {
         $singular ='Testimonial';
         $plural = 'Testimonials';
         $labels = array(
             'name' => _x( $plural, 'textdomain' ),
             'singular_name' => _x( $singular, 'textdomain' ),
             'add_new' => _x( 'Add New', 'textdomain' ),
             'add_new_item' => _x( 'Add New '. $singular, 'textdomain' ),
             'edit_item' => _x( 'Edit '. $singular, 'textdomain' ),
             'new_item' => _x( 'New '. $singular, 'textdomain' ),
             'view_item' => _x( 'View '. $singular, 'textdomain' ),
             'search_items' => _x( 'Search '. $plural, 'textdomain' ),
             'not_found' => _x( 'No '.$plural.' found', 'textdomain' ),
             'not_found_in_trash' => _x( 'No '.$plural.' found in Trash', 'textdomain' ),
             'parent_item_colon' => _x( 'Parent '. $singular, 'textdomain' ),
             'menu_name' => _x( $plural, 'textdomain' ),
         );

         $args = array(
             'labels' => $labels,
             'hierarchical' => true,
             'supports' => array( 'title','thumbnail', 'editor'),
             'taxonomies' => array(),
             'public' => true,
             'show_ui' => true,
             'show_in_menu' => true,
             'show_in_nav_menus' => true,
             'publicly_queryable' => true,
             'exclude_from_search' => true,
             'has_archive' => false,
             'query_var' => true,
             'can_export' => true,
             'rewrite' => array( 'slug' => strtolower($plural)),
             'capability_type' => 'post',
             'menu_position' => 22,
             'menu_icon' =>'dashicons-thumbs-up'
         );

         register_post_type( $plural, $args );

     }

     function register_testimonials_metabox( $post_type ){
            $post_types = array('testimonials');

            if ( in_array( $post_type, $post_types )){
                add_meta_box(
                    'cts_testimonial_vid_id',
                    __('Testimonial Video ID', 'textdomain'),
                    array( $this, 'render_testimonials_meta_box_content'),
                    $post_type,
                    'advanced',
                    'high'
                );
            }

     }

     function save_testimonials_metabox( $post_id ){
            if ( !isset( $_POST['cts_testimonial_nonce'] ) ){
                return $post_id;
            }
            $nonce = $_POST['cts_testimonial_nonce'];

            if ( !wp_verify_nonce( $nonce, 'cts_testimonial' ) ){
                return $post_id;
            }
         if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
             return $post_id;
         }
         // Check the user's permissions.
         if ( 'page' == $_POST['post_type'] ) {
             if ( ! current_user_can( 'edit_page', $post_id ) ) {
                 return $post_id;
             }
         } else {
             if ( ! current_user_can( 'edit_post', $post_id ) ) {
                 return $post_id;
             }
         }

         $mydata = sanitize_text_field( $_POST['testimonial_vid_id'] );

         // Update the meta field.
         update_post_meta( $post_id, 'cts_video_id', $mydata );

     }

     function render_testimonials_meta_box_content( $post ){
         wp_nonce_field('cts_testimonial', 'cts_testimonial_nonce');

         $value = get_post_meta( $post->ID, 'cts_video_id', true );
         ?>
         <label for="testimonial_vid_id">
             <?php _e('Add Testimonial Video ID', 'textdomain');?>
         </label>
         <input type="text" id="testimonial_vid_id" name="testimonial_vid_id" value="<?php echo esc_attr( $value ); ?>" size="25" />
         <?php

     }




 }//CTS_Testimonials


}
new CTS_Testimonials();