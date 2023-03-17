<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_form extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_form', 'Tried Footer Form',
			array(
				'classname' => 'widget_footer_form',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array('title' => '', 'content' => '', 'id_form' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$content = $instance['content'];
		$id_form = $instance['id_form'] ;
		wp_enqueue_style( 'tried-form-wpcf7' );
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-form">
				<div class="section-wrapper">
					<div class="info-block">
						<h4 class="title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h4>
						<p class="content"><?php echo $content; ?></p>
					</div>
					<div class="form-block">
			    		<?php echo do_shortcode('[contact-form-7 id="'.$id_form.'"]') ?>
					</div>
			    </div>
			</section>						
		<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = strip_tags($new_instance['content']);
		$instance['id_form'] = !empty($new_instance['id_form']) ? $new_instance['id_form'] : '0';
		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array('title' => '', 'content' => '', 'id_form' => '');
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
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="4" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
            <div style="margin-bottom: 5px; min-height: 25px;">
				<?php if (!empty($cf7)) : ?>
					<span style="width: 20%; float:left; line-height: 20px;"><?php _e('Form', ''); ?>:</span>
					<span style="float:left; : 70%; margin-left: 5%">
						<select id="<?php echo esc_attr($this->get_field_id('id_form')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('id_form')); ?>">
							<?php foreach ($cf7 as $it_7) : ?>
								<option value="<?=$it_7->ID?>" <?php selected($it_7->ID, $instance['id_form']); ?>><?=$it_7->post_title ?></option>
							<?php endforeach; ?>
						</select>
					</span>
				<?php endif; ?>
            </div>
        <?php
	}
}
