<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_query;
?>
<main class="site-main" role="main">
	<div class="main-contain">
        <div class="wrapper">
            <div class="page-content">
                <div class="search-block">
					<h1 class="title"><?php echo __('Kết quả tìm kiếm', '') . " '" . get_search_query() . "'"; ?></h1>
                    <p class="search-result-count"><?php echo $wp_query->found_posts.' kết quả tìm thấy.'; ?></p>
                    <ul class="products">
					<?php 
                        if( have_posts()):
                            while(have_posts()):
                                the_post();
								if ( class_exists( 'WooCommerce' ) ) :
			                        wc_get_template_part( 'content', 'product' );
                                else :
                                endif;
                            endwhile;
                        else :
                    ?>
                            <p class="no-result"><?php __('Sorry, no posts matched your criteria.'); ?></p>
                    <?php
                        endif;
                    ?>
				</div>
				<div class="post-pagination">
                    <?php
                        // $total_pages = $query->max_num_pages;
                        // echo paginate_links( array(
                        //     'total' => $total_pages,
                        //     'mid_size' => 2,
                        //     'current'   => max(1, $wp->query_vars['paged']),
                        // ));
                    ?>
                </div>
                <?php wp_reset_query(); ?>
            </div>
        </div>
    </div>
</main>
