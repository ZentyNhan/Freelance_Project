<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_login extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_login', 'Tried Anohter Login',
			array(
				'classname' => 'widget_another_login',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('link_profile' => '');
        $instance = wp_parse_args($instance, $defaults);
		$link_profile = $instance['link_profile'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-login">
				<div class="section-wrapper margin-auto">
                    <?php if (is_user_logged_in()) : ?>
                        <?php 
                            global $current_user;
                            wp_get_current_user();
                            $links_args = array(
                                array('link' => '?block=ctt-khoanno', 'name' => __('Khoản nợ đã đăng', 'tried')),
                                array('link' => '?block=ctt-khoanno&action=new-khoanno', 'name' => __('Khoản nợ mới', 'tried')),
                                array('link' => '?block=ctt-manage-save', 'name' => __('Đã lưu', 'tried')),
                                array('link' => '?block=ctt-helps', 'name' => __('Trợ giúp', 'tried')),
                                array('link' => '?block=ctt-settings', 'name' => __('Cài đặt', 'tried'))
                            );
                            $upload_url      = get_the_author_meta( 'tried_upload_meta', $current_user->ID );
                            $upload_edit_url = get_the_author_meta( 'tried_upload_edit_meta', $current_user->ID );
                            $button_text     = $upload_url ? 'Change Current Image' : 'Upload New Image';
                            if ( $upload_url ) {
                                $upload_edit_url = get_site_url() . $upload_edit_url;
                            }
                            $avatar = get_avatar_url( $current_user->ID );
                            if ( !empty( $avatar ) ) {
                                $avatar_url = $avatar;
                            }
                            $display_name = $current_user->display_name;
                        ?>
                        <div class="profile-block">
                            <div class="avatar-button">
                                <a class="dropdown-action" href="javascript:void(0)" title="">
						            <?php if ( $upload_url ): ?>
                                        <img class="avatar user-avatar" src="<?php echo esc_url( $upload_url ); ?>" alt="">
                                    <?php elseif ( $avatar_url ) : ?>
                                        <img class="avatar user-avatar" src="<?php echo esc_url( $avatar_url ); ?>"/>
                                    <?php else : ?>
                                        <img class="avatar user-avatar" src="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>"/>
                                    <?php endif; ?>
                                 </a>
                                <ul class="dropdown-wrapper">
                                    <li class="prod-user">
                                        <?php if ( $upload_url ): ?>
                                            <img class="avatar" src="<?php echo esc_url( $upload_url ); ?>" alt="">
                                        <?php elseif ( $avatar_url ) : ?>
                                            <img class="avatar" src="<?php echo esc_url( $avatar_url ); ?>"/>
                                        <?php else : ?>
                                            <img class="avatar" src="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>"/>
                                        <?php endif; ?>
                                        <div class="info">
                                            <?php echo $display_name; ?><strong>UID: <i><?php echo $uid?$uid:'Undefined'; ?></i></strong>
                                            <a class="toprofile" href="<?php echo $link_profile; ?>" title=""><?php _e('Quản lý tài khoản của bạn', 'tried'); ?></a>
                                        </div>
                                    </li>
                                    <li class="links-user">
                                        <ul class="links">
                                            <?php
                                                if (!empty($links_args)) :
                                                    foreach ($links_args as $l) :
                                                        echo '<li><a href="'.$link_profile.$l['link'].'">'.$l['name'].'</a></li>';
                                                    endforeach;
                                                endif;
                                                if ( current_user_can( 'administrator', $user->ID ) ) :
                                                    echo '<li><a href="'.admin_url().'">'.__('Quản lý Admin').'</a></li>';
                                                endif;
                                            ?>
                                        </ul>
                                    </li>
                                    <li class="logout-user">
                                        <a href="<?php echo wp_logout_url(); ?>" class="tologout"><?php _e('Đăng xuất', 'tried'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="login-block">
                            <a href="<?php echo $link_profile; ?>" title="Đăng Nhập/Đăng Ký"><?php _e('Đăng Nhập/Đăng Ký', 'tried'); ?></a>
                        </div>
                    <?php endif; ?>
			    </div>
			</section>
        <?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['link_profile'] = ($new_instance['link_profile']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('link_profile' => '');
        $instance = wp_parse_args($instance, $defaults);
	    ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link_profile')); ?>"><?php esc_html_e('Link thông tin tài khoản', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['link_profile']); ?>" name="<?php echo esc_attr($this->get_field_name('link_profile')); ?>" id="<?php echo esc_attr($this->get_field_id('link_profile')); ?>" />
            </p>
   	    <?php
    }
}
