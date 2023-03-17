<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_blogbycat extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_blogbycat', 'Tried Home Blog By Cat',
			array(
				'classname' => 'widget_home_blogbycat',
				'description' => esc_html__('Danh sách Bài viết', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array('category' => 0);
        $instance = wp_parse_args($instance, $defaults);
		$category = get_category($instance['category']);
		$posts = get_posts(array (
			'post_type' => 'post',
			'orderby' => 'date',
			'order'=> 'DESC', 
			'post_status' => 'publish',
			'posts_per_page' => 2,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'terms' => $category->term_id,
					'include_children' => false // Remove if you need posts from term 7 child terms
				)
			)
		));
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-blogbycat">
				<h3 class="section-title"><?php echo $args['before_title'] .$category->name. $args['after_title']; ?></h3>
				<div class="section-wrapper">
					<div class="blog-block">
						<div class="blogs">
							<?php 
								if (!empty($posts)) :
									foreach ($posts as $post) :
										get_template_part('template-parts/blog-item/item', 'hot', array( 'id' => $post->ID ) );
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
		$instance['category'] = !empty($new_instance['category']) ? $new_instance['category'] : 0;
		return $instance;
	}

	function form($instance) {
		$defaults = array('category' => 0);
		$instance = wp_parse_args($instance, $defaults);
		$categories = get_categories();
		?>
            <div style="margin-bottom: 5px; min-height: 25px;">
				<?php if (!empty($categories)) : ?>
					<span style="width: 20%; float:left; line-height: 20px;"><?php _e('Danh mục', 'tried'); ?>:</span>
					<span style="float:left; : 70%; margin-left: 5%">
						<select id="<?php echo esc_attr($this->get_field_id('category')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
							<?php foreach ($categories as $category) : ?>
								<option value="<?php echo $category->term_id?>" <?php selected($category->term_id, $instance['category']); ?>><?php echo $category->name; ?></option>
							<?php endforeach; ?>
						</select>
					</span>
				<?php endif; ?>
            </div>
		<?php
	}
}
