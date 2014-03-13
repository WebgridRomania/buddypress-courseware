<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

require_once BPSP_PLUGIN_DIR . '/component/component.class.php';

/**
 * Register post types and taxonomies
 */
function bpsp_registration() {
    BPSP_Courses::register_post_types();
    BPSP_Lectures::register_post_types();
    BPSP_Assignments::register_post_types();
    BPSP_Responses::register_post_types();
    BPSP_Gradebook::register_post_types();
    BPSP_Bibliography::register_post_types();
    BPSP_Schedules::register_post_types();
}
add_action( 'init', 'bpsp_registration' );

/**
 * Loads your component into the $bp global
 *
 * This function loads your component into the $bp global. By hooking to bp_loaded, we ensure that
 * BP_Example_Component is loaded after BuddyPress's core components. This is a good thing because
 * it gives us access to those components' functions and data, should our component interact with
 * them.
 *
 * Keep in mind that, when this function is launched, your component has only started its setup
 * routine. Using print_r( $bp->example ) or var_dump( $bp->example ) at the end of this function
 * will therefore only give you a partial picture of your component. If you need to dump the content
 * of your component for troubleshooting, try doing it at bp_init, ie
 *   function bp_example_var_dump() {
 *   	  global $bp;
 *	  var_dump( $bp->example );
 *   }
 *   add_action( 'bp_init', 'bp_example_var_dump' );
 * It goes without saying that you should not do this on a production site!
 *
 * @package BuddyPress_Skeleton_Component
 * @since 1.6
 */
function bpsp_courseware_load_core_component() {
    global $bp;

    $bp->courseware = new BPSP_Courseware_Component();
}
add_action( 'bp_loaded', 'bpsp_courseware_load_core_component' );

/* Initiate the componenets */
function bpsp_init() {
    new BPSP_WordPress();
    new BPSP_Roles();
    new BPSP_Groups();
    new BPSP_Courses();
    new BPSP_Lectures();
    new BPSP_Assignments();
    new BPSP_Responses();
    new BPSP_Gradebook();
    new BPSP_Bibliography();
    new BPSP_Schedules();
    new BPSP_Dashboards();
    new BPSP_Static();
    new BPSP_Activity();
    new BPSP_Notifications();
}
add_action( 'bp_init', 'bpsp_init', 6 );
