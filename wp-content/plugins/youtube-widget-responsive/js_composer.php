<?php

class youtube_widget_responsive_js_composer extends WPBakeryShortCode {

    // Element Init
    function __construct() {
        add_action('init', array($this, 'vc_mapping'));
    }

    // Element Mapping
    public function vc_mapping() {

        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }
        vc_map(array(
            "name" => __("Youtube Widget Responsive"),
            "base" => "youtube",
            "category" => __('Content'),
            "icon" => plugin_dir_url(__FILE__) . 'YouTube-icon.png',
            "params" => array(
                // VIDEO
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title"),
                    "param_name" => 'title',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __('Video', 'youtube-widget-responsive'),
                    "param_name" => 'video',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => '<i class="fa fa-youtube-play"></i> ' . __('Start video automatically', 'youtube-widget-responsive'),
                    "param_name" => 'autoplay',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => '<i class="fa fa-volume-off"></i> ' . __('Mute video', 'youtube-widget-responsive'),
                    "param_name" => 'mute',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => '<i class="fa fa-arrows-alt"></i> ' . __('Allow fullscreen', 'youtube-widget-responsive'),
                    "param_name" => 'allowfullscreen',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => '<i class="fa fa-refresh"></i> ' . __('Loop', 'youtube-widget-responsive'),
                    "param_name" => 'loop',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => '<i class="fa fa-list-ul"></i> ' . __('Show suggested videos when the video finishes', 'youtube-widget-responsive'),
                    "param_name" => 'suggested',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => '<i class="fa fa-eye-slash"></i> ' . __('Hide video annotations', 'youtube-widget-responsive'),
                    "param_name" => 'iv_load_policy',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => '<i class="fa fa-image"></i> ' . __('Image preview', 'youtube-widget-responsive'),
                    "param_name" => 'image_preview',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube'></i> " . __('Video:', 'youtube-widget-responsive')
                ),
                // THEME
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Auto hide Video progress bar', 'youtube-widget-responsive'),
                    "param_name" => 'autohide',
                    "value" => array(
                        '2' => __('Default', 'youtube-widget-responsive'),
                        '1' => __('Hide video progress bar after video starts playing', 'youtube-widget-responsive'),
                        '0' => __('Show always', 'youtube-widget-responsive'),
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Theme of control bar', 'youtube-widget-responsive'),
                    "param_name" => 'autohide',
                    "value" => array(
                        'dark' => __('Dark', 'youtube-widget-responsive'),
                        'light' => __('Light', 'youtube-widget-responsive'),
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Select color of progress bar', 'youtube-widget-responsive'),
                    "param_name" => 'color',
                    "value" => array(
                        'red' => __('Red', 'youtube-widget-responsive'),
                        'white' => __('White', 'youtube-widget-responsive'),
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Show controls bar', 'youtube-widget-responsive'),
                    "param_name" => 'controls',
                    "value" => array(
                        '1' => __('Always', 'youtube-widget-responsive'),
                        '2' => __('On video playback', 'youtube-widget-responsive'),
                        '0' => __('Never', 'youtube-widget-responsive'),
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Resolution', 'youtube-widget-responsive'),
                    "param_name" => 'quality',
                    "value" => array(
                        'default' => __('Default', 'youtube-widget-responsive'),
                        'small' => '240px',
                        'medium' => '360px',
                        'large' => '480px',
                        'hd720' => '720px',
                        'hd1080' => '1080px',
                        'highres' => '&gt; 1080px',
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('Disable the player Keyboard controls', 'youtube-widget-responsive'),
                    "param_name" => 'disablekb',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('Hide YouTube logo on controls bar', 'youtube-widget-responsive'),
                    "param_name" => 'modestbranding',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('Hide the video title and uploader before the video starts playing', 'youtube-widget-responsive'),
                    "param_name" => 'showinfo',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => "cass",
                    "param_name" => 'class',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => "style",
                    "param_name" => 'style',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => "max-width",
                    "param_name" => 'maxw',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-desktop'></i> " . __("Theme:", 'youtube-widget-responsive')
                ),
                // TIME
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('min', 'youtube-widget-responsive'),
                    "param_name" => 'start_m',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-clock-o'></i> " . __("Time:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('sec', 'youtube-widget-responsive'),
                    "param_name" => 'start_s',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-clock-o'></i> " . __("Time:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('min', 'youtube-widget-responsive'),
                    "param_name" => 'end_m',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-clock-o'></i> " . __("Time:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('sec', 'youtube-widget-responsive'),
                    "param_name" => 'end_s',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-clock-o'></i> " . __("Time:", 'youtube-widget-responsive')
                ),
                // SCHEMA.ORG
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('Name', 'youtube-widget-responsive'),
                    "param_name" => 'schemaorg_name',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-cogs'></i> " . __("Schema.org:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => __('Thumbnail', 'youtube-widget-responsive'),
                    "param_name" => 'schemaorg_thumbnail',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-cogs'></i> " . __("Schema.org:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('Upload date', 'youtube-widget-responsive'),
                    "param_name" => 'schemaorg_uploaddate',
                    "value" => '',
                    "description" => date('Y-m-d'),
                    "group" => "<i class='fa fa-cogs'></i> " . __("Schema.org:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => __('Description', 'youtube-widget-responsive'),
                    "param_name" => 'schemaorg_description',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-cogs'></i> " . __("Schema.org:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('Description visible?', 'youtube-widget-responsive'),
                    "param_name" => 'schemaorg_description_visible',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-cogs'></i> " . __("Schema.org:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('Duration min', 'youtube-widget-responsive'),
                    "param_name" => 'schemaorg_durationm',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-cogs'></i> " . __("Schema.org:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('Duration sec', 'youtube-widget-responsive'),
                    "param_name" => 'schemaorg_durations',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-cogs'></i> " . __("Schema.org:", 'youtube-widget-responsive')
                ),
                // SUBTITLES
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('Enable substitles automatically', 'youtube-widget-responsive'),
                    "param_name" => 'cc_load',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-commenting'></i> " . __("Subtitles:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('language [en]', 'youtube-widget-responsive'),
                    "param_name" => 'cc_lang',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-commenting'></i> " . __("Subtitles:", 'youtube-widget-responsive')
                ),
                // SETTINGS
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('Enable privacy-enhanced mode [<a target="_blank" href="http://www.google.com/support/youtube/bin/answer.py?answer=171780&expand=PrivacyEnhancedMode#privacy">?</a>]', 'youtube-widget-responsive'),
                    "param_name" => 'privacy',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-gear'></i> " . __("Settings:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('wmode transparent', 'youtube-widget-responsive'),
                    "param_name" => 'wmode',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-gear'></i> " . __("Settings:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __('Track video (Google Analytics/Universal Analytics)', 'youtube-widget-responsive'),
                    "param_name" => 'track',
                    "value" => '1',
                    "description" => '',
                    "group" => "<i class='fa fa-gear'></i> " . __("Settings:", 'youtube-widget-responsive')
                ),
                // BUTTON
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __('Channel Name or ID', 'youtube-widget-responsive') . '<a href="https://www.youtube.com/account_advanced" target="_blank" title="Get ID"><i class="fa fa-question-circle"></i></a>:</label>',
                    "param_name" => 'button_channel',
                    "value" => '',
                    "description" => '',
                    "group" => "<i class='fa fa-youtube-square'></i> " . __("Button subscribe:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Layout', 'youtube-widget-responsive'),
                    "param_name" => 'button_layout',
                    "value" => array(
                        'default' => __('Default', 'youtube-widget-responsive'),
                        'full' => __('Full', 'youtube-widget-responsive'),
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-youtube-square'></i> " . __("Button subscribe:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Theme', 'youtube-widget-responsive'),
                    "param_name" => 'button_theme',
                    "value" => array(
                        'default' => __('Default', 'youtube-widget-responsive'),
                        'dark' => __('Dark', 'youtube-widget-responsive'),
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-youtube-square'></i> " . __("Button subscribe:", 'youtube-widget-responsive')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __('Subscriber count', 'youtube-widget-responsive'),
                    "param_name" => 'button_subscriber_count',
                    "value" => array(
                        'default' => __('Default (shown)', 'youtube-widget-responsive'),
                        'hidden' => __('Hidden', 'youtube-widget-responsive'),
                    ),
                    "description" => '',
                    "group" => "<i class='fa fa-youtube-square'></i> " . __("Button subscribe:", 'youtube-widget-responsive')
                ),
            )
        ));
    }

}

new youtube_widget_responsive_js_composer();
