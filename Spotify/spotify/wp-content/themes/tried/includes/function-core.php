<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// -------------------------------------------------------------

if ( ! function_exists( 'tried_the_breadcrumbs' ) ) {
	/**
	 * Breadcrumbs
	 * return void
	 */
	function tried_the_breadcrumbs() {
		global $post;
		global $wp_query;
		$before = '<li class="current">';
		$after  = '</li>';
		if ( ! is_home() && ! is_front_page() || is_paged() || $wp_query->is_posts_page ) {
			echo '<ul id="tried-breadcrumbs" class="breadcrumbs" aria-label="breadcrumbs">';
			echo '<li><a class="home" href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Trang chủ', 'tried' ) . '</a></li>';
			if ( is_category() || is_tax() ) {
				$cat_obj   = $wp_query->get_queried_object();
				$thisCat   = get_category( $cat_obj->term_id );
				$parentCat = get_category( $thisCat->parent );
				if ( 0 != $thisCat->parent ) {
					if ( ! is_wp_error( $cat_code = get_category_parents( $parentCat->term_id, true, '' ) ) ) {
						$cat_code = str_replace( '<a', '<li><a', $cat_code );
						echo $cat_code = str_replace( '</a>', '</a></li>', $cat_code );
					}
				}
				echo $before . single_cat_title( '', false ) . $after;
			} elseif ( is_archive() ) {
				$post_type = get_post_type_object( get_post_type() );
				$title = $post_type->labels->singular_name;
				if (get_post_type() != 'post') {
					global $wp_query;
					if ($wp_query->query['post_type'] == 'dich-vu') {
						$title = 'Dịch vụ';
					}
				}
				echo $before . $title  . $after;
			} elseif ( is_day() ) {
				echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
				echo '<li><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li>';
				echo $before . get_the_time( 'd' ) . $after;
			} elseif ( is_month() ) {
				echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
				echo $before . get_the_time( 'F' ) . $after;
			} elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;
			} elseif ( is_single() && ! is_attachment() ) {
				if ( 'post' != get_post_type() ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					if ( ! is_bool( $slug ) ) {
						echo '<li><a href="' . get_base_url() . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></span>';
					}
					echo $before . get_the_title() . $after;
				} else {
					$cat = primary_term( $post );
					if ( ! empty( $cat ) ) {
						if ( ! is_wp_error( $cat_code = get_category_parents( $cat->term_id, true, '' ) ) ) {
							$cat_code = str_replace( '<a', '<li><a', $cat_code );
							echo $cat_code = str_replace( '</a>', '</a></li>', $cat_code );
						}
					}
					echo $before . get_the_title() . $after;
				}
			} elseif ( ( is_page() && ! $post->post_parent ) || ( function_exists( 'bp_current_component' ) && bp_current_component() ) ) {
				echo $before . get_the_title() . $after;
			} elseif ( is_search() ) {
				echo $before;
				printf( __( 'Search Results for: %s', 'tried' ), get_search_query() );
				echo $after;
			} elseif ( ! is_single() && ! is_page() && 'post' != get_post_type() ) {
				$post_type = get_post_type_object( get_post_type() );
				// echo $before . $post_type->labels->singular_name . $after;
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				echo '<li><a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a></li>';
				echo $before . get_the_title() . $after;
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = [];
				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					$breadcrumbs[] = '<li><a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
					$parent_id     = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					echo $crumb;
				}
				echo $before . get_the_title() . $after;
			} elseif ( is_tag() ) {
				echo $before;
				printf( __( 'Tag Archives: %s', 'tried' ), single_tag_title( '', false ) );
				echo $after;
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before.$userdata->display_name.$after;
			} elseif ( $wp_query->is_posts_page ) {
				$posts_page_title = get_the_title( get_option( 'page_for_posts', true ) );
				echo $before . $posts_page_title . $after;
			}
			if ( is_404() ) {
				echo $before.__( 'Not Found', 'tried' ).$after;
			}
			if ( get_query_var( 'paged' ) ) {
				echo '<li class="paged">';
				if ( is_category() || is_tax() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo __( 'page', 'tried' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_tax() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
				echo $after;
			}
			echo '</ul>';
		}
		// reset
		wp_reset_query();
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'pagination_links' ) ) {
	/**
	 * @param bool $echo
	 *
	 * @return string|null
	 */
	function pagination_links( $echo = true ) {
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) {

			// This needs to be an unlikely integer
			$big = 999999999;

			// For more options and info view the docs for paginate_links()
			// http://codex.wordpress.org/Function_Reference/paginate_links
			$paginate_links = paginate_links(
				apply_filters(
					'wp_pagination_args',
					[
						'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $wp_query->max_num_pages,
						'end_size'  => 3,
						'mid_size'  => 3,
						'prev_next' => true,
						'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path d="M25.1 247.5l117.8-116c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L64.7 256l102.2 100.4c4.7 4.7 4.7 12.3 0 17l-7.1 7.1c-4.7 4.7-12.3 4.7-17 0L25 264.5c-4.6-4.7-4.6-12.3.1-17z"/></svg>',
						'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path d="M166.9 264.5l-117.8 116c-4.7 4.7-12.3 4.7-17 0l-7.1-7.1c-4.7-4.7-4.7-12.3 0-17L127.3 256 25.1 155.6c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0l117.8 116c4.6 4.7 4.6 12.3-.1 17z"/></svg>',
						'type'      => 'list',
					]
				)
			);

			$paginate_links = str_replace( "<ul class='page-numbers'>", '<ul class="pagination">', $paginate_links );
			$paginate_links = str_replace( '<li><span class="page-numbers dots">&hellip;</span></li>', '<li class="ellipsis"></li>', $paginate_links );
			$paginate_links = str_replace( '<li><span aria-current="page" class="page-numbers current">', '<li class="current"><span aria-current="page" class="show-for-sr">You\'re on page </span>', $paginate_links );
			$paginate_links = str_replace( '</span></li>', '</li>', $paginate_links );
			$paginate_links = preg_replace( '/\s*page-numbers\s*/', '', $paginate_links );
			$paginate_links = preg_replace( '/\s*class=""/', '', $paginate_links );

			// Display the pagination if more than one page is found.
			if ( $paginate_links ) {
				$paginate_links = '<nav aria-label="Pagination">' . $paginate_links . '</nav>';
				if ( $echo ) {
					echo $paginate_links;
				} else {
					return $paginate_links;
				}
			}
		}

		return null;
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'get_base_url' ) ) {
	/**
	 * @param string $uri
	 * @param bool $relative relative path. Default empty
	 *
	 * @return string|string[]|null
	 */
	function get_base_url( string $uri = '', bool $relative = false ) {

		if ( empty( $uri ) ) {
			$uri = '/';
		}

		if ( $uri && is_string( $uri ) ) {
			$uri = '/' . trim( $uri, '/' ) . '/';
		}
		$base_url = esc_url( home_url( '/' ) );
		//$base_url = esc_url( site_url( '/' ) );
		$base_url = rtrim( $base_url, '/' );
		if ( $relative == true ) {
			$base_url = preg_replace( '(https?://)', '//', $base_url );
		}

		$current_lg = get_lang();
		$tmp        = $current_lg;

		// polylang plugin
		if ( function_exists( 'pll_default_language' ) ) {
			$tmp = strtolower( substr( pll_default_language(), 0, 2 ) );
		}
		if ( strcmp( $tmp, $current_lg ) !== 0 ) {
			return $base_url . '/' . $current_lg . $uri;
		}

		return $base_url . $uri;
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'get_lang' ) ) {
	/**
	 * Get lang code
	 * @return string
	 */
	function get_lang() {
		return strtolower( substr( get_locale(), 0, 2 ) );
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'primary_term' ) ) {
	/**
	 * @param null $post
	 * @param string $taxonomy
	 *
	 * @return array|bool|int|mixed|object|WP_Error|WP_Term|null
	 */
	function primary_term( $post = null, $taxonomy = '' ) {
		$post = get_post( $post );
		$ID   = is_numeric( $post ) ? $post : $post->ID;

		if ( empty( $taxonomy ) ) {
			$post_type  = get_post_type( $ID );
			$taxonomies = get_object_taxonomies( $post_type );
			if ( isset( $taxonomies[0] ) ) {
				if ( 'product_type' == $taxonomies[0] && isset( $taxonomies[2] ) ) {
					$taxonomy = $taxonomies[2];
				}
			}
		}

		if ( empty( $taxonomy ) ) {
			$taxonomy = 'category';
		}

		// Rank Math SEO
		// https://vi.wordpress.org/plugins/seo-by-rank-math/
		$primary_term_id = get_post_meta( get_the_ID(), 'rank_math_primary_' . $taxonomy, true );
		if ( $primary_term_id ) {
			$term = get_term( $primary_term_id, $taxonomy );
			if ( $term ) {
				return $term;
			}
		}

		// Default, first category
		$post_terms = get_the_terms( $post, $taxonomy );
		if ( is_array( $post_terms ) ) {
			return $post_terms[0];
		}

		return false;
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'w_post_term' ) ) {
	/**
	 * @param $post
	 * @param string $taxonomy
	 * @param string $wrapper_open
	 * @param string $wrapper_close
	 *
	 * @return string|null
	 */
	function w_post_term( $post, $taxonomy = '', $wrapper_open = '<div class="cat">', $wrapper_close = '</div>' ) {
		if ( empty( $taxonomy ) ) {
			$taxonomy = 'category';
		}

		$link       = '';
		$post_terms = get_the_terms( $post, $taxonomy );

		if ( $post_terms ) {
			foreach ( $post_terms as $term ) {
				if ( $term ) {
					$link .= '<a href="' . esc_url( get_term_link( $term, $taxonomy ) ) . '" title="' . esc_attr( $term->name ) . '">' . $term->name . '</a>';
				}
			}

			if ( $wrapper_open && $wrapper_close ) {
				$link = $wrapper_open . $link . $wrapper_close;
			}
		}

		return $link;
	}
}

