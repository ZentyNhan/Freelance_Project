<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_gridblog extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_gridblog', 'Tried Home Grid Blog',
			array(
				'classname' => 'widget_home_gridblog',
				'description' => esc_html__('Bài viết dạng lưới', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array('title' => __('Bài viết nổi bật', 'tried'), 'post_ids' => array(), 'plimit' => 6);
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$post_ids = $instance['post_ids'];
		echo $args['before_widget'];
		?>
		<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-gridblog">
			<h4 class="section-title title-highlight"><span><?= $title; ?></span></h4>
			<div class="section-wrapper">
				<div class="gridblog-block">
					<?php
						if (!empty($post_ids)) :
							foreach ($post_ids as $id) :
								$post = get_post($id);
								if ($post) :
                                    get_template_part('template-parts/blog-item/item', 'grid', array( 'id' => $post->ID ) );
								endif;
							endforeach;
						endif;
					?>
				</div>
			</div>
		</section>
		<?php
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = $new_instance['title'];
		$instance['plimit'] = $new_instance['plimit'];
		for ( $i = 0; $i < $instance['plimit']; $i++ ) {
			$instance['post_ids'][] = $new_instance['post'.'_'.$i];
		}
		return $instance;
	}

	function form($instance) {
		$defaults = array('title' => __('Bài viết nổi bật', 'tried'), 'post_ids' => array(), 'plimit' => 6);
		$instance = wp_parse_args($instance, $defaults);
		$allposts = get_posts(array (
			'post_type' => 'post',
			'orderby' => 'date',
			'order'=> 'DESC', 
			'post_status' => 'publish',
			'posts_per_page' => -1
		));
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('plimit')); ?>"><?php esc_html_e('Số lượng bài viết', 'tried'); ?></label>
				<input class="widefat" type="number" value="<?php echo esc_attr($instance['plimit']); ?>" name="<?php echo esc_attr($this->get_field_name('plimit')); ?>" id="<?php echo esc_attr($this->get_field_id('plimit')); ?>" />
			</p>
		<?php
			for ( $i = 0; $i < 6; $i++ ) :
		?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_name('post'.'_'.$i)); ?>"><?php _e('Bài viết', 'tried'); ?></label>
					<select id="<?php echo esc_attr($this->get_field_name('post'.'_'.$i)); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('post'.'_'.$i)); ?>" style="margin-top: 15px;">
						<?php foreach ($allposts as $i => $post) : ?>
							<option value="<?php echo $post->ID; ?>" <?php echo in_array($post->ID, $instance['post_ids'])?'selected':''; ?>><?php echo (strlen($post->post_title)>=40)?substr($post->post_title, 0, 40).'...':$post->post_title; ?></option>
						<?php endforeach; ?>
					</select>
				</p>
		<?php
			endfor;
	}
}
