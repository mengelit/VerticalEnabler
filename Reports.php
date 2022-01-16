<?php
/**
 * @package Reports
 * @author MengelIT
 * @version 0.1
 */
/*
Plugin Name: Reports
Plugin URI: http://wordpress.org/#
Description: This reporting plugin is built from the hello dolly plugin
Author: MengelIT
Version: 0.1
Author URI: http://www.mengelit.com
*/

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {

    // Add a new top-level menu:
    add_menu_page('Reports', 'Reports', 'administrator', 'mt-top-level-handle', 'mt_toplevel_page');

    // Add a submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', 'Sponsors & Leads', 'Sponsors & Leads', 'administrator', 'sub-page', 'mt_sublevel_page');

}

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function mt_toplevel_page() {
    echo "<h2>Reports:</h2>";
	echo "<p>Please select one of the available reports.</p><hr>";
}

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function mt_sublevel_page() {
    echo "<h2>Sponsors & Leads</h2>";
	echo "<hr>";
	echo "<hr>";
}


?>
