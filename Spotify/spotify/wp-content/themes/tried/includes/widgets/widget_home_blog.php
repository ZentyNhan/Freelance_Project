<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_blog extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_blog', 'Tried Home Blog',
			array(
				'classname' => 'widget_home_blog',
				'description' => esc_html__('Danh sách Bài viết', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array('title' => 'Tin tức nổi bật');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$posts = get_posts(array (
			'post_type' => 'post',
			'orderby' => 'date',
			'order'=> 'DESC', 
			'post_status' => 'publish',
			'posts_per_page' => 6
		));
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-blog">
				<h3 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h3>
				<div class="section-wrapper">
					<div class="blog-block">
						<div class="blogs">
							<?php 
								if (!empty($posts)) :
									foreach ($posts as $post) :
										get_template_part('template-parts/blog-item/item', 'basic', array( 'id' => $post->ID ) );
									endforeach;
								endif;
							?>
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
		$defaults = array('title' => 'Tin tức nổi bật');
		$instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php
	}
}
