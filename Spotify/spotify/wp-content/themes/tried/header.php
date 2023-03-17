<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?> colorTheme="true">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="<?php echo esc_attr( 'width=device-width, initial-scale=1' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title><?php echo get_bloginfo( 'name' ); ?></title>

	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	$header_menu = array( 'menu_location' => 'header-menu' );
	$header_slug = 'primary';
	if ( is_front_page() || is_home() ) :
		$header_slug = 'primary';
	else :
		$header_slug = 'primary';
	endif;
	get_template_part( 'template-parts/header/header', $header_slug, $header_menu );