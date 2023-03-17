<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// add_action( 'wp_ajax_tried_general_form', 'ajx_tried_general_form' );
// add_action( 'wp_ajax_nopriv_tried_general_form', 'ajx_tried_general_form' );
function ajx_tried_general_form() {
    if( !wp_verify_nonce($_REQUEST['tried-admin-general-form'], 'tried-admin-general-form')) {
        wp_send_json(array(
            'code' => '500',
            'response' => 'fail'
        ));
    }
    if (isset($_GET['limit']) && !empty($_GET['limit'])) {}

    wp_send_json(array(
        'code' => '200',
        'response' => 'success'
    ));
}

add_action( 'wp_ajax_render_districts', 'ajx_render_districts' );
function ajx_render_districts() {
    $result = array();
    if ( isset( $_GET['province'] ) && !empty( $_GET['province'] ) && is_numeric( $_GET['province'] ) ) {
        $result = get_districts_by_province( $_GET['province'] );
        wp_send_json(array(
            'code' => '200',
            'response' => $result
        ));
    }
    wp_send_json(array(
        'code' => '400',
        'response' => $result
    ));
}

add_action( 'wp_ajax_avatar_upload', 'ajx_avatar_upload' );
function ajx_avatar_upload() {
    if ( !empty( $_GET['avatar_url'] ) && !empty( $_GET['attachment'] ) ) {
        global $current_user;
        wp_get_current_user();
        $values = array(
            'tried_meta' => get_theme_file_uri( "/assets/img/placeholder.png" ),
            'tried_upload_meta' => $_GET['avatar_url'],
            'tried_upload_edit_meta' => get_admin_url().'/post.php?post='.$_GET['attachment'].'&action=edit&image-editor',
        );
        foreach ( $values as $key => $value ) {
            update_user_meta( $current_user->ID, $key, $value );
        }
        wp_send_json(array(
            'code' => '200',
            'message' => __( 'Thay đổi Avatar thành công!', 'tried' )
        ));
    }
    wp_send_json(array(
        'code' => '400',
        'message' => __( 'Có lỗi xảy ra!', 'tried' )
    ));
}
