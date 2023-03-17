<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_slider extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_slider', 'Tried Home Slider',
			array(
				'classname' => 'widget_home_slider',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	public function widget( $args, $instance ){
		extract($args);
		$sliders = get_field('sliders','widget_'.$args['widget_id']);
		$infoboxs = get_field('infoboxs','widget_'.$args['widget_id']);
		$infoboxs_cols = !empty($infoboxs['item_4']['title'])?4:3;
		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-slider full" data-control="<?php echo $key; ?>">
				<div class="section-wrapper">
					<div class="swiper widget-home-slider">
						<div class="swiper-wrapper">
							<?php
								if(!empty($sliders)):
									foreach( $sliders as $slider ): 
										?>
										<div class="swiper-slide box">
											<div class="background-overlay">
												<img src="<?php echo $slider['image']; ?>" alt="">
											</div>
											<div class="box-content mwidth-main margin-auto" data-reverse="<?php echo $slider['reverse']?$slider['reverse']:'0'; ?>">
												<div class="wrapper">
													<h5 class="subtitle"><?php echo $slider['subtitle']; ?></h5>
													<h3 class="title"><?php echo $slider['title']; ?></h3>
													<p class="content"><?php echo $slider['content']; ?></p>
													<?php if (!empty( $slider['viewmore'] ) ) : ?>
														<div class="more">
															<a href="<?php echo $slider['viewmore']; ?>" class="viewmore"><i class="far fa-shield-alt"></i><?php _e('Xem thêm', 'tried'); ?></a>
														</div>
													<?php endif; ?>
												</div>
											</div>	
										</div>
										<?php
									endforeach;
								endif; 
							?>
						</div>
						<!-- <div class="swiper-pagination"></div> -->
						<div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
						<div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div>
					</div>
				</div>
			</section>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$default = array();
		$instance = wp_parse_args( (array) $instance, $default );
	}

	public function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		return $instance;
	}
}