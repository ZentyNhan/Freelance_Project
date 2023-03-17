<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_recentform extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_recentform', 'Tried Footer Recent Form',
			array(
				'classname' => 'widget_footer_recentform',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array('title_recent' => '', 'title_form' => '', 'id_form' => '');
        $instance = wp_parse_args($instance, $defaults);

		$title_recent = $instance['title_recent'];
		$title_form = $instance['title_form'];
		$id_form = $instance['id_form'] ;

		// echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-recentform">
				<h4 class="section-title"><?php echo $title_recent; ?></h4>
				<div class="section-wrapper margin-auto recent">
                    <ul class="recents">
                        <?php 
                            $posts = get_posts(array (
                                'post_type' => 'post',
                                'orderby' => 'date',
                                'order'=> 'DESC', 
                                'post_status' => 'publish',
                                'posts_per_page' => 2
                            ));
                            if (!empty($posts)) :
                                foreach ($posts as $post) :
						?>
									<li>
										<h4 class="title"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h4>
										<span class="date"><?php echo get_the_date('M d, Y'); ?></span>
									</li>
						<?php
                                endforeach;
                            endif;
                        ?>
                    </ul>
			    </div>
				<h4 class="section-title"><?php echo $title_form; ?></h4>
				<div class="section-wrapper margin-auto form">
			    	<?php echo do_shortcode('[contact-form-7 id="'.$id_form.'"]') ?>
			    </div>
			</section>						
		<?php
		// echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['title_recent'] = strip_tags($new_instance['title_recent']);
		$instance['title_form'] = strip_tags($new_instance['title_form']);
		$instance['id_form'] = !empty($new_instance['id_form']) ? $new_instance['id_form'] : '0';
		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array('title_recent' => '', 'title_form' => '', 'id_form' => '');
        $instance = wp_parse_args($instance, $defaults);
        $cf7 = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'numberposts'   => -1
        ));
        ?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_recent')); ?>"><?php esc_html_e('Tiêu đề Recent', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_recent']); ?>" name="<?php echo esc_attr($this->get_field_name('title_recent')); ?>" id="<?php echo esc_attr($this->get_field_id('title_recent')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_form')); ?>"><?php esc_html_e('Tiêu đề Form', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_form']); ?>" name="<?php echo esc_attr($this->get_field_name('title_form')); ?>" id="<?php echo esc_attr($this->get_field_id('title_form')); ?>" />
			</p>
            <div style="margin-bottom: 5px; min-height: 25px;">
				<?php if (!empty($cf7)) : ?>
					<span style="width: 20%; float:left; line-height: 20px;"><?php _e('Form', ''); ?>:</span>
					<span style="float:left; : 70%; margin-left: 5%">
						<select id="<?php echo esc_attr($this->get_field_id('id_form')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('id_form')); ?>">
							<?php foreach ($cf7 as $it_7) : ?>
								<option value="<?=$it_7->ID?>" <?php selected($it_7->ID, $instance['id_form']); ?>><?=$it_7->post_title ?></option>
							<?php endforeach; ?>
						</select>
					</span>
				<?php endif; ?>
            </div>
        <?php
	}
}