// ------------------------------------------------------

if ( ! function_exists( 'str_contains' ) ) {
	/**
	 * @param string $haystack
	 * @param string $needle
	 *
	 * @return bool
	 */
	function str_contains( string $haystack, string $needle ): bool {
		return '' === $needle || false !== strpos( $haystack, $needle );
	}
}

// ------------------------------------------------------

if ( ! function_exists( 'style_loader_tag' ) ) {
	/**
	 * @param array $arr_styles [ $handle ]
	 * @param string $html
	 * @param string $handle
	 *
	 * @return array|string|string[]|null
	 */
	function style_loader_tag( array $arr_styles, string $html, string $handle ) {
		foreach ( $arr_styles as $style ) {
			if ( str_contains( $handle, $style ) ) {
				return preg_replace( '/media=\'all\'/', 'media=\'print\' onload=\'this.media="all"\'', $html );
			}
		}

		return $html;
	}
}

// -------------------------------------------------------------

// comment off
add_filter( 'wp_insert_post_data', function ( $data ) {
	if ( $data['post_status'] == 'auto-draft' ) {
		$data['comment_status'] = 0;
		$data['ping_status']    = 0;
	}

	return $data;
}, 10, 1 );

// ------------------------------------------------------

if ( ! function_exists( 'script_loader_tag' ) ) {
	/**
	 * @param array $arr_parsed [ $handle: $value ] -- $value[ 'defer', 'delay' ]
	 * @param string $tag
	 * @param string $handle
	 * @param string $src
	 *
	 * @return array|string|string[]|null
	 */
	function script_loader_tag( array $arr_parsed, string $tag, string $handle, string $src ) {
		if ( ! is_admin() ) {
			foreach ( $arr_parsed as $str => $value ) {
				if ( str_contains( $handle, $str ) ) {
					if ( 'defer' === $value ) {
						//$tag = '<script defer type=\'text/javascript\' src=\'' . $src . '\'></script>';
						$tag = preg_replace( '/\s+defer\s+/', ' ', $tag );
						$tag = preg_replace( '/\s+src=/', ' defer src=', $tag );
					} elseif ( 'delay' === $value ) {
						$tag = preg_replace( '/\s+defer\s+/', ' ', $tag );
						$tag = preg_replace( '/\s+src=/', ' defer data-type=\'lazy\' data-src=', $tag );
					}
				}
			}
		}

		return $tag;
	}
}

