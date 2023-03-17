<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_banner extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_banner', 'Tried Header Banner',
			array(
				'classname' => 'widget_header_banner',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('banner' => '', 'link' => '');
        $instance = wp_parse_args($instance, $defaults);
		$banner = $instance['banner'];
		$link = $instance['link'];
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-header-banner">
				<div class="section-wrapper margin-auto">
                	<div class="banner-block">
                        <a href="<?php echo $link; ?>" title="">
                            <div class="banner"><?php echo $banner; ?></div>
                        </a>
                    </div>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['banner'] = $new_instance['banner'];
		$instance['link'] = $new_instance['link'];
        return $instance;
    }

    function form($instance) {
	    $defaults = array('banner' => '', 'link' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('banner')); ?>"><?php esc_html_e('Nhúng Banner', ''); ?></label>
				<textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('banner')); ?>" id="<?php echo esc_attr($this->get_field_id('banner')); ?>"><?php echo esc_attr($instance['banner']); ?></textarea>
			</p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link')); ?>"><?php esc_html_e('Liên kết', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['link']); ?>" name="<?php echo esc_attr($this->get_field_name('link')); ?>" id="<?php echo esc_attr($this->get_field_id('link')); ?>"/>
            </p>
   		<?php
    }
}