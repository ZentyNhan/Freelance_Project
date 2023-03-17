<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Tried_Theme_Backend', false )) :
	class Tried_Theme_Backend {
        public $includes = array();
        
        public $widgets = array(
            array(
                'path' => '/includes/widgets/widget_footer_contact.php',
                'class' => 'widget_footer_contact'
            ),
            array(
                'path' => '/includes/widgets/widget_header_logo.php',
                'class' => 'widget_header_logo'
            ),
            array(
                'path' => '/includes/widgets/widget_contact_content.php',
                'class' => 'widget_contact_content'
            ),
            array(
                'path' => '/includes/widgets/widget_contact_mapform.php',
                'class' => 'widget_contact_mapform'
            ),
            array(
                'path' => '/includes/widgets/widget_home_about.php',
                'class' => 'widget_home_about'
            ),
            array(
                'path' => '/includes/widgets/widget_home_form.php',
                'class' => 'widget_home_form'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_form.php',
                'class' => 'widget_footer_form'
            ),
            array(
                'path' => '/includes/widgets/widget_home_slider.php',
                'class' => 'widget_home_slider'
            ),
            array(
                'path' => '/includes/widgets/widget_home_service.php',
                'class' => 'widget_home_service'
            ),
            array(
                'path' => '/includes/widgets/widget_home_partner.php',
                'class' => 'widget_home_partner'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_recentform.php',
                'class' => 'widget_footer_recentform'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_menu.php',
                'class' => 'widget_footer_menu'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_menusocial.php',
                'class' => 'widget_footer_menusocial'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_workinghours.php',
                'class' => 'widget_footer_workinghours'
            ),
            array(
                'path' => '/includes/widgets/widget_home_banner.php',
                'class' => 'widget_home_banner'
            ),
            array(
                'path' => '/includes/widgets/widget_about_content.php',
                'class' => 'widget_about_content'
            ),
            array(
                'path' => '/includes/widgets/widget_home_review.php',
                'class' => 'widget_home_review'
            ),
            array(
                'path' => '/includes/widgets/widget_home_catproduct.php',
                'class' => 'widget_home_catproduct'
            ),
            array(
                'path' => '/includes/widgets/widget_home_product.php',
                'class' => 'widget_home_product'
            ),
            array(
                'path' => '/includes/widgets/widget_home_blog.php',
                'class' => 'widget_home_blog'
            ),
            array(
                'path' => '/includes/widgets/widget_header_info.php',
                'class' => 'widget_header_info'
            ),
            array(
                'path' => '/includes/widgets/widget_header_menu.php',
                'class' => 'widget_header_menu'
            ),
            array(
                'path' => '/includes/widgets/widget_header_share.php',
                'class' => 'widget_header_share'
            ),
            array(
                'path' => '/includes/widgets/widget_header_contact.php',
                'class' => 'widget_header_contact'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_share.php',
                'class' => 'widget_footer_share'
            ),
            array(
                'path' => '/includes/widgets/widget_home_testimonial.php',
                'class' => 'widget_home_testimonial'
            ),
            array(
                'path' => '/includes/widgets/widget_about_timeline.php',
                'class' => 'widget_about_timeline'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_location.php',
                'class' => 'widget_footer_location'
            ),
            array(
                'path' => '/includes/widgets/widget_another_text.php',
                'class' => 'widget_another_text'
            ),
            array(
                'path' => '/includes/widgets/widget_another_login.php',
                'class' => 'widget_another_login'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_infobox.php',
                'class' => 'widget_footer_infobox'
            ),
            array(
                'path' => '/includes/widgets/widget_home_catservice.php',
                'class' => 'widget_home_catservice'
            ),
            array(
                'path' => '/includes/widgets/widget_home_infocontact.php',
                'class' => 'widget_home_infocontact'
            ),
            array(
                'path' => '/includes/widgets/widget_home_bannerexperience.php',
                'class' => 'widget_home_bannerexperience'
            ),
            array(
                'path' => '/includes/widgets/widget_home_member.php',
                'class' => 'widget_home_member'
            ),
            array(
                'path' => '/includes/widgets/widget_header_banner.php',
                'class' => 'widget_header_banner'
            ),
            array(
                'path' => '/includes/widgets/widget_home_trending_blog.php',
                'class' => 'widget_home_trending_blog'
            ),
            array(
                'path' => '/includes/widgets/widget_home_hotblog.php',
                'class' => 'widget_home_hotblog'
            ),
            array(
                'path' => '/includes/widgets/widget_home_additionblog.php',
                'class' => 'widget_home_additionblog'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_copyright.php',
                'class' => 'widget_footer_copyright'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_vertical_menu.php',
                'class' => 'widget_footer_vertical_menu'
            ),
            array(
                'path' => '/includes/widgets/widget_sidebar_form.php',
                'class' => 'widget_sidebar_form'
            ),
            array(
                'path' => '/includes/widgets/widget_sidebar_banner.php',
                'class' => 'widget_sidebar_banner'
            ),
            array(
                'path' => '/includes/widgets/widget_sidebar_mostblog.php',
                'class' => 'widget_sidebar_mostblog'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_home_gridblog.php',
            //     'class' => 'widget_home_gridblog'
            // ),
            array(
                'path' => '/includes/widgets/widget_home_infobox.php',
                'class' => 'widget_home_infobox'
            ),
            array(
                'path' => '/includes/widgets/widget_home_blogbycat.php',
                'class' => 'widget_home_blogbycat'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_copyrightsocial.php',
                'class' => 'widget_footer_copyrightsocial'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_information_full.php',
                'class' => 'widget_footer_information_full'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_information.php',
                'class' => 'widget_footer_information'
            ),
            array(
                'path' => '/includes/widgets/widget_another_baohanh.php',
                'class' => 'widget_another_baohanh'
            )
        );

        public $widget_sidebars = array(
            // array(
            //     'id' => 'header_banner_outfit', 
            //     'name' => 'Header Banner Outfit'
            // ),
            array(
                'id' => 'header_banner_info', 
                'name' => 'Header Banner Info'
            ),
            // array(
            //     'id' => 'header_container', 
            //     'name' => 'Header Container'
            // ),
            // array(
            //     'id' => 'footer_top', 
            //     'name' => 'Footer trên'
            // ),
            // array(
            //     'id' => 'footer_middle', 
            //     'name' => 'Footer giữa'
            // ),
            array(
                'id' => 'footer_bottom', 
                'name' => 'Footer dưới'
            ),
            array(
                'id' => 'home_page', 
                'name' => 'Trang chủ'
            ),
            array(
                'id' => 'contact_page', 
                'name' => 'Trang liên hệ'
            ),
            array(
                'id' => 'about_page', 
                'name' => 'Trang giới thiệu'
            ),
            array(
                'id' => 'sidebar_post', 
                'name' => 'Sidebar bài viết'
            )
        );

        public $settings = array(
            'admin_page' => array(
                'menu_page' => array(
                    array(
                        'page_title' => 'Tried',
                        'menu_title' => 'Tried',
                        'capability' => 'manage_options',
                        'menu_slug' => 'tried',
                        'callback_function' => 'dashboard',
                        'icon_url' => '',
                        'position' => 10,
                    )
                ),
                'submenu_page' => array(
                    array(
                        'parent_slug' => 'tried',
                        'page_title' => 'Settings',
                        'menu_title' => 'Settings',
                        'capability' => 'manage_options',
                        'menu_slug' => 'tried-settings',
                        'callback_function' => 'settings',
                        'position'  => null
                    ),
                    array(
                        'parent_slug' => 'tried',
                        'page_title' => 'REST API',
                        'menu_title' => 'REST API',
                        'capability' => 'manage_options',
                        'menu_slug' => 'tried-rest-api',
                        'callback_function' => 'api',
                        'position'  => null
                    )
                )
            )
        );

		function __construct() {
            $this->load_hooks();
		}

        function load_hooks() {
            add_action( 'admin_enqueue_scripts', array($this, 'tried_admin_enqueue_scripts') );
            add_action( 'login_enqueue_scripts', [ __CLASS__, 'tried_login_enqueue_scripts' ], 1001 );

            add_action( 'widgets_init', array($this, 'tried_widgets_init') );
            
            add_action( 'admin_body_class', array($this, 'tried_admin_body_class'), 10, 1 );
            
            add_action( 'admin_menu', array($this, 'tried_admin_menu'), 10 );
            add_action( 'admin_footer', array($this, 'tried_admin_footer' ));
        }

        function tried_login_enqueue_scripts() {
            $logo = get_theme_file_uri( "/assets/img/logo-DHCL.jpg" );
            $logo_bg = get_theme_file_uri( "/assets/img/login-bg.png" );
            if ( $logo && $logo_bg) {
                ?>
                    <style type="text/css">
                        body.login {
                            background-image: url(<?php echo $logo_bg; ?>);
                            background-size: cover;
                            background-repeat: no-repeat;
                        }
                        body.login #login h1 a {
                            background-image: url(<?php echo $logo; ?>);
                            background-position: center center;
                            background-repeat: no-repeat;
                            background-size: contain;
                            width: 250px;
                            height: 75px;
                            margin-bottom: 30px;
                        }
                        body.login #login h1 a:focus {
                            box-shadow: none;
                        }
                    </style>
                <?php
            }
        }

        function tried_admin_enqueue_scripts() {
            global $pagenow;
            if( $pagenow == "admin.php" && isset( $_GET['page'] ) && explode( '-', $_GET['page'] )[0] == 'tried' ) {
                // coding
            }
            wp_enqueue_style( 'tried-admin', get_template_directory_uri() . '/assets/css/style-admin.css', '', '1.0.0' );
            wp_enqueue_script( 'tried-admin', get_template_directory_uri() . '/assets/js/script-admin.js', null, '1.0.0', true );
            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
        }

        function tried_admin_menu() {
            $this->add_menu_page();
            $this->add_submenu_page();
        }

        function get_submenu_page() {
            return (!empty($this->settings['admin_page']['submenu_page']))?$this->settings['admin_page']['submenu_page']:false;
        }

        function add_submenu_page() {
            $admin_submenu_page = $this->get_submenu_page();
            if ($admin_submenu_page) {
                foreach ($admin_submenu_page as $page) {
                    $submenu_page = add_submenu_page(
                        $page['parent_slug'], 
                        $page['page_title'], 
                        $page['menu_title'], 
                        $page['capability'], 
                        $page['menu_slug'],
                        array($this, 'callback_function'),
                        ($page['position'])?$page['position']:null
                    );
                    $this->views[$submenu_page] = $page['callback_function'];
                }
            }
        }

        function callback_function() {
            $current_views = $this->views[current_filter()];
            ?>
            <div class="tried-admin-page" role="<?php echo $current_views; ?>">
                <div class="wrapper">
                    <?php include_once get_template_directory().'/includes/backend/'.$current_views.'.php'; ?>
                </div>
            </div>
            <?php
        }

        function get_menu_page() {
            return (!empty($this->settings['admin_page']['menu_page']))?$this->settings['admin_page']['menu_page']:false;
        }

        function add_menu_page() {
            $admin_menu_page = $this->get_menu_page();
            if ($admin_menu_page) {
                foreach ($admin_menu_page as $page) {
                    $menu_page = add_menu_page(
                        $page['page_title'], 
                        $page['menu_title'], 
                        $page['capability'], 
                        $page['menu_slug'],
                        array($this, 'callback_function'),
                        ($page['icon_url'])?$page['icon_url']:null,
                        ($page['position'])?$page['position']:null
                    );
                    $this->views[$menu_page] = $page['callback_function'];
                }
            }
        }
        
        function tried_widgets_init() {
            if (!empty($this->widget_sidebars)) {
                foreach ($this->widget_sidebars as $sidebars) {
                    register_sidebar(array(
                        'id'            => $sidebars['id'],
                        'name'          => $sidebars['name'],
                        'before_widget' => '<div class="widget-component">',
                        'after_widget'  => '</div>',
                        'before_title'  => '',
		                'after_title'   => ''
                    ));
                }
            }

            if (!empty($this->widgets)) {
                foreach ($this->widgets as $widget) {
                    include_once get_template_directory() . $widget['path'];
                    if ( class_exists($widget['class'], false) ) {
                        register_widget($widget['class']);
                    }
                }
            }
        }
        
        function tried_admin_body_class($classes) {
            global $pagenow;
            if($pagenow == "admin.php" && isset($_GET['page']) && explode('-', $_GET['page'])[0] == 'tried') {
                $classes .= 'admin-tried';
            }
            return $classes;
        }

        function tried_admin_footer() {}
	}
endif;

return new Tried_Theme_Backend();
