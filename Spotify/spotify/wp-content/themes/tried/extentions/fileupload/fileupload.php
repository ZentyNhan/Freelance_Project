<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Tried_Theme', false )) :
	class Tried_Extention_FileUpload {
        public $path = '/extentions/fileupload';

		function __construct() {
            $this->load_hooks();
		}

        function load_hooks() {
            add_action( 'wp_enqueue_scripts', array( $this, 'tried_ext_fileupload_enqueue_scripts' ) );
        }

        function tried_ext_fileupload_enqueue_scripts() {
            wp_register_style( 'tried-extention-fileupload', get_template_directory_uri() . $this->path . '/assets/css/fileupload.css', '', '1.0.0' );
            wp_register_script( 'tried-extention-fileupload', get_template_directory_uri() . $this->path . '/assets/js/fileupload.js', null, '1.0.0', true );
        }
	}
endif;

return new Tried_Extention_FileUpload();
