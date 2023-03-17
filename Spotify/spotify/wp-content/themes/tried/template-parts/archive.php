<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp, $query;
?>
<main class="site-main" role="main">
	<div class="main-contain archive">
        <div class="wrapper">
            <div class="page-content">
                <div class="archive-block">
                    <?php if (get_post_type() == 'dich-vu') : ?>
                        <div class="services">
                            <?php 
                                if( have_posts()):
                                    while(have_posts()):
                                        the_post();
                                        global $post;
                                        get_template_part('template-parts/service-item/item', null, array( 'id' => $post->ID ) );
                                    endwhile;
                                else :
                            ?>
                                    <p class="no-result"><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                            <?php
                                endif;
                            ?>
                        </div>
                    <?php else : ?>
                        <div class="wrap-blog">
                            <div class="blogs">
                                <?php 
                                    if( have_posts()):
                                        while(have_posts()):
                                            the_post();
                                            global $post;
                                            get_template_part('template-parts/blog-item/item', 'addition', array( 'id' => $post->ID ) );
                                        endwhile;
                                    else :
                                ?>
                                        <p class="no-result"><?php _e('Xin lỗi, Không có kết quả trả về.'); ?></p>
                                <?php
                                    endif;
                                ?>
                            </div>
                            <div class="sidebar">
                                <?php dynamic_sidebar('sidebar_post'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="post-pagination">
                        <?php
                            $total_pages = $query->max_num_pages;
                            echo paginate_links( array(
                                'total' => $total_pages,
                                'mid_size' => 2,
                                'current'   => max(1, $wp->query_vars['paged']),
                            ));
                        ?>
                    </div>
                    <?php wp_reset_query(); ?>
				</div>
            </div>
        </div>
    </div>
</main>
