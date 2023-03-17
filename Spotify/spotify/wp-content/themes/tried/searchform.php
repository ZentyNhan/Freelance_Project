<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="hidden" name="post_type" value="post">
	<input type="search" class="search-field" placeholder="<?php _e( 'Nhập từ khóa...', 'tried' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="fas fa-search search-submit"></button>
</form>
