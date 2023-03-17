<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// add new role user
add_action('init', 'tried_new_role_user');
function tried_new_role_user() {
	global $wp_roles;
    if ( ! isset( $wp_roles ) ) {
        $wp_roles = new WP_Roles();
		$member = $wp_roles->get_role('Subscriber');
		$wp_roles->add_role( 'member', __('Người dùng', 'tried'), $member->capabilities );
	}
}

// register form
add_shortcode('tried_register_form', 'sc_tried_register_form');
function sc_tried_register_form() {
    ob_start();
	if (is_user_logged_in()) {
		echo '<p>'.__("Bạn đã đăng nhập rồi.", 'tried').'</p>';
	} else {
		global $wp;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') :
			$message = process_register_form($_POST);
	?>
			<div class="message <?php echo $message['notify']; ?>">
				<p><?php echo $message['content']; ?></p>
			</div>
	<?php
		endif;
	?>
			<div id="register-form-wrapper">
				<form  method="post" action="<?php echo add_query_arg( 'form', 'register', home_url( $wp->request ) ); ?>">
					<?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
					<div class="col-field fullname">
						<label for="user-fullname"><?php _e( 'Họ và tên', 'tried' ) ?>:</label>
						<input type="text" name="fullname" id="user-fullname" value="<?php echo esc_attr($fullname) ?>">
					</div>
					<?php echo do_shortcode('[tried_register_form_fields]'); ?>
					<div class="col-field username">
						<label for="user-username"><?php _e( 'Tên người dùng hoặc Email', 'tried' ) ?>:</label>
						<input type="text" name="username" id="user-username" value="<?php echo esc_attr($username) ?>">
					</div>
					<div class="col-field password">
						<label for="user-password"><?php _e('Mật Khẩu', 'tried'); ?>:</label>
						<input type="password" name="password" id="user-password" value="<?php echo esc_attr($password) ?>">
					</div>
					<div class="col-field submit">
						<button type="submit"><?php _e('Đăng ký', 'tried'); ?></button>
					</div>
					<div class="another-field">
						<div class="backlogin-account">
							<p>
								<a href="<?php echo esc_url( add_query_arg( 'form', 'login', home_url( $wp->request ) ) ); ?>">
									<i class="far fa-arrow-left"></i>
									<?php _e('Quay trở lại', 'tried'); ?>
								</a>
							</p>
						</div>
					</div>
				</form>
			</div>
	<?php
	}
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}

add_shortcode( 'tried_register_form_fields', 'sc_tried_register_form_fields' );
function sc_tried_register_form_fields( $atts, $contents = null ) {
	$args = shortcode_atts(array(
        'company' => '',
        'phone' => '',
        'address' => ''
    ), $atts);
	?>
		<div class="col-field company">
			<span class="fieldlabels"><?php _e( 'Công ty', 'tried' ) ?>:</span>
			<input type="text" name="company" id="user-company" value="<?php echo esc_attr( stripslashes( $args['company'] ) ); ?>">
		</div>
		<div class="col-field phone">
			<span class="fieldlabels"><?php _e( 'Phone', 'tried' ) ?><span class="required">*</span>:</span>
			<input type="number" name="phone" id="user-phone" value="<?php echo esc_attr( stripslashes( $args['phone'] ) ); ?>">
		</div>
		<div class="col-field address">
			<span class="fieldlabels"><?php _e( 'Địa chỉ', 'tried' ) ?><span class="required">*</span>:</span>
			<textarea name="address" id="user-address" cols="30" rows="2"><?php echo esc_attr( stripslashes( $args['address'] ) ); ?></textarea>
		</div>
	<?php
}

