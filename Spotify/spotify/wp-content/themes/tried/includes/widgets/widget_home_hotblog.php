<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_hotblog extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_hotblog', 'Tried Home Hot Blog',
			array(
				'classname' => 'widget_home_hotblog',
				'description' => esc_html__('Bài viết Nổi bật', 'tried'),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array('post_ids' => array(), 'plimit' => 3);
        $instance = wp_parse_args($instance, $defaults);
		$post_ids = $instance['post_ids'];
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-hotblog">
				<div class="section-wrapper">
					<div class="hotblog-block">
						<?php
							if (!empty($post_ids)) :
								foreach ($post_ids as $k => $id) :
									$post = get_post($id);
									if ($post) :
										$is_meta = $k==0?true:false;
										$index = $k?$k+1:1;
                                        get_template_part('template-parts/blog-item/item', 'hot', array( 'id' => $post->ID, 'index' => $index,'is_meta' => $is_meta ) );
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
		$instance['plimit'] = 3;
		for ( $i = 0; $i < $instance['plimit']; $i++ ) {
			$instance['post_ids'][] = $new_instance['post'.'_'.$i];
		}
		return $instance;
	}

	function form($instance) {
		$defaults = array('post_ids' => array(), 'plimit' => 3);
		$instance = wp_parse_args($instance, $defaults);
		$allposts = get_posts(array (
			'post_type' => 'post',
			'orderby' => 'date',
			'order'=> 'DESC', 
			'post_status' => 'publish',
			'posts_per_page' => -1
		));
			for ( $i = 0; $i < $instance['plimit']; $i++ ) :
		?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_name('post'.'_'.$i)); ?>"><?=__('Bài viết', 'tried').' '.($i+1).':'; ?></label>
					<select id="<?php echo esc_attr($this->get_field_name('post'.'_'.$i)); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('post'.'_'.$i)); ?>" style="margin-top: 15px;">
						<?php foreach ($allposts as $post) : ?>
							<option value="<?php echo $post->ID; ?>" <?php echo in_array($post->ID, $instance['post_ids'])?'selected':''; ?>><?php echo (strlen($post->post_title)>=40)?substr($post->post_title, 0, 40).'...':$post->post_title; ?><?php echo $i; ?></option>
						<?php endforeach; ?>
					</select>
				</p>
		<?php
			endfor;
	}
}
