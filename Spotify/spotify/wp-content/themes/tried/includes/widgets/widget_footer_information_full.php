<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_information_full extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_information_full', 'Tried Footer Information Full',
			array(
				'classname' => 'widget_footer_information_full',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('choose_logo' => 'custom_logo', 'description' => '', 'contact' => '');
        $instance = wp_parse_args($instance, $defaults);
		$choose_logo = $instance['choose_logo'];
		$description = $instance['description'];
		$contact = $instance['contact'];
		$social_facebook = $instance['social_facebook'];
		$social_instagram = $instance['social_instagram'];
		$social_youtube = $instance['social_youtube'];
		$social_twitter = $instance['social_twitter'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-information-full">
				<div class="section-wrapper margin-auto">
					<div class="logo-block">
						<?php
							if (!empty($instance['choose_logo']) && $choose_logo != 'custom_logo') :
								$second_custom_logo = get_theme_mod( $choose_logo );
								?>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo" title="<?php esc_attr_e( 'Home', 'tried' ); ?>" rel="home">
										<img src="<?php echo esc_url( $second_custom_logo ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
									</a>
								<?php
							else :
								$custom_logo = get_theme_mod( 'custom_logo' );
								$logo = wp_get_attachment_image_src( $custom_logo , 'full' );
								?>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo" title="<?php esc_attr_e( 'Home', 'tried' ); ?>" rel="home">
										<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
									</a>
								<?php
							endif;
						?>
					</div>
					<div class="description-block">
						<p><?php echo $description; ?></p>
					</div>
					<div class="contact-block">
						<?php echo $contact; ?>
					</div>
					<div class="social-block">
						<ul class="socials">
							<?php if (!empty($social_facebook)) : ?>
								<li class="item facebook">
									<a class="fab fa-facebook-f" href="<?php echo $social_facebook; ?>" title=""></a>
								</li>
							<?php endif; ?>
							<?php if (!empty($social_instagram)) : ?>
								<li class="item instagram">
									<a class="fab fa-instagram" href="<?php echo $social_instagram; ?>" title=""></a>
								</li>
							<?php endif; ?>
							<?php if (!empty($social_youtube)) : ?>
								<li class="item youtube">
									<a class="fab fa-youtube" href="<?php echo $social_youtube; ?>" title=""></a>
								</li>
							<?php endif; ?>
							<?php if (!empty($social_twitter)) : ?>
								<li class="item twitter">
									<a class="fab fa-twitter" href="<?php echo $social_twitter; ?>" title=""></a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['choose_logo'] = ($new_instance['choose_logo']);
		$instance['description'] = ($new_instance['description']);
		$instance['contact'] = ($new_instance['contact']);
		$instance['social_facebook'] = $new_instance['social_facebook'];
		$instance['social_instagram'] = $new_instance['social_instagram'];
		$instance['social_youtube'] = $new_instance['social_youtube'];
		$instance['social_twitter'] = $new_instance['social_twitter'];
        return $instance;
    }
    function form($instance) {
	    $defaults = array('choose_logo' => 'custom_logo', 'description' => '', 'contact' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<div>
				<h4><?php esc_html_e('Chọn logo hiển thị', ''); ?></h4>
				<label for="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_logo">
					<input type="radio" id="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_logo" name="<?php echo esc_attr($this->get_field_name('choose_logo')); ?>" value="custom_logo" <?php echo !empty($instance['choose_logo']) && (esc_attr($instance['choose_logo']) == 'custom_logo')?'checked':''; ?>>
			  		<?php esc_html_e('Logo chính', ''); ?>
				</label>
			  	<label for="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_second_logo">
					<input type="radio" id="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_second_logo" name="<?php echo esc_attr($this->get_field_name('choose_logo')); ?>" value="custom_second_logo" <?php echo !empty($instance['choose_logo']) && (esc_attr($instance['choose_logo']) == 'custom_second_logo')?'checked':''; ?>>
			  		<?php esc_html_e('Logo phụ', ''); ?>
				</label>
			</div>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Mô tả', 'tried'); ?></label>
				<textarea class="widefat" rows="3" name="<?php echo esc_attr($this->get_field_name('description')); ?>" id="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact')); ?>"><?php esc_html_e('Thông tin liên hệ', 'tried'); ?></label>
				<textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('contact')); ?>" id="<?php echo esc_attr($this->get_field_id('contact')); ?>"><?php echo esc_attr($instance['contact']); ?></textarea>
			</p>
			<h4><?php _e('Mạng xã hội', 'tried'); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>"><?php esc_html_e('Facebook', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_facebook']); ?>" name="<?php echo esc_attr($this->get_field_name('social_facebook')); ?>" id="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>"><?php esc_html_e('Instagram', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_instagram']); ?>" name="<?php echo esc_attr($this->get_field_name('social_instagram')); ?>" id="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>"><?php esc_html_e('Youtube', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_youtube']); ?>" name="<?php echo esc_attr($this->get_field_name('social_youtube')); ?>" id="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>"><?php esc_html_e('Twitter', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_twitter']); ?>" name="<?php echo esc_attr($this->get_field_name('social_twitter')); ?>" id="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>" />
            </p>
   		<?php
    }
}
