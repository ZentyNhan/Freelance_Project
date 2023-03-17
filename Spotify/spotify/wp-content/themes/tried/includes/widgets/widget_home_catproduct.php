<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_catproduct extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_catproduct', 'Tried Home Cat Product',
			array(
				'classname' => 'widget_home_catproduct',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Danh mục sản phẩm');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$categories = get_field('categories','widget_'.$args['widget_id']);
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-catproduct">
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title'];?></h4>
				<div class="section-wrapper">
					<div class="category-block">
						<div class="categories">
							<?php
								if (!empty($categories)) :
									foreach ($categories as $category) :
							?>
										<div class="category-item">
											<div class="bg-wrap">
												<?php if (!empty($category['image'])) : ?>
													<img src="<?php echo $category['image']; ?>" alt="">
												<?php endif; ?>
											</div>
											<div class="info-wrap">
												<h4 class="title"><?php echo $category['title']; ?></h4>
												<ul class="list">
													<?php
														if (!empty($category['list'])) :
															foreach ($category['list'] as $item) :
																echo '<li><a href="'.$item['link'].'">'.$item['name'].'</a></li>';
															endforeach;
														endif;
													?>
												</ul>
												<a class="viewmore" href="<?php echo $category['viewmore']; ?>"><?php _e('Xem thêm', 'tried'); ?></a>
											</div>
										</div>
							<?php 
									endforeach;
								else :
									_e( 'Không tìm thấy sản phẩm', 'tried' );
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
	    $defaults = array('title' => 'Danh mục sản phẩm');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php
    }
}
