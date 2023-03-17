<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// add_shortcode('shortcode_pattern', 'sc_shortcode_pattern');
// function sc_shortcode_pattern() {
//     ob_start();
    
//     $result = ob_get_contents();
//     ob_end_clean();
//     return $result;
// }

add_shortcode('search_product', 'sc_search_product');
function sc_search_product() {
    ob_start();
	?>
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="hidden" name="post_type" value="product">
			<input type="search" class="search-field" placeholder="<?php _e( 'Nhập từ khóa...', 'tried' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<button type="submit" class="search-submit"><i aria-hidden="true" class="fas fa-search"></i></button>
		</form>
	<?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}

add_shortcode('show_product_categories', 'sc_show_product_categories');
function sc_show_product_categories() {
	$taxonomy     = 'product_cat';
	$order        = 'DESC';
	$orderby      = 'count';  
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no  
	$title        = '';
	
	$args = array(
		'taxonomy'     => $taxonomy,
		'orderby'      => $orderby,
		'order'        => $order,
		'show_count'   => $show_count,
		'pad_counts'   => $pad_counts,
		'hierarchical' => $hierarchical,
		'title_li'     => $title,
		'hide_empty'   => true,
	);
	$all_categories = get_categories( $args );
	if (!empty($all_categories)) {
		echo '<h4>'.__('Danh mục sản phẩm', 'tried').'</h4>';
		echo '<ul class="categories">';
		echo '<li><a href="'. get_permalink( wc_get_page_id( 'shop' ) ) .'">'. __('Tất cả', 'tried') .'</a><span class="count">-</span></li>';
		foreach ($all_categories as $k => $cat) {
			if($cat->category_parent == 0 && $k <= 12) {
				$category_id = $cat->term_id;       
				echo '<li><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a><span class="count">('.$cat->category_count.')</span></li>';
				$args2 = array(
						'taxonomy'     => $taxonomy,
						'child_of'     => 0,
						'parent'       => $category_id,
						'orderby'      => $orderby,
						'show_count'   => $show_count,
						'pad_counts'   => $pad_counts,
						'hierarchical' => $hierarchical,
						'title_li'     => $title,
						'hide_empty'   => true
				);
				$sub_cats = get_categories( $args2 );
				if(!empty($sub_cats)) {
					foreach($sub_cats as $sub_category) {
						echo '<li><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a><span class="count">('.$sub_category->category_count.')</span></li>';
					}   
				}
			}       
		}
		echo '</ul>';
	}
	$html = '';
	return $html;
}

add_shortcode('show_recent_products', 'sc_show_recent_products');
function sc_show_recent_products() {
    ob_start();
	$args = array(
        'post_type'      => 'product',
        'posts_per_page' => 6,
		'orderby' => 'date',
		'order' => 'desc'
    );
    $products = new WP_Query( $args );
	if ($products) :
		echo '<h4>'.__('Sản phẩm mới nhất', '').'</h4>';
		echo '<ul class="recent-products">';
		while ( $products->have_posts() ) :
			$products->the_post();
			global $product;
			echo '<li><a href="'. get_permalink() .'">' . woocommerce_get_product_thumbnail().'<div><h5 class="name">'.get_the_title().'</h5><div class="price">'.(!empty($product->get_price_html())?$product->get_price_html():'<span class="text-contact">Liên hệ</span>').'</div></div></a></li>';
		endwhile;
		echo '</ul>';
	endif;
    wp_reset_query();
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}


add_shortcode('search_post', 'sc_search_post');
function sc_search_post() {
    ob_start();
	?>
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="hidden" name="post_type" value="post">
			<input type="search" class="search-field" placeholder="<?php _e( 'Nhập từ khóa...', 'tried' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<button type="submit" class="search-submit"><i aria-hidden="true" class="fas fa-search"></i></button>
		</form>
	<?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}

add_shortcode('show_categories', 'sc_show_categories');
function sc_show_categories() {
	$taxonomy     = (get_post_type() == 'post')?'category':'du-an_cat';
	$orderby      = 'name';  
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no  
	$title        = '';

	$args = array(
		'taxonomy'     => $taxonomy,
		'orderby'      => $orderby,
		'show_count'   => $show_count,
		'pad_counts'   => $pad_counts,
		'hierarchical' => $hierarchical,
		'title_li'     => $title,
		'hide_empty'   => true
	);
	$all_categories = get_categories( $args );
	if (!empty($all_categories)) {
		$postType = get_post_type_object(get_post_type());
		$namepostType = __( 'Tin', 'tried' );
		if ($postType) {
			$namepostType = $postType->labels->singular_name;
		}
		echo '<h4>'.__( 'Loại', 'tried' ).' '.$namepostType.'</h4>';
		echo '<ul class="categories">';
		echo '<li><a href="'. get_post_type_archive_link( get_post_type() ) .'">'. __('Tất cả', 'tried') .'</a><span class="count">-</span></li>';
		foreach ($all_categories as $k => $cat) {
			if($cat->category_parent == 0 && $k <= 12) {
				$category_id = $cat->term_id;       
				echo '<li><a href="'. get_term_link($cat->slug, $taxonomy) .'">'. $cat->name .'</a><span class="count">('.$cat->category_count.')</span></li>';
				$args2 = array(
						'taxonomy'     => $taxonomy,
						'child_of'     => 0,
						'parent'       => $category_id,
						'orderby'      => $orderby,
						'show_count'   => $show_count,
						'pad_counts'   => $pad_counts,
						'hierarchical' => $hierarchical,
						'title_li'     => $title,
						'hide_empty'   => true
				);
				$sub_cats = get_categories( $args2 );
				if(!empty($sub_cats)) {
					foreach($sub_cats as $sub_category) {
						echo '<li><a href="'. get_term_link($sub_category->slug, $taxonomy) .'">'. $sub_category->name .'</a><span class="count">('.$sub_category->category_count.')</span></li>';
					}   
				}
			}       
		}
		echo '</ul>';
	}
	$html = '';
	return $html;
}

