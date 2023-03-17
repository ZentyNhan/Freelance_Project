<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_about extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_about', 'Tried Home About',
			array(
				'classname' => 'widget_home_about',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
		$defaults = array(
			'subtitle' => '',
			'title' => '',
			'content' => '',
			'viewmore' => 'Read more about',
			'viewmore_link' => ''
		);
        $instance = wp_parse_args($instance, $defaults);
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$content = $instance['content'];
		$viewmore = $instance['viewmore'];
		$viewmore_link = $instance['viewmore_link'];
		$image_1 = get_field('image_1','widget_'.$args['widget_id']);
		$image_2 = get_field('image_2','widget_'.$args['widget_id']);
		$image_3 = get_field('image_3','widget_'.$args['widget_id']);
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-about">
				<div class="section-wrapper margin-auto">
					<div class="info-block">
						<h5 class="subtitle separater"><?php echo $subtitle; ?></h5>
						<h3 class="title"><?php echo $title; ?></h3>
						<div class="content">
							<?php echo $content; ?>
						</div>
						<a href="<?php echo $viewmore_link; ?>" class="viewmore"><?php echo $viewmore; ?></a>
					</div>
					<div class="image-block">
						<?php if (!empty($image_1)) : ?>
							<div class="item image-1">
								<img src="<?php echo $image_1; ?>" alt="">
							</div>
						<?php endif; ?>
						<?php if (!empty($image_2)) : ?>
							<div class="item image-2">
								<img src="<?php echo $image_2; ?>" alt="">
							</div>
						<?php endif; ?>
						<?php if (!empty($image_3)) : ?>
							<div class="item image-3">
								<img src="<?php echo $image_3; ?>" alt="">
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['viewmore'] = ($new_instance['viewmore']);
		$instance['viewmore_link'] = ($new_instance['viewmore_link']);
        return $instance;
    }

    function form($instance) {
		$defaults = array(
			'subtitle' => '',
			'title' => '',
			'content' => '',
			'viewmore' => 'Read more about',
			'viewmore_link' => ''
		);
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Tiêu đề phụ', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="4" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('viewmore')); ?>"><?php esc_html_e('Xem thêm', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmore']); ?>" name="<?php echo esc_attr($this->get_field_name('viewmore')); ?>" id="<?php echo esc_attr($this->get_field_id('viewmore')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('viewmore_link')); ?>"><?php esc_html_e('Xem thêm link', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmore_link']); ?>" name="<?php echo esc_attr($this->get_field_name('viewmore_link')); ?>" id="<?php echo esc_attr($this->get_field_id('viewmore_link')); ?>" />
			</p>
		<?php
    }
}
