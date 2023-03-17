<?php 
/* Template Name: Hồ sơ */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-fileupload' );
wp_enqueue_script( 'tried-fileupload' );

global $current_user, $wp;
wp_get_current_user();

// infos
$user_id = $current_user->ID;
$user_uid = !empty(get_the_author_meta( 'uid', $current_user->ID ))?get_the_author_meta( 'uid', $current_user->ID ):'Undefined';
$user_displayname = $current_user->display_name;
$user_login = $current_user->user_login;
$user_email = !empty($current_user->user_email)?$current_user->user_email:'info@temp.com';
$user_cap = $current_user->caps;
$avatar_url = get_avatar_url( $current_user->ID );
$user_company = !empty(get_the_author_meta( 'company', $current_user->ID ))?get_the_author_meta( 'company', $current_user->ID ):'-';
$user_phone = !empty(get_the_author_meta( 'phone', $current_user->ID ))?get_the_author_meta( 'phone', $current_user->ID ):'-';
$user_address = !empty(get_the_author_meta( 'address', $current_user->ID ))?get_the_author_meta( 'address', $current_user->ID ):'-';
// socials
$social_facebook =  get_the_author_meta( 'facebook', $current_user->ID );
$social_twitter =  get_the_author_meta( 'twitter', $current_user->ID );
$social_skype =  get_the_author_meta( 'skype', $current_user->ID );
$social_instagram =  get_the_author_meta( 'instagram', $current_user->ID );

$khoanno_categories = get_terms(array(
    'taxonomy' => 'khoan-no_cat',
    'hide_empty' => false
));

$provinces = get_position_data();

