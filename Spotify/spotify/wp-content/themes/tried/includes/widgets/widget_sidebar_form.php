<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_sidebar_form extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_sidebar_form', 'Tried Sidebar Form',
			array(
				'classname' => 'widget_sidebar_form',
				'description' => esc_html__('Sidebar Form', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array(
            'title' => __('Liên hệ', 'tried'), 'subtitle' => __('Đăng ký nhận tin', 'tried'), 'form_id' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        wp_enqueue_style( 'tried-form-wpcf7' );
		$title = $instance['title'];
		$subtitle = $instance['subtitle'];
		$form_id = $instance['form_id'];
		echo $args['before_widget'];
		?>
            <section id="section-<?php echo $args['widget_id']; ?>" class="section-sidebar-form">
                <div class="section-wrapper">
                    <div class="sidebarform-block">
                        <?php if (!empty($form_id)) : ?>
                            <h4 class="title-highlight"><span><?php echo $title; ?></span></h4>
                            <h5 class="form-subtitle"><?php echo $subtitle; ?></h5>
                            <div class="form-wrap">
                                <?php echo do_shortcode('[contact-form-7 id="'.$form_id.'"]'); ?>
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
		$instance['title'] = $new_instance['title'];
		$instance['subtitle'] = $new_instance['subtitle'];
		$instance['form_id'] = $new_instance['form_id'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
            'title' => __('Liên hệ', 'tried'), 'subtitle' => __('Đăng ký nhận tin', 'tried'), 'form_id' => ''
        );
		$instance = wp_parse_args($instance, $defaults);
        $cf7 = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'numberposts'   => -1
        ));
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Tiêu đề phụ', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
			</p>
			<?php if (!empty($cf7)) : ?>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('form_id')); ?>"><?php esc_html_e('Form', 'tried').' '.($i+1).':'; ?></label>
                    <select id="<?php echo esc_attr($this->get_field_id('form_id')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('form_id')); ?>" style="margin-top: 15px;">
						<?php foreach ($cf7 as $it_7) : ?>
							<option value="<?php echo $it_7->ID?>" <?php selected($it_7->ID, $instance['form_id']); ?>><?php echo $it_7->post_title; ?></option>
						<?php endforeach; ?>
                    </select>
                </p>
			<?php endif; ?>
        <?php
	}
}
