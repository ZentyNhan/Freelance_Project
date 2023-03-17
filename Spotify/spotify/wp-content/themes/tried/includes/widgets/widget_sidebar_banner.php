<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_sidebar_banner extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_sidebar_banner', 'Tried Sidebar Banner',
			array(
				'classname' => 'widget_sidebar_banner',
				'description' => esc_html__('Sidebar Banner', 'tried'),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array(
            'title' => __('Giới thiệu',' tried'), 'content' => '', 'link' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$content = $instance['content'];
		$link = $instance['link'];
		echo $args['before_widget'];
		?>
            <section id="section-<?php echo $args['widget_id']; ?>" class="section-sidebar-banner">
                <div class="section-wrapper">
                    <div class="sidebarbanner-block">
                        <h4 class="title-highlight"><span><?php echo $title; ?></span></h4>
                        <a href="<?php echo $link; ?>" title="">
                            <div class="banner"><?php echo $content; ?></div>
                        </a>
                    </div>
                </div>
            </section>
		<?php
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = $new_instance['title'];
		$instance['content'] = $new_instance['content'];
		$instance['link'] = $new_instance['link'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
            'title' => __('Giới thiệu',' tried'), 'content' => '', 'link' => ''
        );
		$instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="3" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('link')); ?>"><?php esc_html_e('Liên kết', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['link']); ?>" name="<?php echo esc_attr($this->get_field_name('link')); ?>" id="<?php echo esc_attr($this->get_field_id('link')); ?>" />
			</p>
        <?php
	}
}
