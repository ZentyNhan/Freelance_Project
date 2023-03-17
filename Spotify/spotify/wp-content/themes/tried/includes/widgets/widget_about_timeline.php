<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_about_timeline extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_about_timeline', 'Tried About Timeline',
			array(
				'classname' => 'widget_about_timeline',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Timeline');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
        $timelines = get_field('timelines','widget_'.$args['widget_id']);
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-about-timeline">
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h4>
				<div class="section-wrapper margin-auto">
                    <div class="timelines">
                        <?php
                            if (!empty($timelines)) :
                                foreach ($timelines as $item) :
                        ?>
                                <div class="item">
                                    <div class="time"><?php echo $item['time']; ?></div>
                                    <div class="content">
                                        <h4 class="title"><?php echo $item['title']; ?></h4>
                                        <p class="content"><?php echo $item['content']; ?></p>
                                    </div>
                                </div>
                        <?php
                                endforeach;
                            endif;
                        ?>
                    </div>
			    </div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array('title' => 'Timeline');
        $instance = wp_parse_args($instance, $defaults);
		?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
            </p>
   	    <?php
    }
}
