<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_about_content extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_about_content', 'Tried About Content',
			array(
				'classname' => 'widget_about_content',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Giới thiệu');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
        $content = get_field('content','widget_'.$args['widget_id']);
        $image = get_field('image','widget_'.$args['widget_id']);
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-about-content">
				<div class="section-wrapper">
					<div class="image-block">
						<?php if (!empty($image)) : ?>
							<img src="<?php echo $image; ?>" alt="">
						<?php endif; ?>
					</div>
					<div class="content-block">
						<h3 class="title"><?php echo $title; ?></h3>
						<div class="content">
							<?php echo $content; ?>
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
	    $defaults = array('title' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
            </p>
   	    <?php
    }
}
