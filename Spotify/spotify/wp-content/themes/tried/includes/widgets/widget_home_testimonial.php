<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_testimonial extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_testimonial', 'Tried Home Testimonial',
			array(
				'classname' => 'widget_home_testimonial',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
		$defaults = array('title' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$testimonials = get_field('testimonials','widget_'.$args['widget_id']);
		$key = wp_generate_uuid4();
		echo $args['before_widget'];
			?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-testimonial" data-control="<?php echo $key; ?>">
				<h3 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h3>
				<div class="section-navbutton mwidth-main margin-auto">
					<div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
					<div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div>
				</div>
				<div class="section-wrapper margin-auto">
					<div class="swiper widget-home-testimonial">
						<div class="swiper-wrapper">
							<?php 
								if (!empty($testimonials)) :
									foreach ($testimonials as $testimonial) :
							?>
										<div class="testimonial-item swiper-slide">
											<div class="wrap">
												<div class="featured-image">
													<img src="<?php echo $testimonial['image']; ?>" alt="">
												</div>
												<div class="info-box">
													<h4 class="title"><?php echo $testimonial['title']; ?></h4>
													<h6 class="subtitle"><?php echo $testimonial['subtitle']; ?></h6>
													<p class="content"><?php echo $testimonial['content']; ?></p>
												</div>
											</div>
										</div>
							<?php
									endforeach;
								endif;
							?>
						</div>
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
		$defaults = array('title' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php
    }
}