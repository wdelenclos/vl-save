<?php

/********************************************
	Add button to Toolbar
*********************************************/

// only show button for frontend
if (!is_admin()) {
	add_action('admin_bar_menu', 'hide_fe_toolbar_add_button',  1);
}

function hide_fe_toolbar_add_button($toolbar){

	// Properties for the button
    $args = array(
            'id'		=> 'hide',
            'title'		=> '<a href="javascript://"></a>',
            'parent'	=> 'top-secondary'
            );
 
    // Add button to admin bar
    $toolbar->add_node( $args );

}

/*********************************************
	Add Stylesheet
**********************************************/

add_action( 'wp_enqueue_scripts', 'hide_fe_toolbar_add_stylesheet' );

function hide_fe_toolbar_add_stylesheet() {
	
	// Register the style for plugin
	wp_enqueue_style( 'hide-fe-toolbar-style', plugins_url( 'style.css', __FILE__ ), array('dashicons'), '2.2'  );
}


/*********************************************
	Add Javascript
**********************************************/

add_action( 'wp_enqueue_scripts', 'hide_fe_toolbar_add_script' );

function hide_fe_toolbar_add_script() {

	$toolbar_css = hide_fe_toolbar_get();

	$hide_toolbar = $toolbar_css == 'hide-fe-toolbar' ? "true" : "false";

	wp_enqueue_script( 'hide-fe-toolbar-script', plugin_dir_url( __FILE__ ) . 'script.js', array( 'jquery' ) );
	wp_localize_script( 'hide-fe-toolbar-script', 'HFETB', array(
		// URL to wp-admin/admin-ajax.php to process the request
		'ajaxurl'          => admin_url( 'admin-ajax.php' ),
	 
		// generate a nonce with a unique ID "myajax-post-comment-nonce"
		// so that you can check it later when an AJAX request is sent
		'HFETBnonce' => wp_create_nonce( 'HFETB-status-ajax-nonce' ),

		// toolbar initial state
		'hide_fe_toolbar' => $hide_toolbar,
		)
	);
}

/*********************************************
	Get/Set Toolbar Status
**********************************************/

// set status
function hide_fe_toolbar_set($toolbar_css_class){

	$toolbar_status = 'shown';

	if($toolbar_css_class == 'hide-fe-toolbar'){
		$toolbar_status = 'hidden';
	}

	
}

function hide_fe_toolbar_get(){

	$toolbar_css_class = 'show-fe-toolbar';

	

	if($toolbar_status == 'hidden'){
		$toolbar_css_class = 'hide-fe-toolbar';
	}

	return $toolbar_css_class;
}



/*********************************************
	Ajax Handler
**********************************************/

add_action( 'wp_ajax_HFETB_state', 'HFETB_ajax_submit' );
 
function HFETB_ajax_submit() {

	$nonce = $_POST['ajax_nonce'];
 
	// check to see if the submitted nonce matches with the generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'HFETB-status-ajax-nonce' ) ) {
		die ( 'Invalid nonce value!');
	}

	// ignore the request if the current user isn't logged in
	if ( is_user_logged_in() ) {

		// get the submitted parameters
		$toolbar_class = $_POST['toolbar_class'];

		hide_fe_toolbar_set($toolbar_class);

		// generate the response (WITH NEW NONCE VALUE?)
		// $response = json_encode( array( 'toolbar_class' => $toolbar_class ) );

		// response output
		// header( "Content-Type: application/json" );
		// echo $response;

	}
	// IMPORTANT: don't forget to "exit"
	exit;
}


?>