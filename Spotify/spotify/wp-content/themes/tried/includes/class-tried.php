<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Tried_Theme', false )) :
	class Tried_Theme {
        public $includes = array(
            '/includes/function-core.php',
            '/includes/function-shortcode.php',
            '/includes/function-ajax.php',
            '/includes/function-posttype.php',
            '/includes/function-woocommerce.php',
            '/includes/function-account.php',
            '/includes/function-helper.php',
            '/includes/class-tried-backend.php',
            '/includes/W_Deferred.php'
        );

        public $databases = array(
            array(
                'path' => '/includes/databases/class-account-premium.php',
                'class' => 'Tried_DB__Acc_Premium'
            )
        );

		function __construct() {
            // $this->load_databases();
            $this->load_includes();
            $this->load_hooks();
		}

        function load_hooks() {
            add_action( 'wp_enqueue_scripts', array($this, 'tried_frontend_enqueue_scripts') );
            add_action( 'after_setup_theme', array($this, 'tried_theme_theme_setup') );

            add_action( 'wp_head', array($this, 'tried_wp_head') );
            add_action( 'wp_footer', array($this, 'tried_wp_footer') );

            add_filter( 'show_admin_bar', '__return_false' );
            add_filter( 'use_widgets_block_editor', '__return_false' );
            add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
            add_filter( 'use_block_editor_for_post_type', '__return_false' );
            
            add_action( 'customize_register', array($this, 'tried_theme_customizer_setting') );
        }
        
        function load_databases() {
            if ( !empty( $this->databases ) ) {
                foreach ( $this->databases as $database ) {
                    if ( !class_exists( $database['class'] ) ) {
                        include_once get_template_directory() . $database['path'];
                    }
                }
            }
        }

        function load_includes() {
            if ( !empty( $this->includes ) ) {
                foreach ( $this->includes as $include ) {
                    include_once get_template_directory() . $include;
                }
            }
        }

        function tried_frontend_enqueue_scripts() {
            global $template;
            // basic
            wp_enqueue_style( 'tried', get_template_directory_uri() . '/assets/css/style.css', '', '1.0.0' );
            wp_enqueue_script( 'tried', get_template_directory_uri() . '/assets/js/script.js', null, '1.0.0', true );
            wp_enqueue_style( 'tried-widget', get_template_directory_uri() . '/assets/css/style-widgets.css', '', '1.0.0' );

            wp_register_style( 'tried-fileupload', get_template_directory_uri() . '/assets/css/style-fileupload.css', '', '1.0.0' );
            wp_register_script( 'tried-fileupload', get_template_directory_uri() . '/assets/js/script-fileupload.js', null, '1.0.0', true );

            // blog-item
            wp_register_style( 'tried-blog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-item.css', '', '1.0.0' );
            wp_register_style( 'tried-basicblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-basic-item.css', '', '1.0.0' );
            wp_register_style( 'tried-hotblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-hot-item.css', '', '1.0.0' );
            wp_register_style( 'tried-gridblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-grid-item.css', '', '1.0.0' );
            wp_register_style( 'tried-additionblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-addition-item.css', '', '1.0.0' );
            wp_register_style( 'tried-smallblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-small-item.css', '', '1.0.0' );

            // form
            wp_register_style( 'tried-form-wpcf7', get_template_directory_uri() . '/assets/css/form/wpcf7.css', '', '1.0.0' );

            // header
            wp_enqueue_style( 'tried-header', get_template_directory_uri() . '/assets/css/header/header.css', '', '1.0.0' );
            wp_register_style( 'tried-header-primary', get_template_directory_uri() . '/assets/css/header/header-primary.css', '', '1.0.0' );
            wp_register_style( 'tried-header-content', get_template_directory_uri() . '/assets/css/header/header-content.css', '', '1.0.0' );

            // footer
            wp_enqueue_style( 'tried-footer', get_template_directory_uri() . '/assets/css/footer/footer.css', '', '1.0.0' );

            // wooCommerce
            if ( class_exists( 'WooCommerce' ) ) {
                wp_enqueue_style( 'tried-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce/woocommerce.css', '', '1.0.0' );
                wp_register_style( 'tried-woocommerce-archive', get_template_directory_uri() . '/assets/css/woocommerce/woocommerce-archive.css', '', '1.0.0' );
                wp_register_style( 'tried-product-item', get_template_directory_uri() . '/assets/css/product-item/product-item.css', '', '1.0.0' );
            }

            // font
            wp_enqueue_style( 'tried-font', get_template_directory_uri() . '/assets/css/style-fonts.css', '', '1.0.0' );

            // lib
            wp_enqueue_script( 'jquery-min', get_theme_file_uri( '/assets/lib/jquery/jquery.min.js' ), null, '3.5.1', false );

            // wp_enqueue_style( "swiper-bundle-min", get_theme_file_uri( '/assets/lib/swiper-bundle/swiper-bundle.min.css' ), [], false );
            // wp_enqueue_script( "swiper-bundle-min", get_theme_file_uri( '/assets/lib/swiper-bundle/swiper-bundle.min.js' ), array(), false, false );
            
            // wp_enqueue_script( "isotope-min", get_theme_file_uri( '/assets/lib/isotope/isotope.min.js' ), array(), false, false );
            
            // wp_enqueue_style( "lightboxed", get_theme_file_uri( "/assets/lib/lightboxed/lightboxed.css" ), [], false );
            // wp_enqueue_script( "lightboxed", get_theme_file_uri( "/assets/lib/lightboxed/lightboxed.js" ), array(), false, false );
            
            wp_localize_script( 'tried', 'tried_script', array(
                'ajax_url' => admin_url( 'admin-ajax.php' )
            ) );

            if ( $template && basename($template) == 'profile.php' ) {
                wp_enqueue_style( 'tried-profile', get_template_directory_uri() . '/assets/css/style-profile.css', '', '1.0.0' );
                wp_enqueue_script( 'tried-profile', get_template_directory_uri() . '/assets/js/script-profile.js', null, '1.0.0', true );
            }
        }

        function tried_theme_theme_setup() {
            register_nav_menus(array(
                'header-menu'  => esc_html__('Header Menu', 'tried')
            ));
            
            $defaults = array(
                'flex-height'          => true,
                'flex-width'           => true,
                'header-text'          => array( 'site-title', 'site-description' ),
                'unlink-homepage-logo' => true, 
            );
            add_theme_support( 'custom-logo', $defaults );
            add_theme_support( 'post-thumbnails' );
            remove_theme_support( 'widgets-block-editor' );
        }
        
        function tried_theme_customizer_setting($wp_customize) {
            $wp_customize->add_setting( 'custom_second_logo' );
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize, 
                    'custom_second_logo', 
                    array(
                        'label' => __( 'Second Logo' ),
                        'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
                        'settings' => 'custom_second_logo',
                        'priority' => 8 // show it just below the custom-logo
                    )
                )
            );
        }

        function tried_wp_head() {
            ?>
                <script>
                    var fileupload_url = "<?php echo get_site_url(); ?>";
                </script>
                <style>
                    :root {
                        --main-max-width: 1200px;
                        --primary-color-theme: #222;
                        --second-color-theme: #3c763d;
                    }
                </style>
            <?php
            if (is_single() && false) {
                ?>
                    <link rel=stylesheet href="<?php echo get_template_directory_uri().'/assets/lib/mibreit-gallery/css/mibreitGallery.css'; ?>" type="text/css" />
                    <script src="<?php echo get_template_directory_uri().'/assets/lib/mibreit-gallery/mibreitGallery.min.js'; ?>"></script>
                    <script>
                        $(document).ready(function(){mibreitGallery.createGallery({slideshowContainer:"#full-gallery",thumbviewContainer:".mibreit-thumbview",titleContainer:"#full-gallery-title",allowFullscreen:!0,preloadLeftNr:2,preloadRightNr:3})})
                    </script>
                <?php
            }
        }

        function tried_wp_footer() {
            $user = get_current_user_id();
            ?>
                <div id="modal-file-up-load" style="display: none;" data-key="">
                    <div class="wrapper">
                        <h2 class="title"><?php _e('File Upload', 'woocommerce'); ?><span class="modal-fclose">&times;</span></h2>
                        <div class="content">
                            <iframe class="embed-responsive-item" id="my_media_list" name="my_media_list" src="" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            <?php
        }
	}
endif;

return new Tried_Theme();
