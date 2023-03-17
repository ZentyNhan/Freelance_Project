<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_contact extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_contact', 'Tried Footer Contact',
			array(
				'classname' => 'widget_footer_contact',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => '', 'address' => '', 'phone' => '', 'email' => '');
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$address = $instance['address'];
		$phone = $instance['phone'];
		$dkkd = $instance['dkkd'];
		$email = $instance['email'];
		$social_facebook = $instance['social_facebook'];
		$social_instagram = $instance['social_instagram'];
		$social_youtube = $instance['social_youtube'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-contact">
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title'];?></h4>
				<div class="section-wrapper margin-auto">
					<div class="info-block">
						<?php if (!empty($address)) : ?>
							<div class="item address">
								<div class="icon"><i aria-hidden="true" class="far fa-building"></i></div>
								<div class="text"><?php echo $address; ?></div>
							</div>
						<?php endif; ?>
						<?php if (!empty($phone)) : ?>
							<div class="item phone">
								<div class="icon"><i aria-hidden="true" class="fas fa-phone-alt"></i></div>
								<div class="text"><?php echo $phone; ?></div>
							</div>
						<?php endif; ?>
						<?php if (!empty($email)) : ?>
							<div class="item email">
								<div class="icon"><i aria-hidden="true" class="far fa-envelope"></i></div>
								<div class="text"><?php echo $email; ?></div>
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
		$instance['title'] = ($new_instance['title']);
		$instance['address'] = ($new_instance['address']);
		$instance['phone'] = ($new_instance['phone']);
		$instance['email'] = ($new_instance['email']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array('title' => '', 'address' => '', 'phone' => '', 'email' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<h5><?php esc_html_e('Thông tin liên hệ', ''); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php esc_html_e('Địa chỉ', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['address']); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" id="<?php echo esc_attr($this->get_field_id('address')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Số điện thoại', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['phone']); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['email']); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" id="<?php echo esc_attr($this->get_field_id('email')); ?>" />
			</p>
   		<?php
    }
}
