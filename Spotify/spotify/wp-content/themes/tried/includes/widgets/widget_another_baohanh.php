<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_baohanh extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_baohanh', 'Tried Anohter Bảo hành',
			array(
				'classname' => 'widget_another_baohanh',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array( 'title' => __( 'Tra cứu thông tin bảo hành', 'tried' ),'title_search' => __( 'Tra cứu bảo hành', 'tried' ), 'title_guide' => __( 'Hướng dẫn tra cứu bảo hành', 'tried'), 'content_guide' => '' );
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$title_search = $instance['title_search'];
		$title_guide = $instance['title_guide'];
		$content_guide = $instance['content_guide'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-baohanh">
				<h4 class="section-title"><?php echo $args['before_title'].$title.$args['after_title']; ?></h4>
				<div class="section-wrapper">
                    <div class="item search-baohanh">
                        <h3 class="title"><?php echo $title_search; ?></h3>
                        <div class="content">
                            <?php echo do_shortcode( '[tried_search_baohanh_form_fields]' ); ?>
                        </div>
                    </div>
                    <div class="item guide-baohanh">
                        <h3 class="title"><?php echo $title_guide; ?></h3>
                        <div class="content"><?php echo $content_guide; ?></div>
                    </div>
                </div>
			</section>
        <?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['title_search'] = ($new_instance['title_search']);
		$instance['title_guide'] = ($new_instance['title_guide']);
		$instance['content_guide'] = ($new_instance['content_guide']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array( 'title' => __( 'Tra cứu thông tin bảo hành', 'tried' ),'title_search' => __( 'Tra cứu bảo hành', 'tried' ), 'title_guide' => __( 'Hướng dẫn tra cứu bảo hành', 'tried'), 'content_guide' => '' );
        $instance = wp_parse_args($instance, $defaults);
	    ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
            </p>
            <h3><?php _e('Phần Tra cứu bảo hành', 'tried'); ?></h3>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_search')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_search']); ?>" name="<?php echo esc_attr($this->get_field_name('title_search')); ?>" id="<?php echo esc_attr($this->get_field_id('title_search')); ?>" />
            </p>
            <h3><?php _e('Phần hướng dẫn tra cứu bảo hành', 'tried'); ?></h3>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title_guide')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_guide']); ?>" name="<?php echo esc_attr($this->get_field_name('title_guide')); ?>" id="<?php echo esc_attr($this->get_field_id('title_guide')); ?>" />
            </p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content_guide')); ?>"><?php esc_html_e('Nội dung', 'tried'); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_guide')); ?>" id="<?php echo esc_attr($this->get_field_id('content_guide')); ?>" cols="30" rows="8"><?php echo esc_attr($instance['content_guide']); ?></textarea>
			</p>
   	    <?php
    }
}
