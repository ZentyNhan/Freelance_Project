<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_infobox extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_infobox', 'Tried Footer Infobox',
			array(
				'classname' => 'widget_footer_infobox',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
            'title_phone' => 'Any Questions?', 'content_phone' => '',
            'title_mail' => 'Send Email', 'content_mail' => '',
            'title_open' => 'Open Hours', 'content_open' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$title_phone = $instance['title_phone'];
		$content_phone = $instance['content_phone'];
		$title_mail = $instance['title_mail'];
		$content_mail = $instance['content_mail'];
		$title_open = $instance['title_open'];
		$content_open = $instance['content_open'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-infobox">
                <div class="section-wrapper margin-auto">
                    <?php if (!empty($content_phone)) : ?>
                        <a href="tel:<?php echo $content_phone; ?>" class="box">
                            <span class="icon fas fa-phone-alt"></span>
                            <div class="info">
                                <div class="title"><?php echo $title_phone; ?></div>
                                <div class="content"><?php echo $content_phone; ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content_mail)) : ?>
                        <a href="mailto:<?php echo $content_mail; ?>" class="box">
                            <span class="icon fas fa-envelope"></span>
                            <div class="info">
                                <div class="title"><?php echo $title_mail; ?></div>
                                <div class="content"><?php echo $content_mail; ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content_open)) : ?>
                        <a href="javascript:void(0)" class="box">
                            <span class="icon fas fa-history"></span>
                            <div class="info">
                                <div class="title"><?php echo $title_open; ?></div>
                                <div class="content"><?php echo $content_open; ?></div>
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
		$instance['title_phone'] = ($new_instance['title_phone']);
		$instance['content_phone'] = ($new_instance['content_phone']);
		$instance['title_mail'] = ($new_instance['title_mail']);
		$instance['content_mail'] = ($new_instance['content_mail']);
		$instance['title_open'] = ($new_instance['title_open']);
		$instance['content_open'] = ($new_instance['content_open']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array(
            'title_phone' => 'Any Questions?', 'content_phone' => '',
            'title_mail' => 'Send Email', 'content_mail' => '',
            'title_open' => 'Open Hours', 'content_open' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
            <h4><?php _e('Phone', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_phone')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_phone']); ?>" name="<?php echo esc_attr($this->get_field_name('title_phone')); ?>" id="<?php echo esc_attr($this->get_field_id('title_phone')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('content_phone')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['content_phone']); ?>" name="<?php echo esc_attr($this->get_field_name('content_phone')); ?>" id="<?php echo esc_attr($this->get_field_id('content_phone')); ?>" />
            </p>
            <h4><?php _e('Email', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_mail')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_mail']); ?>" name="<?php echo esc_attr($this->get_field_name('title_mail')); ?>" id="<?php echo esc_attr($this->get_field_id('title_mail')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('content_mail')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['content_mail']); ?>" name="<?php echo esc_attr($this->get_field_name('content_mail')); ?>" id="<?php echo esc_attr($this->get_field_id('content_mail')); ?>" />
            </p>
            <h4><?php _e('Open', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_open')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_open']); ?>" name="<?php echo esc_attr($this->get_field_name('title_open')); ?>" id="<?php echo esc_attr($this->get_field_id('title_open')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('content_open')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['content_open']); ?>" name="<?php echo esc_attr($this->get_field_name('content_open')); ?>" id="<?php echo esc_attr($this->get_field_id('content_open')); ?>" />
            </p>
        <?php
    }
}
