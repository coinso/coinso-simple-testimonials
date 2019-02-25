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

global $testimonials_atts, $cts_options;

$testimonials_atts = shortcode_atts( array(
    'testimonials_title'    =>  $cts_options['cts_section_title'] ? $cts_options['cts_section_title'] : 'Testimonials',
    'testimonials_count'    =>  !empty($cts_options['cts_posts_count']) ? $cts_options['cts_posts_count'] : -1,
    'autoplay'              =>  !empty($cts_options['cts_autoplay']) ? $cts_options['cts_autoplay'] : 'true',
    'autoplaySpeed'         =>  !empty($cts_options['cts_autoplay_speed']) ? $cts_options['cts_autoplay_speed'] : 2000,
    'infinite'              =>  !empty($cts_options['cts_infinite']) ? $cts_options['cts_infinite'] : 'true',
    'main_color'            =>  !empty($cts_options['cts_main_color']) ? $cts_options['cts_main_color'] : '#000000',
    'secondary_color'       =>  !empty($cts_options['cts_secondary_color']) ? $cts_options['cts_secondary_color'] : '#fff',
    'play_icon'             =>  !empty($cts_options['cts_play_icon']) ?  $cts_options['cts_play_icon'] : 'far fa-play-circle',
    'title_attr'            =>  !empty($cts_options['cts_section_title_attr']) ?  $cts_options['cts_section_title_attr'] : 'h3',
    'subtitle'              =>  !empty($cts_options['cts_section_subtitle']) ?  $cts_options['cts_section_subtitle'] : '',
    'head_align'            =>  !empty($cts_options['cts_head_align']) ?  $cts_options['cts_head_align'] : 'left',



), $shortcode_args );

$all = -1;
$args = array(
    'post_type'         =>  'testimonials',
    'posts_per_page'    =>  $all,
    'orderby'           =>  'menu_id title',
    'order'             =>  'DESC',
);
$test_query = new WP_Query( $args );

if ( $test_query->have_posts() ){ ?>
    <div class="cts-testimonials-wrap">
        <div class="cts-title-wrap" style="text-align: <?php echo $testimonials_atts['head_align'] ;?>">
            <?php if ( $testimonials_atts['title_attr'] ){
                printf('%s', '<'.$testimonials_atts['title_attr'].' class="cts-testimonial-title" style="color:'.$testimonials_atts['main_color'].'">'.$testimonials_atts['testimonials_title'].'</'.$testimonials_atts['title_attr'].'>');
            } else { ?>
                <h3 class="cts-testimonial-title" style="color: <?php echo $testimonials_atts['main_color'];?>">
                    <?php echo $testimonials_atts['testimonials_title'];?>
                </h3>
            <?php }
            if ( $testimonials_atts['subtitle']) { ?>
                <div class="cts-testimonials-subtitle">
                    <?php echo esc_attr( $testimonials_atts['subtitle'] );?>
                </div>
            <?php } ?>
        </div>
        <div id="cts-testimonials"
             data-autoplay="<?php echo $testimonials_atts['autoplay'];?>"
             data-speed="<?php echo $testimonials_atts['autoplaySpeed'];?>"
             data-infinite="<?php echo $testimonials_atts['infinite'];?>"
             data-count="<?php echo $cts_options['cts_posts_count'];?>"
             >
            <?php
            $i = 1;
            while ( $test_query->have_posts() ){
                $test_query->the_post();
                $testimonial_img        = get_the_post_thumbnail_url();
                $testimonial_video_id   = get_post_meta($test_query->post->ID, 'testimonial_vid_id', true);
                $testimonial_title      = get_the_title();
                $testimonioal_rating    = get_post_meta( $test_query->post->ID, 'testimonial_rating', true );
                $testimonioal_content   = get_the_content();

                if ( $i == 3 ){ $i = 1; }
                if ( $i = 1 ){
                    echo '<div class="wrap-2">';
                }
                ?>
                <div class="cts-testimonial-wrap count-<?php echo $i;?>" itemprop="review" itemscope itemtype="http://schema.org/Review">
                    <div class="cts-testimonial">
                        <div class="cts-testimonial__thumbnail-wrap" style="border-color: <?php echo $testimonials_atts['main_color'];?>;">
                            <div class="cts-img-overlay"></div>
                            <i class="<?php echo $testimonials_atts['play_icon'];?>" style="color: <?php echo $testimonials_atts['secondary_color'];?>;"></i>
                            <div class="cts-testimonial__img-wrap">
                                <?php if ( $testimonial_img ){ ?>
                                    <img src="<?php echo $testimonial_img;?>" alt="<?php echo $testimonial_title;?>" data-id="<?php echo $testimonial_video_id;?>" class="cts-testimonial__img">
                                <?php } else { ?>
                                    <img src="<?php echo 'https://img.youtube.com/vi/'. $testimonial_video_id . '/0.jpg';?>" alt="<?php echo $testimonial_title;?>" data-id="<?php echo $testimonial_video_id;?>" class="cts-testimonial__img">
                                <?php } ?>
                            </div>
                            <div class="cts-testimonial__vid-wrap">
                                <iframe id="<?php echo $testimonial_video_id;?>" class="embed-responsive-item cts-testimonial__vid" src="" data-src="https://www.youtube.com/embed/<?php echo $testimonial_video_id;?>?rel=0" allow="autoplay; encrypted-media" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="cts-testimonial__content" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                            <meta itemprop="worstRating" content = "1">
                            <meta itemprop="bestRating" content = "5">
                            <h4 class="cts-testimonials-title" itemprop="name">
                                <?php echo $testimonial_title;?>
                            </h4>
                            <?php if ($testimonioal_content){ ?>
                                <p itemprop="description">
                                    <?php echo $testimonioal_content;?>
                                </p>
                            <?php } ?>
                            <ul class="cts-testimonial-star-rating" itemprop="ratingValue">
                                <meta itemprop="ratingValue" content = "<?php echo $testimonioal_rating;?>">
                                <?php for( $s = 1; $s<= $testimonioal_rating; $s++ ){ ?>
                                    <li class="ctr-star">
                                        <i class="fas fa-star" aria-hidden="true" style="color:<?php echo $testimonials_atts['main_color'];?>"></i>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            <?php if ( $i = 2 ){
                    echo '</div>';
                }
                $i++;
            } ?>
        </div>
    </div>

    <?php wp_reset_query();
}

