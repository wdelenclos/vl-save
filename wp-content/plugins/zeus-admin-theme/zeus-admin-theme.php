<?php

/*
Plugin Name: Zeus Admin Theme
Plugin URI: http://mainsailcreative.com/
Description: A simple, clean admin theme with select features to improve your WordPress experience.
Author: Luke Hertzler
Version: 1.1
Author URI: http://mainsailcreative.com/
*/

/* 
* Load zeus css/script plugin files
*/

function zeus_admin_files() {
  wp_enqueue_style( 'zeus-admin-theme', plugins_url('css/zeus-admin.css', __FILE__), array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'zeus_admin_files' );

/* 
* Load admin menu editor
*/

    require 'inc/menu-editor/menu-editor.php';


/* 
* Load front-end admin bar toggle
*/

    require 'inc/hide-front-end-toolbar/hide-fe-toolbar.php';
    
/* 
* Load back-end search
*/

    require 'inc/search/search.php';
?>
