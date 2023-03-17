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
							elseif ( is_single()) :
								if (get_post_type() == 'dich-vu') :
						?>
									<div class="single-blog">
										<div class="wrap service">
											<div class="sidebar">
												<div class="block all-service">
													<?php echo do_shortcode('[show_services]'); ?>
												</div>
												<div class="block contact-service">
													<?php echo do_shortcode('[show_contact_service]'); ?>
												</div>
											</div>
											<div class="content">
												<?php
													if (has_post_thumbnail( $post->ID ) ):
														$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
														$image = get_theme_file_uri( "/assets/img/placeholder.png" );
														if (!empty($image_url[0])) {
															$image = $image_url[0];
														}
														$author_id = get_post_field ('post_author', $cause_id);
														$display_name = get_the_author_meta( 'display_name' , $author_id ); 
												?>
														<div class="featured-image">
															<img src="<?php echo $image; ?>" alt="">
														</div>
														<ul class="meta">
															<li class="author">
																<i class="far fa-user"></i>
																<?php echo $display_name; ?>
															</li>
															<li class="date">
																<i class="far fa-clock"></i>
																<?php echo get_the_date('M d, Y'); ?>
															</li>
														</ul>
												<?php
													endif;
												?>
												<div class="expert"><?php echo get_the_content(); ?></div>
											</div>
										</div>
									</div>
                    	<?php 
								else :
						?>
									<div class="single-blog">
										<div class="wrap">
											<div class="content">
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
														<ul class="meta">
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
												<?php
													endif;
													echo '<div class="expert">'.get_the_content().'</div>';
												?>
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
															$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
															$image = get_theme_file_uri( "/assets/img/placeholder.png" );
															if (!empty($image_url[0])) {
																$image = $image_url[0];
															}
															$terms = get_the_terms( $post->ID, 'category' );
						?>
															<div class="blog-item swiper-slide">
																<div class="wrap">
																	<div class="featured-image">
																		<a href="<?php echo get_permalink($post->ID); ?>" title=""><img src="<?php echo $image; ?>" alt=""></a>
																	</div>
																	<div class="box-contain">
																		<h5 class="title"><?php echo get_the_title($post->ID); ?></h5>
																		<ul class="meta">
																			<li class="date">
																				<i class="far fa-calendar-alt"></i>
																				<span><?php echo get_the_date('M d, Y'); ?></span>
																			</li>
																			<?php if (!empty($terms)) : ?>
																				<li class="terms">
																					<i class="fas fa-folder"></i>
																					<span><?php echo $terms[0]->name; ?></span>
																				</li>
																			<?php endif; ?>
																		</ul>
																		<p class="content"><?php echo get_the_excerpt($post->ID); ?></p>
																		<div class="view">
																			<a href="<?php echo get_permalink($post->ID); ?>" title=""><?php _e('Xem thêm', ''); ?></a>
																		</div>
																	</div>
																</div>
															</div>
						<?php
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
