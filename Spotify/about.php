<?php 
/* Template Name: Giới thiệu */
defined('ABSPATH') || exit;

?>
<?php get_header(); ?>
    <main <?php post_class( 'site-main' ); ?> role="main">
        <div class="main-contain about">
            <div class="wrapper">
                <div class="page-content">
                    <?php dynamic_sidebar('about_page'); ?>
                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>