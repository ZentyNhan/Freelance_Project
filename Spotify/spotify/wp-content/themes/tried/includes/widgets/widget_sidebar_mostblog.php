<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_sidebar_mostblog extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_sidebar_mostblog', 'Tried Sidebar Most Blog',
			array(
				'classname' => 'widget_sidebar_mostblog',
				'description' => esc_html__('Sidbar Most BLog', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array(
            'title' => __('Bài viết nổi bật', 'tried')
        );
        $instance = wp_parse_args($instance, $defaults);
        wp_enqueue_style( 'tried-form-wpcf7' );
		$title = $instance['title'];
        $posts = get_posts(array (
            'post_type' => 'post',
            'orderby' => 'date',
            'order'=> 'DESC', 
            'post_status' => 'publish',
            'posts_per_page' => 5
        ));
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-sidebar-mostblog">
				<div class="section-wrapper">
					<div class="sidebarmostblog-block">
						<h4 class="title-highlight"><span><?php echo $title; ?></span></h4>
						<div class="smallblogs">
							<?php
								if (!empty($posts)) :
									foreach ($posts as $post) :
										get_template_part('template-parts/blog-item/item', 'small', array( 'id' => $post->ID ) );
									endforeach;
								else :
									echo '<p class="no-result">'.__('Xin lỗi, Không có kết quả trả về.', 'tried').'</p>';
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
		$instance['title'] = $new_instance['title'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
            'title' => __('Bài viết nổi bật', 'tried')
        );
		$instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
        <?php
	}
}
