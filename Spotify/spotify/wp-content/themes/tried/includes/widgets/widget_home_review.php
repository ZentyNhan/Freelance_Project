<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_review extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_review', 'Tried Home Review',
			array(
				'classname' => 'widget_home_review',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Đánh giá khách hàng', 'description' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$description = $instance['description'];
		$background = get_field('background','widget_'.$args['widget_id']);
		$reviews = get_field('reviews','widget_'.$args['widget_id']);
		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-review" data-control="<?php echo $key; ?>">
				<?php if (!empty($background)) : ?>
					<div class="background-overlay" style="background-image: url(<?php echo $background; ?>);"></div>
				<?php endif; ?>
				<div class="separater separater-block mwidth-main margin-auto"></div>
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h4>
				<?php if (!empty($description)) : ?>
					<p class="section-description"><?php echo $description; ?></p>
				<?php endif; ?>
				<div class="section-wrapper margin-auto">
					<?php if (!empty($reviews)) : ?>
						<div class="swiper widget-home-review">
							<div class="swiper-wrapper">
								<?php foreach ($reviews as $review) : ?>
									<div class="swiper-slide review">
										<div class="box">
											<div class="title margin-auto"><?php echo $review['title']; ?></div>
											<p class="content"><?php echo $review['content']; ?></p>
											<div class="author">
												<img class="avatar" src="<?php echo $review['avatar']; ?>" alt="">
												<div class="info">
													<h4 class="name"><?php echo $review['name']; ?></h4>
													<h6 class="subject"><?php echo $review['subname']; ?></h6>
													<div class="rating">
														<?php
															for ($i = 0; $i < 5; $i++) :
																if ($i >= $review['rating']) :
																	echo '<span class="far fa-star"></span>';
																	continue;
																endif;
																echo '<span class="fas fa-star"></span>';
															endfor;
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="swiper-pagination"></div>
						<!-- <div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
						<div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div> -->
					<?php endif; ?>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['description'] = ($new_instance['description']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => 'Đánh giá khách hàng', 'description' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Mô tả', ''); ?></label>
				<textarea class="widefat" rows="4" name="<?php echo esc_attr($this->get_field_name('description')); ?>" id="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
			</p>
		<?php
    }
}
