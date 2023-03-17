<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_product extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_product', 'Tried Home Product',
			array(
				'classname' => 'widget_home_product',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Sản phẩm nổi bật');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		wp_enqueue_style( 'tried-product-item' );
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-product">
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title'];?></h4>
				<div class="section-wrapper">
					<div class="products">
						<?php
							$products = new WP_Query(array(
								'post_type' => 'product',
								'posts_per_page' => 8
							));
							if ( $products->have_posts() ) :
								while ( $products->have_posts() ) :
									$products->the_post();
									global $post, $product;
									$image_url  = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );
									$image = get_theme_file_uri( "/assets/img/placeholder.png" );
									if (!empty($image_url[0])) {
										$image = $image_url[0];
									}
						?>
										<div class="product-item">
											<div class="box">
												<div class="feature-image">
													<a href="<?php echo get_permalink($product->ID); ?>">
														<img src="<?php echo $image; ?>" alt="">
													</a>
												</div>
												<div class="info-wrap">
													<h3 class="title"><a href="<?php echo get_permalink($product->ID); ?>"><?php echo get_the_title($product->ID); ?></a></h3>
                                                    <div class="extra">
                                                        <?php
                                                            $_product = wc_get_product( $post->ID );
                                                            if (!empty($_product->get_price_html())) :
                                                                echo '<p class="price">'.$_product->get_price_html().'</p>';
                                                            else :
                                                                echo '<p class="no-price"><span>'.__('Liên hệ', 'tried').'</span></p>';
                                                            endif;
					                                    ?>
                                                    </div>
												</div>
											</div>
										</div>
						<?php
								endwhile;
								wp_reset_postdata();
							else :
								_e( 'Không tìm thấy sản phẩm', 'tried' );
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
		$instance['title'] = ($new_instance['title']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => 'Sản phẩm nổi bật');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php
    }
}