function process_register_form($args) {
	global $wp;
	$fullname = sanitize_text_field($args['fullname']);
	$username = sanitize_user($args['username']);
	$password = sanitize_text_field($args['password']);
	$message = array(
		'notify' => 'warning',
		'content' => 'Xin lỗi, phiên làm việc hiện tại đang có lỗi phát sinh.'
	);
	if( isset( $args['tried-accountform-nonce'] ) && wp_verify_nonce($args['tried-accountform-nonce'], 'tried-accountform') ) {
		if ( !empty( $username ) && !empty( $password ) ) {
			$email = 'info@temp.com';
			if ( validate_string_to_email( $username ) ) {
				$email = $username;
			}
			$user_id = wp_create_user($username, $password, $email);
			$errors = apply_filters( 'registration_errors', $errors, $username, $password );
			if ( !$user_id || is_wp_error( $user_id ) ) {
				$message = array(
					'notify' => 'danger',
					'content' => $user_id->get_error_message()
				);
			} else {
				$capability = 'member';
				$prefix_uid = 'M';
				$userinfo = array(
					'ID' => $user_id,
					'first_name' => ucwords($fullname),
					'role' => $capability
				);
				$uid = $prefix_uid.current_time('timestamp');
				update_user_meta( $user_id, 'uid', $uid );
				wp_update_user( $userinfo );
				$message = array(
					'notify' => 'success',
					'content' => 'Tài khoản '.$username.' đã được tạo thành công! <a href="'.esc_url( add_query_arg( 'form', 'login', home_url( $wp->request ) ) ).'">'.__('Đăng nhập ngay', 'tried').'</a>'
				);
			}
		}
	}
	return $message;
}

if( !function_exists('tried_register_form') ) {
	add_filter( 'registration_errors', 'ft_registration_errors', 10, 3 );
	function ft_registration_errors( $errors, $username, $password ) {
		global $errors;
		if (! is_wp_error($errors)) $errors = new WP_Error();
		if ( empty ( $_POST['phone'] ) ) {
			$errors->add( 'phone_error', __( '<strong>Lỗi</strong>: Company name is required.', 'tried' ) );
		}
		return $errors;
	}

    //  This action for 'Add New User' screen
    add_action( 'user_new_form', 'tried_register_profile_fields' );
    //  This actions for 'User Profile' screen
    add_action( 'show_user_profile', 'tried_register_profile_fields' );
    add_action( 'edit_user_profile', 'tried_register_profile_fields' );
    function tried_register_profile_fields( $user ) {
        if ( !current_user_can( 'administrator', $user->ID ) ) return false;
        ?>
			<h2><?php _e('Thông tin bổ sung', 'tried'); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr class="user-uid-wrap">
						<th><label for="user-uid"><?php _e('UID', 'tried'); ?></label></th>
						<td><strong><?php echo get_the_author_meta( 'uid', $user->ID ); ?></strong></td>
					</tr>
				</tbody>
			</table>
			<h2><?php _e('Thông tin cá nhân', 'tried'); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr class="user-phone-wrap">
						<th><label for="user-phone"><?php _e('Phone', 'tried'); ?></label></th>
						<td><input type="text" class="regular-text" name="phone" id="user-phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>"/></td>
					</tr>
					<tr class="user-company-wrap">
						<th><label for="user-company"><?php _e('Công ty', 'tried'); ?></label></th>
						<td><input type="text" class="regular-text" name="company" id="user-company" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>"/></td>
					</tr>
					<tr class="user-address-wrap">
						<th><label for="user-address"><?php _e('Địa chỉ', 'tried'); ?></label></th>
						<td><textarea class="regular-text" name="address" id="user-address" cols="30" rows="2"><?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?></textarea></td>
					</tr>
				</tbody>
			</table>
			<h2><?php _e('Mạng xã hội', 'tried'); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr class="user-facebook-wrap">
						<th><label for="user-facebook"><?php _e('Facebook', 'tried'); ?></label></th>
						<td><input type="text" class="regular-text" name="facebook" id="user-facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>"/></td>
					</tr>
					<tr class="user-twitter-wrap">
						<th><label for="user-twitter"><?php _e('Twitter', 'tried'); ?></label></th>
						<td><input type="text" class="regular-text" name="twitter" id="user-twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>"/></td>
					</tr>
					<tr class="user-skype-wrap">
						<th><label for="user-skype"><?php _e('Skype', 'tried'); ?></label></th>
						<td><input type="text" class="regular-text" name="skype" id="user-skype" value="<?php echo esc_attr( get_the_author_meta( 'skype', $user->ID ) ); ?>"/></td>
					</tr>
					<tr class="user-instagram-wrap">
						<th><label for="user-instagram"><?php _e('Instagram', 'tried'); ?></label></th>
						<td><input type="text" class="regular-text" name="instagram" id="user-instagram" value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user->ID ) ); ?>"/></td>
					</tr>
				</tbody>
			</table>
    	<?php
	}

    //  This action save 'Add New User'
    add_action( 'user_register', 'tried_save_profile_register' );
	function tried_save_profile_register( $user_id ) {
		if ( isset( $_POST['company'] ) ) {
			update_user_meta($user_id, 'company', $_POST['company']);
		}
		if ( isset( $_POST['address'] ) ) {
			update_user_meta($user_id, 'address', $_POST['address']);
		}
		if ( isset( $_POST['phone'] ) ) {
			update_user_meta($user_id, 'phone', $_POST['phone']);
		}
	}

    //  This actions save 'User Profile'
    add_action( 'personal_options_update', 'tried_save_profile_fields' );
    add_action( 'edit_user_profile_update', 'tried_save_profile_fields' );
    function tried_save_profile_fields( $user_id ) {
		if ( isset( $_POST['company'] ) ) {
			update_user_meta($user_id, 'company', $_POST['company']);
		}
		if ( isset( $_POST['address'] ) ) {
			update_user_meta($user_id, 'address', $_POST['address']);
		}
		if ( isset( $_POST['phone'] ) ) {
			update_user_meta($user_id, 'phone', $_POST['phone']);
		}
		if ( isset( $_POST['facebook'] ) ) {
			update_user_meta($user_id, 'facebook', $_POST['facebook']);
		}
		if ( isset( $_POST['twitter'] ) ) {
			update_user_meta($user_id, 'twitter', $_POST['twitter']);
		}
		if ( isset( $_POST['skype'] ) ) {
			update_user_meta($user_id, 'skype', $_POST['skype']);
		}
		if ( isset( $_POST['instagram'] ) ) {
			update_user_meta($user_id, 'instagram', $_POST['instagram']);
		}
    }
}

