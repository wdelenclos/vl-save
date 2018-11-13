<?php

if (!defined('ABSPATH')) {
    exit();
}

class PTOptions {

    public $postTypes = array('post');
    public $thumbWidth = 80;
    public $thumbHeight = 0;
    public $thumbDefault = '';

    public function __construct() {
        $this->addOptions();
        $this->initOptions();
    }

    public function form() {
        if (isset($_POST['pt_submit'])) {

            if (!current_user_can('manage_options')) {
                die(_e('Hacker?', 'post-thumbnail'));
            }

            check_admin_referer('pt_form');

            $postTypes = array();
            if (isset($_POST['postTypes']) && is_array($_POST['postTypes'])) {
                foreach ($_POST['postTypes'] as $postType) {
                    if (($pT = sanitize_text_field($postType)) && post_type_exists($pT)) {
                        $postTypes[] = $pT;
                    }
                }
            }

            $this->postTypes = $postTypes ? $postTypes : array();
            $this->thumbWidth = isset($_POST['thumbWidth']) ? absint($_POST['thumbWidth']) : 80;
            $this->thumbHeight = isset($_POST['thumbHeight']) ? absint($_POST['thumbHeight']) : 0;
            $this->thumbDefault = isset($_POST['thumbDefault']) ? esc_url($_POST['thumbDefault']) : '';
            update_option(PTCore::$OPTION_NAME, $this->toArray());
        }
        include_once 'form.php';
    }

    public function addOptions() {
        $options = array(
            'postTypes' => array('post'),
            'thumbWidth' => 80,
            'thumbHeight' => 0,
            'thumbDefault' => plugins_url(PT_DIR_NAME . '/assets/thumbnail.png'),
        );
        add_option(PTCore::$OPTION_NAME, $options);
    }

    public function initOptions() {
        $options = get_option(PTCore::$OPTION_NAME);
        if ($options && is_array($options)) {
            $this->postTypes = isset($options['postTypes']) && is_array($options['postTypes']) ? $options['postTypes'] : array('post');
            $this->thumbWidth = isset($options['thumbWidth']) ? absint($options['thumbWidth']) : 80;
            $this->thumbHeight = isset($options['thumbHeight']) ? absint($options['thumbHeight']) : 0;
            $this->thumbDefault = isset($options['thumbDefault']) ? esc_url($options['thumbDefault']) : plugins_url(PT_DIR_NAME . '/assets/thumbnail.png');
        } else {
            $this->postTypes = array('post');
            $this->thumbWidth = 80;
            $this->thumbHeight = 0;
            $this->thumbDefault = plugins_url(PT_DIR_NAME . '/assets/thumbnail.png');
        }
    }

    public function toArray() {
        $options = array(
            'postTypes' => $this->postTypes,
            'thumbWidth' => $this->thumbWidth,
            'thumbHeight' => $this->thumbHeight,
            'thumbDefault' => $this->thumbDefault,
        );
        return $options;
    }

}
