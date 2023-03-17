<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_menusocial extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_menusocial', 'Tried Footer Menu Social',
			array(
				'classname' => 'widget_footer_menusocial',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array('title_menu' => '', 'id_menu' => '', 'title_social' => '', 'description_social' => '', 'social_facebook' => '', 'social_instagram' => '', 'social_youtube' => '', 'social_twitter' => '');
        $instance = wp_parse_args($instance, $defaults);

		$title_menu = $instance['title_menu'];
		$id_menu = $instance['id_menu'];
        $menu = wp_get_nav_menu_items($id_menu);
		$title_social = $instance['title_social'];
		$description_social = $instance['description_social'];
		$social_facebook = $instance['social_facebook'];
		$social_instagram = $instance['social_instagram'];
		$social_youtube = $instance['social_youtube'];
		$social_twitter = $instance['social_twitter'];
		// echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-menusocial">
				<h4 class="section-title"><?php echo $title_menu; ?></h4>
				<div class="section-wrapper margin-auto nav">
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
				<h4 class="section-title"><?php echo $title_social; ?></h4>
                <div class="section-wrapper margin-auto social">
                    <p class="description"><?php echo $description_social; ?></p>
					<ul class="socials">
						<?php if (!empty($social_facebook)) : ?>
							<li class="item facebook">
								<a href="<?php echo $social_facebook; ?>" title=""><i class="fab fa-facebook-f"></i></a>
							</li>
						<?php endif; ?>
						<?php if (!empty($social_instagram)) : ?>
							<li class="item instagram">
								<a href="<?php echo $social_instagram; ?>" title=""><i class="fab fa-instagram"></i></a>
							</li>
						<?php endif; ?>
						<?php if (!empty($social_youtube)) : ?>
							<li class="item youtube">
								<a href="<?php echo $social_youtube; ?>" title=""><i class="fab fa-youtube"></i></a>
							</li>
						<?php endif; ?>
						<?php if (!empty($social_twitter)) : ?>
							<li class="item twitter">
								<a href="<?php echo $social_twitter; ?>" title=""><i class="fab fa-twitter"></i></a>
							</li>
						<?php endif; ?>
                    </ul>
                </div>
			</section>						
		<?php
		// echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['title_menu'] = strip_tags($new_instance['title_menu']);
		$instance['id_menu'] = !empty($new_instance['id_menu']) ? $new_instance['id_menu'] : '0';
		$instance['title_social'] = strip_tags($new_instance['title_social']);
		$instance['description_social'] = strip_tags($new_instance['description_social']);
		$instance['social_facebook'] = ($new_instance['social_facebook']);
		$instance['social_instagram'] = ($new_instance['social_instagram']);
		$instance['social_youtube'] = ($new_instance['social_youtube']);
		$instance['social_twitter'] = ($new_instance['social_twitter']);
		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array('title_menu' => '', 'id_menu' => '', 'title_social' => '', 'description_social' => '', 'social_facebook' => '', 'social_instagram' => '', 'social_youtube' => '', 'social_twitter' => '');
        $instance = wp_parse_args($instance, $defaults);
        $nav_menus = wp_get_nav_menus();
        ?>
            <h5><?php esc_html_e('Menu', ''); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_menu')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_menu']); ?>" name="<?php echo esc_attr($this->get_field_name('title_menu')); ?>" id="<?php echo esc_attr($this->get_field_id('title_menu')); ?>" />
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
			<h5><?php esc_html_e('Mạng xã hội', ''); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_social')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_social']); ?>" name="<?php echo esc_attr($this->get_field_name('title_social')); ?>" id="<?php echo esc_attr($this->get_field_id('title_social')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('description_social')); ?>"><?php esc_html_e('Mô tả', ''); ?></label>
				<textarea class="widefat" rows="2" name="<?php echo esc_attr($this->get_field_name('description_social')); ?>" id="<?php echo esc_attr($this->get_field_id('description_social')); ?>"><?php echo esc_attr($instance['description_social']); ?></textarea>
			</p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>"><?php esc_html_e('Facebook', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_facebook']); ?>" name="<?php echo esc_attr($this->get_field_name('social_facebook')); ?>" id="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>"><?php esc_html_e('Instagram', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_instagram']); ?>" name="<?php echo esc_attr($this->get_field_name('social_instagram')); ?>" id="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>"><?php esc_html_e('Youtube', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_youtube']); ?>" name="<?php echo esc_attr($this->get_field_name('social_youtube')); ?>" id="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>"><?php esc_html_e('Twitter', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_twitter']); ?>" name="<?php echo esc_attr($this->get_field_name('social_twitter')); ?>" id="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>" />
            </p>
        <?php
	}
}