// -------------------------------------------------------------

add_filter( "posts_search", function ( $search, $wp_query ) {

	global $wpdb;
	if ( empty( $search ) ) {
		return $search; // skip processing – no search term in query
	}

	$q      = $wp_query->query_vars;
	$n      = ! empty( $q['exact'] ) ? '' : '%';
	$search =
	$searchand = '';
	foreach ( (array) $q['search_terms'] as $term ) {
		$term      = esc_sql( $wpdb->esc_like( $term ) );
		$search    .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = " AND ";
	}
	if ( ! empty( $search ) ) {
		$search = " AND ({$search}) ";
		if ( ! is_user_logged_in() ) {
			$search .= " AND ($wpdb->posts.post_password = '') ";
		}
	}

	return $search;
}, 500, 2 );

// -------------------------------------------------------------


// add_filter('admin_init', 'register_add_phone_button_fields');
function register_add_phone_button_fields() {
    // register_setting('general', 'add_phone_button', 'esc_attr');
    // add_settings_field('add_phone_button', '<label for="add_phone_button">'.__('Nút sdt' , 'add_phone_button' ).'</label>' , 'print_add_phone_button_field', 'general');
    // register_setting('general', 'add_zalo_button', 'esc_attr');
    // add_settings_field('add_zalo_button', '<label for="add_zalo_button">'.__('Nút Zalo' , 'add_zalo_button' ).'</label>' , 'print_add_zalo_button_field', 'general');
    // register_setting('general', 'add_messager_button', 'esc_attr');
    // add_settings_field('add_messager_button', '<label for="add_messager_button">'.__('Nút Messager' , 'add_messager_button' ).'</label>' , 'print_add_messager_button_field', 'general');
	
    // register_setting('general', 'add_header_phone', 'esc_attr');
    // add_settings_field('add_header_phone', '<label for="add_header_phone">'.__('Nút phone header' , 'add_header_phone' ).'</label>' , 'print_add_header_phone_field', 'general');
	
    // register_setting('general', 'add_header_phone_banner', 'esc_attr');
    // add_settings_field('add_header_phone_banner', '<label for="add_header_phone_banner">'.__('Nút phone header banner' , 'add_header_phone_banner' ).'</label>' , 'print_add_header_phone_banner_field', 'general');
}
function print_add_phone_button_field() {
    echo '<input type="text" id="add_phone_button" name="add_phone_button" value="' . get_option( 'add_phone_button', '' ) . '" />';
}
function print_add_zalo_button_field() {
    echo '<input type="text" id="add_zalo_button" name="add_zalo_button" value="' . get_option( 'add_zalo_button', '' ) . '" />';
}
function print_add_messager_button_field() {
    echo '<input type="text" id="add_messager_button" name="add_messager_button" value="' . get_option( 'add_messager_button', '' ) . '" />';
}
// function print_add_header_phone_field() {
//     echo '<input type="text" id="add_header_phone" name="add_header_phone" value="' . get_option( 'add_header_phone', '' ) . '" />';
// }
function print_add_header_phone_banner_field() {
    echo '<input type="text" id="add_header_phone_banner" name="add_header_phone_banner" value="' . get_option( 'add_header_phone_banner', '' ) . '" />';
}

