<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_contact extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_contact', 'Tried Header Contact',
			array(
				'classname' => 'widget_header_contact',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array( 'title' => '', 'content' => '', 'link' => '' );
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$content = $instance['content'];
		$link = $instance['link'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-contact">
                <div class="section-wrapper">
                    <div class="contact-block">
                        <div class="title"><?php echo $title; ?></div>
                        <div class="content"><a href="<?php echo !empty($link)?$link:'javascript:void(0)'; ?>"><?php echo $content; ?></a></div>
                    </div>
                </div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['link'] = ($new_instance['link']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array( 'title' => '', 'content' => '', 'link' => '' );
        $instance = wp_parse_args($instance, $defaults);
		?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['content']); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link')); ?>"><?php esc_html_e('Liên kết', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['link']); ?>" name="<?php echo esc_attr($this->get_field_name('link')); ?>" id="<?php echo esc_attr($this->get_field_id('link')); ?>" />
            </p>
        <?php
    }
}
