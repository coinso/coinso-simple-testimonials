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
             'show_in_rest' => true,
             'menu_icon' =>'dashicons-thumbs-up'
         );

         register_post_type( $plural, $args );

     }

     function register_testimonials_metabox( $post_type ){
            $post_types = array('testimonials');

            if ( in_array( $post_type, $post_types )){
                add_meta_box(
                    'cts_testimonial_fields',
                    __('Testimonial Info', 'cts'),
                    array( $this, 'render_testimonials_meta_box_content'),
                    $post_type,
                    'advanced',
                    'high'
                );
            }

     }

     function render_testimonials_meta_box_content( $post ){
         wp_nonce_field(basename( __FILE__ ), 'cts_testimonial_nonce');
        $cts_stored_meta = get_post_meta( $post->ID );

         ?>
         <div class="wrap testimonials-form">
             <div class="form-group">
                 <label for="testimonial_vid_id">
                     <?php _e('Add Testimonial Video ID', 'cts');?>
                 </label>
                 <input type="text" id="testimonial_vid_id" name="testimonial_vid_id" value="<?php if(!empty($cts_stored_meta['testimonial_vid_id'])) echo esc_attr($cts_stored_meta['testimonial_vid_id'][0]); ?>" class="form-control half-width" />
             </div>
             <div class="form-group">
                 <label for="testimonial_rating">
                     <?php _e('Select Rating', 'cts');?>
                 </label>
                 <select name="testimonial_rating" id="testimonial_rating" class="form-control half-width">
                     <?php $ratingValues = array(1,2,3,4,5);
                     foreach ( $ratingValues as $key=>$value){
                        if ( $value == $cts_stored_meta['testimonial_rating'][0]){ ?>
                            <option value="<?php echo $value;?>" selected><?php echo $value . ' Stars';?></option>
                        <?php } else { ?>
                            <option value="<?php echo $value;?>"><?php echo $value . ' Stars';?></option>
                        <?php }
                     }?>

                 </select>
             </div>
         </div>
         <?php

     }


     function save_testimonials_metabox( $post_id ){
         $is_autosave = wp_is_post_autosave( $post_id );
         $is_revision = wp_is_post_revision( $post_id );

         $is_valid_nonce = ( isset( $_POST['cts_testimonial_nonce'] ) && wp_verify_nonce( $_POST['cts_testimonial_nonce'] , basename( __FILE__) ) ) ? 'true' : 'false' ;

         if ( $is_autosave || $is_revision || !$is_valid_nonce ){
             return;
         }

         if ( isset( $_POST['testimonial_vid_id'] ) ){
             update_post_meta( $post_id, 'testimonial_vid_id', sanitize_text_field( $_POST['testimonial_vid_id'] ) );
         }
         if ( isset( $_POST['testimonial_rating'] ) ){
             update_post_meta( $post_id, 'testimonial_rating', sanitize_text_field( $_POST['testimonial_rating'] ) );
         }
     }

	 function cts_set_testimonials_columns($columns) {
		 return array(
			 'cb' => '<input type="checkbox" />',
			 'title' => __('Title', 'cts'),
			 'date' => __('Date', 'cts'),
			 'video_id' =>__( 'Video ID', 'cts'),
             'rating'   => __('Rating', 'cts')
		 );
	 }

	 function custom_testimonials_column_content( $column_name, $post_id ) {
		 if ( $column_name == 'video_id' ) {
			 $video_id = get_post_meta( $post_id, 'testimonial_vid_id', true );
			 if ( $video_id ) {
				 echo $video_id;
			 }
		 }
         if ( $column_name == 'rating' ) {
             $rating = get_post_meta( $post_id, 'testimonial_rating', true );
             if ( $rating ) {
                 echo $rating;
             }
         }
	 }



 }//CTS_Testimonials


}
new CTS_Testimonials();