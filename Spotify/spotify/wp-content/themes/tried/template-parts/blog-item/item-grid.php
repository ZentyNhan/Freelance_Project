<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-gridblog-item');
$post_id = 0;
if ($args['id']) {
    $post_id = $args['id'];
}
$post = get_post($post_id);
if ($post) :
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $image = get_theme_file_uri( "/assets/img/placeholder.png" );
    if (!empty($image_url[0])) {
        $image = $image_url[0];
    }
    $terms = get_the_terms( $post->ID, 'category' );
?>
    <div class="gridblog-item <?php echo $slide?'swiper-slide':''; ?>">
        <div class="wrap">
            <a href="<?php echo get_permalink($post->ID); ?>" title=""></a>
            <div class="featured-image">
                <img src="<?php echo $image; ?>" alt="">
            </div>
            <div class="box-contain">
                <h5 class="title"><?php echo get_the_title($post->ID); ?></h5>
                <ul class="meta">
                    <?php if (!empty($terms)) : ?>
                        <li class="term"><a href="<?php echo get_term_link($terms[0]->term_id); ?>"><?php echo $terms[0]->name; ?></a></li>
                    <?php endif; ?>
                    <li class="author"><?php echo get_the_author_meta('display_name', $post->post_author); ?></li>
                    <li class="date"><?php echo get_the_date('M d, Y'); ?></li>
                </ul>
            </div>
        </div>
    </div>
<?php
endif;