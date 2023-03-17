<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

if ( is_singular() || (class_exists( 'WooCommerce' ) && is_woocommerce()) ) {
	get_template_part( 'template-parts/single' );
} elseif ( is_archive() || is_home() ) {
	get_template_part( 'template-parts/archive' );
} elseif ( is_search() ) {
	get_template_part( 'template-parts/search' );
} elseif ( is_archive() || (class_exists( 'WooCommerce' ) && is_woocommerce()) ) {
	get_template_part( 'template-parts/single' );
} else {
	get_template_part( 'template-parts/404' );
}

get_footer();
