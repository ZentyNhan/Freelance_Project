<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_contact_mapform extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_contact_mapform', 'Tried Contact Map Form',
			array(
				'classname' => 'widget_contact_mapform',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => '', 'content' => '', 'company' => '', 'form' => '', 'map' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$content = $instance['content'];
		$form = $instance['form'];
		$map = $instance['map'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-contact-mapform">
				<div class="section-wrapper margin-auto">
					<div class="map-block">
						<?php echo $map; ?>
					</div>
					<div class="form-block">
						<div class="separater separater-block mwidth-main margin-auto"></div>
						<h4 class="title"><?php echo $title; ?></h4>
						<p class="content"><?php echo $content; ?></p>
						<?php if (!empty($form)) : ?>
							<?php echo do_shortcode('[contact-form-7 id="'.$form.'"]'); ?>
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
		$instance['content'] = ($new_instance['content']);
		$instance['form'] = ($new_instance['form']);
		$instance['map'] = ($new_instance['map']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => '', 'content' => '', 'company' => '', 'form' => '', 'map' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>" cols="30" rows="4"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
			<div style="margin-bottom: 5px; min-height: 25px;">
				<?php 
					$cf7 = get_posts(array(
						'post_type'     => 'wpcf7_contact_form',
						'numberposts'   => -1
					));
					if (!empty($cf7)) :
				?>
					<span style="width: 20%; float:left; line-height: 20px;"><?php _e('Form', ''); ?>:</span>
					<span style="float:left; : 70%; margin-left: 5%">
						<select id="<?php echo esc_attr($this->get_field_id('form')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('form')); ?>">
							<?php foreach ($cf7 as $it_7) : ?>
								<option value="<?=$it_7->ID?>" <?php selected($it_7->ID, $instance['form']); ?>><?php echo $it_7->post_title ?></option>
							<?php endforeach; ?>
						</select>
					</span>
				<?php endif; ?>
            </div>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('map')); ?>"><?php esc_html_e('Bản đồ', ''); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('map')); ?>" id="<?php echo esc_attr($this->get_field_id('map')); ?>" cols="30" rows="4"><?php echo esc_attr($instance['map']); ?></textarea>
			</p>
   		<?php
    }
}
