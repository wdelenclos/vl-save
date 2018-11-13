<?php
/*
Plugin Name: Authorized Digital Sellers TXT
Description: This is a simple plugin that provides you with the option of making a Authorized Digital Sellers -file (ads.txt) that is accesable through your site.com/ads.txt.
Author: jeffreyvr
Author URI: https://profiles.wordpress.org/jeffreyvr/
Text Domain: authorized-digital-sellers-txt
Domain Path: /languages
Version: 1.1
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Authorized_Digital_Sellers_Txt' ) )  {

class Authorized_Digital_Sellers_Txt {
  private $plugin_version = '1.1';

  /**
   * Construct
   *
   * @since 1.0
   */
  public function __construct() {
    $this->init();
  }

  /**
   * Admin actions
   *
   * @since 1.0
   */
  public function admin_actions() {
    add_action( 'admin_menu', array( $this, 'register_settings_page' ) );
    add_action( 'admin_init', array( $this, 'register_settings' ) );
    add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

    if ( isset( $_GET['page'] ) && $_GET['page'] == 'authorized-digital-sellers-txt' ) {
      add_action( 'admin_head', array( $this, 'settings_page_css' ) );
    }
  }

  /**
   * Init
   *
   * @since 1.0
   */
  public function init() {
    add_action( 'init', array( $this, 'rewrite_rules' ), 10 );
    add_filter( 'query_vars', array( $this, 'query_vars' ), 10, 1 );
    add_action( 'parse_request', array( $this, 'parse_request' ), 10, 1 );

    if ( is_admin() ) {
      $this->admin_actions();
    }
  }

  /**
   * Activation
   *
   * @since 1.1
   */
  static function activation() {
    if ( ! get_option( 'authorized_digital_sellers_txt_flush_rewrite_rules_flag' ) ) {
      add_option( 'authorized_digital_sellers_txt_flush_rewrite_rules_flag', true );
    }
  }

  /**
   * Flush rewrite rules
   *
   * @since 1.1
   */
  public function flush_rewrite_rules() {
    if ( get_option( 'authorized_digital_sellers_txt_flush_rewrite_rules_flag' ) ) {
        flush_rewrite_rules();
        delete_option( 'authorized_digital_sellers_txt_flush_rewrite_rules_flag' );
    }
  }

  /**
   * Uninstall
   *
   * @since 1.1
   */
  static function uninstall() {
    delete_option( 'authorized_digital_sellers_txt_flush_rewrite_rules_flag' );
    delete_option( 'authorized_digital_sellers_txt' );

    flush_rewrite_rules();
  }

  /**
   * Rewrite rules
   *
   * @since 1.1
   */
  public function rewrite_rules() {
    add_rewrite_rule( '^ads\.txt$', 'index.php?authorized_digital_sellers_txt_adstxt=true', 'top' );
  }

  /**
   * Query vars
   *
   * @since 1.1
   */
  public function query_vars( $public_query_vars ) {
    $public_query_vars[] = 'authorized_digital_sellers_txt_adstxt';
    return $public_query_vars;
  }

  /**
   * Parse request
   *
   * @since 1.1
   */
  public function parse_request( $wp ) {
    if ( isset( $wp->query_vars['authorized_digital_sellers_txt_adstxt'] ) && 'true' === $wp->query_vars['authorized_digital_sellers_txt_adstxt'] ) {

      if ( $content = get_option( 'authorized_digital_sellers_txt' ) ) {
        header( 'Content-Type: text/plain' );

        echo $content;

        exit;
      }

    }
  }

  /**
   * Load textdomain
   *
   * @since 1.0
   */
  public function load_textdomain() {
    load_plugin_textdomain( 'authorized-digital-sellers-txt', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
  }

  /**
   * Register settings page
   *
   * @since 1.0
   */
  public function register_settings_page() {
    add_options_page(
      __( 'ADS.txt options', 'authorized-digital-sellers-txt' ),
      __( 'ADS.txt', 'authorized-digital-sellers-txt' ),
      'manage_options',
      'authorized-digital-sellers-txt',
      array( $this, 'settings_page_callback' )
    );
  }

  /**
   * Register settings
   *
   * @since 1.1
   */
  public function register_settings() {
    register_setting( 'authorized-digital-sellers-txt-settings', 'authorized_digital_sellers_txt', array( $this, 'adstxt_callback' ) );
  }

  /**
   * Adstxt callback
   *
   * @since 1.1
   */
  public function adstxt_callback( $value ) {
    if ( file_exists( get_home_path() . 'ads.txt' ) ) {

      $rename_name = get_home_path() . 'ads-' . date( 'YmdHis' ) . '.txt';

      if ( rename( get_home_path() . 'ads.txt', $rename_name ) ) {
        set_transient( 'authorized-digital-sellers-txt-notice-init-file-renamed', $rename_name, 5 );

      } else {
        set_transient( 'authorized-digital-sellers-txt-notice-delete-existing-file', true, 5 );

      }

    }

    $this->flush_rewrite_rules(); // is executed only when flagged

    return filter_var( $value, FILTER_SANITIZE_STRING );
  }

  /**
   * Settings page css.
   *
   * @since 1.0
   */
  public function settings_page_css() {
    $css = '<style>
      .authorized-digital-sellers-txt-block {
        max-width: 800px;
        padding: 5px 15px 15px 15px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        background-color: #fff;
      }
      .authorized-digital-sellers-txt-block textarea {
        font-family: consolas, courier;
      }
      .authorized-digital-sellers-txt-block .submit {
        margin-bottom: 0;
        padding-bottom: 0;
      }
      .authorized-digital-sellers-txt-block code {
        display: block;
        padding: 15px;
      }
    </style>';

    echo $css;
  }

  /**
   * Settings page html
   *
   * @since 1.0
   */
  public function settings_page_callback() {
    $txt_content = get_option( 'authorized_digital_sellers_txt' );

    include 'partials/admin-settings-page.php';
  }
}

new Authorized_Digital_Sellers_Txt();

register_activation_hook( __FILE__, array( 'Authorized_Digital_Sellers_Txt', 'activation' ) );
register_uninstall_hook( __FILE__, array( 'Authorized_Digital_Sellers_Txt', 'uninstall' ) );
}
