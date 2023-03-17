<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_infobox extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_infobox', 'Tried Home Infobox',
			array(
				'classname' => 'widget_home_infobox',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
            'box1_image' => '', 'box1_title' => '', 'box1_content' => '',
            'box2_image' => '', 'box2_title' => '', 'box2_content' => '',
            'box3_image' => '', 'box3_title' => '', 'box3_content' => '',
            'box4_image' => '', 'box4_title' => '', 'box4_content' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$box1_image = $instance['box1_image'];
		$box1_title = $instance['box1_title'];
		$box1_content = $instance['box1_content'];
		$box2_image = $instance['box2_image'];
		$box2_title = $instance['box2_title'];
		$box2_content = $instance['box2_content'];
		$box3_image = $instance['box3_image'];
		$box3_title = $instance['box3_title'];
		$box3_content = $instance['box3_content'];
		$box4_image = $instance['box4_image'];
		$box4_title = $instance['box4_title'];
		$box4_content = $instance['box4_content'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-home-infobox">
                <div class="section-wrapper">
                    <div class="infoboxs">
                        <?php if (!empty($box1_image)) : ?>
                            <div class="infobox-item">
                                <div class="image-block">
                                    <img src="<?php echo $box1_image; ?>" alt="">
                                </div>
                                <div class="info-block">
                                    <h4><?php echo $box1_title; ?></h4>
                                    <p><?php echo $box1_content; ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($box2_image)) : ?>
                            <div class="infobox-item">
                                <div class="image-block">
                                    <img src="<?php echo $box2_image; ?>" alt="">
                                </div>
                                <div class="info-block">
                                    <h4><?php echo $box2_title; ?></h4>
                                    <p><?php echo $box2_content; ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($box3_image)) : ?>
                            <div class="infobox-item">
                                <div class="image-block">
                                    <img src="<?php echo $box3_image; ?>" alt="">
                                </div>
                                <div class="info-block">
                                    <h4><?php echo $box3_title; ?></h4>
                                    <p><?php echo $box3_content; ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($box4_image)) : ?>
                            <div class="infobox-item">
                                <div class="image-block">
                                    <img src="<?php echo $box4_image; ?>" alt="">
                                </div>
                                <div class="info-block">
                                    <h4><?php echo $box4_title; ?></h4>
                                    <p><?php echo $box4_content; ?></p>
                                </div>
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
		$instance['box1_image'] = ($new_instance['box1_image']);
		$instance['box1_title'] = ($new_instance['box1_title']);
		$instance['box1_content'] = ($new_instance['box1_content']);
		$instance['box2_image'] = ($new_instance['box2_image']);
		$instance['box2_title'] = ($new_instance['box2_title']);
		$instance['box2_content'] = ($new_instance['box2_content']);
		$instance['box3_image'] = ($new_instance['box3_image']);
		$instance['box3_title'] = ($new_instance['box3_title']);
		$instance['box3_content'] = ($new_instance['box3_content']);
		$instance['box4_image'] = ($new_instance['box4_image']);
		$instance['box4_title'] = ($new_instance['box4_title']);
		$instance['box4_content'] = ($new_instance['box4_content']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array(
            'box1_image' => '', 'box1_title' => '', 'box1_content' => '',
            'box2_image' => '', 'box2_title' => '', 'box2_content' => '',
            'box3_image' => '', 'box3_title' => '', 'box3_content' => '',
            'box4_image' => '', 'box4_title' => '', 'box4_content' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
            <h4><?php _e('Box 1', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box1_image')); ?>"><?php esc_html_e('Hình ảnh(Link)', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box1_image']); ?>" name="<?php echo esc_attr($this->get_field_name('box1_image')); ?>" id="<?php echo esc_attr($this->get_field_id('box1_image')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box1_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box1_title']); ?>" name="<?php echo esc_attr($this->get_field_name('box1_title')); ?>" id="<?php echo esc_attr($this->get_field_id('box1_title')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box1_content')); ?>"><?php esc_html_e('Nội dung', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box1_content']); ?>" name="<?php echo esc_attr($this->get_field_name('box1_content')); ?>" id="<?php echo esc_attr($this->get_field_id('box1_content')); ?>" />
            </p>
            <h4><?php _e('Box 2', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box2_image')); ?>"><?php esc_html_e('Hình ảnh(Link)', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box2_image']); ?>" name="<?php echo esc_attr($this->get_field_name('box2_image')); ?>" id="<?php echo esc_attr($this->get_field_id('box2_image')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box2_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box2_title']); ?>" name="<?php echo esc_attr($this->get_field_name('box2_title')); ?>" id="<?php echo esc_attr($this->get_field_id('box2_title')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box2_content')); ?>"><?php esc_html_e('Nội dung', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box2_content']); ?>" name="<?php echo esc_attr($this->get_field_name('box2_content')); ?>" id="<?php echo esc_attr($this->get_field_id('box2_content')); ?>" />
            </p>
            <h4><?php _e('Box 3', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box3_image')); ?>"><?php esc_html_e('Hình ảnh(Link)', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box3_image']); ?>" name="<?php echo esc_attr($this->get_field_name('box3_image')); ?>" id="<?php echo esc_attr($this->get_field_id('box3_image')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box3_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box3_title']); ?>" name="<?php echo esc_attr($this->get_field_name('box3_title')); ?>" id="<?php echo esc_attr($this->get_field_id('box3_title')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box3_content')); ?>"><?php esc_html_e('Nội dung', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box3_content']); ?>" name="<?php echo esc_attr($this->get_field_name('box3_content')); ?>" id="<?php echo esc_attr($this->get_field_id('box3_content')); ?>" />
            </p>
            <h4><?php _e('Box 4', ''); ?></h4>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box4_image')); ?>"><?php esc_html_e('Hình ảnh(Link)', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box4_image']); ?>" name="<?php echo esc_attr($this->get_field_name('box4_image')); ?>" id="<?php echo esc_attr($this->get_field_id('box4_image')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box4_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box4_title']); ?>" name="<?php echo esc_attr($this->get_field_name('box4_title')); ?>" id="<?php echo esc_attr($this->get_field_id('box4_title')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('box4_content')); ?>"><?php esc_html_e('Nội dung', 'tried'); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['box4_content']); ?>" name="<?php echo esc_attr($this->get_field_name('box4_content')); ?>" id="<?php echo esc_attr($this->get_field_id('box4_content')); ?>" />
            </p>
        <?php
    }
}