// add_action('wp_footer', 'tried_wp_footer');
function tried_wp_footer() {
    $phone = get_option( 'add_phone_button', '' );
    $zalo = get_option( 'add_zalo_button', '' );
    $messager = get_option( 'add_messager_button', '' );
    ?>
        <div class="button-contact-block">
            <ul>
                <?php if (!empty($phone)) : ?>
                    <li class="phone">
                        <a href="tel:<?php echo $phone;?>" rel="nofollow">
                            <span class="phone-ico"></span>
                        </a>
                    </li>
                    <li class="mobile phone">
                        <a href="tel:<?php echo $phone;?>" rel="nofollow"></a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($zalo)) : ?>
                    <li class="zalo">
                        <a href="https://zalo.me/<?php echo $zalo;?>" rel="nofollow" target="_blank">
                            <img src="<?php echo get_template_directory_uri(). '/assets/img/zalo.png'; ?>" alt="">
                        </a>
                    </li>
                    <li class="mobile zalo">
                        <a href="https://zalo.me/<?php echo $zalo;?>" rel="nofollow" target="_blank"></a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($messager)) : ?>
                    <li class="messenger">
                        <a href="<?php echo $messager;?>" rel="nofollow" target="_blank">
                            <svg width="60px" height="60px" viewBox="0 0 60 60" cursor="pointer"><svg x="0" y="0" width="60px" height="60px"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g><circle fill="#fd5622" cx="30" cy="30" r="30"></circle><svg x="10" y="10"><g transform="translate(0.000000, -10.000000)" fill="#FFFFFF"><g id="logo" transform="translate(0.000000, 10.000000)"><path d="M20,0 C31.2666,0 40,8.2528 40,19.4 C40,30.5472 31.2666,38.8 20,38.8 C17.9763,38.8 16.0348,38.5327 14.2106,38.0311 C13.856,37.9335 13.4789,37.9612 13.1424,38.1098 L9.1727,39.8621 C8.1343,40.3205 6.9621,39.5819 6.9273,38.4474 L6.8184,34.8894 C6.805,34.4513 6.6078,34.0414 6.2811,33.7492 C2.3896,30.2691 0,25.2307 0,19.4 C0,8.2528 8.7334,0 20,0 Z M7.99009,25.07344 C7.42629,25.96794 8.52579,26.97594 9.36809,26.33674 L15.67879,21.54734 C16.10569,21.22334 16.69559,21.22164 17.12429,21.54314 L21.79709,25.04774 C23.19919,26.09944 25.20039,25.73014 26.13499,24.24744 L32.00999,14.92654 C32.57369,14.03204 31.47419,13.02404 30.63189,13.66324 L24.32119,18.45264 C23.89429,18.77664 23.30439,18.77834 22.87569,18.45674 L18.20299,14.95224 C16.80079,13.90064 14.79959,14.26984 13.86509,15.75264 L7.99009,25.07344 Z"></path></g></g></svg></g></g></svg></svg>
                        </a>
                    </li>
                    <li class="mobile messenger">
                        <a href="<?php echo $messager;?>" rel="nofollow" target="_blank"></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <style>
            .button-contact-block {
                position: fixed;
                bottom: 20px;
                right: 10px;
				z-index: 99999999;
            }
            .button-contact-block a {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .button-contact-block .phone .phone-ico {
                width: 48px;
                height: 48px;
                animation: ng-circle-icon-anim 1s infinite ease-in-out;
                transform-origin: 50% 50%;
                background-color: #fefefe;
                border-radius: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: rgb(0 0 0 / 15%) 0 0 12px 0;
                border: 2px solid #c91508;
            }
            .button-contact-block .phone .phone-ico::before {
                content: "\f2a0";
                font-family: "Font Awesome 5 Pro";
                color: #c91508;
                font-weight: 700;
                font-size: 22px;
                transform: rotate(320deg);
            }
            .button-contact-block .zalo img {
                width: 60px;
                height: 60px;
            }
            .button-contact-block .messenger svg {
                width: 48px;
                height: 48px;
            }
            .button-contact-block ul {
                list-style-type: none;
            }
            .button-contact-block ul li {
                display: block;
            }
            .button-contact-block ul li.mobile {
                display: none;
            }
            .button-contact-block ul li:not(:last-child) {
                margin-bottom: 20px;
            }
            @keyframes ng-circle-icon-anim{0%{transform:rotate(0) scale(1) skew(1deg)}10%{transform:rotate(-25deg) scale(1) skew(1deg)}20%{transform:rotate(25deg) scale(1) skew(1deg)}30%{transform:rotate(-25deg) scale(1) skew(1deg)}40%{transform:rotate(25deg) scale(1) skew(1deg)}50%{transform:rotate(0) scale(1) skew(1deg)}100%{transform:rotate(0) scale(1) skew(1deg)}}
        </style>
    <?php
}