$current_block =  $_GET['block']?'profile':$_GET['block'];
$message_form = array();
?>
<?php get_header(); ?>
    <main <?php post_class( 'site-main' ); ?> role="main">
        <div class="main-contain profile">
            <div class="wrapper">
                <div class="page-content">
                    <?php if ( is_user_logged_in() ) : ?>
                        <?php
                            if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) :
                                switch ( $_GET['action'] ) :
                                    case 'update-info':
                                        $message_form = process_update_info_form( $user_id );
                                        break;
                                    case 'change-password':
                                        $message_form = process_change_password_form( $user_id );
                                        break;
                                    case 'new-khoanno':
                                        $message_form = process_new_khoanno_form( $user_id );
                                        break;
                                    case 'update-khoanno':
                                        $message_form = process_update_khoanno_form( $user_id );
                                        break;
                                    default:
                                        # code...
                                        break;
                                endswitch;
                            endif;
                        ?>
                        <div class="profile-contain" role="<?php echo $current_block; ?>">
                            <div class="profile-tab">
                                <?php
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
                                    $key_avatarupload = wp_generate_uuid4();
                                ?>
                                <div class="avatar-user avatar-upload <?php echo $key_avatarupload; ?>">
                                    <div class="avatar-edit">
                                        <input type="hidden" name="avatar_url" value="" data-attachment="" data-placeholder="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>"/>
                                        <a class="avatar-browse" href="javascript:void(0)" id="file-browse" data-order="<?php echo $key_avatarupload; ?>"></a>
                                    </div>
						            <?php if ( $upload_url ): ?>
                                        <div class="avatar-preview" style="background-image: url(<?php echo esc_url( $upload_url ); ?>);"></div>
                                    <?php elseif ( $avatar_url ) : ?>
                                        <div class="avatar-preview" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
                                    <?php else : ?>
                                        <div class="avatar-preview" style="background-image: url(<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>);"></div>
                                    <?php endif; ?>
                                </div>
                                <ul class="lists-navigation">
                                    <li class="navigation-item">
                                        <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-profile', home_url( $wp->request ) ) ); ?>"><?php _e('Thông tin tài khoản', 'tried'); ?></a>
                                    </li>
                                    <li class="navigation-item">
                                        <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-khoanno', home_url( $wp->request ) ) ); ?>"><?php _e('Khoản nợ đã đăng', 'tried'); ?></a>
                                    </li>
                                    <li class="navigation-item">
                                        <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-saves', home_url( $wp->request ) ) ); ?>"><?php _e('Đã lưu', 'tried'); ?></a>
                                    </li>
                                    <li class="navigation-item">
                                        <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-policy', home_url( $wp->request ) ) ); ?>"><?php _e('Chính sách', 'tried'); ?></a>
                                    </li>
                                    <li class="navigation-item">
                                        <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-helps', home_url( $wp->request ) ) ); ?>"><?php _e('Trợ giúp', 'tried'); ?></a>
                                    </li>
                                    <li class="navigation-item">
                                        <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-settings', home_url( $wp->request ) ) ); ?>"><?php _e('Cài đặt', 'tried'); ?></a>
                                    </li>
                                    <li class="navigation-item">
                                        <a href="<?php echo wp_logout_url(); ?>"><?php _e('Đăng xuất', 'tried'); ?></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="profile-content">
                                <?php if ( !empty($_GET) ) : ?>
                                    <?php if ( $_GET['block'] == 'ctt-khoanno' ) : ?>
                                        <div class="content-item" id="ctt-khoanno">
                                            <?php if ( $_GET['action'] == 'new-khoanno' ) : ?>
                                                <?php
                                                    $is_complete = false;
                                                    if ( ( $message_form['notify'] && $message_form['notify'] == 'success' ) || $_SERVER['REQUEST_METHOD'] === 'POST' ) {
                                                        $is_complete = true;
                                                    }
                                                ?>
                                                <div class="new-khoanno">
                                                    <div class="header-wrap">
                                                        <h3 class="title"><?php _e('Thêm mới khoản nợ', 'tried'); ?></h3>
                                                    </div>
                                                    <div class="body-wrap">
                                                        <?php if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) : ?>
                                                            <div class="step-form">
                                                        <?php else : ?>
                                                            <form class="step-form" method="post" action="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'new-khoanno' ), home_url( $wp->request ) ); ?>">
                                                        <?php endif; ?>
                                                            <ul class="progressbar-bar">
                                                                <li class="fal fa-window active" id="account"><?php _e( 'Khoản nợ', 'tried' ); ?></li>
                                                                <li class="fal fa-box-alt <?php echo $is_complete?'active':''; ?>"><?php _e( 'Tài sản đảm bảo', 'tried' ); ?></li>
                                                                <li class="fal fa-address-card <?php echo $is_complete?'active':''; ?>"><?php _e( 'Thông tin người mượn nợ', 'tried' ); ?></li>
                                                                <li class="fal fa-clipboard-user <?php echo $is_complete?'active':''; ?>"><?php _e( 'Thông tin người bán', 'tried' ); ?></li>
                                                                <li class="fal fa-check <?php echo $is_complete?'active':''; ?>"><?php _e( 'Hoàn thành', 'tried' ); ?></li>
                                                            </ul>
                                                            <?php if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) : ?>
                                                                <input type="hidden" name="knid" value="<?php echo 'KN'.current_time( 'timestamp' ); ?>">
                                                                <?php wp_nonce_field( 'tried-khoannoform', 'tried-khoannoform-nonce' ); ?>
                                                                <fieldset class="<?php echo !$is_complete?'active':''; ?>">
                                                                    <div class="wrappper-step">
                                                                        <div class="wrap-head">
                                                                            <h4 class="step-title"><?php _e( 'Thông tin khoản nợ', 'tried' ); ?></h4>
                                                                        </div>
                                                                        <div class="wrap-body">
                                                                            <div class="col-field khoanno-name">
                                                                                <span class="fieldlabels"><?php _e( 'Tên khoản nợ', 'tried' ) ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="knname" id="user-khoanno-name" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-type">
                                                                                <span class="fieldlabels"><?php _e( 'Loại khoản nợ', 'tried' ) ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <label for="user-type-difference">
                                                                                        <input name="type" type="radio" id="user-type-difference" value="diff" checked><?php _e('Nợ khác', 'tried'); ?>
                                                                                    </label>
                                                                                    <label for="user-type-bank">
                                                                                        <input name="type" type="radio" id="user-type-bank" value="bank"><?php _e('Nợ ngân hàng', 'tried'); ?>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-name_bank" style="display: none;">
                                                                                <span class="fieldlabels"><?php _e( 'Tên ngân hàng', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="name_bank" id="user-khoanno-name_bank" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-content">
                                                                                <span class="fieldlabels"><?php _e( 'Mô tả', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <?php
                                                                                        wp_editor(
                                                                                            htmlspecialchars(''),
                                                                                            'user-khoanno-content',
                                                                                            $settings = array(
                                                                                                'media_buttons' => false,
                                                                                                'textarea_name' => 'content',
                                                                                                'wp_autoresize_on' => false,
                                                                                                'textarea_rows' => 10,
                                                                                                'editor_height' => 200,
                                                                                                'editor_class' => 'width-auto',
                                                                                                'tinymce' => false
                                                                                            )
                                                                                        );
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-value">
                                                                                <span class="fieldlabels"><?php _e('Số tiền nợ gốc', 'tried'); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="number" name="value" id="user-khoanno-value" value="0" min="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-value_interest">
                                                                                <span class="fieldlabels"><?php _e('Lãi phát sinh (đến thời điểm đăng bán)', 'tried'); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="number" name="value_interest" id="user-khoanno-value_interest" value="0" min="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-total_value">
                                                                                <span class="fieldlabels"><?php _e('Tổng nợ', 'tried'); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <p id="user-khoanno-total-value">
                                                                                        <span class="currency">0</span>
                                                                                        <span class="unit">₫</span>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="next action-button"><?php _e( 'Tiếp tục', 'tried' ); ?></button>
                                                                    </div>
                                                                </fieldset>
                                                                <fieldset>
                                                                    <div class="wrappper-step">
                                                                        <div class="wrap-head">
                                                                            <h4 class="step-title"><?php _e( 'Tài sản đảm bảo', 'tried' ); ?></h4>
                                                                        </div>
                                                                        <div class="wrap-body">
                                                                            <div class="col-field khoanno-featuredimage">
                                                                                <span class="fieldlabels"><?php _e( 'Hình ảnh tài sản', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <?php echo do_shortcode('[fileupload_attachment]'); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-category">
                                                                                <span class="fieldlabels"><?php _e('Danh mục', 'tried'); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <?php
                                                                                        if ( !empty( $khoanno_categories ) ) :
                                                                                            foreach ($khoanno_categories as $kncat) :
                                                                                    ?>
                                                                                                <label for="cat-<?php echo $kncat->slug; ?>">
                                                                                                    <input name="category[]" type="checkbox" id="cat-<?php echo $kncat->slug; ?>" value="<?php echo $kncat->term_id; ?>"> <?php echo $kncat->name; ?>
                                                                                                </label>
                                                                                    <?php
                                                                                            endforeach;
                                                                                        endif;
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="next action-button"><?php _e( 'Tiếp tục', 'tried' ); ?></button>
                                                                        <button type="button" class="previous action-button action-button-highlight"><?php _e( 'Quay lại', 'tried' ); ?></button>
                                                                    </div>
                                                                </fieldset>
                                                                <fieldset>
                                                                    <div class="wrappper-step">
                                                                        <div class="wrap-head">
                                                                            <h4 class="step-title"><?php _e( 'Thông tin người mượn nợ', 'tried' ); ?></h4>
                                                                        </div>
                                                                        <div class="wrap-body">
                                                                            <div class="col-field khoanno-fullname_borrow">
                                                                                <span class="fieldlabels"><?php _e( 'Họ và tên', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="fullname_borrow" id="user-khoanno-fullname_borrow" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-company_borrow">
                                                                                <span class="fieldlabels"><?php _e( 'Tên công ty (nếu có)', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="company_borrow" id="user-khoanno-company_borrow" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-phone_borrow">
                                                                                <span class="fieldlabels"><?php _e( 'Số điện thoại', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="phone_borrow" id="user-khoanno-phone_borrow" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-email_borrow">
                                                                                <span class="fieldlabels"><?php _e( 'Email', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="email_borrow" id="user-khoanno-email_borrow" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-address_borrow">
                                                                                <span class="fieldlabels"><?php _e('Địa chỉ', 'tried'); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <textarea name="address_borrow" id="user-khoanno-address_borrow" rows="2"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-position">
                                                                                <span class="fieldlabels"><?php _e( 'Địa phương', 'tried' ) ?>:</span>
                                                                                <div class="wrap-fields slct-position">
                                                                                    <select name="posprovince" id="user-khoanno-position-provinces" class="slct-provinces">
                                                                                        <option value=""><?php _e( 'Chọn tỉnh', 'tried' ); ?></option>
                                                                                        <?php
                                                                                            if ( !empty( $provinces ) ) :
                                                                                                foreach ($provinces as $province) :
                                                                                                    echo '<option value="'.$province['province_service_order'].'-'.$province['province_service_key'].'" data-type="'.$province['type'].'" data-service="'.$province['province_service_key'].'">'.$province['name'].'</option>';
                                                                                                endforeach;
                                                                                            endif;
                                                                                        ?>
                                                                                    </select>
                                                                                    <select name="posdistrict" id="user-khoanno-position-districts" class="slct-districts">
                                                                                        <option value=""><?php _e( 'Chọn huyện', 'tried' ); ?></option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="next action-button"><?php _e( 'Tiếp tục', 'tried' ); ?></button>
                                                                        <button type="button" class="previous action-button action-button-highlight"><?php _e( 'Quay lại', 'tried' ); ?></button>
                                                                    </div>
                                                                </fieldset>
                                                                <fieldset>
                                                                    <div class="wrappper-step">
                                                                        <div class="wrap-head">
                                                                            <h4 class="step-title"><?php _e( 'Thông tin người bán', 'tried' ); ?></h4>
                                                                        </div>
                                                                        <div class="wrap-body">
                                                                            <div class="col-field khoanno-fullname_sell">
                                                                                <span class="fieldlabels"><?php _e( 'Họ và tên', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="fullname_sell" id="user-khoanno-fullname_sell" value="<?php echo $user_displayname; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-company_sell">
                                                                                <span class="fieldlabels"><?php _e( 'Tên công ty (nếu có)', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="company_sell" id="user-khoanno-company_sell" value="<?php echo $user_company; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-phone_sell">
                                                                                <span class="fieldlabels"><?php _e( 'Số điện thoại', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="phone_sell" id="user-khoanno-phone_sell" value="<?php echo $user_phone; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-email_sell">
                                                                                <span class="fieldlabels"><?php _e( 'Email', 'tried' ); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <input type="text" name="email_sell" id="user-khoanno-email_sell" value="<?php echo $user_email; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-field khoanno-address_sell">
                                                                                <span class="fieldlabels"><?php _e('Địa chỉ', 'tried'); ?>:</span>
                                                                                <div class="wrap-fields">
                                                                                    <textarea name="address_sell" id="user-khoanno-address_sell" rows="2"><?php echo $user_address; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="next action-button"><?php _e( 'Thêm mới', 'tried' ); ?></button>
                                                                        <button type="button" class="previous action-button action-button-highlight"><?php _e( 'Quay lại', 'tried' ); ?></button>
                                                                    </div>
                                                                    <div class="ask-popup">
                                                                        <h5 class="title-ask step-title"><?php _e( 'Sử dụng thông tin chủ tài khoản làm người đăng bán?', 'tried' ); ?></h5>
                                                                        <div class="chooses-ask">
                                                                            <button type="button" class="ask-choose action-button" roll="Y"><?php _e( 'Đồng ý', 'tried' ); ?></button>
                                                                            <button type="button" class="ask-choose action-button action-button-highlight" roll="N"><?php _e( 'Từ chối', 'tried' ); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            <?php endif; ?>
                                                            <fieldset class="<?php echo $is_complete?'active':''; ?>">
                                                                <div class="wrappper-step">
                                                                    <div class="wrap-head">
                                                                        <?php if ( $message_form['notify'] == 'success' ) : ?>
                                                                            <h4 class="step-title"><?php _e( 'Thành công', 'tried' ); ?></h4>
                                                                        <?php elseif ( $message_form['notify'] == 'success' ) : ?>
                                                                            <h4 class="step-title"><?php _e( 'Thất bại', 'tried' ); ?></h4>
                                                                        <?php else : ?>
                                                                            <h4 class="step-title"><?php _e( 'Chờ xử lý', 'tried' ); ?></h4>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="wrap-body">
                                                                        <?php if ( !empty( $message_form ) ) : ?>
                                                                            <div class="message <?php echo $message_form['notify']; ?>">
                                                                                <?php echo $message_form['content']; ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-khoanno', home_url( $wp->request ) ) ); ?>"><?php _e('Quay lại', 'tried'); ?></a>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        <?php if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) : ?>
                                                            </div>
                                                        <?php else :?>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php elseif ( $_GET['id'] && is_numeric( $_GET['id'] ) ) : ?>
                                                <?php
                                                    $khoanno_id = $_GET['id'];
                                                    $khoanno_data = get_post( $khoanno_id );
                                                    $khoanno_title = $khoanno_data->post_title?$khoanno_data->post_title:'#Undefined';
                                                    $khoanno_postdate = $khoanno_data->post_date;
                                                    $khoanno_poststatus = $khoanno_data->post_status;
                                                    $khoanno_postcontent = $khoanno_data->post_content;
                                                    $khoanno_category = get_the_terms( $khoanno_data, 'khoan-no_cat' );
                                                    $khoanno_category_ids = array();
                                                    if ( !empty( $khoanno_category ) ) {
                                                        foreach ($khoanno_category as $kncat) :
                                                            array_push( $khoanno_category_ids, $kncat->term_id );
                                                        endforeach;
                                                    }
                                                    $khoanno_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $khoanno_id ), 'full' );
                                                    $khoanno_image = get_theme_file_uri( "/assets/img/placeholder.png" );
                                                    if (!empty($khoanno_image_url[0])) {
                                                        $khoanno_image = $khoanno_image_url[0];
                                                    }
                                                    $khoanno_knid = get_post_meta( $khoanno_id, 'knid', true );
                                                    $khoanno_type = get_post_meta( $khoanno_id, 'type', true );
                                                    $khoanno_name_bank = get_post_meta( $khoanno_id, 'name_bank', true );
                                                    $khoanno_value = get_post_meta( $khoanno_id, 'value', true );
                                                    $khoanno_value_interest = get_post_meta( $khoanno_id, 'value_interest', true );
                                                    $khoanno_images_browses = get_post_meta( $khoanno_id, 'images_browses', true );

                                                    $khoanno_posprovince = get_post_meta( $khoanno_id, 'posprovince', true );
                                                    $khoanno_valposprovince = explode( '-', $khoanno_posprovince );
                                                    $khoanno_posdistrict = get_post_meta( $khoanno_id, 'posdistrict', true );
                                                    $khoanno_valposdistrict = explode( '-', $khoanno_posdistrict );
                                                    $khoanno_position = get_district_by_id( $khoanno_valposdistrict[0] );
                                                    
                                                    $khoanno_fullname_borrow = get_post_meta( $khoanno_id, 'fullname_borrow', true );
                                                    $khoanno_company_borrow = get_post_meta( $khoanno_id, 'company_borrow', true );
                                                    $khoanno_phone_borrow = get_post_meta( $khoanno_id, 'phone_borrow', true );
                                                    $khoanno_email_borrow = get_post_meta( $khoanno_id, 'email_borrow', true );
                                                    $khoanno_address_borrow = get_post_meta( $khoanno_id, 'address_borrow', true );

                                                    $khoanno_fullname_sell = get_post_meta( $khoanno_id, 'fullname_sell', true );
                                                    $khoanno_company_sell = get_post_meta( $khoanno_id, 'company_sell', true );
                                                    $khoanno_phone_sell = get_post_meta( $khoanno_id, 'phone_sell', true );
                                                    $khoanno_email_sell = get_post_meta( $khoanno_id, 'email_sell', true );
                                                    $khoanno_address_sell = get_post_meta( $khoanno_id, 'address_sell', true );
                                                ?>
                                                <?php if ( $_GET['action'] == 'detail-khoanno' ) : ?>
                                                    <div class="detail-khoanno">
                                                        <div class="header-wrap">
                                                            <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-khoanno', home_url( $wp->request ) ) ); ?>"><i class="far fa-arrow-left"></i><?php _e('Quay trở lại', 'tried'); ?></a>
                                                            <a href="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'update-khoanno', 'id' => $khoanno_id ), home_url( $wp->request ) ); ?>"><?php _e( 'Cập nhật', 'tried' ); ?></a>
                                                            <h3 class="title"><?php _e('Chi tiết', 'tried'); ?> <i><?php echo $khoanno_data->post_title; ?></i></h3>
                                                        </div>
                                                        <div class="body-wrap">
                                                            <table class="form-table" role="presentation">
                                                                <tbody>
                                                                    <!-- infos meta -->
                                                                    <tr class="user-meta-wrap">
                                                                        <th><?php _e('Phần Meta', 'tried'); ?></th>
                                                                        <td>
                                                                            <ul class="meta">
                                                                                <li><i class="fal fa-university"></i><?php echo ($khoanno_type == 'diff')?'Nợ khác':'Nợ ngân hàng'; ?></li>
                                                                                <li><i class="fal fa-user"></i><?php echo $khoanno_fullname_sell?$khoanno_fullname_sell:'#Name'; ?></li>
                                                                                <li><i class="fal fa-alarm-clock"></i><?php echo $khoanno_postdate; ?></li>
                                                                                <li><i class="fal fa-lock"></i><?php echo $khoanno_poststatus; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- infos additional -->
                                                                    <tr class="user-additional-wrap">
                                                                        <th><?php _e('Phần cơ bản', 'tried'); ?></th>
                                                                        <td>
                                                                            <p class="type">
                                                                                <?php echo ($khoanno_type == 'diff')?'Nợ khác':'Nợ ngân hàng'; ?>
                                                                                <?php
                                                                                    if ( $khoanno_type == 'bank' ) :
                                                                                        echo '<i>'.$khoanno_name_bank.'</i>';
                                                                                    endif;
                                                                                ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Hình ảnh', 'tried'); ?>
                                                                                <img src="<?php echo $image; ?>" alt="" style="width: 150px">
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Nội dung', 'tried'); ?>
                                                                                <?php echo $khoanno_postcontent; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Danh mục', 'tried'); ?>
                                                                                <?php
                                                                                    if ( !empty( $khoanno_category ) ) :
                                                                                        echo '<ul class="khoanno-categories">';
                                                                                        foreach( $khoanno_category as $knc ) :
                                                                                            echo '<li>- <a href="">'.$knc->name.'</a></li>';
                                                                                        endforeach;
                                                                                        echo '</ul>';
                                                                                    endif;
                                                                                ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Số tiền nợ gốc', 'tried'); ?>
                                                                                <?php echo number_format( $khoanno_value?$khoanno_value:'0', 0 ).'₫'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Lãi phát sinh', 'tried'); ?>
                                                                                <?php echo number_format( $khoanno_value_interest?$khoanno_value_interest:'0', 0 ).'₫'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Tổng nợ', 'tried'); ?>
                                                                                <?php
                                                                                    $khoanno_total_value = 0;
                                                                                    if ( is_numeric( $khoanno_value ) && is_numeric( $khoanno_value_interest ) ) {
                                                                                        $khoanno_total_value = intval( $khoanno_value ) + intval( $khoanno_value_interest );
                                                                                    }
                                                                                ?>
                                                                                <span class="currency"><?php echo number_format( $khoanno_total_value, 0 ); ?></span>
                                                                                <span class="unit">₫</span>
                                                                            </p>
                                                                            <p>
                                                                                <?php echo $khoanno_position['type'].' '.$khoanno_position['name'].', '.$khoanno_position['province_name']; ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- infos borrow -->
                                                                    <tr class="user-additional-wrap">
                                                                        <th><?php _e('Phần người mượn nợ', 'tried'); ?></th>
                                                                        <td>
                                                                            <p>
                                                                                <?php _e('Họ và tên', 'tried'); ?>
                                                                                <?php echo $khoanno_fullname_borrow; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Tên công ty (nếu có)', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_company_borrow))?$khoanno_company_borrow:'-'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Số điện thoại', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_phone_borrow))?$khoanno_phone_borrow:'-'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Email', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_email_borrow))?$khoanno_email_borrow:'-'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Địa chỉ', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_address_borrow))?$khoanno_address_borrow:'-'; ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- infos sell -->
                                                                    <tr class="user-additional-wrap">
                                                                        <th><?php _e('Phần người đăng bán', 'tried'); ?></th>
                                                                        <td>
                                                                            <p>
                                                                                <?php _e('Họ và tên', 'tried'); ?>
                                                                                <?php echo $khoanno_fullname_sell; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Tên công ty (nếu có)', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_company_sell))?$khoanno_company_sell:'-'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Số điện thoại', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_phone_sell))?$khoanno_phone_sell:'-'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Email', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_email_sell))?$khoanno_email_sell:'-'; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Địa chỉ', 'tried'); ?>
                                                                                <?php echo (!empty($khoanno_address_sell))?$khoanno_address_sell:'-'; ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                <?php elseif ( $_GET['action'] == 'update-khoanno' ) : ?>
                                                    <div class="update-khoanno">
                                                        <div class="header-wrap">
                                                            <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-khoanno', home_url( $wp->request ) ) ); ?>"><i class="far fa-arrow-left"></i><?php _e('Quay trở lại', 'tried'); ?></a>
                                                            <h3 class="title"><?php _e('Cập nhật thông tin', 'tried'); ?> <i><?php echo $khoanno_data->post_title; ?></i></h3>
                                                        </div>
                                                        <div class="body-wrap">
                                                            <?php
                                                                $is_complete = false;
                                                                if ( ( $message_form['notify'] && $message_form['notify'] == 'success' ) || $_SERVER['REQUEST_METHOD'] === 'POST' ) {
                                                                    $is_complete = true;
                                                                }
                                                            ?>
                                                            <?php if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) : ?>
                                                                <div class="step-form">
                                                            <?php else : ?>
                                                                <form class="step-form" method="post" action="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'update-khoanno', 'id' => $khoanno_id ), home_url( $wp->request ) ); ?>">
                                                            <?php endif; ?>
                                                                <ul class="progressbar-bar">
                                                                    <li class="fal fa-window active" id="account"><?php _e( 'Khoản nợ', 'tried' ); ?></li>
                                                                    <li class="fal fa-box-alt <?php echo $is_complete?'active':''; ?>"><?php _e( 'Tài sản đảm bảo', 'tried' ); ?></li>
                                                                    <li class="fal fa-address-card <?php echo $is_complete?'active':''; ?>"><?php _e( 'Thông tin người mượn nợ', 'tried' ); ?></li>
                                                                    <li class="fal fa-clipboard-user <?php echo $is_complete?'active':''; ?>"><?php _e( 'Thông tin người bán', 'tried' ); ?></li>
                                                                    <li class="fal fa-check <?php echo $is_complete?'active':''; ?>"><?php _e( 'Hoàn thành', 'tried' ); ?></li>
                                                                </ul>
                                                                <?php if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) : ?>
                                                                    <input type="hidden" name="knid" value="<?php echo $khoanno_knid; ?>">
                                                                    <input type="hidden" name="id" value="<?php echo $khoanno_id; ?>">
                                                                    <?php wp_nonce_field( 'tried-khoannoform', 'tried-khoannoform-nonce' ); ?>
                                                                    <fieldset class="<?php echo !$is_complete?'active':''; ?>">
                                                                        <div class="wrappper-step">
                                                                            <div class="wrap-head">
                                                                                <h4 class="step-title"><?php _e( 'Thông tin khoản nợ', 'tried' ); ?></h4>
                                                                            </div>
                                                                            <div class="wrap-body">
                                                                                <div class="col-field khoanno-name">
                                                                                    <span class="fieldlabels"><?php _e( 'Tên khoản nợ', 'tried' ) ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="knname" id="user-khoanno-name" value="<?php echo $khoanno_title; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-type">
                                                                                    <span class="fieldlabels"><?php _e( 'Loại khoản nợ', 'tried' ) ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <label for="user-type-difference">
                                                                                            <input name="type" type="radio" id="user-type-difference" value="diff" <?php echo ( $khoanno_type == 'diff' )?'checked':''; ?>><?php _e('Nợ khác', 'tried'); ?>
                                                                                        </label>
                                                                                        <label for="user-type-bank">
                                                                                            <input name="type" type="radio" id="user-type-bank" value="bank" <?php echo ( $khoanno_type == 'bank' )?'checked':''; ?>><?php _e('Nợ ngân hàng', 'tried'); ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-name_bank" <?php echo ( $khoanno_type != 'bank' )?'style="display: none;"':''; ?>>
                                                                                    <span class="fieldlabels"><?php _e( 'Tên ngân hàng', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="name_bank" id="user-khoanno-name_bank" value="<?php echo $khoanno_name_bank; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-content">
                                                                                    <span class="fieldlabels"><?php _e( 'Mô tả', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <?php
                                                                                            wp_editor(
                                                                                                htmlspecialchars( $khoanno_postcontent ),
                                                                                                'user-khoanno-content',
                                                                                                $settings = array(
                                                                                                    'media_buttons' => false,
                                                                                                    'textarea_name' => 'content',
                                                                                                    'wp_autoresize_on' => false,
                                                                                                    'textarea_rows' => 10,
                                                                                                    'editor_height' => 200,
                                                                                                    'editor_class' => 'width-auto',
                                                                                                    'tinymce' => false
                                                                                                )
                                                                                            );
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-value">
                                                                                    <span class="fieldlabels"><?php _e('Số tiền nợ gốc', 'tried'); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="number" name="value" id="user-khoanno-value" value="<?php echo $khoanno_value; ?>" min="0">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-value_interest">
                                                                                    <span class="fieldlabels"><?php _e('Lãi phát sinh (đến thời điểm đăng bán)', 'tried'); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="number" name="value_interest" id="user-khoanno-value_interest" value="<?php echo $khoanno_value_interest; ?>" min="0">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-total_value">
                                                                                    <span class="fieldlabels"><?php _e('Tổng nợ', 'tried'); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <p id="user-khoanno-total-value">
                                                                                            <span class="currency"><?php echo number_format( intval( $khoanno_value ) + intval( $khoanno_value_interest ) ); ?></span>
                                                                                            <span class="unit">₫</span>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="next action-button"><?php _e( 'Tiếp tục', 'tried' ); ?></button>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <div class="wrappper-step">
                                                                            <div class="wrap-head">
                                                                                <h4 class="step-title"><?php _e( 'Tài sản đảm bảo', 'tried' ); ?></h4>
                                                                            </div>
                                                                            <div class="wrap-body">
                                                                                <div class="col-field khoanno-featuredimage">
                                                                                    <span class="fieldlabels"><?php _e( 'Hình ảnh tài sản', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <?php
                                                                                            $khoanno_new_imgbrowses = $khoanno_images_browses;
                                                                                            $khoanno_media_ids = '';
                                                                                            if ( is_array( $khoanno_new_imgbrowses ) ) {
                                                                                                array_unshift( $khoanno_new_imgbrowses, get_post_thumbnail_id( $khoanno_id ) );
                                                                                                $khoanno_media_ids = implode( '-', $khoanno_new_imgbrowses );
                                                                                            }
                                                                                            echo do_shortcode('[fileupload_attachment media="'.$khoanno_media_ids.'"]');
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-category">
                                                                                    <span class="fieldlabels"><?php _e('Danh mục', 'tried'); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <?php
                                                                                            if ( !empty( $khoanno_categories ) ) :
                                                                                                foreach ($khoanno_categories as $kncat) :
                                                                                        ?>
                                                                                                    <label for="cat-<?php echo $kncat->slug; ?>">
                                                                                                        <input name="category[]" type="checkbox" id="cat-<?php echo $kncat->slug; ?>" value="<?php echo $kncat->term_id; ?>" <?php echo ( in_array( $kncat->term_id, $khoanno_category_ids ) )?'checked':''; ?>> <?php echo $kncat->name; ?>
                                                                                                    </label>
                                                                                        <?php
                                                                                                endforeach;
                                                                                            endif;
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="next action-button"><?php _e( 'Tiếp tục', 'tried' ); ?></button>
                                                                            <button type="button" class="previous action-button action-button-highlight"><?php _e( 'Quay lại', 'tried' ); ?></button>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <div class="wrappper-step">
                                                                            <div class="wrap-head">
                                                                                <h4 class="step-title"><?php _e( 'Thông tin người mượn nợ', 'tried' ); ?></h4>
                                                                            </div>
                                                                            <div class="wrap-body">
                                                                                <div class="col-field khoanno-fullname_borrow">
                                                                                    <span class="fieldlabels"><?php _e( 'Họ và tên', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="fullname_borrow" id="user-khoanno-fullname_borrow" value="<?php echo $khoanno_fullname_borrow; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-company_borrow">
                                                                                    <span class="fieldlabels"><?php _e( 'Tên công ty (nếu có)', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="company_borrow" id="user-khoanno-company_borrow" value="<?php echo $khoanno_company_borrow; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-phone_borrow">
                                                                                    <span class="fieldlabels"><?php _e( 'Số điện thoại', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="phone_borrow" id="user-khoanno-phone_borrow" value="<?php echo $khoanno_phone_borrow; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-email_borrow">
                                                                                    <span class="fieldlabels"><?php _e( 'Email', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="email_borrow" id="user-khoanno-email_borrow" value="<?php echo $khoanno_email_borrow; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-address_borrow">
                                                                                    <span class="fieldlabels"><?php _e('Địa chỉ', 'tried'); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <textarea name="address_borrow" id="user-khoanno-address_borrow" rows="2"><?php echo $khoanno_address_borrow; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-position">
                                                                                    <span class="fieldlabels"><?php _e( 'Địa phương', 'tried' ) ?>:</span>
                                                                                    <div class="wrap-fields slct-position">
                                                                                        <select name="posprovince" id="user-khoanno-position-provinces" class="slct-provinces">
                                                                                            <option value=""><?php _e( 'Chọn tỉnh', 'tried' ); ?></option>
                                                                                            <?php
                                                                                                if ( !empty( $provinces ) ) :
                                                                                                    foreach ($provinces as $province) :
                                                                                                        echo '<option value="'.$province['province_service_order'].'-'.$province['province_service_key'].'" data-type="'.$province['type'].'" data-service="'.$province['province_service_key'].'" '.($province['province_service_order']==$khoanno_valposprovince[0]?'selected':'').'>'.$province['name'].'</option>';
                                                                                                    endforeach;
                                                                                                endif;
                                                                                            ?>
                                                                                        </select>
                                                                                        <select name="posdistrict" id="user-khoanno-position-districts" class="slct-districts">
                                                                                            <option value=""><?php _e( 'Chọn huyện', 'tried' ); ?></option>
                                                                                            <?php
                                                                                                if ( $khoanno_posdistrict ) :
                                                                                                    $khoanno_districts = get_districts_by_province( $khoanno_valposprovince[1] );
                                                                                                    if ( $khoanno_districts ) :
                                                                                                        foreach ( $khoanno_districts as $district ) :
                                                                                                            echo '<option value="'.$district['district_service_order'].'-'.$district['district_service_key'].'" data-type="'.$district['type'].'" data-service="'.$district['district_service_key'].'" '.($district['district_service_order']==$khoanno_valposdistrict[0]?'selected':'').'>'.$district['name'].'</option>';
                                                                                                        endforeach;
                                                                                                    endif;
                                                                                                endif;
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button" class="next action-button"><?php _e( 'Tiếp tục', 'tried' ); ?></button>
                                                                            <button type="button" class="previous action-button action-button-highlight"><?php _e( 'Quay lại', 'tried' ); ?></button>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <div class="wrappper-step">
                                                                            <div class="wrap-head">
                                                                                <h4 class="step-title"><?php _e( 'Thông tin người bán', 'tried' ); ?></h4>
                                                                            </div>
                                                                            <div class="wrap-body">
                                                                                <div class="col-field khoanno-fullname_sell">
                                                                                    <span class="fieldlabels"><?php _e( 'Họ và tên', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="fullname_sell" id="user-khoanno-fullname_sell" value="<?php echo $khoanno_fullname_sell; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-company_sell">
                                                                                    <span class="fieldlabels"><?php _e( 'Tên công ty (nếu có)', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="company_sell" id="user-khoanno-company_sell" value="<?php echo $khoanno_company_sell; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-phone_sell">
                                                                                    <span class="fieldlabels"><?php _e( 'Số điện thoại', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="phone_sell" id="user-khoanno-phone_sell" value="<?php echo $khoanno_phone_sell; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-email_sell">
                                                                                    <span class="fieldlabels"><?php _e( 'Email', 'tried' ); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <input type="text" name="email_sell" id="user-khoanno-email_sell" value="<?php echo $khoanno_email_sell; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-field khoanno-address_sell">
                                                                                    <span class="fieldlabels"><?php _e('Địa chỉ', 'tried'); ?>:</span>
                                                                                    <div class="wrap-fields">
                                                                                        <textarea name="address_sell" id="user-khoanno-address_sell" rows="2"><?php echo $khoanno_address_sell; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="submit" class="next action-button"><?php _e( 'Cập nhật', 'tried' ); ?></button>
                                                                            <button type="button" class="previous action-button action-button-highlight"><?php _e( 'Quay lại', 'tried' ); ?></button>
                                                                        </div>
                                                                    </fieldset>
                                                                <?php endif; ?>
                                                                <fieldset class="<?php echo $is_complete?'active':''; ?>">
                                                                    <div class="wrappper-step">
                                                                        <div class="wrap-head">
                                                                            <?php if ( $message_form['notify'] == 'success' ) : ?>
                                                                                <h4 class="step-title"><?php _e( 'Thành công', 'tried' ); ?></h4>
                                                                            <?php elseif ( $message_form['notify'] == 'success' ) : ?>
                                                                                <h4 class="step-title"><?php _e( 'Thất bại', 'tried' ); ?></h4>
                                                                            <?php else : ?>
                                                                                <h4 class="step-title"><?php _e( 'Chờ xử lý', 'tried' ); ?></h4>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="wrap-body">
                                                                            <?php if ( !empty( $message_form ) ) : ?>
                                                                                <div class="message <?php echo $message_form['notify']; ?>">
                                                                                    <?php echo $message_form['content']; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                            <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-khoanno', home_url( $wp->request ) ) ); ?>"><?php _e('Quay lại', 'tried'); ?></a>
                                                                            <a href="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'detail-khoanno', 'id' => $khoanno_id ), home_url( $wp->request ) ); ?>"><?php _e( 'Chi tiết', 'tried' ); ?></a>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            <?php if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) : ?>
                                                                </div>
                                                            <?php else :?>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php elseif ( $_GET['action'] == 'delete-khoanno' ) : ?>
                                                    <div class="delete-khoanno">
                                                        <div class="header-wrap">
                                                            <h3 class="title"><?php _e('Xóa khoản nợ', 'tried'); ?> <i><?php echo $khoanno_data->post_title; ?></i></h3>
                                                        </div>
                                                        <div class="body-wrap">
                                                            <?php $message_form = process_delete_khoanno_form( $_GET['id'] ); ?>
                                                            <?php if ( !empty( $message_form ) ) : ?>
                                                                <div class="message <?php echo $message_form['notify']; ?>">
                                                                    <?php echo $message_form['content']; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                            <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-khoanno', home_url( $wp->request ) ) ); ?>"><i class="far fa-arrow-left"></i><?php _e('Quay trở lại', 'tried'); ?></a>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="none-khoanno">
                                                        <div class="header-wrap">
                                                            <h3 class="title"><?php _e('Không tìm thấy', 'tried'); ?></h3>
                                                        </div>
                                                        <div class="body-wrap">
                                                            <div class="message warning">
                                                                <?php _e('Lỗi! không tìm thấy thông tin cần tìm.', 'tried'); ?>
                                                            </div>
                                                            <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-khoanno', home_url( $wp->request ) ) ); ?>"><i class="far fa-arrow-left"></i><?php _e('Quay trở lại', 'tried'); ?></a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <div class="list-khoanno">
                                                    <div class="header-wrap">
                                                        <h3 class="title"><?php _e('Danh sách các khoản nợ', 'tried'); ?></h3>
                                                    </div>
                                                    <div class="body-wrap">
                                                        <?php
                                                            $khoanno = get_posts(array (
                                                                'author' =>  $current_user->ID,
                                                                'post_type' => 'khoan-no',
                                                                'orderby' => 'date',
                                                                'order'=> 'DESC', 
                                                                'post_status' => 'publish',
                                                                'posts_per_page' => -1
                                                            ));
                                                        ?>
                                                        <?php if ( !empty($khoanno) ) : ?>
                                                            <table class="form-table" role="presentation">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th scope="col"><?php _e('Hình ảnh', 'tried'); ?></th>
                                                                        <th scope="col"><?php _e('Tên', 'tried'); ?></th>
                                                                        <th scope="col"><?php _e('Giá', 'tried'); ?></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($khoanno as $k => $n) : ?>
                                                                    <?php
                                                                        $image = get_theme_file_uri( "/assets/img/placeholder.png" );
                                                                        $thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( $n->ID ), 'full' );
                                                                        if ( $thumbnail_image ) :
                                                                            $image = $thumbnail_image[0];
                                                                        endif;
                                                                        $type = get_post_meta( $n->ID, 'type', true );
                                                                        $value = get_post_meta( $n->ID, 'value', true );
                                                                        $value_interest = get_post_meta( $n->ID, 'value_interest', true );
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $k + 1; ?></td>
                                                                            <td><img src="<?php echo $image; ?>" alt="" style="width: 70px"></td>
                                                                            <td>
                                                                                <h5 class="title"><?php echo get_the_title($n->ID); ?></h5>
                                                                                <p class="type"><?php echo ($type == 'diff')?'Nợ khác':'Nợ ngân hàng'; ?></p>
                                                                            </td>
                                                                            <td>
                                                                                <p><strong><?php _e('Số tiền nợ gốc', 'tried'); ?>:</strong><br><?php echo number_format( $value?$value:0, 0 ).'₫'; ?></p>
                                                                                <p><strong><?php _e('Lãi phát sinh', 'tried'); ?>:</strong><br><?php echo number_format( $value_interest?$value_interest:0, 0 ).'₫'; ?></p>
                                                                            </td>
                                                                            <td>
                                                                                <ul class="actions">
                                                                                    <li>
                                                                                        <a href="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'delete-khoanno', 'id' => $n->ID ), home_url( $wp->request ) ); ?>"><?php _e( 'Xóa', 'tried' ); ?></a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'detail-khoanno', 'id' => $n->ID ), home_url( $wp->request ) ); ?>"><?php _e( 'Chi tiết', 'tried' ); ?></a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'update-khoanno', 'id' => $n->ID ), home_url( $wp->request ) ); ?>"><?php _e( 'Cập nhật', 'tried' ); ?></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        <?php else : ?>
                                                            <p class="message">
                                                                <?php _e( 'Hiện không sở hữu khoản nợ nào!', 'tried' ); ?>
                                                            </p>
                                                        <?php endif; ?>
                                                        <a href="<?php echo add_query_arg( array('block' => 'ctt-khoanno', 'action' => 'new-khoanno' ), home_url( $wp->request ) ); ?>"><?php _e('Thêm mới', 'tried'); ?></a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif ( $_GET['block'] == 'ctt-save' ) : ?>
                                        <div class="content-item" id="ctt-save">
                                            <h4>save</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
                                        </div>
                                    <?php elseif ( $_GET['block'] == 'ctt-policy' ) : ?>
                                        <div class="content-item" id="ctt-policy">
                                            <h4>policy</h4>
                                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.<br>
                                            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
                                        </div>
                                    <?php elseif ( $_GET['block'] == 'ctt-helps' ) : ?>
                                        <div class="content-item" id="ctt-helps">
                                            <h4>helps</h4>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        </div>
                                    <?php elseif ( $_GET['block'] == 'ctt-settings' ) : ?>
                                        <div class="content-item" id="ctt-settings">
                                            <h4>settings</h4>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        </div>
                                    <?php else : ?>
                                        <div class="content-item" id="ctt-profile">
                                            <?php if ($_GET['action'] == 'update-info') : ?>
                                                <div class="update-info">
                                                    <div class="header-wrap">
                                                        <h3 class="title"><?php _e('Cập nhật thông tin', 'tried'); ?></h3>
                                                    </div>
                                                    <div class="body-wrap">
                                                        <form method="post" action="<?php echo add_query_arg( array('block' => 'ctt-profile', 'action' => 'update-info' ), home_url( $wp->request ) ); ?>">
                                                            <?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
                                                            <div class="col-field avatar">
                                                                <div class="wrap-fields">
                                                                    <input type='file' name="avatar" id="user-avatar" value="<?php echo esc_attr($avatar_url); ?>" accept=".png, .jpg, .jpeg"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-field fullname">
                                                                <span class="fieldlabels"><?php _e( 'Họ và tên', 'tried' ) ?>:</span>
                                                                <input type="text" name="fullname" id="user-fullname" value="<?php echo esc_attr($user_displayname); ?>">
                                                            </div>
					                                        <?php echo do_shortcode( '[tried_register_form_fields company="'.$user_company.'" phone="'.$user_phone.'" address="'.$user_address.'"]' ); ?>
                                                            <div class="col-field email">
                                                                <span class="fieldlabels"><?php _e( 'Email', 'tried' ) ?>:</span>
                                                                <div class="wrap-fields">
                                                                    <input type="text" name="email" id="user-email" value="<?php echo esc_attr($user_email); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-field socials">
                                                                <span class="fieldlabels"><?php _e('Mạng xã hội', 'tried'); ?>:</span>
                                                                <div class="wrap-fields">
                                                                    <ul class="socials">
                                                                        <li>
                                                                            <label for="user-facebook"><?php _e('Facebook', 'tried'); ?>:</label>
                                                                            <input type="text" name="facebook" id="user-facebook" value="<?php echo $social_facebook; ?>">
                                                                        </li>
                                                                        <li>
                                                                            <label for="user-twitter"><?php _e('Twitter', 'tried'); ?>:</label>
                                                                            <input type="text" name="twitter" id="user-twitter" value="<?php echo $social_twitter; ?>">
                                                                        </li>
                                                                        <li>
                                                                            <label for="user-skype"><?php _e('Skype', 'tried'); ?>:</label>
                                                                            <input type="text" name="skype" id="user-skype" value="<?php echo $social_skype; ?>">
                                                                        </li>
                                                                        <li>
                                                                            <label for="user-instagram"><?php _e('Instagram', 'tried'); ?>:</label>
                                                                            <input type="text" name="instagram" id="user-instagram" value="<?php echo $social_instagram; ?>">
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-field password">
                                                                <span class="fieldlabels"><?php _e('Mật Khẩu', 'tried'); ?>:</span>
                                                                <input type="password" name="password" id="user-password" value="">
                                                            </div>
                                                            <div class="col-field submit">
                                                                <button type="submit"><?php _e('Cập nhật', 'tried'); ?></button>
                                                            </div>
                                                            <div class="message-field">
                                                                <?php if ( !empty( $message_form ) ) : ?>
                                                                    <div class="message <?php echo $message_form['notify']; ?>">
                                                                        <?php echo $message_form['content']; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="another-field">
                                                                <p class="backlogin-account">
                                                                    <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-profile', home_url( $wp->request ) ) ); ?>">
                                                                        <i class="far fa-arrow-left"></i>
                                                                        <?php _e('Quay trở lại', 'tried'); ?>
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php elseif ( $_GET['action'] == 'change-password' ) : ?>
                                                <div class="change-password">
                                                    <div class="header-wrap">
                                                        <h3 class="title"><?php _e( 'Thay đổi mật khẩu', 'tried' ); ?></h3>
                                                    </div>
                                                    <div class="body-wrap">
                                                        <form method="post" action="<?php echo add_query_arg( array('block' => 'ctt-profile', 'action' => 'change-password' ), home_url( $wp->request ) ); ?>">
                                                            <?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
                                                            <div class="col-field username">
                                                                <label for="user-username"><?php _e( 'Tên đăng nhập', 'tried' ) ?>:</label>
                                                                <span><?php echo $user_login; ?></span>
                                                            </div>
                                                            <div class="col-field currentpassword">
                                                                <label for="user-currentpassword"><?php _e( 'Mật Khẩu hiện tại', 'tried' ); ?>:</label>
                                                                <input type="password" name="currentpassword" id="user-currentpassword" value="">
                                                            </div>
                                                            <div class="col-field newpassword">
                                                                <label for="user-newpassword"><?php _e( 'Mật Khẩu mới', 'tried' ); ?>:</label>
                                                                <input type="password" name="newpassword" id="user-newpassword" value="">
                                                            </div>
                                                            <div class="col-field submit">
                                                                <button type="submit"><?php _e('Đổi mật khẩu', 'tried'); ?></button>
                                                            </div>
                                                            <div class="message-field">
                                                                <?php if ( !empty( $message_form ) ) : ?>
                                                                    <div class="message <?php echo $message_form['notify']; ?>">
                                                                        <?php echo $message_form['content']; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="another-field">
                                                                <div class="backlogin-account">
                                                                    <a href="<?php echo esc_url( add_query_arg( 'block', 'ctt-profile', home_url( $wp->request ) ) ); ?>">
                                                                        <i class="far fa-arrow-left"></i>
                                                                        <?php _e('Quay trở lại', 'tried'); ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="content-item" id="ctt-profile">
                                                    <div class="view-info">
                                                        <div class="header-wrap">
                                                            <h3 class="title"><?php _e('Thông tin tài khoản', 'tried'); ?></h3>
                                                        </div>
                                                        <div class="body-wrap">
                                                            <table class="form-table" role="presentation">
                                                                <tbody>
                                                                    <!-- infos base -->
                                                                    <tr class="user-displayname-wrap">
                                                                        <th><?php _e('Phần cơ bản', 'tried'); ?></th>
                                                                        <td>
                                                                            <p>
                                                                                <?php _e('Tên hiển thị', 'tried'); ?>
                                                                                <?php echo $user_displayname; ?>(<strong>UID: <i><?php echo $user_uid; ?></i></strong>)
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- infos additional -->
                                                                    <tr class="user-additional-wrap">
                                                                        <th><?php _e('Phần cá nhân', 'tried'); ?></th>
                                                                        <td>
                                                                            <p>
                                                                                <?php _e('Tên công ty', 'tried'); ?>
                                                                                <?php echo $user_company; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Số điện thoại', 'tried'); ?>
                                                                                <?php echo $user_phone; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Địa chỉ', 'tried'); ?>
                                                                                <?php echo $user_address; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Email', 'tried'); ?>
                                                                                <?php echo $user_email; ?>
                                                                            </p>
                                                                            <p class="text-right">
                                                                                <a href="<?php echo add_query_arg( array( 'block' => 'ctt-profile', 'action' => 'update-info' ), home_url( $wp->request )); ?>"><?php _e('Cập nhật thông tin'); ?></a>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- socials -->
                                                                    <tr class="user-contact-wrap">
                                                                        <th><?php _e('Mạng xã hội', 'tried'); ?></th>
                                                                        <td>
                                                                            <ul class="vertical socials">
                                                                                <?php if ( !empty( $social_facebook ) ) : ?>
                                                                                    <li><a href="<?php echo $social_facebook; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a></li>
                                                                                <?php endif; ?>
                                                                                <?php if ( !empty( $social_twitter ) ) : ?>
                                                                                    <li><a href="<?php echo $social_twitter; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a></li>
                                                                                <?php endif; ?>
                                                                                <?php if ( !empty( $social_skype ) ) : ?>
                                                                                    <li><a href="<?php echo $social_skype; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-skype"></i></a></li>
                                                                                <?php endif; ?>
                                                                                <?php if ( !empty( $social_instagram ) ) : ?>
                                                                                    <li><a href="<?php echo $social_instagram; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>
                                                                                <?php endif; ?>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- account -->
                                                                    <tr class="user-account-wrap">
                                                                        <th><?php _e('Tài khoản', 'tried'); ?></th>
                                                                        <td>
                                                                            <p>
                                                                                <?php _e('Người dùng', 'tried'); ?>
                                                                                <?php echo $user_login; ?>
                                                                            </p>
                                                                            <p>
                                                                                <?php _e('Mật khẩu', 'tried'); ?>
                                                                                <?php echo str_repeat( '*', 10 );; ?>
                                                                            </p>
                                                                            <p class="text-right">
                                                                                <a href="<?php echo add_query_arg( array( 'block' => 'ctt-profile', 'action' => 'change-password' ), home_url( $wp->request )); ?>"><?php _e('Thay đổi mật khẩu'); ?></a>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <div class="content-item" id="ctt-profile">
                                        <div class="view-info">
                                            <div class="header-wrap">
                                                <h3 class="title"><?php _e('Thông tin tài khoản', 'tried'); ?></h3>
                                            </div>
                                            <div class="body-wrap">
                                                <table class="form-table" role="presentation">
                                                    <tbody>
                                                        <!-- infos base -->
                                                        <tr class="user-displayname-wrap">
                                                            <th><?php _e('Phần cơ bản', 'tried'); ?></th>
                                                            <td>
                                                                <p>
                                                                    <?php _e('Tên hiển thị', 'tried'); ?>
                                                                    <?php echo $user_displayname; ?>(<strong>UID: <i><?php echo $user_uid; ?></i></strong>)
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <!-- infos additional -->
                                                        <tr class="user-additional-wrap">
                                                            <th><?php _e('Phần cá nhân', 'tried'); ?></th>
                                                            <td>
                                                                <p>
                                                                    <?php _e('Tên công ty', 'tried'); ?>
                                                                    <?php echo $user_company; ?>
                                                                </p>
                                                                <p>
                                                                    <?php _e('Số điện thoại', 'tried'); ?>
                                                                    <?php echo $user_phone; ?>
                                                                </p>
                                                                <p>
                                                                    <?php _e('Địa chỉ', 'tried'); ?>
                                                                    <?php echo $user_address; ?>
                                                                </p>
                                                                <p>
                                                                    <?php _e('Email', 'tried'); ?>
                                                                    <?php echo $user_email; ?>
                                                                </p>
                                                                <p class="text-right">
                                                                    <a href="<?php echo add_query_arg( array( 'block' => 'ctt-profile', 'action' => 'update-info' ), home_url( $wp->request )); ?>"><?php _e('Cập nhật thông tin'); ?></a>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <!-- socials -->
                                                        <tr class="user-contact-wrap">
                                                            <th><?php _e('Mạng xã hội', 'tried'); ?></th>
                                                            <td>
                                                                <ul class="vertical socials">
                                                                    <?php if ( !empty( $social_facebook ) ) : ?>
                                                                        <li><a href="<?php echo $social_facebook; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a></li>
                                                                    <?php endif; ?>
                                                                    <?php if ( !empty( $social_twitter ) ) : ?>
                                                                        <li><a href="<?php echo $social_twitter; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a></li>
                                                                    <?php endif; ?>
                                                                    <?php if ( !empty( $social_skype ) ) : ?>
                                                                        <li><a href="<?php echo $social_skype; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-skype"></i></a></li>
                                                                    <?php endif; ?>
                                                                    <?php if ( !empty( $social_instagram ) ) : ?>
                                                                        <li><a href="<?php echo $social_instagram; ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <!-- account -->
                                                        <tr class="user-account-wrap">
                                                            <th><?php _e('Tài khoản', 'tried'); ?></th>
                                                            <td>
                                                                <p>
                                                                    <?php _e('Người dùng', 'tried'); ?>
                                                                    <?php echo $user_login; ?>
                                                                </p>
                                                                <p>
                                                                    <?php _e('Mật khẩu', 'tried'); ?>
                                                                    <?php echo str_repeat( '*', 10 );; ?>
                                                                </p>
                                                                <p class="text-right">
                                                                    <a href="<?php echo add_query_arg( array( 'block' => 'ctt-profile', 'action' => 'change-password' ), home_url( $wp->request )); ?>"><?php _e('Thay đổi mật khẩu'); ?></a>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php
                            if (isset($_GET['form']) && $_GET['form'] == 'register') :
                                echo do_shortcode('[tried_register_form]');
                            else :
                                echo do_shortcode('[tried_login_form]');
                            endif;
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>