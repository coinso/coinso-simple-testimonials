<?php
/**
 * Created by PhpStorm.
 * User: ido
 * Date: 10/25/2018
 * Time: 08:16
 */

global $testimonials_atts;

$testimonials_atts = shortcode_atts( array(
    'testimonials_title'    =>  __('Testimonials', 'textdoman'),
    'testimonials_count'    =>  -1,
    'autoplay'              =>  'true',
    'autoplaySpeed'         =>  2000,
    'infinite'              =>  'true',


), $shortcode_args );

$args = array(
    'post_type'         =>  'testimonials',
    'posts_per_page'    =>  $testimonials_atts['testimonials_count'],
    'orderby'           =>  'menu_id title',
    'order'             =>  'DESC',
);
$test_query = new WP_Query( $args );

if ( $test_query->have_posts() ){ ?>
    <div class="cts-testimonials-wrap">
        <div class="cts-title-wrap">
            <h3 class="cts-testimonial-title">
                <?php echo $testimonials_atts['testimonials_title'];?>
            </h3>
        </div>
        <div id="cts-testimonials" data-autoplay="<?php echo $testimonials_atts['autoplay'];?>" data-speed="<?php echo $testimonials_atts['autoplaySpeed'];?>" data-infinite="<?php echo $testimonials_atts['infinite'];?>">
            <?php while ( $test_query->have_posts() ){
                $test_query->the_post();
                $testimonial_img        = get_the_post_thumbnail_url();
                $testimonial_video_id   = get_post_meta($test_query->post->ID, 'cts_video_id', true);
                $testimonial_title      = get_the_title();

                ?>
                <div class="cts-testimonial-wrap">
                    <div class="cts-testimonial">
                        <div class="cts-testimonial__thumbnail-wrap">
                            <div class="cts-img-overlay"></div>
                            <i class="far fa-play-circle"></i>
                            <div class="cts-testimonial__img-wrap">
                                <img src="<?php echo $testimonial_img;?>" alt="<?php echo $testimonial_title;?>" data-id="<?php echo $testimonial_video_id;?>" class="cts-testimonial__img">
                            </div>
                            <div class="cts-testimonial__vid-wrap">
                                <iframe id="<?php echo $testimonial_video_id;?>" class="embed-responsive-item cts-testimonial__vid" src="" data-src="https://www.youtube.com/embed/<?php echo $testimonial_video_id;?>?rel=0" allow="autoplay; encrypted-media" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="cts-testimonial__content">
                            <blockquote>
                                <?php echo $testimonial_title;?>
                            </blockquote>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php wp_reset_query();
}

