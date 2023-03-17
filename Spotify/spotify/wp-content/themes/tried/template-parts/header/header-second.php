<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$location_menu = 'header-menu';
if ($args['menu_location']) :
	$location_menu = $args['menu_location'];
endif;
$header_nav_menu = wp_nav_menu( [
	'theme_location' => $location_menu,
	'fallback_cb' => false,
	'echo' => false,
	'container_class' => 'nav-menu'
] );
$header_phone = get_option( 'add_header_phone_banner', '' );

$custom_logo = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo , 'full' );
?>
<header id="site-header" class="site-header none-shadow" role="primary">
	<div class="header-outfit">
		<div class="wrapper mwidth-main margin-auto">
			<?php dynamic_sidebar('header_banner_outfit'); ?>
		</div>
	</div>

    <div class="header-info">
        <div class="wrapper mwidth-main margin-auto">
            <?php dynamic_sidebar('header_banner_info'); ?>
        </div>
    </div>

	<div class="header-contain">
		<div class="wrapper mwidth-main margin-auto">
            <!-- <div class="logo-block">
                <?php
					if ( $logo ) :
						?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-second-logo" title="<?php esc_attr_e( 'Home', 'tried' ); ?>" rel="home">
								<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
							</a>
						<?php
					endif;
				?>
				<p class="tagline"><?php echo get_bloginfo('description'); ?></p>
            </div> -->
            <div class="nav-block">
                <?php if ( $header_nav_menu ) : ?>
                    <nav class="site-navigation" role="navigation">
                        <div class="site-navigation-wrapper">
                            <?php echo $header_nav_menu; ?>
							<div class="nav-order">
								<div class="nav-action">
									<!-- <div class="search-action-block" role="sidebar">
										<a class="searchform-action fas fa-search" href="javascript:void(0)"></a>
										<div class="searchform-wrapper">
											<a class="searchform-action fal fa-angle-up" href="javascript:void(0)"></a>
											<?php get_search_form(); ?>
										</div>
									</div> -->
									<div class="search-action-block" role="dropdown">
										<a class="searchform-action" href="javascript:void(0)" data-status="false"></a>
										<div class="searchform-wrapper">
											<?php get_search_form(); ?>
										</div>
									</div>
									<?php if ( class_exists( 'WooCommerce' ) ) : ?>
										<div class="cart-block">
											<a class="cart-toggle" href="javascript:void(0)"><i aria-hidden="true" class="fas fa-shopping-cart"></i></a>
											<div class="cart-wrapper">
												<?php woocommerce_mini_cart(); ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
								<?php if (!empty($header_phone)) : ?>
									<div class="call-number">
										<a href="<?php echo $header_phone; ?>" class="support">
                                            <p><?php _e('Contact Us', ''); ?></p>
                                        </a>
									</div>
								<?php endif; ?>
							</div>
                        </div>
                        <div class="site-navigation-toggle" role="menu">
                            <i aria-hidden="true" class="fal fa-bars icon-nav open"></i>
                            <i aria-hidden="true" class="far fa-times icon-nav close"></i>
                        </div>
						<?php if ( class_exists( 'WooCommerce' ) ) : ?>
							<div class="site-cart-toggle" role="cart">
								<i aria-hidden="true" class="fas fa-shopping-cart icon-nav open"></i>
								<i aria-hidden="true" class="far fa-times icon-nav close"></i>
							</div>
						<?php endif; ?>
						<?php if ( false ) : ?>
							<div class="call-number">
								<a href="<?php echo $header_phone; ?>" class="support">
                                    <i class="far fa-calendar-alt"></i>
                                    <p><?php _e('Contact Us', ''); ?></p>
                                </a>
							</div>
						<?php endif; ?>
                    </nav>
                <?php endif; ?>
            </div>
		</div>
	</div>	  

	<div class="header-contain sticky">
		<div class="wrapper mwidth-main margin-auto">
            <div class="logo-block">
                <?php
					if ( $logo ) :
						?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-second-logo" title="<?php esc_attr_e( 'Home', 'tried' ); ?>" rel="home">
								<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
							</a>
						<?php
					endif;
				?>
				<p class="tagline"><?php echo get_bloginfo('description'); ?></p>
            </div>
            <div class="nav-block">
                <?php if ( $header_nav_menu ) : ?>
                    <nav class="site-navigation" role="navigation">
                        <div class="site-navigation-wrapper">
                            <?php echo $header_nav_menu; ?>
							<div class="nav-order">
								<div class="nav-action">
									<div class="search-block">
										<?php get_search_form(); ?>
									</div>
									<?php if ( class_exists( 'WooCommerce' ) ) : ?>
										<div class="cart-block">
											<a class="cart-toggle" href="javascript:void(0)"><i aria-hidden="true" class="fas fa-shopping-cart"></i></a>
											<div class="cart-wrapper">
												<?php woocommerce_mini_cart(); ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
								<?php if (!empty($header_phone)) : ?>
									<div class="call-number">
										<a href="<?php echo $header_phone; ?>" class="support">
                                            <p><?php _e('Contact Us', ''); ?></p>
                                        </a>
									</div>
								<?php endif; ?>
							</div>
                        </div>
                        <div class="site-navigation-toggle" role="menu">
                            <i aria-hidden="true" class="fal fa-bars icon-nav open"></i>
                            <i aria-hidden="true" class="far fa-times icon-nav close"></i>
                        </div>
						<?php if ( class_exists( 'WooCommerce' ) ) : ?>
							<div class="site-cart-toggle" role="cart">
								<i aria-hidden="true" class="fas fa-shopping-cart icon-nav open"></i>
								<i aria-hidden="true" class="far fa-times icon-nav close"></i>
							</div>
						<?php endif; ?>
                    </nav>
                <?php endif; ?>
            </div>
		</div>
	</div>
</header>

<?php if (!is_front_page()) : ?>
	<div class="site-banner">
		<div class="wrapper">
			<h3 class="page-title">
				<?php global $wp_query; ?>
				<?php echo (is_archive() || in_array("blog", get_body_class()))?get_the_archive_title():get_the_title(); ?>
			</h3>
		</div>
	</div>
	<div class="site-breadcrumbs">
		<div class="wrapper">
			<?php tried_the_breadcrumbs(); ?>
		</div>
	</div>
<?php endif; ?>