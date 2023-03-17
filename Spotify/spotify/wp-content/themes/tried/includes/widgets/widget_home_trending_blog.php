<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_trending_blog extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_trending_blog', 'Tried Home Trending Blog',
			array(
				'classname' => 'widget_home_trending_blog',
				'description' => esc_html__('Bài viết trending', 'tried'),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array('title' => 'Bài viết Trending');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-trending-blog section-swiper" data-control="<?php echo $key; ?>" data-loop="true" data-effect="fade">
				<div class="section-wrapper">
				    <div class="title-block">
						<h5><?php echo $title; ?></h5>
					</div>
                    <div class="trendings-block">
                        <div class="swiper widget-home-trending-blog">
                            <div class="swiper-wrapper">
                                <?php 
                                    $posts = get_posts(array (
                                        'post_type' => 'post',
                                        'orderby' => 'date',
                                        'order'=> 'DESC', 
                                        'post_status' => 'publish',
                                        'posts_per_page' => 6
                                    ));
                                    if (!empty($posts)) :
                                        foreach ($posts as $post) :
                                            $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                            $terms = get_the_terms( $post->ID, 'category' );
                                ?>
                                            <div class="trending-blog-item swiper-slide">
                                                <div class="wrap">
                                                    <a href="<?php echo get_permalink($post->ID); ?>" title=""><h5 class="title"><?php echo get_the_title($post->ID); ?></h5></a>
                                                </div>
                                            </div>
                                <?php
                                        endforeach;
                                    endif;
                                ?>
                            </div>
                        </div>
                        <div class="navbutton">
                            <div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
                            <div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div>
                        </div>
                    </div>
				</div>
			</section>
		<?php
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = ($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$defaults = array('title' => 'Bài viết Trending');
		$instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php
	}
}
