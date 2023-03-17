<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-basicblog-item');
$post_id = 0;
$slide = false;
if ($args['id']) {
    $post_id = $args['id'];
}
if ($args['slide']) {
    $slide = $args['slide'];
}
$post = get_post($post_id);
if ($post) :
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $image = get_theme_file_uri( "/assets/img/placeholder.png" );
    if (!empty($image_url[0])) {
        $image = $image_url[0];
    }
?>
    <div class="basicblog-item <?php echo $slide?'swiper-slide':''; ?>">
        <div class="wrap">
            <div class="featured-image">
                <img src="<?php echo $image; ?>" alt="">
            </div>
            <div class="box-contain">
                <h5 class="title"><?php echo get_the_title($post->ID); ?></h5>
                <p class="excerpt"><?php echo get_the_excerpt($post->ID); ?></p>
                <div class="viewmore">
                    <a href="<?php echo get_permalink($post->ID); ?>" title="">[<?php _e('Xem thêm', 'tried'); ?>...]</a>
                </div>
            </div>
        </div>
    </div>
<?php
endif;