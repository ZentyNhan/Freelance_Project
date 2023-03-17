<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_member extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_member', 'Tried Home Member',
			array(
				'classname' => 'widget_home_member',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Đội ngũ chúng tôi', 'description' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$description = $instance['description'];
		$members = get_field('members','widget_'.$args['widget_id']);
		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-member" data-control="<?php echo $key; ?>">
				<div class="separater separater-block mwidth-main margin-auto"></div>
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h4>
				<?php if (!empty($description)) : ?>
					<p class="section-description"><?php echo $description; ?></p>
				<?php endif; ?>
				<div class="section-wrapper margin-auto">
					<?php if (!empty($members)) : ?>
						<div class="swiper widget-home-member">
							<div class="swiper-wrapper">
								<?php foreach ($members as $member) : ?>
									<div class="swiper-slide member-item">
										<div class="wrapper">
											<div class="featured-image">
												<?php
													$photo = get_theme_file_uri( "/assets/img/placeholder.png" );
													if (!empty($member['photo'])) {
														$photo = $member['photo'];
													}
												?>
												<img src="<?php echo $photo; ?>" alt="">
												<div class="socials">
													<?php if (!empty($member['socials']['facebook'])) : ?>
														<a href="<?php echo $member['socials']['facebook']; ?>" class="item facebook fab fa-facebook-f"></a>
													<?php endif; ?>
													<?php if (!empty($member['socials']['twitter'])) : ?>
														<a href="<?php echo $member['socials']['twitter']; ?>" class="item twitter fab fa-twitter"></a>
													<?php endif; ?>
													<?php if (!empty($member['socials']['linkedin'])) : ?>
														<a href="<?php echo $member['socials']['linkedin']; ?>" class="item linkedin fab fa-linkedin-in"></a>
													<?php endif; ?>
													<?php if (!empty($member['socials']['instagram'])) : ?>
														<a href="<?php echo $member['socials']['instagram']; ?>" class="item instagram fab fa-instagram"></a>
													<?php endif; ?>
												</div>
											</div>
											<div class="info-block">
												<div class="name"><?php echo $member['name']; ?></div>
												<p class="subname"><?php echo $member['subname']; ?></p>
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
	    $defaults = array('title' => 'Đội ngũ chúng tôi', 'description' => '');
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
