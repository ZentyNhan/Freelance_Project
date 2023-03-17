<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_info extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_info', 'Tried Header Info',
			array(
				'classname' => 'widget_header_info',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
            'title_mail' => 'Email', 'content_mail' => '',
            'title_address' => 'Địa chỉ', 'content_address' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$title_mail = $instance['title_mail'];
		$content_mail = $instance['content_mail'];
		$title_address = $instance['title_address'];
		$content_address = $instance['content_address'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-support">
                <div class="section-wrapper margin-auto">
                    <?php if (!empty($content_mail)) : ?>
                        <a href="<?php echo $content_mail; ?>" class="box">
                            <div class="icon"><i aria-hidden="true" class="fas fa-envelope"></i></div>
                            <div class="info">
                                <div class="title"><?php echo $title_mail; ?></div>
                                <div class="content"><?php echo $content_mail; ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content_address)) : ?>
                        <a href="javascript:void(0)" class="box">
                            <div class="icon"><i aria-hidden="true" class="fas fa-map-marker-alt"></i></div>
                            <div class="info">
                                <div class="title"><?php echo $title_address; ?></div>
                                <div class="content"><?php echo $content_address; ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title_mail'] = ($new_instance['title_mail']);
		$instance['content_mail'] = ($new_instance['content_mail']);
		$instance['title_address'] = ($new_instance['title_address']);
		$instance['content_address'] = ($new_instance['content_address']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array(
            'title_mail' => 'Email', 'content_mail' => '',
            'title_address' => 'Địa chỉ', 'content_address' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
            <h4><?php _e('Email', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_mail')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_mail']); ?>" name="<?php echo esc_attr($this->get_field_name('title_mail')); ?>" id="<?php echo esc_attr($this->get_field_id('title_mail')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('content_mail')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['content_mail']); ?>" name="<?php echo esc_attr($this->get_field_name('content_mail')); ?>" id="<?php echo esc_attr($this->get_field_id('content_mail')); ?>" />
            </p>
            <h4><?php _e('Địa chỉ', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_address')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_address']); ?>" name="<?php echo esc_attr($this->get_field_name('title_address')); ?>" id="<?php echo esc_attr($this->get_field_id('title_address')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('content_address')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['content_address']); ?>" name="<?php echo esc_attr($this->get_field_name('content_address')); ?>" id="<?php echo esc_attr($this->get_field_id('content_address')); ?>" />
            </p>
        <?php
    }
}
