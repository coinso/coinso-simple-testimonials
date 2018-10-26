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

if (!class_exists('CTS_Testimonials')){

 class CTS_Testimonials{
        public function __construct(){

            add_action('init', array( $this, 'register_testimonials_post_types'));
            add_action('add_meta_boxes',array( $this, 'register_testimonials_metabox') );
            add_action('save_post', array( $this,'save_testimonials_metabox'));
	        add_action( 'manage_testimonials_posts_custom_column', array( $this, 'custom_testimonials_column_content'),10, 2 );
	        add_filter('manage_testimonials_posts_columns' , array( $this, 'cts_set_testimonials_columns'));


        }


     function register_testimonials_post_types() {
         $singular ='Testimonial';
         $plural = 'Testimonials';
         $labels = array(
             'name' => _x( $plural, 'cts' ),
             'singular_name' => _x( $singular, 'cts' ),
             'add_new' => _x( 'Add New' . $singular, 'cts' ),
             'add_new_item' => _x( 'Add New '. $singular, 'cts' ),
             'edit_item' => _x( 'Edit '. $singular, 'cts' ),
             'new_item' => _x( 'New '. $singular, 'cts' ),
             'view_item' => _x( 'View '. $singular, 'cts' ),
             'search_items' => _x( 'Search '. $plural, 'cts' ),
             'not_found' => _x( 'No '.$plural.' found', 'cts' ),
             'not_found_in_trash' => _x( 'No '.$plural.' found in Trash', 'cts' ),
             'parent_item_colon' => _x( 'Parent '. $singular, 'cts' ),
             'menu_name' => _x( $plural, 'cts' ),
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
                    __('Testimonial Video ID', 'cts'),
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
             <?php _e('Add Testimonial Video ID', 'cts');?>
         </label>
         <input type="text" id="testimonial_vid_id" name="testimonial_vid_id" value="<?php echo esc_attr( $value ); ?>" size="25" />
         <?php

     }

	 function cts_set_testimonials_columns($columns) {
		 return array(
			 'cb' => '<input type="checkbox" />',
			 'title' => __('Title', 'cts'),
			 'date' => __('Date', 'cts'),
			 'video_id' =>__( 'Video ID', 'cts'),
		 );
	 }

	 function custom_testimonials_column_content( $column_name, $post_id ) {
		 if ( $column_name == 'video_id' ) {
			 $video_id = get_post_meta( $post_id, 'cts_video_id', true );
			 if ( $video_id ) {
				 echo $video_id;
			 }
		 }
	 }



 }//CTS_Testimonials


}
new CTS_Testimonials();