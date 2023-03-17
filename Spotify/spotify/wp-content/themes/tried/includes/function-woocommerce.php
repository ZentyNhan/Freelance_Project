<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// add_filter( 'woocommerce_get_price_html', function( $price ) {
// 	return '';
// } );
// add_filter( 'woocommerce_cart_item_price', '__return_false' );
// add_filter( 'woocommerce_cart_item_subtotal', '__return_false' );

// add_filter('woocommerce_is_purchasable', '__return_false');

add_action( 'woocommerce_after_shop_loop_item_title', 'action_function_name_9437' );
function action_function_name_9437(){
	global $product;
	if (!$product->get_price()) {
		echo '<span class="text-contact">'.__('Liên hệ', 'tried').'</span>';
	}
}

add_action( 'woocommerce_before_single_product', 'customise_product_page' );
function customise_product_page() {
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
}

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 4 columns
	return $args;
}

add_filter( 'woocommerce_get_price_html', 'njengah_text_after_price' );
function njengah_text_after_price($price){
	if (is_product()) {
		global $product;
		$unit = get_post_meta( $product->ID, 'prod_unit', true )?get_post_meta( $product->ID, 'prod_unit', true ):'Bộ';
		$price_regular = $product->get_regular_price();
		$price_sale = 0;
		if( $product->is_on_sale() ) {
			$price_sale = $product->get_sale_price();
		}
		$economical = ($price_regular - $price_sale)*100/$price_regular;
		$insurance = get_post_meta( $product->ID, 'prod_insurance', true )?get_post_meta( $product->ID, 'prod_insurance', true ):'1 Năm';
		$shipping = __( 'Miễn Phí Toàn Quốc', 'tried' );
		$contact = __( 'Để Có Giá Tốt Hơn', 'tried' );
	
		$text_to_add_after_price = '<div class="economical"><strong>'.__( 'Tiết kiệm', 'tried' ).':</strong>-'.ceil($economical).'%</div>';
		$text_to_add_after_price .= '<div class="metainfos">
			<ul>
				<li><strong>'.__( 'Mã sản phẩm', 'tried' ).':</strong><span class="sku">'.$product->get_sku().'</span></li>
				<li><strong>'.__( 'Đơn vị tính', 'tried' ).':</strong>'.$unit.'</li>
				<li><strong>'.__( 'Bảo hành', 'tried' ).':</strong>'.$insurance.'</li>
				<li><strong>'.__( 'Giao hàng', 'tried' ).':</strong>'.$shipping.'</li>
				<li><strong>'.__( 'Liên hệ', 'tried' ).':</strong>'.$contact.'</li>
			</ul>
		</div>';
	
		return $price . $text_to_add_after_price;	
	}
    return $price;	  
}
