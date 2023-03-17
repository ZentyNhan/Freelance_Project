<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_service extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_service', 'Tried Home Service',
			array(
				'classname' => 'widget_home_service',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array();
        $instance = wp_parse_args($instance, $defaults);
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-service">
				<div class="section-wrapper margin-auto">
					<div class="services">
							<?php 
								$services = get_posts(array (
									'post_type' => 'dich-vu',
									'orderby' => 'date',
									'order'=> 'DESC', 
									'post_status' => 'publish',
									'posts_per_page' => 6
								));
								if (!empty($services)) :
									foreach ($services as $s => $service) :
										$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $service->ID ), 'full' );
										$image = get_theme_file_uri( "/assets/img/placeholder.png" );
										if (!empty($image_url[0])) {
											$image = $image_url[0];
										}
							?>
										<div class="service-item <?php echo ($s == 0)?'special':''; ?>" data-taget="<?php echo $s; ?>" style="width: <?php echo $config_grid[$s]; ?>%;">
                                            <div class="wrap">
                                                <div class="featured-image">
                                                    <img src="<?php echo $image; ?>" alt="">
                                                </div>
                                                <div class="box-contain">
													<a href="<?php echo get_permalink($service->ID); ?>">
														<h5 class="title"><?php echo get_the_title($service->ID); ?></h5>
                                                    	<p class="content"><?php echo get_the_excerpt($service->ID); ?></p>
													</a>
											    </div>
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
		return $instance;
	}

	function form($instance) {
		$defaults = array();
		$instance = wp_parse_args($instance, $defaults);
	}
}
