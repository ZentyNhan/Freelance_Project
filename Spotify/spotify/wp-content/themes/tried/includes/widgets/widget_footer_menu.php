<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_menu extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_menu', 'Tried Footer Menu',
			array(
				'classname' => 'widget_footer_menu',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array('title' => 'Menu Footer', 'id_menu' => '');
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$id_menu = $instance['id_menu'];
        $menu = wp_get_nav_menu_items($id_menu);
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-menu">
				<h4 class="section-title"><?php echo $args['before_title'].$title.$args['after_title']; ?></h4>
				<div class="section-wrapper">
                    <?php
                        if (!empty($menu)) :
                            echo '<ul class="menu">';
                            foreach ($menu as $item) :
                    ?>
                                <li class="item"><a href="<?php echo $item->url; ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></li>
                    <?php
                            endforeach;
                            echo '</ul>';
                        endif;
                    ?>
			    </div>
			</section>						
		<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['id_menu'] = !empty($new_instance['id_menu']) ? $new_instance['id_menu'] : '0';
		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array('title' => 'Menu Footer', 'id_menu' => '');
        $instance = wp_parse_args($instance, $defaults);
        $nav_menus = wp_get_nav_menus();
        ?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
            <div style="margin-bottom: 5px; min-height: 25px;">
				<?php if (!empty($nav_menus)) : ?>
					<span style="width: 20%; float:left; line-height: 20px;"><?php _e('Menu', ''); ?>:</span>
					<span style="float:left; : 70%; margin-left: 5%">
						<select id="<?php echo esc_attr($this->get_field_id('id_menu')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('id_menu')); ?>">
							<?php foreach ($nav_menus as $menu) : ?>
								<option value="<?=$menu->term_id?>" <?php selected($menu->term_id, $instance['id_menu']); ?>><?=$menu->name ?></option>
							<?php endforeach; ?>
						</select>
					</span>
				<?php endif; ?>
            </div>
        <?php
	}
}
