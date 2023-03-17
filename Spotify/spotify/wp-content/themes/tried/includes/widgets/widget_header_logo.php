<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_logo extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_logo', 'Tried Header Logo',
			array(
				'classname' => 'widget_header_logo',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('choose_logo' => 'custom_logo');
        $instance = wp_parse_args($instance, $defaults);
		$choose_logo = !empty($instance['choose_logo'])?$instance['choose_logo']:'custom_logo';
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-logo">
				<div class="section-logo">
					<?php
						$logo = get_theme_mod( $choose_logo );
						$custom_logo = is_numeric($logo)?wp_get_attachment_image_src( $logo , 'full' )[0]:$logo;
						if ( $custom_logo ) :
							?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'webhd' ); ?>" rel="home">
									<img src="<?php echo $custom_logo; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
								</a>
							<?php
						endif;
					?>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['choose_logo'] = ($new_instance['choose_logo']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array('choose_logo' => 'custom_logo');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<h4><?php _e('Chọn logo hiển thị', ''); ?></h4>
			  	<input type="radio" id="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_logo" name="<?php echo esc_attr($this->get_field_name('choose_logo')); ?>" value="custom_logo" <?php echo !empty($instance['choose_logo']) && (esc_attr($instance['choose_logo']) == 'custom_logo')?'checked':''; ?>>
			  	<label for="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_logo"><?php _e('Logo chính', ''); ?></label><br>
			  	<input type="radio" id="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_second_logo" name="<?php echo esc_attr($this->get_field_name('choose_logo')); ?>" value="custom_second_logo" <?php echo !empty($instance['choose_logo']) && (esc_attr($instance['choose_logo']) == 'custom_second_logo')?'checked':''; ?>>
			  	<label for="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_second_logo"><?php _e('Logo phụ', ''); ?></label>
			</p>
		<?php
    }
}
