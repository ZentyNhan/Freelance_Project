<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_copyright extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_copyright', 'Tried Footer Copyright',
			array(
				'classname' => 'widget_footer_copyright',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('copyright' => '');
        $instance = wp_parse_args($instance, $defaults);
		$copyright = $instance['copyright'];
		// echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-copyright">
				<div class="section-wrapper">
					<div class="copyright-block">
						<?php echo $copyright; ?>
					</div>
				</div>
			</section>
        <?php
		// echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['copyright'] = $new_instance['copyright'];
        return $instance;
    }
    function form($instance) {
	    $defaults = array('copyright' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('copyright')); ?>"><?php esc_html_e('Bản quyền', 'tried'); ?></label>
				<textarea class="widefat" rows="3" name="<?php echo esc_attr($this->get_field_name('copyright')); ?>" id="<?php echo esc_attr($this->get_field_id('copyright')); ?>"><?php echo esc_attr($instance['copyright']); ?></textarea>
			</p>
   		<?php
    }
}
