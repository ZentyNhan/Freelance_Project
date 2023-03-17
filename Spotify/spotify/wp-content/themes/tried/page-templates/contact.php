<?php 
/* Template Name: Liên hệ */
defined('ABSPATH') || exit;

?>
<?php get_header(); ?>
    <main <?php post_class( 'site-main' ); ?> role="main">
        <div class="main-contain contact">
            <div class="wrapper">
                <div class="page-content">
                    <?php dynamic_sidebar('contact_page'); ?>
                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>