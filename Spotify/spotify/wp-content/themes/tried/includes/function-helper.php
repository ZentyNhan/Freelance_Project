<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function validate_string_to_email($str) {
    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

    if (preg_match($pattern, $str) === 1) return true;
    return false;
}

function glob_includes( $path = '', $extensions = array( 'php' ) ) {
    $result = array();
    if ( !empty( $path ) ) {
        foreach ( $extensions as $extension ) {
            $files = glob( $path . '/*' . $extension );
            foreach ( $files as $file ) {
                $result[] = $file;
            }
        }
    }
    return $result;
}

if( !function_exists( 'data_provinces' ) ) {
    include_once get_template_directory() . '/assets/data/provinces.php';
}
if( !function_exists( 'data_districts' ) ) {
    include_once get_template_directory() . '/assets/data/districts.php';
}
function get_position_data( $type = 'provinces' ) {
    $result = array();
    if ( $type == 'districts' ) {
        if ( !empty( data_districts() ) ) {
            $result = json_decode( data_districts(), true );
        }
    } else {
        if ( !empty( data_provinces() ) ) {
            $result = json_decode( data_provinces(), true );
        }
    }
    return $result;
}

function get_province_by_id( $province_id = null ) {
    $result = array();
    if ( $province_id ) {
        if ( !empty( data_districts() ) ) {
            $provinces = json_decode( data_provinces(), true );
            $result = $provinces[$province_id];
        }
    }
    return $result;
}

function get_districts_by_province( $province ) {
    $data_districts = get_position_data( 'districts' );
    $districts = array();
    foreach ( $data_districts as $rkey => $district ) {
        if ( $district['province_service_key'] == $province ){
            $districts[] = $district;
        }
    }
    return $districts;
}

function get_district_by_id( $district_id = null ) {
    $result = array();
    if ( $district_id ) {
        if ( !empty( data_districts() ) ) {
            $districts = json_decode( data_districts(), true );
            $result = $districts[$district_id];
        }
    }
    return $result;
}