// login form
add_shortcode('tried_login_form', 'sc_tried_login_form');
function sc_tried_login_form() {
    ob_start();
	if (is_user_logged_in()) {
		echo '<p>'.__("Bạn đã đăng nhập rồi.", 'tried').'</p>';
	} else {
		global $wp;
		?>
			<div id="login-form-wrapper">
				<?php if (!empty($message)) : ?>
					<div class="message <?php echo $notify['level']; ?>">
						<p><?php echo $notify['message']; ?></p>
					</div>
				<?php endif; ?>
				<form method="post" action="<?php echo wp_login_url(); ?>">
					<?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
					<input type="hidden" name="redirect_to" value="<?php echo admin_url(); ?>">
					<div class="col-field username">
						<label for="user_name"><?php _e( 'Tên người dùng hoặc Email', 'tried' ) ?>:</label>
						<input type="text" name="log" id="user_name" value="<?php echo esc_attr($username) ?>">
					</div>
					<div class="col-field password">
						<label for="user_pass">Mật Khẩu:</label>
						<input type="password" name="pwd" id="user_pass" autocomplete="current-password" value="<?php echo esc_attr($password) ?>">
					</div>
					<div class="col-field remember">
						<label for="remember">
							<input type="checkbox" name="rememberme" id="remember" value="<?php echo esc_attr($remember) ?>">
							Ghi nhớ mật khẩu
						</label>
					</div>
					<div class="col-field submit">
						<button type="submit" name="wp-submit"><?php _e('Đăng nhập', 'tried'); ?></button>
					</div>
					<div class="another-field">
						<div class="notyet-account">
							<p>
								<?php _e('Bạn chưa có tài khoản?', 'tried'); ?>
								<a href="<?php echo esc_url( add_query_arg( 'form', 'register', home_url( $wp->request ) ) ); ?>"><?php _e('Đăng ký', 'tried'); ?></a>
							</p>
						</div>
					</div>
				</form>
			</div>
		<?php
	}
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}

if( !function_exists('tried_login_form') ) {
	function no_wordpress_errors(){
		return 'Something is wrong!';
	}
	add_filter( 'login_errors', 'no_wordpress_errors' );
}

// Allows the use of email logins
add_action( 'wp_authenticate', 'optional_email_address_login', 1, 2 );
function optional_email_address_login( $username, $password ) {
	$user = get_user_by( 'email', $username );
	if ( !empty( $user->user_login ) ) {
		$username = $user->user_login;
	}
}

// Redirect after logout
add_action('wp_logout','tried_redirect_after_logout');
function tried_redirect_after_logout() {
  wp_safe_redirect( home_url() );
  exit();
}

