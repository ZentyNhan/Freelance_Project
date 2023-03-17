<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_infocontact extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_infocontact', 'Tried Home Info Contact',
			array(
				'classname' => 'widget_home_infocontact',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('content' => '', 'readmore' => 'Xem thêm', 'link_readmore' => '');
        $instance = wp_parse_args($instance, $defaults);
		$content = $instance['content'];
		$readmore = $instance['readmore'];
		$link_readmore = $instance['link_readmore'];
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-infocontact">
				<div class="section-wrapper margin-auto">
					<div class="info-block">
						<span class="icon fas fa-phone-alt"></span>
                		<p class="content"><?php echo $content; ?></p>
					</div>
					<div class="link-block">
                    	<a href="<?php echo $link_readmore; ?>" class="readmore"><i class="far fa-shield-alt"></i><?php echo $readmore; ?></a>
					</div>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['content'] = ($new_instance['content']);
		$instance['readmore'] = ($new_instance['readmore']);
		$instance['link_readmore'] = ($new_instance['link_readmore']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('content' => '', 'readmore' => 'Xem thêm', 'link_readmore' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('readmore')); ?>"><?php esc_html_e('Xem thêm', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['readmore']); ?>" name="<?php echo esc_attr($this->get_field_name('readmore')); ?>" id="<?php echo esc_attr($this->get_field_id('readmore')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>"><?php esc_html_e('Link xem thêm', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['link_readmore']); ?>" name="<?php echo esc_attr($this->get_field_name('link_readmore')); ?>" id="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>" />
			</p>
   		<?php
    }
}