<?php
/*
Plugin Name: BuddyPress Courseware
Plugin URI: http://buddypress.coursewa.re/
Description: A LMS for BuddyPress.
Author: Stas Sușcov, Mădălin Ignișca
Version: 0.9.8
License: GNU/GPL 2
Requires at least: WordPress 3.8, BuddyPress 1.9
Tested up to: WordPress 3.8.1 / BuddyPress 1.9.2
Author URI: https://github.com/Courseware/buddypress-courseware/contributors
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

define( 'BPSP_VERSION', '0.9.8' );
define( 'BPSP_DEBUG', (bool) WP_DEBUG ); // This will allow you to see post types in wp-admin
define( 'BPSP_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'BPSP_WEB_URI', WP_PLUGIN_URL . '/' . basename( BPSP_PLUGIN_DIR ) );
define( 'BPSP_PLUGIN_FILE', basename( BPSP_PLUGIN_DIR ) . '/' . basename( __FILE__ ) );

/* Load the components */
require_once BPSP_PLUGIN_DIR . '/wordpress/wordpress.class.php';
require_once BPSP_PLUGIN_DIR . '/roles/roles.class.php';
require_once BPSP_PLUGIN_DIR . '/courses/courses.class.php';
require_once BPSP_PLUGIN_DIR . '/lectures/lectures.class.php';
require_once BPSP_PLUGIN_DIR . '/assignments/assignments.class.php';
require_once BPSP_PLUGIN_DIR . '/responses/responses.class.php';
require_once BPSP_PLUGIN_DIR . '/gradebook/gradebook.class.php';
require_once BPSP_PLUGIN_DIR . '/bibliography/bibliography.class.php';
require_once BPSP_PLUGIN_DIR . '/bibliography/webapis.class.php';
require_once BPSP_PLUGIN_DIR . '/schedules/schedules.class.php';
require_once BPSP_PLUGIN_DIR . '/groups/groups.class.php';
require_once BPSP_PLUGIN_DIR . '/dashboards/dashboards.class.php';
require_once BPSP_PLUGIN_DIR . '/static/static.class.php';
require_once BPSP_PLUGIN_DIR . '/activity/activity.class.php';
require_once BPSP_PLUGIN_DIR . '/notifications/notifications.class.php';

/**
 * i18n
 */
function bpsp_textdomain() {
    load_plugin_textdomain( 'bpsp', false, basename( BPSP_PLUGIN_DIR ) . '/languages' );
}
add_action( 'init', 'bpsp_textdomain' );

/* Only load the component if BuddyPress is loaded and initialized. */
function bp_courseware_init() {
    // Because our loader file uses BP_Component, it requires BP 1.5 or greater.
    if ( version_compare( BP_VERSION, '1.9', '>=' ) )
        require_once( BPSP_PLUGIN_DIR . '/bp-courseware-loader.php' );
}
add_action( 'bp_include', 'bp_courseware_init' );

/**
 * bpsp_check()
 * Will check for Courseware dependencies and active components
 *
 * @return True on errors
 * @uses `admin_notices`
 */
function bpsp_check() {
    $messages = array();

    if ( function_exists( 'bp_get_version' ) ) {
        foreach( array( 'groups', 'activity', 'xprofile', 'messages' ) as $c ) {
            if( !bp_is_active( $c ) ) {
                $messages[] = sprintf(
                    __( 'BuddyPress Courseware dependency error: <a href="%1$s">%2$s has to be activated</a>!', 'bpsp' ),
                    admin_url( 'admin.php?page=bp-general-settings' ),
                    $c
                );
			}
		}
    } else {
        $messages[] = sprintf(
            __( 'BuddyPress Courseware dependency error: Please <a href="%1$s">install BuddyPress</a>!', 'bpsp' ),
            admin_url( 'plugins.php' )
        );
    }

    if( !empty( $messages ) ) {
        echo '<div id="message" class="error fade">';
        foreach ( $messages as $m ) {
            echo "<p>{$m}</p>";
		}
        echo '</div>';
        return false;
    }

    return true;
}

/* Activate the components */
function bpsp_activation() {
    if( !bpsp_check() ) {
        exit(1);
	}
    BPSP_Roles::register_profile_fields();
}
register_activation_hook( BPSP_PLUGIN_FILE, 'bpsp_activation' );