add_shortcode('show_recent_posts', 'sc_show_recent_posts');
function sc_show_recent_posts() {
    ob_start();
	$args = array(
        'post_type' => get_post_type(),
        'posts_per_page' => 4,
		'orderby' => 'date',
		'order' => 'desc'
    );
    $post = new WP_Query( $args );
	if (!empty($post)) :
		$postType = get_post_type_object(get_post_type());
		$namepostType = __( 'Tin', 'tried' );
		if ($postType) {
			$namepostType = $postType->labels->singular_name;
		}
		echo '<h4>'.$namepostType.' '.__( 'mới nhất', 'tried' ).'</h4>';
		echo '<ul class="recent-posts">';
		while ( $post->have_posts() ) :
			$post->the_post();
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$image = get_theme_file_uri( "/assets/img/placeholder.png" );
			if (!empty($image_url[0])) {
				$image = $image_url[0];
			}
			echo '<li><a href="'. get_permalink() .'"><img src="'.$image.'" alt=""><div><h5 class="name">'.get_the_title().'</h5><div class="date"><span>'.get_the_date('M d, Y').'</span></div></div></a></li>';
		endwhile;
		echo '</ul>';
	endif;
    wp_reset_query();
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}

// service
add_shortcode('show_services', 'sc_show_services');
function sc_show_services() {
	$services = get_posts(array (
		'post_type' => 'dich-vu',
		'orderby' => 'date',
		'order'=> 'DESC', 
		'post_status' => 'publish',
		'posts_per_page' => 6
	));
	if (!empty($services)) {
		echo '<h4>'.__('Tất cả dịch vụ', 'tried').'</h4>';
		echo '<ul class="services">';
		echo '<li><a href="'. get_post_type_archive_link( get_post_type() ) .'">'. __('Tất cả', 'tried') .'</a></li>';
		foreach ($services as $service) {
			echo '<li><a href="'. get_permalink($service->ID) .'">'.get_the_title($service->ID).'</a></li>'; 
		}
		echo '</ul>';
	}
	$html = '';
	return $html;
}

add_shortcode('fileupload_attachment', 'sc_fileupload_attachment');
function sc_fileupload_attachment( $atts = array(), $content = null ) {
    ob_start();
    $args = shortcode_atts( 
		array(
			'media' => array()
		),
	$atts );
	$media_ids = '';
	if ( !empty( $args['media'] ) ) {
		$media_ids = explode( '-', $args['media'] );
	}
	$generate_key = wp_generate_uuid4();
	?>
		<div id="upload_attachment_wapper">
			<div class="attach_link_or_browse fileupload-block <?php echo $generate_key; ?>" id="attach_link_or_browse">
				<input type="hidden" name="fileupload_browses" value="<?php echo $args['media']; ?>">
				<div class="drop-uploader">
					<div class="browse-wrapper">
						<a href="javascript:void(0)" id="file-browse" data-order="<?php echo $generate_key; ?>">
							<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#9b9b9b">
								<path d="M0 0h24v24H0V0z" fill="none"/>
								<path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4 0-2.05 1.53-3.76 3.56-3.97l1.07-.11.5-.95C8.08 7.14 9.94 6 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5 1.53.11c1.56.1 2.78 1.41 2.78 2.96 0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z"/>
							</svg>
							<?php _e( 'Mở Gallery', 'tried' ); ?>
						</a>
					</div>
				</div>
				<div class="fileupload-list">
					<?php
						if ( !empty( $media_ids ) ) :
							foreach ( $media_ids as $media_id ) :
								$attachment_image_src = wp_get_attachment_image_src( $media_id, 'full' );
								$filename = pathinfo( $attachment_image_src[0], PATHINFO_FILENAME ); // to get file name
								$fileext = pathinfo( $attachment_image_src[0], PATHINFO_EXTENSION ); // to get extension
					?>
							<div class="item" data-type="file" data-value="<?php echo $media_id; ?>">
								<div class="content">
									<img src="<?php echo $attachment_image_src[0]; ?>" alt="'+file_title+'" width="80">
									<p class="title"><?php echo ( ( strlen( $filename ) > 15 )?substr( $filename, 0, 15 ).'...':$filename ).'.'.$fileext; ?></p>
									<span class="size">-</span>
								</div>
								<div class="action"><button class="delete"><?php _e( 'Delete', 'tried' ); ?></button></div>
							</div>
					<?php
							endforeach;
						endif;
					?>
			</div>
		</div>
	<?php
    wp_reset_query();
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}
