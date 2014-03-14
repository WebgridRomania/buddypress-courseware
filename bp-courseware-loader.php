<?php

use BPSP_Courses;
use BPSP_Lectures;
use BPSP_Assignments;
use BPSP_Responses;
use BPSP_Gradebook;
use BPSP_Bibliography;
use BPSP_Schedules;

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