add_action( 'after_setup_theme', 'tried_login_user' );
function tried_login_user() {
	if ( !is_user_logged_in() ) {
		if( isset( $_POST['tried-accountform-nonce'] ) && wp_verify_nonce($_POST['tried-accountform-nonce'], 'tried-accountform') ) {
			$username = sanitize_user($_POST['log']);
			$password = sanitize_text_field($_POST['pwd']);
			$remember = isset($_POST['rememberme']) ? intval($_POST['rememberme']) : 0;
	
			$creds = array(
				'user_login' => $username,
				'user_password' => $password,
				'remember' => $remember
			);
			$user = wp_signon( $creds, false );
			if ( is_wp_error( $user ) ) {
				error_log( $user->get_error_message() );
			}
		}
	}
}

// change password
function process_change_password_form( $user_id ) {
	$errors = apply_filters( 'change_password_errors', $errors, $user_id, array(
		'action' => $_POST['tried-accountform-nonce'],
		'name' => 'tried-accountform'
	), $_POST['currentpassword'], $_POST['newpassword'] );
	$message = array(
		'notify' => 'warning',
		'content' => 'Xin lỗi, phiên làm việc hiện tại đang có lỗi phát sinh.'
	);
	if ( is_wp_error($errors) && !empty($errors->get_error_messages()) ) {
		$message = array(
			'notify' => 'warning',
			'content' => __( '<strong>Lỗi:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $errors->get_error_messages()).'</li></ul>'
		);
	} else {
		$set_password = wp_set_password( $_POST['newpassword'], $user_id );
		if ( is_wp_error($set_password) ) {
			$message = array(
				'notify' => 'warning',
				'content' => __( '<strong>Lỗi:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $set_password->get_error_messages()).'</li></ul>'
			);
		} else  {
			$message = array(
				'notify' => 'success',
				'content' => __( '<strong>Thành công:</strong> Tài khoản đã cập nhật lại mật khẩu.', 'tried' )
			);
		}
	}
	return $message;
}

add_filter( 'change_password_errors', 'ft_change_password_errors', 10, 5 );
function ft_change_password_errors( $errors, $user_id, $verify, $currentpassword, $newpassword ) {
	global $errors;
	if (! is_wp_error($errors)) $errors = new WP_Error();
	if( isset( $verify['action'] ) && wp_verify_nonce( $verify['action'], $verify['name'] ) ) {
		if ( empty($currentpassword) ) {
			$errors->add( 'currentpassword_errors', __( 'Mật khẩu hiện tại không được để rỗng.', 'tried' ) );
		} else {
			$user_data = get_user_by('id', $user_id);
			if ( !wp_check_password( $currentpassword, $user_data->user_pass, $user_id) ) {
				$errors->add( 'checkpassword_errors', __( 'Mật khẩu hiện tại không chính xác.', 'tried' ) );
			} else {
				if ( empty($newpassword) ) {
					$errors->add( 'newpassword_errors', __( 'Mật khẩu mới không được để rỗng.', 'tried' ) );
				}
			}
		}
	} else {
		$errors->add( 'failded_errors', __( 'đã phát hiện một lỗi phát sinh.', 'tried' ) );
	}
	return $errors;
}

// update info
function process_update_info_form( $user_id ) {
	$errors = apply_filters( 'update_info_errors', $errors, $user_id, array(
		'action' => $_POST['tried-accountform-nonce'],
		'name' => 'tried-accountform'
	), $_POST );
	$message = array(
		'notify' => 'warning',
		'content' => 'Xin lỗi, phiên làm việc hiện tại đang có lỗi phát sinh.'
	);
	if ( is_wp_error($errors) && !empty($errors->get_error_messages()) ) {
		$message = array(
			'notify' => 'warning',
			'content' => __( '<strong>Lỗi:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $errors->get_error_messages()).'</li></ul>'
		);
	} else {
		update_user_meta( $user_id, 'company', $_POST['company'] );
		update_user_meta( $user_id, 'phone', $_POST['phone'] );
		update_user_meta( $user_id, 'address', $_POST['address'] );
		update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
		update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
		update_user_meta( $user_id, 'skype', $_POST['skype'] );
		update_user_meta( $user_id, 'instagram', $_POST['instagram'] );
		wp_update_user( array(
			'ID' => $user_id,
			'display_name' => $_POST['fullname'],
			'user_email' => $_POST['email']
		) );
		$message = array(
			'notify' => 'success',
			'content' => __( '<strong>Thành công:</strong> Thông tin tài khoản đã được cập nhật.', 'tried' )
		);
	}
	return $message;
}

add_filter( 'update_info_errors', 'ft_update_info_errors', 10, 4 );
function ft_update_info_errors( $errors, $user_id, $verify, $args ) {
	global $errors;
	if (! is_wp_error($errors)) $errors = new WP_Error();
	if( isset( $verify['action'] ) && wp_verify_nonce( $verify['action'], $verify['name'] ) ) {
		if ( empty( $args['password'] ) ) {
			$errors->add( 'password_errors', __( 'Không được để trống Mật khẩu.', 'tried' ) );
		} else {
			$user_data = get_user_by('id', $user_id);
			if ( !wp_check_password( $args['password'], $user_data->user_pass, $user_id) ) {
				$errors->add( 'password_errors', __( 'Mật khẩu không chính xác.', 'tried' ) );
			} else {
				if ( empty($args['fullname']) ) {
					$errors->add( 'fullname_errors', __( 'Họ và tên không được để trống.', 'tried' ) );
				}
				if ( empty($args['phone']) ) {
					$errors->add( 'phone_errors', __( 'Số điện thoại không được để trống.', 'tried' ) );
				}
				if ( empty($args['address']) ) {
					$errors->add( 'address_errors', __( 'Địa chỉ không được để trống.', 'tried' ) );
				}
				if ( empty($args['email']) ) {
					$errors->add( 'email_errors', __( 'Email không được để trống.', 'tried' ) );
				} elseif ( !validate_string_to_email( $args['email'] ) ) {
					$errors->add( 'email_errors', __( 'Email không đúng định dạng.', 'tried' ) );
				}
			}
		}
	} else {
		$errors->add( 'failded_errors', __( 'đã phát hiện một lỗi phát sinh.', 'tried' ) );
	}
	return $errors;
}


// Custom User's avatar
add_action( 'show_user_profile', 'tried_profile_img_fields' );
add_action( 'edit_user_profile', 'tried_profile_img_fields' );
function tried_profile_img_fields( $user ) {
	if ( ! current_user_can( 'upload_files' ) ) return;
	$upload_url      = get_the_author_meta( 'tried_upload_meta', $user->ID );
	$upload_edit_url = get_the_author_meta( 'tried_upload_edit_meta', $user->ID );
	$button_text     = $upload_url ? 'Change Current Image' : 'Upload New Image';
	if ( $upload_url ) {
		$upload_edit_url = get_site_url() . $upload_edit_url;
	}
	$avatar = get_avatar_url( $user->ID );
	if ( !empty( $avatar ) ) {
		$avatar_url = $avatar;
	}
	?>
	<h2><?php _e( 'Hình ảnh đại diện', 'tried' ); ?></h2>
	<div id="tried_container">
		<table class="form-table">
			<tr>
				<th><label for="tried_meta"><?php _e( 'Profile Photo', 'tried' ); ?></label></th>
				<td>
					<!-- Outputs the image after save -->
					<div id="current_img">
						<?php if ( $upload_url ): ?>
							<img class="tried-current-img" src="<?php echo esc_url( $upload_url ); ?>"/>
							<div class="edit_options uploaded">
								<a class="remove_img" href="javascript:void(0)"><?php _e( 'Xóa', 'tried' ); ?></a>
								<a class="edit_img" href="<?php echo esc_url( $upload_edit_url ); ?>" target="_blank"><?php _e( 'Chỉnh sửa', 'tried' ); ?></a>
							</div>
						<?php elseif ( $avatar_url ) : ?>
							<img class="tried-current-img" src="<?php echo esc_url( $avatar_url ); ?>"/>
							<div class="edit_options single">
								<a class="remove_img" href="javascript:void(0)"><?php _e( 'Remove', 'tried' ); ?></a>
							</div>
						<?php else : ?>
							<img class="tried-current-img placeholder" src="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>"/>
						<?php endif; ?>
					</div>
					<!-- Select an option: Upload to WPMU or External URL -->
					<div id="tried_options">
						<label for="upload_option"><input type="radio" id="upload_option" name="img_option" value="upload" class="tog" checked> <?php _e( 'Upload New Image', 'tried' ); ?></label>
						<label for="external_option"><input type="radio" id="external_option" name="img_option" value="external" class="tog"> <?php _e( 'Use External URL', 'tried' ); ?></label>
					</div>
					<!-- Hold the value here if this is a WPMU image -->
					<div id="tried_upload">
						<input class="hidden" type="hidden" name="tried_placeholder_meta" id="tried_placeholder_meta" value="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>"/>
						<input class="hidden" type="hidden" name="tried_upload_meta" id="tried_upload_meta" value="<?php echo esc_url_raw( $upload_url ); ?>"/>
						<input class="hidden" type="hidden" name="tried_upload_edit_meta" id="tried_upload_edit_meta" value="<?php echo esc_url_raw( $upload_edit_url ); ?>"/>
						<input id="uploadimage" type='button' class="tried_wpmu_button button-primary" value="<?php _e( esc_attr( $button_text ), 'tried' ); ?>"/>
					</div>
					<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
					<div id="tried_external" style="display: none;">
						<input class="regular-text" type="text" name="tried_meta" id="tried_meta" value="<?php echo esc_url_raw( $url ); ?>"/>
					</div>
					<!-- Outputs the save button -->
					<p class="description">
						<?php _e( 'Update Profile to save your changes.', 'tried' ); ?>
					</p>
				</td>
			</tr>
		</table><!-- end form-table -->
	</div> <!-- end #tried_container -->
	<?php
	// Enqueue the WordPress Media Uploader.
	wp_enqueue_media();
}

add_action( 'personal_options_update', 'tried_save_img_meta' );
add_action( 'edit_user_profile_update', 'tried_save_img_meta' );
function tried_save_img_meta( $user_id ) {
	// print_r($_POST); exit();
	if ( ! current_user_can( 'upload_files', $user_id ) ) return;
	$values = array(
		// String value. Empty in this case.
		'tried_meta' => filter_input( INPUT_POST, 'tried_meta', FILTER_SANITIZE_STRING ),
		// File path, e.g., http://3five.dev/wp-content/plugins/tried/img/placeholder.gif.
		'tried_upload_meta' => filter_input( INPUT_POST, 'tried_upload_meta', FILTER_SANITIZE_URL ),
		// Edit path, e.g., /wp-admin/post.php?post=32&action=edit&image-editor.
		'tried_upload_edit_meta' => filter_input( INPUT_POST, 'tried_upload_edit_meta', FILTER_SANITIZE_URL ),
	);
	foreach ( $values as $key => $value ) {
		update_user_meta( $user_id, $key, $value );
	}
}

add_filter( 'get_avatar', 'tried_avatar', 1, 5 );
function tried_avatar( $avatar, $identifier, $size, $alt ) {
	if ( $user = tried_get_user_by_id_or_email( $identifier ) ) {
		if ( $custom_avatar = get_tried_meta( $user->ID, 'thumbnail' ) ) {
			return "<img alt='{$alt}' src='{$custom_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}
		if ( $attachment_upload_url = esc_url( get_the_author_meta( 'tried_upload_meta', $user->ID ) ) ) {
			return "<img alt='{$alt}' src='{$attachment_upload_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}
	}
	return $identifier;
}

function get_tried_meta( $user_id, $size = 'thumbnail' ) {
	global $post;
	if ( ! $user_id || ! is_numeric( $user_id ) ) {
		$user_id = $post->post_author;
	}
	// Check first for a custom uploaded image.
	$attachment_upload_url = esc_url( get_the_author_meta( 'tried_upload_meta', $user_id ) );
	if ( $attachment_upload_url ) {
		// Grabs the id from the URL using the WordPress function attachment_url_to_postid @since 4.0.0.
		$attachment_id = attachment_url_to_postid( $attachment_upload_url );
		// Retrieve the thumbnail size of our image. Should return an array with first index value containing the URL.
		$image_thumb = wp_get_attachment_image_src( $attachment_id, $size );
		return isset( $image_thumb[0] ) ? $image_thumb[0] : '';
	}
	// Finally, check for image from an external URL. If none exists, return an empty string.
	$attachment_ext_url = esc_url( get_the_author_meta( 'tried_meta', $user_id ) );
	return $attachment_ext_url ? $attachment_ext_url : '';
}

function tried_get_user_by_id_or_email( $identifier ) {
	// If an integer is passed.
	if ( is_numeric( $identifier ) ) {
		return get_user_by( 'id', (int) $identifier );
	}
	// If the WP_User object is passed.
	if ( is_object( $identifier ) && property_exists( $identifier, 'ID' ) ) {
		return get_user_by( 'id', (int) $identifier->ID );
	}
	// If the WP_Comment object is passed.
	if ( is_object( $identifier ) && property_exists( $identifier, 'user_id' ) ) {
		return get_user_by( 'id', (int) $identifier->user_id );
	}
	return get_user_by( 'email', $identifier );
}
