<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_workinghours extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_workinghours', 'Tried Footer Working Hours',
			array(
				'classname' => 'widget_footer_workinghours',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => '', 'content' => '');
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$content = $instance['content'];
        $hours = get_field('hours','widget_'.$args['widget_id']);
		// echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-workinghours">
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h4>
				<div class="section-wrapper margin-auto">
                    <p class="content"><?php echo $content; ?></p>
                    <table class="hours">
                        <tbody>
                            <?php
                                if (!empty($hours)) :
                                    foreach ($hours as $item) :
                            ?>
                                        <tr>
                                            <th <?php echo $item['highlight']?'class="highlight"':''; ?>><?php echo $item['weekday']; ?></th>
                                            <th><?php echo $item['hour']; ?></th>
                                        </tr>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </tbody>
                    </table>
			    </div>
			</section>
        <?php
		// echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array('title' => '', 'content' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
            </p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="2" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
   	    <?php
    }
}
