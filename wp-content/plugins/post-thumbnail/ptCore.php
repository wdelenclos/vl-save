<?php

/*
 * Plugin Name: Post Thumbnail
 * Description: Adds posts' thumbnails in dashboard posts list
 * Version: 1.0.0
 * Author: Hakob Martirosyan
 * Text Domain: post-thumbnail
 * Domain Path: /languages/
 */

if (!defined('ABSPATH')) {
    exit();
}

define('PT_DIR_PATH', dirname(__FILE__));
define('PT_DIR_NAME', basename(PT_DIR_PATH));
define('PT_BASENAME_FILE', basename(__FILE__));

include_once 'options/ptOptions.php';

class PTCore {

    public static $PAGE_SETTINGS = 'post_thumbnail';
    public static $OPTION_NAME = 'pt_options';
    private $options;

    public function __construct() {
        $this->options = new PTOptions();
        add_action('plugins_loaded', array(&$this, 'ptTextDomain'));
        add_action('admin_enqueue_scripts', array(&$this, 'adminFiles'), 10);
        add_action('admin_menu', array(&$this, 'optionsPage'), 10);

        if ($this->options->postTypes && is_array($this->options->postTypes)) {
            foreach ($this->options->postTypes as $postType) {
                if ($postType == 'page') {
                    add_filter('manage_pages_columns', array(&$this, 'ptColumns'), 9999);
                    add_action('manage_pages_custom_column', array(&$this, 'ptCustomColumn'), 9999, 2);
                } else {
                    add_filter('manage_' . $postType . '_posts_columns', array(&$this, 'ptColumns'), 9999);
                    add_action('manage_' . $postType . '_posts_custom_column', array(&$this, 'ptCustomColumn'), 9999, 2);
                }
            }
        }
    }

    public function ptTextDomain() {
        load_plugin_textdomain('post-thumbnail', false, PT_DIR_NAME . '/languages/');
    }

    public function adminFiles() {
        $args = array(
            'uploadFrameTitle' => __('Choose Image', 'post-thumbnail'),
            'uploadFrameText' => __('Choose Image', 'post-thumbnail'),
            'msgThumbnailDimensions' => __('Thumbnail width or height must be non empty and greater than 0', 'post-thumbnail'),
        );
        wp_enqueue_media();
        wp_register_style('pt-options-css', plugins_url(PT_DIR_NAME . '/assets/options.css'));
        wp_enqueue_style('pt-options-css');
        wp_register_script('pt-options-js', plugins_url(PT_DIR_NAME . '/assets/options.js'), array('jquery'));
        wp_enqueue_script('pt-options-js');
        wp_localize_script('pt-options-js', 'ptJsObj', $args);
    }

    public function optionsPage() {
        $title = __('Post Thumbnail', 'post-thumbnail');
        add_submenu_page('options-general.php', $title, $title, 'manage_options', self::$PAGE_SETTINGS, array(&$this->options, 'form'));
    }

    public function ptColumns($columns) {
        if (is_array($columns)) {
            $imgArr = array('post_thumb' => __('Thumbnail', 'post-thumbnail'));
            $columns = array_slice($columns, 0, 1, true) + $imgArr + array_slice($columns, 1, count($columns) - 1, true);
        }
        return $columns;
    }

    public function ptCustomColumn($column, $post_id) {
        switch ($column) {
            case 'post_thumb':
                $imgUrl = '';
                if (has_post_thumbnail($post_id)) {
                    $size = apply_filters('pt_size', 'thumbnail');
                    $attachs = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
                    if ($attachs && isset($attachs[0])) {
                        $imgUrl = $attachs[0];
                    }
                }

                if ($imgUrl) {
                    $src = $imgUrl;
                } else {
                    if ($this->options->thumbDefault) {
                        $src = $this->options->thumbDefault;
                    } else {
                        $src = plugins_url(PT_DIR_NAME . '/assets/thumbnail.png');
                    }
                }
                $style = $this->options->thumbWidth ? "width:{$this->options->thumbWidth}px;" : "width:auto;";
                $style .= $this->options->thumbHeight ? "height:{$this->options->thumbHeight}px;" : "height:auto;";
                echo "<img style='$style' src='$src' width='{$this->options->thumbWidth}' height='{$this->options->thumbHeight}' />";
                break;
        }
    }

}

new PTCore();
