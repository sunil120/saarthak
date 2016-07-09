<?php
/*
	Plugin Name:            Woocommerce CSV Import
	Plugin URI:             http://allaerd.org/
	Description:            Import and Export Woocommerce products

 	Author:					Allaerd Mensonides
 	Author URI:				https://allaerd.org

 	Version:				3.2.2

	Requires at least: 		4.0
	Tested up to: 			4.5

	License: GPLv2 or later

	Text Domain: woocommerce-csvimport
	Domain Path: /languages
*/

if (!defined( 'ABSPATH' )) {
    exit;
}

define('WOOCSV_PLUGIN_PATH', dirname(__FILE__));

//include the main classes
include dirname( __FILE__ ) . '/include/class-woocsv-import.php';

//include statics
include dirname( __FILE__ ) . '/include/class-woocsv-batches.php';
include dirname( __FILE__ ) . '/include/class-woocsv-schedule-import.php';

//logger
include dirname( __FILE__ ) . '/include/LoggerInterface.php';
include dirname( __FILE__ ) . '/include/LogToFile.php';

//exporter
include dirname( __FILE__ ) . '/export/interfaces/productsInterface.php';
include dirname( __FILE__ ) . '/export/interfaces/exportInterface.php';
include dirname( __FILE__ ) . '/export/interfaces/writerInterface.php';
include dirname( __FILE__ ) . '/export/include/woocsvExport.php';
include dirname( __FILE__ ) . '/export/include/woocsvExportAdmin.php';
include dirname( __FILE__ ) . '/export/include/woocsvExportProduct.php';
include dirname( __FILE__ ) . '/export/include/ajaxExport.php';
include dirname( __FILE__ ) . '/export/include/csvWriter.php';
include dirname( __FILE__ ) . '/export/include/woocsvAttributes.php';
include dirname( __FILE__ ) . '/export/products/simple.php';
include dirname( __FILE__ ) . '/export/products/variable.php';
include dirname( __FILE__ ) . '/export/products/variation.php';
include dirname( __FILE__ ) . '/export/exporter.php';

/**
 * ajax actions
 */
//delete batch
add_action( 'wp_ajax_delete_batch', array ( 'woocsv_batches', 'delete' ) );

//delete batch all
add_action( 'wp_ajax_delete_batch_all', 'woocsv_batches::delete_all' );

//start_batch
add_action( 'wp_ajax_start_batch', 'woocsv_batches::start' );

/**
 * multi language
 */

load_plugin_textdomain( 'woocommerce-csvimport', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

//global stuff
$woocsv_import = new woocsv_import() ;
$woocsv_product = '';

// the good hook for loading add-ons. others will be removed
do_action( 'woocsv_after_init' );

//helper functions
function aem_helper_date ($timestamp = NULL)
{

    if (!$timestamp) {
        $new_date = '';

        return $new_date;
    }

    $temp_date = new DateTime();
    $temp_date->setTimestamp( $timestamp );
    $new_date = $temp_date->format( 'Y-m-d H:i' );

    return $new_date;
}

add_filter( 'plugin_row_meta', 'add_support_link', 10, 2 );

function add_support_link ($links, $file)
{
    $plugin = plugin_basename( __FILE__ );
    if (!current_user_can( 'install_plugins' )) {
        return $links;
    }
    //if($file == $this->plugin_basefile){
    if ($file == $plugin) {
        $links[] = '<a href="https://allaerd.org/knowledgebase/" target="_blank">' . __( 'Docs',
                'woocommerce-csvimport' ) . '</a>';
        $links[] = '<a href="https://allaerd.org/shop/" target="_blank">' . __( 'Add-ons',
                'woocommerce-csvimport' ) . '</a>';
    }

    return $links;
}
