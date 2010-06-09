<?php
/*
Plugin Name: BuddyPress ScholarPress LMS
Plugin URI: http://scholarpress.net/
Description: A LMS for BuddyPress.
Author: Stas Sușcov
Version: 0.1alfa
License: GNU/GPL 2
Requires at least: WordPress 3.0, BuddyPress 1.2.4.1
Tested up to: WordPress 2.9.2 / BuddyPress 1.2.4.1
Author URI: http://stas.nerd.ro/
*/

define( 'BPSP_VERSION', '0.1' );
define( 'BPSP_DIR', dirname( __FILE__ ) );
define( 'BPSP_TD', 'bpsp' );

/**
 * i18n
 */
function bpsp_textdomain() {
    load_plugin_textdomain( BPSP_TD, false, BPSP_DIR . '/i18n' );
}
add_action( 'init', 'bpsp_textdomain' );

/* Load the components */
require_once( BPSP_DIR . '/roles/bpsp_roles.class.php' );

/* Initiate the componenets */
function bpsp_init() {
    new BPSP_Roles();
}
add_action( 'bp_init', 'bpsp_init' );

/* Activate the components */
function bpsp_activation() {
    BPSP_Roles::register_profile_fields();
}
register_activation_hook( 'scholarpress/scholarpress.php', 'bpsp_activation' );

/** TEMPORARY HELPERS **/
function _dd($stuff) {
    echo '<pre>';
        var_dump($stuff);
    echo '</pre>';
}
?>