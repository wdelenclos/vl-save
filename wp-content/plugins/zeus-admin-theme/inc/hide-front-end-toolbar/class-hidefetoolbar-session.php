<?php
/**
 * HideFEToolbar Session
 *
 * This is a wrapper class for WP_Session / PHP $_SESSION and handles the hide/show status of the toolbar. Adapted from Pippin Williamson's Easy Digital Downloads (https://github.com/easydigitaldownloads/Easy-Digital-Downloads/blob/master/includes/class-edd-session.php)
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * HideFEToolbar_Session Class
 *
 * 
 */
class HideFEToolbar_Session {

	/**
	 * Holds our session data
	 *
	 * @var array
	 * @access private
	 * 
	 */
	private $session = array();


	/**
	 * Whether to use PHP $_SESSION or WP_Session
	 *
	 * PHP $_SESSION is opt-in only by defining the HideFEToolbar_USE_PHP_SESSIONS constant
	 *
	 * @var bool
	 * @access private
	 * 
	 */
	private $use_php_sessions = false;


	/**
	 * Get things started
	 *
	 * Defines our WP_Session constants, includes the necessary libraries and
	 * retrieves the WP Session instance
	 *
	 * @access public
	 * 
	 * @return void
	 */
	public function __construct() {

		$this->use_php_sessions = defined( 'HideFEToolbar_USE_PHP_SESSIONS' ) && HideFEToolbar_USE_PHP_SESSIONS;

		if( $this->use_php_sessions ) {

			// Use PHP SESSION (must be enabled via the HideFEToolbar_USE_PHP_SESSIONS constant)

			if( ! session_id() )
				add_action( 'init', 'session_start', -1 );

		} else {

			// Use WP_Session (default)

			if ( ! defined( 'WP_SESSION_COOKIE' ) )
				define( 'WP_SESSION_COOKIE', 'wordpress_wp_session' );

			if ( ! class_exists( 'Recursive_ArrayAccess' ) )
				require_once HideFEToolbar_PLUGIN_DIR . 'includes/class-recursive-arrayaccess.php';

			if ( ! class_exists( 'WP_Session' ) ) {
				require_once HideFEToolbar_PLUGIN_DIR . 'includes/class-wp-session.php';
				require_once HideFEToolbar_PLUGIN_DIR . 'includes/wp-session.php';
			}

		}

		if ( empty( $this->session ) && ! $this->use_php_sessions )
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		else
			add_action( 'init', array( $this, 'init' ) );
	}


	/**
	 * Setup the WP_Session instance
	 *
	 * @access public
	 * 
	 * @return void
	 */
	public function init() {

		if( $this->use_php_sessions )
			$this->session = isset( $_SESSION['HideFEToolbar'] ) && is_array( $_SESSION['HideFEToolbar'] ) ? $_SESSION['HideFEToolbar'] : array();
		else
			$this->session = WP_Session::get_instance();

		return $this->session;
	}


	/**
	 * Retrieve session ID
	 *
	 * @access public
	 * 
	 * @return string Session ID
	 */
	public function get_id() {
		return $this->session->session_id;
	}


	/**
	 * Retrieve a session variable
	 *
	 * @access public
	 * 
	 * @param string $key Session key
	 * @return string Session variable
	 */
	public function get( $key ) {
		$key = sanitize_key( $key );
		return isset( $this->session[ $key ] ) ? maybe_unserialize( $this->session[ $key ] ) : false;
	}


	/**
	 * Set a session variable
	 *
	 * @access public
	 * 
	 * @param string $key Session key
	 * @param string $variable Session variable
	 * @return array Session variable
	 */
	public function set( $key, $value ) {
		$key = sanitize_key( $key );

		if ( is_array( $value ) )
			$this->session[ $key ] = serialize( $value );
		else
			$this->session[ $key ] = $value;

		if( $this->use_php_sessions )
			$_SESSION['HideFEToolbar'] = $this->session;

		return $this->session[ $key ];
	}
}