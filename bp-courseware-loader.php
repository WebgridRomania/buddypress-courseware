<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

require_once BPSP_PLUGIN_DIR . '/component/component.class.php';

/**
 * Loads your component into the $bp global
 */
function bpsp_courseware_load_core_component() {
    global $bp;

    $bp->courseware = new BPSP_Courseware_Component();
}
add_action( 'bp_loaded', 'bpsp_courseware_load_core_component' );
