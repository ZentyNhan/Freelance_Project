<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_contact_content extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_contact_content', 'Tried Contact Content',
			array(
				'classname' => 'widget_contact_content',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
			'title' => '',
			'id_form' => '',
			'contact_title' => '', 'contact_content' => '', 'contact_address' => '', 'contact_phone' => '', 'contact_email' => ''
		);
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$id_form = $instance['id_form'] ;
		$contact_title = ($instance['contact_title']);
		$contact_content = ($instance['contact_content']);
		$contact_address = ($instance['contact_address']);
		$contact_phone = ($instance['contact_phone']);
		$contact_email = ($instance['contact_email']);
		wp_enqueue_style( 'tried-form-wpcf7' );
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-contact-content">
				<h4 class="section-title"><?php echo $args['before_title'].$title.$args['after_title']; ?></h4>
				<div class="section-wrapper">
					<div class="form-block">
			    		<?php echo do_shortcode('[contact-form-7 id="'.$id_form.'"]') ?>
					</div>
					<div class="contact-block">
						<h4 class="title"><?php echo $contact_title; ?></h4>
						<div class="content">
							<?php echo $contact_content; ?>
						</div>
						<div class="infos">
							<ul>
								<?php if ( !empty( $contact_address ) ) : ?>
									<li class="fas fa-map-marker-alt"><?php echo $contact_address; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $contact_phone ) ) : ?>
									<li class="fas fa-phone-alt"><a href="tel:<?php echo $contact_phone; ?>"><?php echo $contact_phone; ?></a></li>
								<?php endif; ?>
								<?php if ( !empty( $contact_email ) ) : ?>
									<li class="fas fa-envelope"><a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a></li>
								<?php endif; ?>
							</ul>
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
		$instance['id_form'] = !empty($new_instance['id_form']) ? $new_instance['id_form'] : '0';
		$instance['contact_title'] = ($new_instance['contact_title']);
		$instance['contact_content'] = ($new_instance['contact_content']);
		$instance['contact_address'] = ($new_instance['contact_address']);
		$instance['contact_phone'] = ($new_instance['contact_phone']);
		$instance['contact_email'] = ($new_instance['contact_email']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array(
			'title' => '',
			'id_form' => '',
			'contact_title' => '', 'contact_content' => '', 'contact_address' => '', 'contact_phone' => '', 'contact_email' => ''
		);
        $instance = wp_parse_args($instance, $defaults);
        $cf7 = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'numberposts'   => -1
        ));
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<h5><?php esc_html_e('Phần form', 'tried'); ?></h5>
			<p>
				<?php if (!empty($cf7)) : ?>
					<select id="<?php echo esc_attr($this->get_field_id('id_form')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('id_form')); ?>">
						<?php foreach ($cf7 as $it_7) : ?>
							<option value="<?=$it_7->ID?>" <?php selected($it_7->ID, $instance['id_form']); ?>><?=$it_7->post_title ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
			</p>
			<h5><?php esc_html_e('Phần liên hệ', 'tried'); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['contact_title']); ?>" name="<?php echo esc_attr($this->get_field_name('contact_title')); ?>" id="<?php echo esc_attr($this->get_field_id('contact_title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact_content')); ?>"><?php esc_html_e('Nội dung', 'tried'); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('contact_content')); ?>" id="<?php echo esc_attr($this->get_field_id('contact_content')); ?>" cols="30" rows="6"><?php echo esc_attr($instance['contact_content']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact_address')); ?>"><?php esc_html_e('Địa chỉ', 'tried'); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('contact_address')); ?>" id="<?php echo esc_attr($this->get_field_id('contact_address')); ?>" cols="30" rows="2"><?php echo esc_attr($instance['contact_address']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact_phone')); ?>"><?php esc_html_e('Điện thoại', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['contact_phone']); ?>" name="<?php echo esc_attr($this->get_field_name('contact_phone')); ?>" id="<?php echo esc_attr($this->get_field_id('contact_phone')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact_email')); ?>"><?php esc_html_e('Email', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['contact_email']); ?>" name="<?php echo esc_attr($this->get_field_name('contact_email')); ?>" id="<?php echo esc_attr($this->get_field_id('contact_email')); ?>" />
			</p>
   		<?php
    }
}
