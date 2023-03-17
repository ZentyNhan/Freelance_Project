<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-smallblog-item');
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
    <div class="smallblog-item <?php echo $slide?'swiper-slide':''; ?>">
        <div class="wrap">
            <div class="featured-image">
                <a href="<?php echo get_permalink($post->ID); ?>" title=""><img src="<?php echo $image; ?>" alt=""></a>
            </div>
            <div class="box-contain">
                <h5 class="title"><a href="<?php echo get_permalink($post->ID); ?>" title=""><?php echo get_the_title($post->ID); ?></a></h5>
                <ul class="meta">
                    <li class="date"><?php echo get_the_date('M d, Y'); ?></li>
                </ul>
            </div>
        </div>
    </div>
<?php
endif;