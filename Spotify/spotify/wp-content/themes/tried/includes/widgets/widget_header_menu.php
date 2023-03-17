<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_menu extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_menu', 'Tried Header Menu',
			array(
				'classname' => 'widget_header_menu',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array('id_menu' => '', 'is_date' => '');
        $instance = wp_parse_args($instance, $defaults);
		$id_menu = $instance['id_menu'];
        $menu = wp_get_nav_menu_items($id_menu);
		$is_date = $instance['is_date'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-menu">
				<div class="section-wrapper margin-auto">
					<?php if ( $is_date ) : ?>
						<div class="date-block">
							<span class="date"><?php echo date("l, F d Y"); ?></span>
						</div>
					<?php endif; ?>
					<div class="menu-block">
						<?php
							if (!empty($menu)) :
								echo '<ul class="menu">';
								foreach ($menu as $item) :
									echo '<li class="item"><a href="'.$item->url.'" title="'.$item->title.'">'.$item->title.'</a></li>';
								endforeach;
								echo '</ul>';
							endif;
						?>
					</div>
			    </div>
			</section>
		<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['id_menu'] = !empty($new_instance['id_menu']) ? $new_instance['id_menu'] : '0';
		$instance['is_date'] = $new_instance['is_date'];
		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array('id_menu' => '', 'is_date' => '');
        $instance = wp_parse_args($instance, $defaults);
        $nav_menus = wp_get_nav_menus();
        ?>
			<?php if (!empty($nav_menus)) : ?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('id_menu')); ?>"><?php esc_html_e('Menu', 'tried'); ?></label>
					<select id="<?php echo esc_attr($this->get_field_id('id_menu')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('id_menu')); ?>" style="margin-top: 15px;">
						<?php foreach ($nav_menus as $menu) : ?>
							<option value="<?=$menu->term_id?>" <?php selected($menu->term_id, $instance['id_menu']); ?>><?=$menu->name ?></option>
						<?php endforeach; ?>
					</select>
				</p>
			<?php endif; ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('is_date')); ?>"><?php esc_html_e('Ngày tháng', 'tried'); ?></label>
				<input class="widefat" type="checkbox" value="true" name="<?php echo esc_attr($this->get_field_name('is_date')); ?>" id="<?php echo esc_attr($this->get_field_id('is_date')); ?>" <?php echo !empty($instance['is_date']) && (esc_attr($instance['is_date']) == 'true')?'checked':''; ?>/>
            </p>
        <?php
	}
}
