<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Tried_DB__Acc_Premium', false ) ) {
	class Tried_DB__Acc_Premium extends Tried_DB {
        public $table_name = 'tried';
        
        public function __construct() {
        //     $this->create_mifp_table("CREATE TABLE IF NOT EXISTS `$this->table_name` (
        //     `id` INT(11) NOT NULL AUTO_INCREMENT,
        //     `product_id` VARCHAR(11) NOT NULL,
        //     `retail_price` FLOAT(11,2),
        //     `sale_price` FLOAT(11,2),
        //     `time_imported` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (`id`)
        //     ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
        }

        // public function create_mifp_table($sql) {
        //     global $wpdb;
        //     if ($wpdb->get_var("SHOW TABLES LIKE '$this->table_name'") != $this->table_name) {
        //         $charset_collate = $wpdb->get_charset_collate();
        //         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        //         dbDelta($sql);
        //     }
        // }

        // public function delete_get_mifp_all() {
        //     global $wpdb;
        //     $wpdb->query("DELETE FROM `" . $this->table_name . "`");
        // }

        // public function get_mifp_all() {
        //     global $wpdb;
        //     $results = $wpdb->get_results("SELECT `product_id`, `retail_price`, `sale_price`, `time_imported` FROM " . $this->table_name);
        //     return $results;
        // }

        // public function get_mifp_by_query($sql) {
        //     global $wpdb;
        //     $results = $wpdb->get_results($sql);
        //     return $results;
        // }

        // public function get_mifp($product_id, $value = null) {
        //     global $wpdb;
        //     $where = "`product_id`='" . $product_id . "'" . (($value != null)? " AND `product_id`=". $value: "");
        //     $results = $wpdb->get_results("SELECT `retail_price`, `sale_price` FROM " . $this->table_name . " WHERE " . $where);
        //     return $results;
        // }

        // public function insert_mifp($product_id, $retail_price, $sale_price){
        //     global $wpdb;
        //     if (empty($product_id)) return;
        //     $sql = "INSERT INTO `".$this->table_name."`(`product_id`, `retail_price`, `sale_price`) values ('".$product_id."',".$retail_price.",".$sale_price.")";
        //     $wpdb->query($sql);
        // }

        // public function update_mifp_by_product_id($product_id, $retail_price, $sale_price){
        //     global $wpdb;
        //     if (empty($product_id) || empty($value)) return;
        //     $sql = "UPDATE `".$this->table_name."` SET `retail_price`=".$retail_price.", `sale_price`=".$sale_price." WHERE `product_id`='".$product_id."'";
        //     $wpdb->query($sql);
        // }
        
        // public function update_mifp_by_id($product_id, $retail_price, $sale_price){
        //     global $wpdb;
        //     if (empty($product_id) || empty($value)) return;
        //     $sql = "UPDATE `".$this->table_name."` SET `retail_price`=".$retail_price.", `sale_price`=".$sale_price." WHERE `product_id`='".$product_id."'";
        //     $wpdb->query($sql);
        // }
    }
}
