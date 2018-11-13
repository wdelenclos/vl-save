<?php
/*

Author: Janis Elsts
Author URI: http://w-shadow.com/blog/
*/

if ( include(dirname(__FILE__) . '/includes/version-conflict-check.php') ) {
	return;
}

//Are we running in the Dashboard?
if ( is_admin() ) {

    //Load the plugin
    require 'includes/menu-editor-core.php';
    $wp_menu_editor = new WPMenuEditor(__FILE__, 'ws_menu_editor');

}//is_admin()