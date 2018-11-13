<?php defined( 'ABSPATH' ) OR exit;
/**
 * Plugin Name: Post State Tags
 * Plugin URI:  http://wordpress.org/plugins/post-state-tags/
 * Description: Make your WordPress post state list stand out with colors and color tags (draft, pending, sticky, etc)
 * Version:     2.0.3
 * Author:      BRANDbrilliance
 * Author URI:  http://www.brandbrilliance.co.za/
 * License:     GPL-2.0+
 * Text Domain: post-state-tags
 * Domain Path: /languages
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


if ( !class_exists('Post_State_Tags' ) ):

require_once('libraries/class.color-hsl.php');
require_once('libraries/class.settings-api.php');

//Plugin Activation (not in class)
//register_activation_hook( __FILE__, array('Post_State_Tags', 'on_activation') );

// Todo
//register_deactivation_hook( __FILE__, array('Post_State_Tags', 'on_deactivation'));
//register_uninstall_hook( __FILE__, array('Post_State_Tags', 'on_uninstall') );

/**
 * The core plugin class.
 *
 * @since      2.0.1
 * @package    Post State Tags
 * @author     John Brand <john@brandbrilliance.co.za>
 */
class Post_State_Tags {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      string    $plugin_slug    The string used to uniquely identify this plugin.
	 */
	protected $plugin_slug;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Holds values for plugin array.
	 *
	 * @since    1.1.7
	 * @access   protected
	 * @var      array    $arrConfir    The config array.
	 */
  protected $arrData = array();

	/**
	 * Holds values for settings api.
	 *
	 * @since    1.1.7
	 * @access   protected
	 * @var      array    $settings_api    The settings configuration array.
	 */
  protected $settings_api;


	/**
	 * Prevent cloning of the object (Singleton)
	 */
	final private function __clone() {}


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Set the hooks for processing
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// plugin variables
		$this->plugin_slug = 'post-state-tags';
		$this->version = '2.0.3';
		$this->set_locale();

		// default config
		$this->admin_page = 'options-' . $this->plugin_slug;

		// field settings
		$this->pfx = 'bb-pst-';
		$this->submit = $this->pfx . 'submit';
		$this->reset = $this->pfx . 'submit-reset';
		$this->icon = '-icon';

		// settings api		
		$this->settings_api = new WeDevs_Settings_API;
		$this->set_defaults();
		
		$this->migrate_check();