add_filter( 'get_the_archive_title', 'ft_get_the_archive_title', 10, 1 ); 
function ft_get_the_archive_title( $title ) { 
	if ( is_category() ) {    
		$title = single_cat_title( '', false );    
	} elseif ( is_tag() ) {    
		$title = single_tag_title( '', false );    
	} elseif ( is_author() ) {    
		$title = '<span class="vcard">' . get_the_author() . '</span>' ;    
	} elseif ( is_tax() ) { //for custom post types
		$title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title( '', false );
	}
    return $title; 
}

add_filter( "posts_search", function ( $search, $wp_query ) {

	global $wpdb;
	if ( empty( $search ) ) {
		return $search; // skip processing – no search term in query
	}

	$q      = $wp_query->query_vars;
	$n      = ! empty( $q['exact'] ) ? '' : '%';
	$search =
	$searchand = '';
	foreach ( (array) $q['search_terms'] as $term ) {
		$term      = esc_sql( $wpdb->esc_like( $term ) );
		$search    .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = " AND ";
	}
	if ( ! empty( $search ) ) {
		$search = " AND ({$search}) ";
		if ( ! is_user_logged_in() ) {
			$search .= " AND ($wpdb->posts.post_password = '') ";
		}
	}

	return $search;
}, 500, 2 );

// add_action('admin_menu', 'add_custom_link_into_appearnace_menu');
// function add_custom_link_into_appearnace_menu() {
//     global $submenu;
//     $permalink = add_query_arg( array( 'export' => 'excel', 'post_type' => 'bao-hanh' ) );
//     $submenu['edit.php?post_type=bao-hanh'][] = array( 'Custom Link', 'manage_options', $permalink );
// }
