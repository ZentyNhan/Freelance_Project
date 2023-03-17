<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

while ( have_posts() ) :
	the_post();
	?>
		<main <?php post_class( 'site-main' ); ?> role="main">
			<div class="main-contain single">
				<div class="wrapper">
					<div class="page-content">
						<?php 
							if ( is_front_page() || is_home() ) :
								dynamic_sidebar('home_page');
							elseif ( is_single() && !( class_exists( 'WooCommerce' ) && is_woocommerce() ) ) :
								if (get_post_type() == 'dich-vu') :
									// coding
								else :
						?>
									<div class="single-blog">
										<div class="wrap">
											<div class="content">
												<div class="info-meta">
													<h3 class="blog-title"><?php echo get_the_title($post->ID); ?></h3>
													<ul class="blog-meta">
														<li class="author far fa-user">
															<?php echo get_the_author_meta('display_name', $post->post_author); ?>
														</li>
														<li class="date far fa-clock">
															<?php echo get_the_date('M d, Y'); ?>
														</li>
														<li class="term far fa-file-alt">
															<?php 
																$terms = get_the_terms( $post->ID, 'category' );
																if (!empty($terms)) :
																	foreach ($terms as $term) :
																		echo '<span>'.$term->name.'</span>';
																	endforeach;
																endif;
															?>
														</li>
													</ul>
												</div>
												<?php
													if (has_post_thumbnail( $post->ID ) ):
														$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
														$image = get_theme_file_uri( "/assets/img/placeholder.png" );
														if (!empty($image_url[0])) {
															$image = $image_url[0];
														}
												?>
														<div class="featured-image">
															<img src="<?php echo $image; ?>" alt="">
														</div>
												<?php
													endif;
												?>
												<div class="expert"><?php echo get_the_content(); ?></div>
											</div>
											<div class="sidebar">
												<div class="block">
													<?php echo do_shortcode('[search_post]'); ?>
												</div>
												<div class="block">
													<?php echo do_shortcode('[show_categories]'); ?>
												</div>
												<div class="block">
													<?php echo do_shortcode('[show_recent_posts]'); ?>
												</div>
											</div>
										</div>
										<div class="related-blog">
											<h3 class="title"><?php _e('Bài viết tương tự', ''); ?></h3>
											<div class="blogs">
						<?php 
												$posts = get_posts(array (
													'post_type' => get_post_type(),
													'orderby' => 'date',
													'order'=> 'DESC', 
													'post_status' => 'publish',
													'posts_per_page' => 5,
													'category__in' => wp_get_post_categories( get_the_ID() )
												));
												if (!empty($posts)) :
													$key = wp_generate_uuid4();
						?>
													<div class="swiper widget-single-relate" data-control="<?php echo $key; ?>">
														<div class="swiper-wrapper">
						<?php
														foreach ($posts as $post) :
                                            				get_template_part('template-parts/blog-item/item', null, array( 'id' => $post->ID, 'slide' => true ) );
														endforeach;
						?>
														</div>
													</div>
						<?php
												else :
						?>
													<p class="no-result"><?php _e('Xin lỗi, không có kết quả trả về', ''); ?></p>
						<?php
												endif;
												wp_reset_postdata();
						?>
											</div>
										</div>
									</div>
						<?php
								endif;
							else :
						?>
								<div class="page-block">
									<div class="content">
										<?php
											the_content();
										?>
									</div>
								</div>
						<?php
							endif;
						?>
					</div>
				</div>
			</div>
		</main>
	<?php
endwhile;