		//plugin setup		
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array($this, 'plugin_settings_links') );

		// plugin admin backend
		add_action( 'admin_init', array($this, 'admin_init') );
		add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );

		// plugin filters
		add_filter( 'display_post_states', array($this, 'display_post_states') );

	}


	/**
	 * Set an object property
	 * @param string
	 * @param mixed
	 */
	public function __set($key, $value)
	{
		$this->arrData[$key] = $value;
	}

	/**
	 * Return an object property
	 * @param string
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->arrData[$key];
	}

	/**
	 * Check whether a property is set
	 * @param string
	 * @return boolean
	 */
	public function __isset($key)
	{
		return isset($this->arrData[$key]);
	}

	/**
	 * Unsets a property
	 * @param string
	 * @return nothing
	 */
  public function __unset($key)
  {
    unset($this->arrData[$key]);
  }


	/**
	 *  Load plugin text domain
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function set_locale() {

		load_plugin_textdomain(
			$this->plugin_slug,
			false,
			plugin_dir_path( __FILE__ ) . '/languages/'
		);

	}

	
	public function admin_init() {

		if (isset($_POST[$this->reset]))
		{
			$this->reset_settings();
		}	

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );
		
		//initialize settings
		$this->settings_api->admin_init();
		
	}
	
	
	function get_settings_sections() {
	    $sections = array(
	        array(
	            'id'    => $this->pfx . 'default',
	            'title' => __( 'Default Statuses', $this->plugin_slug ),
	            'desc'	=> __( 'Sets the individual default post status colors and icons. Some colors and icons may not be used or visible.', $this->plugin_slug )
	        ),
	        array(
	            'id'    => $this->pfx . 'special',
	            'title' => __( 'Special Statuses', $this->plugin_slug ),
	            'desc'	=> __( 'Sets the individual special post status colors and icons. Some colors and icons may not be used or visible.', $this->plugin_slug )
	        ),
	        array(
	            'id'    => $this->pfx . 'custom',
	            'title' => __( 'Custom Statuses', $this->plugin_slug ),
	            'desc'	=> __( 'Sets the custom post statuses settings of the plugin.', $this->plugin_slug )
	        ),
	        array(
	            'id'    => $this->pfx . 'advanced',
	            'title' => __( 'Advanced Settings', $this->plugin_slug ),
	            'desc'	=> __( 'Enables the plugin and also enables the mini icons.', $this->plugin_slug )
	        )
	    );
	    return $sections;
	}

	/**
	 *  admin_enqueue_scripts
	 *
	 *  @since    1.1.0
	 *  @created  2015-05-23
	 */
	 function admin_enqueue_scripts($hook) {
	
			// Add Color styles for any page or posts page, using edit.php
			// hook: edit
	    if ( 'edit.php' == $hook ) {
				// add as inline styles appended to dummy stylesheet
		    wp_enqueue_style( 'poststates', plugin_dir_url( __FILE__ ) . 'css/poststates.css' );
		    wp_add_inline_style( 'poststates', $this->get_css_poststates() );
	    }
	
			// Add Color pickers and custom styles, scripts for plugin settings page
			// hook: settings_page_options-post-state-tags
			if ( 'settings_page_' . $this->admin_page == $hook) {
				// color picker
			  wp_enqueue_style('wp-color-picker');
			  wp_enqueue_script('wp-color-picker');
	
				// enqueue support scripts
			  wp_enqueue_script('pst-settings-color',  plugin_dir_url( __FILE__ ) . 'js/settings.js' , array('jquery', 'wp-color-picker'));
			  wp_enqueue_script('pst-settings-dashicons',  plugin_dir_url( __FILE__ ) . 'js/dashicons-picker.js' , array('jquery'));
	
				// additional support styles
				wp_enqueue_style('pst-settings', plugin_dir_url( __FILE__ ) . 'css/admin.css');	
				wp_enqueue_style('pst-settings-dashicons', plugin_dir_url( __FILE__ ) . 'css/dashicons-picker.css');	
			}
	
	}


	/**
	 * admin_menu
	 *
	 *  Add plugin settings page
	 *
	 *  @since    1.1.0
	 *  @created  2015-05-23
	 */
	function admin_menu() 
	{
    //add_options_page( 'Settings API', 'Settings API', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );

		add_options_page( 
			__('Post State Tags Settings', $this->plugin_slug), //page_title
			__('Post State Tags', $this->plugin_slug), //menu_title
			'manage_options', //capability
			$this->admin_page, //page
			array ($this, 'plugin_page') //callback
		);
	}
	


	private function set_defaults() {
		
		$this->defaults = array ('publish', 'draft', 'pending', 'private', 'future', 'trash');
		$this->defaults = apply_filters( 'bb_pst_status_defaults', $this->defaults);

		$this->specials = array('protected', 'sticky', 'page_on_front', 'page_for_posts', 'page_for_privacy_policy');
		$this->specials = apply_filters( 'bb_pst_status_specials', $this->specials);


		$this->colors = array(
			'publish'				=> '',
			'draft'					=> '#2ea2cc',
			'pending'				=> '#7ad03a',
			'private'				=> '#ffba00',
			'future'				=> '#aaaaaa',
			'trash'					=> '',
			'protected'			=> '#d54e21',
			'sticky'				=> '#9859b9',
			'page_on_front'	=> '#000000', // WP 4.2 
			'page_for_posts'=> '#000000', // WP 4.2
			'page_for_privacy_policy' => '#000000', // WP 4.9
			'archive' 			=> '#a67c52', // Custom Plugin
		);
		$this->colors = apply_filters( 'bb_pst_status_colors', $this->colors);

		$this->icons = array (
			'publish' 			=> '',
			'draft' 				=> 'dashicons-edit',
			'pending' 			=> 'dashicons-format-chat',
			'private' 			=> 'dashicons-lock',
			'future' 				=> 'dashicons-calendar-alt', // not yet supported by wordpress
			'trash' 				=> 'dashicons-trash',
			'protected' 		=> 'dashicons-admin-network',
			'sticky' 				=> 'dashicons-star-filled',
			'page_on_front'	=> 'dashicons-admin-home', // WP 4.2
			'page_for_posts'=> 'dashicons-admin-post', // WP 4.2
			'page_for_privacy_policy' => 'dashicons-flag', // WP 4.9
			'archive' 			=> 'dashicons-archive', // Custom Plugin
		);
		$this->icons = apply_filters( 'bb_pst_status_icons', $this->icons);
				
		// Advanced 
		$this->lightvalue = 0.97;		 
		$this->lightvalue = apply_filters( 'bb_pst_lightvalue', $this->lightvalue);

	}	
	


	/**
	 * Returns the option setting
	 *
	 * @return variable option setting
	 */
	private function get_option($option, $section, $default = '') {

		return $this->settings_api->get_option( $option, $section, $default );

	}

	
	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		// default post statuses
		$defaults = $this->get_post_statuses_default();
		foreach ($defaults as $status) 
		{

			// Colour picker
	    $settings_fields[$this->pfx . 'default'][] = array(
	      'name'    => $status['option_handle'],
	      'label'   => __( $status['label'], $this->plugin_slug ),
	      'type'    => 'color',
	      'sanitize_callback' => array($this, 'validate_color'),
      );

			// Dashicon picker
	    $settings_fields[$this->pfx . 'default'][] = array(
	      'name'    => $status['option_handle'] . $this->icon,
	      'label'   => __( $status['label'] . ' Icon', $this->plugin_slug ),
	      'type'    => 'dashicon',
				'size'		=> '',
	      'callback' => array( $this, 'callback_dashicons' ),
        'sanitize_callback' => array( $this, 'validate_dashicons' ),
				
      );

		}

		// special post statuses
		$special = $this->get_post_statuses_special();
		foreach ($special as $status) 
		{

			// Colour picker
	    $settings_fields[$this->pfx . 'special'][] = array(
	      'name'    => $status['option_handle'],
	      'label'   => __( $status['label'], $this->plugin_slug ),
	      'type'    => 'color',
      );

			// Dashicon picker
	    $settings_fields[$this->pfx . 'special'][] = array(
	      'name'    => $status['option_handle'] . $this->icon,
	      'label'   => __( $status['label'] . ' Icon', $this->plugin_slug ),
	      'type'    => 'dashicon',
				'size'		=> '',
	      'callback' => array( $this, 'callback_dashicons' ),
        'sanitize_callback' => array( $this, 'validate_dashicons' ),
				
      );

		}

		// special post statuses
		$custom = $this->get_post_statuses_custom();
		foreach ($custom as $status) 
		{

			// Colour picker
	    $settings_fields[$this->pfx . 'custom'][] = array(
	      'name'    => $status['option_handle'],
	      'label'   => __( $status['label'], $this->plugin_slug ),
	      'type'    => 'color',
      );

			// Dashicon picker
	    $settings_fields[$this->pfx . 'custom'][] = array(
	      'name'    => $status['option_handle'] . $this->icon,
	      'label'   => __( $status['label'] . ' Icon', $this->plugin_slug ),
	      'type'    => 'dashicon',
				'size'		=> '',
	      'callback' => array( $this, 'callback_dashicons' ),
        'sanitize_callback' => array( $this, 'validate_dashicons' ),
				
      );

		}


		$settings_fields[$this->pfx . 'advanced'] = array (

	    array(
	        'name'  => $this->pfx . 'setting-enabled',
	        'label' => __( 'Enabled', $this->plugin_slug ),
	        'desc'  => __( 'Enables the plugin', $this->plugin_slug ),
	        'type'  => 'checkbox'
	    ),
	    array(
	        'name'  => $this->pfx . 'setting-icons',
	        'label' => __( 'Show icons', $this->plugin_slug ),
	        'desc'  => __( 'Enables the icons', $this->plugin_slug ),
	        'type'  => 'checkbox'
	    ),
			
			array(
	        'name'              => $this->pfx .'setting-lightvalue',
	        'label'             => __( 'Background tint', $this->plugin_slug ),
	        'desc'              => __( 'Enter a value between (0 = dark) and (1 = light). Default is 0.97 (subtle pastel shade).', $this->plugin_slug ),
	        'placeholder'       => __( 'Lightness ', $this->plugin_slug  ),
	        'min'               => 0,
	        'max'               => 1,
	        'step'              => '0.01',
	        'type'              => 'number',
	        'default'           => $this->lightvalue,
	        'sanitize_callback' => 'floatval' //???
	    ),

		);

    return $settings_fields;
	}


	public function get_post_statuses($include = array(), $exclude = array()) {

		// get wordpress post stati
	  $post_stati = get_post_stati($post_stati = array(), "objects");
	
	  $post_statuses = array();
	
	  foreach ($post_stati as $status) 
	  {
	    if ($status->show_in_admin_status_list === false || (sizeof($include) > 0 && !in_array($status->name, $include)) || in_array($status->name, $exclude)) 
	        continue;
	
	    $handle = $this->pfx . sanitize_key($status->name);
	    $post_statuses[$status->name] = array(
	    	'option_handle' => $handle, 
	    	'label' => $status->label, 
	    	'name' => $status->name
	    );

	  }
	
	  //ksort($custom_post_statuses);
	  return $post_statuses;
	}

	public function get_post_statuses_default() {
	    return $this->get_post_statuses($this->defaults);
	}
	public function get_post_statuses_custom() {
	    return $this->get_post_statuses(array(), $this->defaults);
	}


	// special treatment for special statuses
	public function get_post_statuses_special() {
	
	  $post_statuses = array();
	
	  foreach ($this->specials as $status)
	  {
	    $handle = $this->pfx . sanitize_key($status);
			$name = $status;
			$label = $this->get_special_post_label($status);
	    $post_statuses[$name] = array(
	    	'option_handle' => $handle, 
	    	'label' => $label, 
	    	'name' => $name
	    );
	  }
	
	  return $post_statuses;
	}


	private function get_special_post_label($status) {
		
		switch ($status) {
			
			case 'protected':
				$label = __('Password Protected', $this->plugin_slug);
				break;
	
			case 'sticky':
				$label = __('Sticky', $this->plugin_slug);
				break;
	
			case 'page_on_front':
				$label = __('Front Page', $this->plugin_slug);
				break;
	
			case 'page_for_posts':
				$label = __('Posts Page', $this->plugin_slug);
				break;

			case 'page_for_privacy_policy':
				$label = __('Privacy Policy Page', $this->plugin_slug);
				break;
				
			default:
				$label = __( ucfirst($status), $this->plugin_slug);
		}
	
		return $label;
	}	


	public function validate_color( $input ) {
	  $valid = filter_var($input, FILTER_SANITIZE_STRING);
		
	  if (!empty($valid) && $this->validate_html_color($valid) === false) {

	    add_settings_error($this->pfx . 'errors', 666, __('Invalid Color on field: ', $this->plugin_slug) . $input , 'error');
	    return false;

	  }
	
	  return $valid;
	}


	public function validate_html_color( $color ) {

	    if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
	        return $color;
	    } else if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
	        $color = '#' . $color;
	        return $color;
	    }
	
	    return false;
	}


	public function callback_dashicons(array $args) {
	
	  $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

    $html = sprintf( '<input  type="text" class="%1$s-text wp-dashicon-picker" id="%3$s" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
		$html .= sprintf('<input type="button" data-target="#%2$s" class="button dashicons-picker" value="%3$s" />', $args['section'], $args['id'], __('Choose icon', $this->plugin_slug) );
		$html .= $this->settings_api->get_field_description( $args );

    echo $html;

	}

	public function validate_dashicons($input) {
	    return $input;
	}

	
	
	function plugin_page() {
?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Post State Tags Settings', $this->plugin_slug); ?></h1>

			<?php 
				// includes notifications (save/error) from settings_errors(); 
				$this->settings_api->show_navigation(); 
				$this->settings_api->show_forms(); 
			?>
	    
			<form method="post" action="<?php echo admin_url('options-general.php?page=' . $this->admin_page ); ?>" id="bb-pst-form-reset-to-defaults">
        <?php submit_button(__('Reset Settings', $this->plugin_slug), 'delete', $this->pfx.'submit-reset', true, array('id' => 'bb-pst-button-reset-to-defaults', 'data-message' => __('Are you sure?', $this->plugin_slug))); ?>
			</form>
	
	   </div>
<?php
	}
	

		
	private function update_options($section, $desired_options = array()) {
		
		// no new options set
		if (!is_array($desired_options) && count($desired_options) < 1)
			return;
		
		$current_options = get_option( $section, array() );
		$merged_options = wp_parse_args( $desired_options, $current_options );

		update_option( $section, $merged_options );

	}	

	
	/**
	 *  Reset Settings
	 *
	 *  @since    1.1.0
	 *  @created  
	 */
	private function reset_settings() 
	{
		
		// default post statuses
		$new_options = array();
		$default = $this->get_post_statuses_default();
		foreach ($default as $status)
		{
			$new_options[ $status['option_handle'] ] = $this->colors[$status['name']];
			$new_options[ $status['option_handle']. $this->icon] = $this->icons[$status['name']];
		}
		$this->update_options( $this->pfx . 'default', $new_options);
		
		// special post statuses
		$new_options = array();
		$special = $this->get_post_statuses_special();
		foreach ($special as $status) 
		{
		  $new_options[ $status['option_handle'] ] = $this->colors[$status['name']];
			$new_options[ $status['option_handle'] . $this->icon ] = $this->icons[$status['name']];
		}
		$this->update_options( $this->pfx . 'special', $new_options);

		// custom post statuses
		$new_options = array();
		$custom = $this->get_post_statuses_custom();
	  if (sizeof($custom) > 0)
	  {
			foreach ($custom as $status) 
			{
			  $new_options[ $status['option_handle'] ] = $this->colors[$status['name']];
				$new_options[ $status['option_handle'] . $this->icon ] = $this->icons[$status['name']];
			}
			$this->update_options( $this->pfx . 'custom', $new_options);
		}
		
		// advanced settings
		//Array ( [bb-pst-setting-enabled] => on [bb-pst-setting-icons] => on [setting-lightval] => 0.97 )
		$new_options = array();
		$new_options[ $this->pfx .'setting-enabled' ] = 'on';
		$new_options[ $this->pfx .'setting-icons' ] = 'on';
		$new_options[ $this->pfx .'setting-lightvalue' ] = $this->lightvalue;
		$this->update_options( $this->pfx . 'advanced', $new_options );

	}
		
	// Generate post state classes
	public function get_css_poststates () {

		if ( $this->get_option( $this->pfx . 'setting-enabled', $this->pfx . 'advanced' ) != 'on' ) 
			return;
			
		// Background Colors
		$css = "";
	
		$css .= "
	/* Post Status Tags */
	.post-state .states {
			font-size:10px;
			padding:3px 8px 3px 8px;
			-moz-border-radius:2px;
			-webkit-border-radius:2px;
			border-radius:2px;
			background:#999; /* default colors */
			color:#fff;
			white-space: nowrap;
	}
	/* Post Status Tags Icons */
	.post-state .states .dashicons {
		width: inherit;
		height: inherit;
		font-size: inherit;
		vertical-align: -1px;
		margin-right:3px;
	}
	";

		// default post statuses
		$section = $this->pfx . 'default';
		$default = $this->get_post_statuses_default();
		foreach ($default as $status) 
		{

			$color = $this->get_option( $status['option_handle'] , $section , $this->colors[$status['name']] ); 
	    $css .= $this->color_builder($status['name'], $color);

			$icon = $this->get_option( $status['option_handle'] . $this->icon, $section , $this->icons[$status['name']] ); 
	    $css .= $this->tag_builder($status['name'], $color, $icon);

		}

		// special post statuses
		$section = $this->pfx . 'special';
		$special = $this->get_post_statuses_special();
		foreach ($special as $status) 
		{
			$color = $this->get_option( $status['option_handle'] , $section , $this->colors[$status['name']] ); 
	    $css .= $this->color_builder($status['name'], $color);

			$icon = $this->get_option( $status['option_handle'] . $this->icon, $section , $this->icons[$status['name']] ); 
	    $css .= $this->tag_builder($status['name'], $color, $icon);
		}

		// custom post statuses
		$section = $this->pfx . 'custom';
		$custom = $this->get_post_statuses_custom();
	  if (sizeof($custom) > 0)
	  {
			foreach ($custom as $status) 
			{
				$color = $this->get_option( $status['option_handle'] , $section , $this->colors[$status['name']] ); 
		    $css .= $this->color_builder($status['name'], $color);
	
				$icon = $this->get_option( $status['option_handle'] . $this->icon, $section, $this->icons[$status['name']] ); 
		    $css .= $this->tag_builder($status['name'], $color, $icon);
			}
		}

		return $css;
	
	}


	public function color_builder($status, $color) {

		// no color setup
	  if ($status == '' || $color == '' || $color == 'transparent')
			return;
	
		// sticky is only a tag
	  if ($status == 'sticky')
			return;
	
	  $style = '';
	
		// map status values to classes (wordpress does this)
		switch ($status)
		{
			case 'protected':
				$class = ".post-password-required";
				break;	
			
			default: 
				$class = ".status-$status";
		}
	
		// use filter to modify light color
		$lightvalue = $this->get_option( $this->pfx . 'setting-lightvalue', $this->pfx . 'advanced' , $this->lightvalue ) ;

		$lightcolor = HSLColorLibrary::get_light_color(str_replace('#', '', $color), $lightvalue);
		if ($lightcolor)
		{
			$lightcolor = "#$lightcolor";
		}
	  $style .= "#the-list $class th.check-column { border-left:4px solid $color; }\n";
	  $style .= "#the-list $class th.check-column input { margin-left:4px; }\n";
	  $style .= "#the-list $class th, #the-list $class td { background-color:$lightcolor; }\n";
	
	  return $style;
	}
	
	
	
	public function tag_builder($status, $color, $icon = '') {
		// no tag needed
	  if ($status == '' || $color !='' && $color == 'transparent')
			return;
	
		// map status values to classes (wordpress does this)
		switch ($status)
		{
			case 'future':
				$class = 'scheduled';
				break;	
			
			default: 
				$class = $status;
		}
	
	  $style = ".post-state .$class {background:$color;color:#fff;}\n";
	
	  return $style;
	}


	private function get_icons()
	{
		$icon_list = array();

		// default post statuses
		$section = $this->pfx . 'default';
		$default = $this->get_post_statuses_default();
		foreach ($default as $status) 
		{
			$icon_list[ $status['option_handle'] . $this->icon ] = $this->get_option( $status['option_handle'] . $this->icon, $section , $this->icons[$status['name']] );	
		}

		// special post statuses
		$section = $this->pfx . 'special';
		$special = $this->get_post_statuses_special();
		foreach ($special as $status) 
		{
			$icon_list[ $status['option_handle'] . $this->icon] = $this->get_option( $status['option_handle'] . $this->icon, $section , $this->icons[$status['name']] );
		}

		// custom post statuses
		$section = $this->pfx . 'custom';
		$custom = $this->get_post_statuses_custom();
	  if (sizeof($custom) > 0)
	  {
			foreach ($custom as $status) 
			{
				$icon_list[ $status['option_handle'] . $this->icon] = $this->get_option( $status['option_handle'] . $this->icon, $section , $this->icons[$status['name']] );
			}
		}

		return $icon_list;
	}
	
	
	// Custom tag styling of post state, including removal of seperators
	public function display_post_states ( $post_states ) {
	
		if ( $this->get_option( $this->pfx . 'setting-enabled', $this->pfx . 'advanced' ) != 'on' ) 
			return $post_states;
	
		if ( !empty($post_states) ) {
			
			$icon_list = $this->get_icons();
			
			foreach ( $post_states as $key=>&$state ) {
				
				// get icon
				$iconname = '';
				if ( $this->get_option( $this->pfx . 'setting-icons', $this->pfx . 'advanced' ) == 'on' ) { 
	
					// map status values to classes (wordpress does this)
					switch ($key)
					{
						case 'scheduled':
							$lkey = 'future';
							break;	
						
						default: 
							$lkey = $key;
					}
			    $iconname = $icon_list[$this->pfx . sanitize_key($lkey) . $this->icon];
				}
	
				// add tag
				$state = '<span class="'. $key.' states">'. ($iconname ? '<span class="dashicons '.$iconname.'"></span>' : '') . $state . '</span>'; // strtolower( $state )
			}
			echo ' <span class="post-state">'. implode('</span> <span class="post-state">', $post_states) . '</span>';
		}
	}
	



	/**
	 *  plugin_settings_links
	 *
	 *  Add settings link to the plugin action links
	 *
	 *  @since    1.1.0
	 *  @created  2015-05-23
	 */ 
	 
	function plugin_settings_links( $links )
	{
		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page='.$this->admin_page). '">' . __('Settings', $this->plugin_slug) . '</a>'
			),
			$links
		);
	}


	/**
	 *  migrate_options
	 *
	 *  Migrate old options to new options
	 *
	 *  @since    2.0.1
	 *  @created  10/009/2018
	 */ 
	
	public function migrate_options() 
	{

		// Convert Defaults				
		$new_options = array();
		$default = $this->get_post_statuses_default();
		foreach ($default as $status)
		{
			$handle = str_replace($this->pfx, $this->pfx . 'color-', $status['option_handle']);

			if ( null !== get_option($handle) )
				$new_options[ $status['option_handle'] ] = get_option($handle);

			if ( null !== get_option($handle . $this->icon) )
				$new_options[ $status['option_handle'] . $this->icon] = get_option($handle . $this->icon);

		}
		$this->update_options( $this->pfx . 'default', $new_options);

		foreach ($default as $status) {
			$handle = str_replace($this->pfx, $this->pfx . 'color-', $status['option_handle']);
			delete_option( $handle );
			delete_option( $handle . $this->icon );
		}				

		// Special post statuses Tab
		$new_options = array();
		$special = $this->get_post_statuses_special();
		foreach ($special as $status)
		{
			$handle = str_replace($this->pfx, $this->pfx . 'color-', $status['option_handle']);

			if ( null !== get_option($handle) )
				$new_options[ $status['option_handle'] ] = get_option($handle);

			if ( null !== get_option($handle . $this->icon) )
				$new_options[ $status['option_handle'] . $this->icon] = get_option($handle . $this->icon);
				
		}
		$this->update_options( $this->pfx . 'special', $new_options);

		foreach ($special as $status) {
			$handle = str_replace($this->pfx, $this->pfx . 'color-', $status['option_handle']);
			delete_option( $handle );
			delete_option( $handle . $this->icon );
		}				


		// Custom post statuses Tab
		$new_options = array();
		$custom = $this->get_post_statuses_custom();
	  if (sizeof($custom) > 0)
	  {
			foreach ($custom as $status) 
			{
				$handle = str_replace($this->pfx, $this->pfx . 'color-', $status['option_handle']);

				if ( null !== get_option($handle) )
					$new_options[ $status['option_handle'] ] = get_option($handle);
	
				if (  null !== get_option($handle . $this->icon) )
					$new_options[ $status['option_handle'] . $this->icon] = get_option($handle . $this->icon);
					
			}
			$this->update_options( $this->pfx . 'custom', $new_options);

			foreach ($custom as $status) {
				$handle = str_replace($this->pfx, $this->pfx . 'color-', $status['option_handle']);
				delete_option( $handle );
				delete_option( $handle . $this->icon );
			}				

		}


		// old options have a incorrect setting prefix
		/*
		bb_pst_setting_enabled	
		bb_pst_setting_icons	
		bb_pst_installed	
		bb_pst_version	
		*/

		// convert advanced settings
		$new_options = array();

		if ( null !== get_option('bb_pst_setting_enabled') ) 
			$new_options[ $this->pfx . 'setting-enabled' ] = ( get_option($this->pfx . 'setting-enabled') == '1' ? 'on' :  'off');

		if ( null !== get_option('bb_pst_setting_icons') ) 
			$new_options[ $this->pfx . 'setting-enabled' ] = ( get_option($this->pfx . 'setting-icons') == '1' ? 'on' :  'off');

		// add lightness value
		$new_options[ $this->pfx .'setting-lightvalue' ] = $this->lightvalue;

		$this->update_options( $this->pfx . 'advanced', $new_options );


		$this->update_options( $this->pfx . 'advanced', $new_options);

		delete_option('bb_pst_installed');
		delete_option('bb_pst_version');
		delete_option('bb_pst_setting_enabled');
		delete_option('bb_pst_setting_icons');
	
	}

		
	/**
	 *  migrate_check
	 *
	 *  Check installation and reset settings, or migrate
	 *
	 *  @since    2.0.1
	 *  @created  2018-09-10
	 */ 
	
	public function migrate_check() 
	{

		// old options have a incorrect setting prefix
		/*
		bb_pst_installed	
		bb_pst_version	
		*/

		// not installed, so reset settings to new installation
		if ( ! get_option($this->pfx . 'installed'))
		{

			// check if older version exists
			if ( version_compare(get_option('bb_pst_version'), '2.0.1', '<'))
			{
				$this->migrate_options();
			}
			else
			{
				$this->reset_settings();
			}

			// set installation complete
			update_option($this->pfx . 'installed', '1');
			update_option($this->pfx . 'version', $this->version);

		}
		else
		{
			
			// update version
			if ( version_compare($this->version, get_option($this->pfx . 'version'), '>'))
			{
				update_option($this->pfx . 'version', $this->version);
			}
			
		}


	}
		
}

new Post_State_Tags();

endif;
?>