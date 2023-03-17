<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_information extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_information', 'Tried Footer Information',
			array(
				'classname' => 'widget_footer_information',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => '', 'description' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$description = $instance['description'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-information">
                <h4 class="section-title"><?php echo $args['before_title'].$title.$args['after_title']; ?></h4>
				<div class="section-wrapper">
					<div class="description-block">
						<?php echo $description; ?>
					</div>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['description'] = ($new_instance['description']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array('title' => '', 'description' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
            </p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Mô tả', 'tried'); ?></label>
				<textarea class="widefat" rows="5" name="<?php echo esc_attr($this->get_field_name('description')); ?>" id="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
			</p>
   		<?php
    }
}
