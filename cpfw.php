<?php
/**
* Plugin Name: cpfw
* Description: Membership plugin with different levels and payment gateway.
* Version: 0.1
* Author: Laszlo Kruchio
*/

/*
* =============================================================================
* =========== GENERAL =========================================================
* =============================================================================
*/

// Allow redirection, even if my theme starts to send output to the browser
add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}

// Include CSS / JS - Admin
if ( isset($_GET['page']) && ( $_GET['page'] == 'cpfw-general' ) ) {
    add_action( 'admin_enqueue_scripts', 'cpfw_include_admin' );
}
function cpfw_include_admin() {

    /* CSS */
    wp_register_style('cpfw_css', plugins_url('assets/cpfw.css',__FILE__ ), false, '1.0');
    wp_enqueue_style('cpfw_css');

    /* Scripts */
    /*
    wp_register_script('cpfw_js', plugins_url('assets/cpfw_js',__FILE__ ), false, '1.0');

    wp_enqueue_script('jquery');
    wp_enqueue_script('cpfw_js');
    */

    /* AJAX */
    //wp_localize_script('cpfw_admin_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php')));
}

// Required files
/*
foreach ( glob( plugin_dir_path( __FILE__ ) . "includes/*.php" ) as $file ) {
    include_once $file;
}
*/

/*
* =============================================================================
* =========== ACTIVATION ======================================================
* =============================================================================
*/

// DB - Create table on first activation 
register_activation_hook( __FILE__, 'cpfw_install' );

// DB - Versioning
global $cpfw_db_version;
$cpfw_db_version = '1.0';

function cpfw_install () {

    global $wpdb;
    global $cpfw_db_version;

    // Table - Members
    $table_members = $wpdb->prefix . "cpfw_members";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_members (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        userid MEDIUMINT(9) NOT NULL,
        fname MEDIUMTEXT NOT NULL,
        lname MEDIUMTEXT NOT NULL,
        email MEDIUMTEXT NOT NULL,
        company MEDIUMINT(9) NOT NULL,
        position MEDIUMINT(9) NOT NULL,
        website MEDIUMTEXT NOT NULL,
        phone MEDIUMTEXT NOT NULL,
        address TEXT NOT NULL,
        linkedin MEDIUMTEXT NOT NULL,
        twitter MEDIUMTEXT NOT NULL,
        profile_image MEDIUMTEXT NOT NULL,
        biography TEXT NOT NULL,
        membership MEDIUMINT(9) NOT NULL,
        status MEDIUMINT(9),
        renewal_date MEDIUMTEXT NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'cpfw_db_version', $cpfw_db_version );
}

// DB - Update
add_action( 'plugins_loaded', 'cpfw_update_db_check' );
function cpfw_update_db_check() {
    global $cpfw_db_version;
    if ( get_site_option( 'cpfw_db_version' ) != $cpfw_db_version ) {
        cpfw_install();
    }
}

/*
* =============================================================================
* =========== PAGES ===========================================================
* =============================================================================
*/

// Add Options Page
add_action('admin_menu', 'cpfw_create_menu');
function cpfw_create_menu() {
 	add_menu_page('cpfw', 'cpfw', 'manage_options', 'cpfw-general', 'cpfw_general', 'dashicons-id-alt');
}

/*
* =============================================================================
* =========== PAGES - GENERAL =================================================
* =============================================================================
*/

// Options page
function cpfw_general() {
    ?>
       
    <?php
}
