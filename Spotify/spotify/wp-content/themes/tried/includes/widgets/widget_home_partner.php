<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_partner extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_partner', 'Tried Home Partner',
			array(
				'classname' => 'widget_home_partner',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
		$defaults = array();
        $instance = wp_parse_args($instance, $defaults);
		$partners = get_field('partners','widget_'.$args['widget_id']);
		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-partner" data-control="<?php echo $key; ?>">
				<div class="section-wrapper margin-auto">
					<div class="swiper widget-home-partner">
						<div class="swiper-wrapper">
							<?php 
								if (!empty($partners)) :
									foreach ($partners as $partner) :
							?>
										<div class="partner-item swiper-slide">
											<div class="wrap">
												<a href="<?php echo $partner['link']; ?>">
													<img src="<?php echo $partner['image']; ?>" alt="">
												</a>
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
        return $instance;
    }

    function form($instance) {
		$defaults = array();
        $instance = wp_parse_args($instance, $defaults);
    }
}