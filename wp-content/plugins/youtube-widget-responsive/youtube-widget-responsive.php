<?php
/*
  Plugin Name: YouTube widget responsive
  Description: Widgets responsive and shorcode to embed youtube in your sidebar or in your content, with all available options.
  Author: StefanoAI
  Version: 1.4.1
  Author URI: http://www.stefanoai.com
  Text Domain: youtube-widget-responsive
  Domain Path: /lang
 */

//todo http://blog.cmstutorials.org/tutorials/how-to-add-buttons-to-the-wordpress-editor

class YouTubeResponsive extends \WP_Widget {

    static $footer = "";

    public function __construct() {
        parent::__construct(
                'youtube_responsive', // Base ID
                'Youtube widget responsive', // Name
                array('description' => __('YouTube Responsive enable you to place a widget with youtube video.
Among the various options there is also the possibility to start the video automatically', 'youtube-widget-responsive')) // Args
        );
        add_action('vc_before_init', array($this, 'visual_composer'));
    }

    static function wp_head() {
        wp_enqueue_script('jquery');
        add_shortcode('youtube', array('YouTubeResponsive', 'shortcode'));
    }

    static function wp_footer() {
        ?>
        <script type="text/javascript">
            function AI_responsive_widget() {
                jQuery('object.StefanoAI-youtube-responsive').each(function () {
                    jQuery(this).parent('.fluid-width-video-wrapper').removeClass('fluid-width-video-wrapper').removeAttr('style').css('width', '100%').css('display', 'block');
                    jQuery(this).children('.fluid-width-video-wrapper').removeClass('fluid-width-video-wrapper').removeAttr('style').css('width', '100%').css('display', 'block');
                    var width = jQuery(this).parent().innerWidth();
                    var maxwidth = jQuery(this).css('max-width').replace(/px/, '');
                    var pl = parseInt(jQuery(this).parent().css('padding-left').replace(/px/, ''));
                    var pr = parseInt(jQuery(this).parent().css('padding-right').replace(/px/, ''));
                    width = width - pl - pr;
                    if (maxwidth < width) {
                        width = maxwidth;
                    }
                    jQuery(this).css('width', width + "px");
                    jQuery(this).css('height', width / (16 / 9) + "px");
                    jQuery(this).find('iframe').css('width', width + "px");
                    jQuery(this).find('iframe').css('height', width / (16 / 9) + "px");
                });
            }
            if (typeof jQuery !== 'undefined') {
                jQuery(document).ready(function () {
                    var tag = document.createElement('script');
                    tag.src = "https://www.youtube.com/iframe_api";
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                    AI_responsive_widget();
                });
                jQuery(window).resize(function () {
                    AI_responsive_widget();
                });
            }
        <?php if (!empty(YouTubeResponsive::$footer)) { ?>

                function onYouTubeIframeAPIReady() {
            <?php echo YouTubeResponsive::$footer; ?>
                }
                function StefanoAI_trackYoutubeVideo(state, video) {
                    if (typeof _config !== 'undefined') {
                        var forceSyntax = _config.forceSyntax || 0;
                    } else {
                        var forceSyntax = 0;
                    }
                    if (typeof window.dataLayer !== 'undefined' && !forceSyntax) {
                        window.dataLayer.push({
                            'event': 'youTubeTrack',
                            'attributes': {
                                'videoUrl': video,
                                'videoAction': state
                            }
                        });
                    }
                    if (typeof window.ga === 'function' && typeof window.ga.getAll === 'function' && forceSyntax !== 2) {
                        window.ga('send', 'event', 'YoutubeWidgetResponsive', state, video, 0);
                    } else if (typeof window._gaq !== 'undefined' && forceSyntax !== 1) {
                        window._gaq.push(['_trackEvent', 'YoutubeWidgetResponsive', state, video]);
                    }
                }
        <?php } ?>
        </script>
        <?php
    }

    static function makeEmbedUrl($params) {
        if (!empty($params['track'])) {
            wp_enqueue_script("youtube-iframe-api", "https://www.youtube.com/iframe_api", false, false, true);
        }
        if (!empty($params['button_channel'])) {
            wp_enqueue_script("apis-google-platform", "https://apis.google.com/js/platform.js", false, false, true);
        }
        global $youtube_id;
        //https://www.youtu.be/_9tBFVKhn5o
        //https://www.youtube.com/watch?v=_9tBFVKhn5o
        //https://www.youtube.com/embed/_9tBFVKhn5o
        //https://www.youtube-nocookie.com/embed/_9tBFVKhn5o
        $idvideo = $idlist = $listType = NULL;
        preg_match('/youtu.be\/([^\/\?]+)/', $params['video'], $m);
        $idvideo = !empty($m[1]) ? $m[1] : null;
        if (empty($idvideo)) {
            preg_match('/(&|&amp;|\?|&#038;)v=([^&]+)/', $params['video'], $m);
            $idvideo = !empty($m[2]) ? $m[2] : null;
        }
        if (empty($idvideo)) {
            preg_match('/\/embed\/([^\/|\?]+)/', $params['video'], $m);
            $idvideo = !empty($m[1]) ? $m[1] : null;
        }


        if (preg_match('/(^|&|&amp;|\?|&#038;)list=([^&]+)/', $params['video'], $l)) {
            $idlist = !empty($l[2]) ? $l[2] : '';
            if (empty($idvideo)) {
                $idvideo = '';
            }
            if (preg_match('/(^|&|&amp;|\?|&#038;)listType=([^&]+)/', $params['video'], $lt)) {
                $listType = !empty($lt[2]) ? $lt[2] : '';
            }
        } else if (empty($idvideo)) {
            $idvideo = !empty($m[2]) ? $m[2] : $params['video'];
        }

        if (empty($idlist) && !empty($params['list'])) {
            $idlist = $params['list'];
        }

        if (empty($listType) && !empty($params['listType'])) {
            $listType = $params['listType'];
        }

        if (!empty($idvideo) || !empty($idlist)) {
            //$w3c = !empty($params['w3c']) ? 1 : 0;
            $w3c = 1;
            $and = $w3c ? '&amp;' : '&';
            $idlist = !empty($idlist) ? $and . "list=$idlist" : '';
            $listType = !empty($listType) ? $and . "listType=$listType" : '';
            $autohide = isset($params['autohide']) ? $and . "autohide=" . $params['autohide'] : '';
            $autoplay = !empty($params['autoplay']) ? $and . 'autoplay=1' : '';
            $cc_load = !empty($params['cc_load']) ? $and . 'cc_load_policy=1' : '';
            $cc_lang = !empty($params['cc_lang']) ? $and . 'hl=' . $params['cc_lang'] : '';
            $color = isset($params['color']) ? $and . 'color=' . $params['color'] : '';
            $controls = isset($params['controls']) ? $and . 'controls=' . $params['controls'] : '';
            $disablekb = isset($params['disablekb']) ? $and . 'disablekb=' . $params['disablekb'] : '';
            $endtime = (!empty($params['end_m']) ? intval($params['end_m']) * 60 : 0) + (!empty($params['end_s']) ? intval($params['end_s']) : 0);
            $end = !empty($endtime) ? $and . "end=$endtime" : '';
            $allowfullscreen = !empty($params['allowfullscreen']) ? 'allowfullscreen' : '';
            $fs = !empty($params['allowfullscreen']) ? $and . 'fs=1' : $and . 'fs=0';
            $iv_load_policy = isset($params['iv_load_policy']) ? $and . 'iv_load_policy=' . $params['iv_load_policy'] : '';
            $loop = !empty($params['loop']) ? $and . 'loop=' . $params['loop'] : '';
            if (!empty($loop) && empty($idlist) && !empty($idvideo)) {
                $idlist = $and . "playlist=$idvideo";
            }
            $modestbranding = isset($params['modestbranding']) ? $and . 'modestbranding=' . $params['modestbranding'] : '';
            $rel = !empty($params['suggested']) && $params['suggested'] == '1' ? '' : $and . 'rel=0';
            $showinfo = !empty($params['showinfo']) && $params['showinfo'] == '1' ? '' : $and . 'showinfo=0';
            $starttime = (!empty($params['start_m']) ? intval($params['start_m']) * 60 : 0) + (!empty($params['start_s']) ? intval($params['start_s']) : 0);
            $start = (!empty($starttime)) ? $and . "start=$starttime" : "";
            $theme = isset($params['theme']) ? $and . 'theme=' . $params['theme'] : '';
            $quality = isset($params['quality']) ? $and . 'vq=' . $params['quality'] : '';
            $wmode = !empty($params['wmode']) ? $and . 'wmode=transparent' : '';
            $url = !empty($params['privacy']) && $params['privacy'] == '1' ? '//www.youtube-nocookie.com/embed/' : '//www.youtube.com/embed/';

            $class = isset($params['class']) ? esc_attr($params['class']) : '';
            $style = isset($params['style']) ? esc_attr($params['style']) : '';
            $maxw = !empty($params['maxw']) ? 'max-width:' . intval($params['maxw']) . 'px;' : '';
            @$id = ++$youtube_id;

            $jsapi = !empty($params['track']) || !empty($params['mute']) || !empty($params['image_preview']) ? $and . "enablejsapi=1" : "";

            $image_preview = !empty($params['image_preview']) ? $params['image_preview'] : NULL;

            $schemaorg_name = !empty($params['schemaorg_name']) ? $params['schemaorg_name'] : NULL;
            $schemaorg_description_visible = !empty($params['schemaorg_description_visible']) ? TRUE : FALSE;
            $schemaorg_description = !empty($params['schemaorg_description']) ? $params['schemaorg_description'] : NULL;
            $schemaorg_uploaddate = !empty($params['schemaorg_uploaddate']) ? $params['schemaorg_uploaddate'] : NULL;
            $schemaorg_thumbnail = !empty($params['schemaorg_thumbnail']) ? $params['schemaorg_thumbnail'] : NULL;
            $schemaorg_durationm = !empty($params['schemaorg_durationm']) ? $params['schemaorg_durationm'] : 0;
            $schemaorg_durations = !empty($params['schemaorg_durations']) ? $params['schemaorg_durations'] : 0;


            $schema = !empty($schemaorg_name) && !empty($schemaorg_uploaddate) && !empty($schemaorg_description) && !empty($schemaorg_thumbnail) ? ' itemscope itemtype="http://schema.org/VideoObject"' : '';
            @$urlembed = "<object $schema class='StefanoAI-youtube-responsive fitvidsignore $class' width='160' height='90' style='$maxw$style' type='application/video'>";
            @$urlembed .= "<iframe id='StefanoAI-youtube-$id' class='StefanoAI-youtube-responsive $class' width='160' height='90' src='$url$idvideo?$idlist$listType$autohide$autoplay$cc_load$cc_lang$color$controls$disablekb$end$fs$iv_load_policy$loop$modestbranding$rel$showinfo$start$theme$quality$wmode$jsapi' $allowfullscreen style='border:none;AISTYLENONE$maxw$style'></iframe>";

            if (!empty($params['track']) || !empty($params['mute']) || !empty($image_preview)) {
                $onStateChange = $onReady = '';
                if (!empty($params['mute'])) {
                    $onReady = "'onReady': function (event) {
                                        event.target.mute();
                                    },";
                }
                if (!empty($params['track'])) {
                    $onStateChange = <<<SCRIPT

                    'onStateChange': function () {
                        var d = player_$id.getVideoData();
                        switch (player_$id.getPlayerState()) {
                            case -1:
                                //unstarted
                                break;
                            case 0:
                                //ended
                                //StefanoAI_trackYoutubeVideo('Ended', d.title + " | " + d.video_id + " (" + d.author + ")");
                                break;
                            case 1:
                                //playing
                                StefanoAI_trackYoutubeVideo('Playing', d.title + " | " + d.video_id + " (" + d.author + ")");
                                break;
                            case 2:
                                //paused
                                //StefanoAI_trackYoutubeVideo('Paused', d.title + " | " + d.video_id + " (" + d.author + ")");
                                break;
                            case 3:
                                //buffering
                                break;
                            case 5:
                                //video cued (When a video is queued and ready for playback)
                                break;
                        }
                    },
SCRIPT;
                }
                YouTubeResponsive::$footer .= <<<SCRIPT
                        
                var player_$id;
                player_$id = new YT.Player('StefanoAI-youtube-$id', {
                    events: {
                        $onReady
                        $onStateChange
                    }
                });
SCRIPT;
            }
            if (!empty($image_preview)) {
                if (preg_match('/^[0-9]+$/', $image_preview)) {
                    $img = wp_get_attachment_image_src($image_preview, array(320, 180));
                    $src = $img[0];
                    $alt = get_post_meta($image_preview, '_wp_attachment_image_alt', true);
                } else {
                    $src = $image_preview;
                    $alt = !empty($params['altimg']) ? $params['altimg'] : '';
                }
                YouTubeResponsive::$footer .= "
                    
                jQuery('#StefanoAI-youtube-$id').fadeOut(0);
                jQuery('#StefanoAI-Youtube-image_preview-$id').click(function(){
                    jQuery(this).fadeOut(0);
                    jQuery('#StefanoAI-youtube-$id').fadeIn('fast');
                    player_$id.playVideo();
                    AI_responsive_widget();
                });
";
                $urlembed .= "\n<img src='$src' alt='" . esc_attr($alt) . "' id='StefanoAI-Youtube-image_preview-$id' style='width: 100%;' />";
                $urlembed = preg_replace('/AISTYLENONE/', 'display:none;', $urlembed);
            } else {
                $urlembed = preg_replace('/AISTYLENONE/', '', $urlembed);
            }
            if (!empty($schema)) {
                if (!empty($schemaorg_thumbnail)) {
                    if (preg_match('/^[0-9]+$/', $schemaorg_thumbnail)) {
                        $img = wp_get_attachment_image_src($schemaorg_thumbnail, array(320, 180));
                        $src1 = $img[0];
                    } else {
                        $src1 = $schemaorg_thumbnail;
                    }
                }
                @$urlembed .= "<meta itemprop='name' content=\"" . esc_attr($schemaorg_name) . "\" />";
                if ($schemaorg_description_visible) {
                    @$urlembed .= "<p itemprop='description' >" . nl2br(strip_tags($schemaorg_description, '')) . "</p>";
                } else {
                    @$urlembed .= "<meta itemprop='description' content=\"" . esc_attr($schemaorg_description) . "\" />";
                }
                @$urlembed .= "<meta itemprop='uploadDate' content=\"" . esc_attr($schemaorg_uploaddate) . "\" />";
                @$urlembed .= "<meta itemprop='thumbnailUrl' content=\"" . esc_attr($src1) . "\" />";
                @$urlembed .= "<meta itemprop='embedUrl' content=\"http://youtube.be/" . esc_attr($idvideo) . "\" />";
                if (!empty($schemaorg_durationm) || !empty($schemaorg_durations)) {
                    @$urlembed .= "<meta itemprop='duration' content='PT" . intval($schemaorg_durationm) . "M" . intval($schemaorg_durations) . "S' />";
                }
            }
            @$urlembed .= "</object>";
            if (!empty($params['button_channel'])) {
                $data_channel = preg_match('/^UC/', $params['button_channel']) && strlen($params['button_channel']) == 24 ? "data-channelid" : "data-channel";
                $urlembed .= "<div class='g-ytsubscribe' $data_channel='" . esc_attr($params['button_channel']) . "' data-layout='" . esc_attr($params['button_layout']) . "' data-count='" . esc_attr($params['button_subscriber_count']) . "' data-theme='" . esc_attr($params['button_theme']) . "' ></div>";
            }
            return apply_filters('youtube_iframe', $urlembed);
        } else if (!empty($params['button_channel'])) {
            return "<div class='g-ytsubscribe' data-channel='" . esc_attr($params['button_channel']) . "' data-layout='" . esc_attr($params['button_layout']) . "' data-count='" . esc_attr($params['button_subscriber_count']) . "' data-theme='" . esc_attr($params['button_theme']) . "' ></div>";
        }
        return '';
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        preg_match('/\?v=([^&]+)/', $instance['video'], $m);
        $urlembed = YouTubeResponsive::makeEmbedUrl($instance);
        if (!empty($urlembed)) {
            echo $before_widget;
            echo $before_title . $title . $after_title;
            echo $urlembed;
            echo $after_widget;
        }
    }

    function update($new_instance, $old_instance) {
//save widget settings
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['video'] = strip_tags($new_instance['video']);
        $instance['autohide'] = isset($new_instance['autohide']) && ($new_instance['autohide'] == 1 || $new_instance['autohide'] == 0) ? $new_instance['autohide'] : 2;
        $instance['autoplay'] = !empty($new_instance['autoplay']) ? 1 : 0;
        $instance['mute'] = !empty($new_instance['mute']) ? 1 : 0;
        $instance['cc_load'] = !empty($new_instance['cc_load']) ? 1 : 0;
        $instance['cc_lang'] = strip_tags($new_instance['cc_lang']);
        $instance['color'] = !empty($new_instance['color']) && $new_instance['color'] == "white" ? 'white' : 'red';
        $instance['controls'] = isset($new_instance['controls']) && ( $new_instance['controls'] == 0 || $new_instance['controls'] == 2) ? $new_instance['controls'] : 1;
        $instance['disablekb'] = isset($new_instance['disablekb']) && $new_instance['disablekb'] == 1 ? 1 : 0;
        $instance['end_m'] = strip_tags($new_instance['end_m']);
        $instance['end_s'] = strip_tags($new_instance['end_s']);
        $instance['allowfullscreen'] = !empty($new_instance['allowfullscreen']) ? $new_instance['allowfullscreen'] : 0;
        $instance['iv_load_policy'] = !empty($new_instance['iv_load_policy']) && $new_instance['iv_load_policy'] == 3 ? 3 : 1;
        $instance['loop'] = !empty($new_instance['loop']) ? 1 : 0;
        $instance['modestbranding'] = !empty($new_instance['modestbranding']) ? 1 : 0;
        $instance['suggested'] = !empty($new_instance['suggested']) ? $new_instance['suggested'] : 0;
        $instance['showinfo'] = isset($new_instance['showinfo']) && $new_instance['showinfo'] == 0 ? 0 : 1;
        $instance['start_m'] = strip_tags($new_instance['start_m']);
        $instance['start_s'] = strip_tags($new_instance['start_s']);
        $instance['theme'] = !empty($new_instance['theme']) && $new_instance['theme'] == 'light' ? 'light' : 'dark';
        $instance['quality'] = !empty($new_instance['quality']) ? $new_instance['quality'] : 'default';
        $instance['class'] = !empty($new_instance['class']) ? $new_instance['class'] : '';
        $instance['style'] = !empty($new_instance['style']) ? $new_instance['style'] : '';
        $instance['maxw'] = !empty($new_instance['maxw']) ? $new_instance['maxw'] : '';
        $instance['w3c'] = isset($new_instance['w3c']) && $new_instance['w3c'] == 0 ? 0 : 1;
        $instance['privacy'] = !empty($new_instance['privacy']) ? $new_instance['privacy'] : 0;
        $instance['wmode'] = !empty($new_instance['wmode']) ? $new_instance['wmode'] : 0;
        $instance['track'] = !empty($new_instance['track']) ? $new_instance['track'] : 0;
        $instance['image_preview'] = !empty($new_instance['image_preview']) ? $new_instance['image_preview'] : '';
        $instance['schemaorg_name'] = !empty($new_instance['schemaorg_name']) ? $new_instance['schemaorg_name'] : '';
        $instance['schemaorg_description'] = !empty($new_instance['schemaorg_description']) ? $new_instance['schemaorg_description'] : '';
        $instance['schemaorg_description_visible'] = !empty($new_instance['schemaorg_description_visible']) ? 1 : 0;
        $instance['schemaorg_durationm'] = !empty($new_instance['schemaorg_durationm']) ? $new_instance['schemaorg_durationm'] : '';
        $instance['schemaorg_durations'] = !empty($new_instance['schemaorg_durations']) ? $new_instance['schemaorg_durations'] : '';
        $instance['schemaorg_uploaddate'] = !empty($new_instance['schemaorg_uploaddate']) && preg_match('/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/', $new_instance['schemaorg_uploaddate']) ? date('Y-m-d', strtotime($new_instance['schemaorg_uploaddate'])) : '';
        $instance['schemaorg_thumbnail'] = !empty($new_instance['schemaorg_thumbnail']) ? $new_instance['schemaorg_thumbnail'] : '';
        $instance['button_channel'] = !empty($new_instance['button_channel']) ? $new_instance['button_channel'] : '';
        $instance['button_layout'] = !empty($new_instance['button_layout']) ? $new_instance['button_layout'] : 'default';
        $instance['button_theme'] = !empty($new_instance['button_theme']) ? $new_instance['button_theme'] : 'default';
        $instance['button_subscriber_count'] = !empty($new_instance['button_subscriber_count']) ? $new_instance['button_subscriber_count'] : 'default';
        return $instance;
    }

    function form($instance) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_style('jquery-ui-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/black-tie/jquery-ui.css', NULL, NULL);
        wp_enqueue_style('font-awesome-css', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', NULL, NULL);
        wp_enqueue_media();
        $title = (isset($instance['title'])) ? $instance['title'] : '';
        $video = (isset($instance['video'])) ? $instance['video'] : '';
        $autohide = (isset($instance['autohide'])) ? $instance['autohide'] : 2;
        $autoplay = (isset($instance['autoplay'])) ? $instance['autoplay'] : 0;
        $mute = (isset($instance['mute'])) ? $instance['mute'] : 0;
        $cc_load = (isset($instance['cc_load'])) ? $instance['cc_load'] : 0;
        $cc_lang = (isset($instance['cc_lang'])) ? $instance['cc_lang'] : '';
        $color = !empty($instance['color']) && $instance['color'] == "white" ? 'white' : 'red';
        $controls = isset($instance['controls']) && ( $instance['controls'] == 0 || $instance['controls'] == 2) ? $instance['controls'] : 1;
        $disablekb = isset($instance['disablekb']) && $instance['disablekb'] == 1 ? 1 : 0;
        $end_m = (isset($instance['end_m'])) ? $instance['end_m'] : '';
        $end_s = (isset($instance['end_s'])) ? $instance['end_s'] : '';
        $allowfullscreen = !empty($instance['allowfullscreen']) ? $instance['allowfullscreen'] : 0;
        $iv_load_policy = !empty($instance['iv_load_policy']) && $instance['iv_load_policy'] == 3 ? 3 : 1;
        $loop = !empty($instance['loop']) ? 1 : 0;
        $modestbranding = !empty($instance['modestbranding']) ? 1 : 0;
        $suggested = !empty($instance['suggested']) ? $instance['suggested'] : 0;
        $showinfo = !empty($instance['showinfo']) ? 1 : 0;
        $start_m = (isset($instance['start_m'])) ? $instance['start_m'] : 0;
        $start_s = (isset($instance['start_s'])) ? $instance['start_s'] : 0;
        $theme = !empty($instance['theme']) && $instance['theme'] == 'light' ? 'light' : 'dark';
        $quality = !empty($instance['quality']) ? $instance['quality'] : 'default';
        $class = !empty($instance['class']) ? $instance['class'] : '';
        $style = !empty($instance['style']) ? $instance['style'] : '';
        $maxw = !empty($instance['maxw']) ? $instance['maxw'] : '';
        //$w3c = !empty($instance['w3c']) ? 1 : 0;
        $w3c = 1;
        $privacy = !empty($instance['privacy']) ? $instance['privacy'] : 0;
        $wmode = !empty($instance['wmode']) ? $instance['wmode'] : 0;
        $track = !empty($instance['track']) ? $instance['track'] : 0;
        $image_preview = !empty($instance['image_preview']) ? $instance['image_preview'] : 0;

        $button_channel = (isset($instance['button_channel'])) ? $instance['button_channel'] : '';
        $button_layout = (isset($instance['button_layout'])) ? $instance['button_layout'] : '';
        $button_theme = (isset($instance['button_theme'])) ? $instance['button_theme'] : '';
        $button_subscriber_count = (isset($instance['button_subscriber_count'])) ? $instance['button_subscriber_count'] : '';


        $schemaorg_name = !empty($instance['schemaorg_name']) ? $instance['schemaorg_name'] : '';
        $schemaorg_description = !empty($instance['schemaorg_description']) ? $instance['schemaorg_description'] : '';
        $schemaorg_description_visible = !empty($instance['schemaorg_description_visible']) ? 1 : 0;
        $schemaorg_durationm = !empty($instance['schemaorg_durationm']) ? $instance['schemaorg_durationm'] : '';
        $schemaorg_durations = !empty($instance['schemaorg_durations']) ? $instance['schemaorg_durations'] : '';
        $schemaorg_uploaddate = !empty($instance['schemaorg_uploaddate']) ? $instance['schemaorg_uploaddate'] : '';
        $schemaorg_thumbnail = !empty($instance['schemaorg_thumbnail']) ? $instance['schemaorg_thumbnail'] : 0;

        $src = '';
        if (!empty($image_preview)) {
            $img = wp_get_attachment_image_src($image_preview, array(320, 180));
            $src = $img[0];
        }
        $src1 = '';
        if (!empty($schemaorg_thumbnail)) {
            $img = wp_get_attachment_image_src($schemaorg_thumbnail, array(320, 180));
            $src1 = $img[0];
        }
        ?>
        <div id='<?php echo $this->get_field_id('video') ?>-tabs' class='StefanoAI_YoutubeVideo-tabs'>
            <ul>
                <li>
                    <a href="#<?php echo $this->get_field_id('video') ?>-tab-video">Video</a>
                </li>
                <li>
                    <a href="#<?php echo $this->get_field_id('video') ?>-tab-schemaorg">Schema.org</a>
                </li>
                <li>
                    <a href="#<?php echo $this->get_field_id('video') ?>-tab-shortcode">ShortCode</a>
                </li>
            </ul>
            <div id="<?php echo $this->get_field_id('video') ?>-tab-video">
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'youtube-widget-responsive') ?>: </label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('video'); ?>"><?php _e('Video', 'youtube-widget-responsive') ?>: </label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('video'); ?>" name="<?php echo $this->get_field_name('video'); ?>" type="text" value="<?php echo esc_attr($video); ?>" />
                </p>
                <div class="group-collapse">
                    <h5>
                        <i class="fa fa-youtube"></i> 
                        <span class="styles">
                            <?php
                            _e('Video:', 'youtube-widget-responsive');
                            ?>
                        </span>
                    </h5>
                    <div class="StefanoAI_YoutubeVideo-video"> 
                        <p>
                            <input <?php echo (!empty($image_preview)) ? 'disabled="disabled"' : ''; ?> id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="1" <?php echo!empty($autoplay) ? 'checked' : ''; ?> class='autoplay' />
                            <label for="<?php echo $this->get_field_id('autoplay'); ?>">
                                <i class="fa fa-youtube-play"></i>
                                <?php _e('Start video automatically', 'youtube-widget-responsive') ?>
                            </label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('mute'); ?>" name="<?php echo $this->get_field_name('mute'); ?>" type="checkbox" value="1" <?php echo!empty($mute) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('mute'); ?>">
                                <i class="fa fa-volume-off"></i>
                                <?php _e('Mute video', 'youtube-widget-responsive') ?>
                            </label> 
                        </p>
                        <p>
                            <input id="<?php echo $this->get_field_id('allowfullscreen'); ?>" name="<?php echo $this->get_field_name('allowfullscreen'); ?>" type="checkbox" value="1" <?php echo!empty($allowfullscreen) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('allowfullscreen'); ?>">
                                <i class="fa fa-arrows-alt"></i> 
                                <?php _e('Allow fullscreen', 'youtube-widget-responsive') ?> 
                            </label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('loop'); ?>" name="<?php echo $this->get_field_name('loop'); ?>" type="checkbox" value="1" <?php echo!empty($loop) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('loop'); ?>">
                                <i class="fa fa-refresh"></i> 
                                <?php _e('Loop', 'youtube-widget-responsive') ?> 
                            </label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('suggested'); ?>" name="<?php echo $this->get_field_name('suggested'); ?>" type="checkbox" value="1" <?php echo!empty($suggested) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('suggested'); ?>">
                                <i class="fa fa-list-ul"></i> 
                                <?php _e('Show suggested videos when the video finishes', 'youtube-widget-responsive') ?> 
                            </label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('iv_load_policy'); ?>" name="<?php echo $this->get_field_name('iv_load_policy'); ?>" type="checkbox" value="3" <?php echo esc_attr($iv_load_policy) == "3" ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('iv_load_policy'); ?>">
                                <i class="fa fa-eye-slash"></i> 
                                <?php _e('Hide video annotations', 'youtube-widget-responsive') ?> 
                            </label> 
                        </p>
                    </div>
                </div>
                <div id="<?php echo $this->get_field_id('video'); ?>-StefanoAI_YoutubeVideo_preview" class='StefanoAI_YoutubeVideo_preview group-collapse'>
                    <h5>
                        <i class="fa fa-image"></i>
                        <span class="image-preview"><?php _e("Image preview:", 'youtube-widget-responsive') ?></span>
                    </h5>
                    <div class="StefanoAI_YoutubeVideo-preview">
                        <p>
                            <span style="text-align: center;display: block;">
                                <img src="<?php echo esc_attr($src); ?>" alt="" style="width:90%;background-color: #eee;<?php echo empty($src) ? 'display:none' : ''; ?>"/>
                            </span>
                            <input type="hidden" class="image_preview" name="<?php echo $this->get_field_name('image_preview'); ?>" value="<?php echo $image_preview; ?>" />
                        </p>
                        <div style="text-align: center;display: block;width: 100%;">
                            <input type="button" class="button-primary upload" value="Upload preview" style="width: 45%;" />
                            <input type="button" class="button-secondary noimage" value="No preview" style="width: 45%;" />
                        </div>
                    </div>
                </div>
                <div class="group-collapse">
                    <h5>
                        <i class="fa fa-clock-o"></i> 
                        <span class="start_end"><?php _e("Time:", 'youtube-widget-responsive'); ?></span>
                    </h5>
                    <div class="StefanoAI_YoutubeVideo-timing">
                        <p>
                            <label for="<?php echo $this->get_field_id('start_m'); ?>">
                                <i class="fa fa-play"></i> 
                                <?php _e('Start from', 'youtube-widget-responsive') ?>: 
                            </label> <br/>
                            <input class="widefat" style="width:70px;display: inline-block;" id="<?php echo $this->get_field_id('start_m'); ?>" name="<?php echo $this->get_field_name('start_m'); ?>" type="number" value="<?php echo esc_attr($start_m); ?>" /> <?php _e('min', 'youtube-widget-responsive') ?>
                            <input class="widefat" style="width:50px;display: inline-block;" id="<?php echo $this->get_field_id('start_s'); ?>" name="<?php echo $this->get_field_name('start_s'); ?>" type="number" min="0" max="59" value="<?php echo esc_attr($start_s); ?>" /> <?php _e('sec', 'youtube-widget-responsive') ?>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('end_m'); ?>">
                                <i class="fa fa-stop"></i> 
                                <?php _e('End to', 'youtube-widget-responsive') ?>: 
                            </label> <br/>
                            <input class="widefat" style="width:70px;display: inline-block;" id="<?php echo $this->get_field_id('end_m'); ?>" name="<?php echo $this->get_field_name('end_m'); ?>" type="number" value="<?php echo esc_attr($end_m); ?>" /> <?php _e('min', 'youtube-widget-responsive') ?>
                            <input class="widefat" style="width:50px;display: inline-block;" id="<?php echo $this->get_field_id('end_s'); ?>" name="<?php echo $this->get_field_name('end_s'); ?>" type="number" min="0" max="59" value="<?php echo esc_attr($end_s); ?>" /> <?php _e('sec', 'youtube-widget-responsive') ?>
                        </p>
                    </div>
                </div>
                <div class="group-collapse">
                    <h5>
                        <i class="fa fa-commenting"></i> 
                        <span class="subtitles">
                            <?php
                            _e('Subtitles:', 'youtube-widget-responsive');
                            ?>
                        </span>
                    </h5>
                    <div class="StefanoAI_YoutubeVideo-subtitles">
                        <p>
                            <input id="<?php echo $this->get_field_id('cc_load'); ?>" name="<?php echo $this->get_field_name('cc_load'); ?>" type="checkbox" value="1" <?php echo!empty($cc_load) ? 'checked' : ''; ?> />
                            <label style="margin-left: 14px;max-width: 80%;" for="<?php echo $this->get_field_id('cc_load'); ?>">
                                <i class="fa fa-keyboard-o"></i> 
                                <?php _e('Enable substitles automatically', 'youtube-widget-responsive') ?> 
                            </label> <br/>
                            <input maxlength="2" style="width:30px" id="<?php echo $this->get_field_id('cc_lang'); ?>" name="<?php echo $this->get_field_name('cc_lang'); ?>" type="text" value="<?php echo esc_attr($cc_lang); ?>" />
                            <label style="max-width: 80%;" for="<?php echo $this->get_field_id('cc_lang'); ?>">
                                <i class="fa fa-language"></i> 
                                <?php _e('language [en]', 'youtube-widget-responsive') ?>
                            </label> 
                        </p>
                    </div>
                </div>
                <div class="group-collapse">
                    <h5>
                        <i class="fa fa-desktop"></i> 
                        <span class="styles">
                            <?php
                            _e('Theme:', 'youtube-widget-responsive');
                            ?>
                        </span>
                    </h5>
                    <div class="StefanoAI_YoutubeVideo-styles">
                        <p>
                            <label for="<?php echo $this->get_field_id('autohide'); ?>"><?php _e('Auto hide Video progress bar', 'youtube-widget-responsive') ?> </label> 
                            <select class='widefat' id="<?php echo $this->get_field_id('autohide'); ?>" name="<?php echo $this->get_field_name('autohide'); ?>">
                                <option value="2" <?php echo $autohide == 2 ? 'selected' : '' ?>><?php _e('Default', 'youtube-widget-responsive') ?></option>
                                <option value="1" <?php echo $autohide == 1 ? 'selected' : '' ?>><?php _e('Hide video progress bar after video starts playing', 'youtube-widget-responsive') ?></option>
                                <option value="0" <?php echo $autohide == 0 ? 'selected' : '' ?>><?php _e('Show always', 'youtube-widget-responsive') ?></option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('theme'); ?>"><?php _e('Theme of control bar', 'youtube-widget-responsive') ?> </label> 
                            <select class='widefat' id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>">
                                <option value="dark" <?php echo $theme == 'dark' ? 'selected' : '' ?>><?php _e('Dark', 'youtube-widget-responsive') ?></option>
                                <option value="light" <?php echo $theme == 'light' ? 'selected' : '' ?>><?php _e('Light', 'youtube-widget-responsive') ?></option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Select color of progress bar', 'youtube-widget-responsive') ?> </label> 
                            <select class='widefat' id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>">
                                <option value="red" <?php echo $color == 'red' ? 'selected' : '' ?>><?php _e('Red', 'youtube-widget-responsive') ?></option>
                                <option value="white" <?php echo $color == 'white' ? 'selected' : '' ?>><?php _e('White', 'youtube-widget-responsive') ?></option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('controls'); ?>"><?php _e('Show controls bar', 'youtube-widget-responsive') ?> </label> 
                            <select class='widefat' id="<?php echo $this->get_field_id('controls'); ?>" name="<?php echo $this->get_field_name('controls'); ?>">
                                <option value="1" <?php echo $controls == 1 ? 'selected' : '' ?>><?php _e('Always', 'youtube-widget-responsive') ?></option>
                                <option value="2" <?php echo $controls == 2 ? 'selected' : '' ?>><?php _e('On video playback', 'youtube-widget-responsive') ?></option>
                                <option value="0" <?php echo $controls == 0 ? 'selected' : '' ?>><?php _e('Never', 'youtube-widget-responsive') ?></option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('quality'); ?>"><?php _e('Resolution', 'youtube-widget-responsive') ?> </label> 
                            <select class='widefat' id="<?php echo $this->get_field_id('quality'); ?>" name="<?php echo $this->get_field_name('quality'); ?>">
                                <option value="default" <?php echo empty($quality) || $quality == 'default' ? 'selected' : '' ?>><?php _e('Default', 'youtube-widget-responsive') ?></option>
                                <option value="small" <?php echo $quality == 'small' ? 'selected' : '' ?>>240px</option>
                                <option value="medium" <?php echo $quality == 'medium' ? 'selected' : '' ?>>360px</option>
                                <option value="large" <?php echo $quality == 'large' ? 'selected' : '' ?>>480px</option>
                                <option value="hd720" <?php echo $quality == 'hd720' ? 'selected' : '' ?>>720px</option>
                                <option value="hd1080" <?php echo $quality == 'hd1080' ? 'selected' : '' ?>>1080px</option>
                                <option value="highres" <?php echo $quality == 'highres' ? 'selected' : '' ?>> &gt; 1080px</option>
                            </select>
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('disablekb'); ?>" name="<?php echo $this->get_field_name('disablekb'); ?>" type="checkbox" value="1" <?php echo!empty($disablekb) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('disablekb'); ?>"><?php _e('Disable the player Keyboard controls', 'youtube-widget-responsive') ?> </label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('modestbranding'); ?>" name="<?php echo $this->get_field_name('modestbranding'); ?>" type="checkbox" value="1" <?php echo!empty($modestbranding) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('modestbranding'); ?>"><?php _e('Hide YouTube logo on controls bar', 'youtube-widget-responsive') ?> </label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('showinfo'); ?>" name="<?php echo $this->get_field_name('showinfo'); ?>" type="checkbox" value="0" <?php echo $showinfo == "0" ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('showinfo'); ?>"><?php _e('Hide the video title and uploader before the video starts playing', 'youtube-widget-responsive') ?> </label> 
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('class'); ?>">class: </label> 
                            <input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($class); ?>" />
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('style'); ?>">style: </label> 
                            <input class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="text" value="<?php echo esc_attr($style); ?>" />
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('maxw'); ?>" class="maxw">max-width: </label> 
                            <input id="<?php echo $this->get_field_id('maxw'); ?>" name="<?php echo $this->get_field_name('maxw'); ?>" type="number" value="<?php echo esc_attr($maxw); ?>" style="width: 6em" /> px
                        </p>
                    </div>
                </div>
                <div class="group-collapse">
                    <h5>
                        <i class="fa fa-gear"></i> 
                        <span class="styles">
                            <?php
                            _e('Settings:', 'youtube-widget-responsive');
                            ?>
                        </span>
                    </h5>
                    <div class="StefanoAI_YoutubeVideo-styles">
        <!--                        <p>
                            <input  id="<?php echo $this->get_field_id('w3c'); ?>" name="<?php echo $this->get_field_name('w3c'); ?>" type="checkbox" value="1" <?php echo!empty($w3c) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('w3c'); ?>">W3C standard </label> 
                        </p>-->
                        <p>
                            <input  id="<?php echo $this->get_field_id('privacy'); ?>" name="<?php echo $this->get_field_name('privacy'); ?>" type="checkbox" value="1" <?php echo!empty($privacy) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('privacy'); ?>"><?php _e('Enable privacy-enhanced mode [<a target="_blank" href="http://www.google.com/support/youtube/bin/answer.py?answer=171780&expand=PrivacyEnhancedMode#privacy">?</a>]', 'youtube-widget-responsive') ?> </label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('wmode'); ?>" name="<?php echo $this->get_field_name('wmode'); ?>" type="checkbox" value="1" <?php echo!empty($wmode) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('wmode'); ?>"><?php _e('wmode transparent', 'youtube-widget-responsive') ?></label> 
                        </p>
                        <p>
                            <input  id="<?php echo $this->get_field_id('track'); ?>" name="<?php echo $this->get_field_name('track'); ?>" type="checkbox" value="1" <?php echo!empty($track) ? 'checked' : ''; ?> />
                            <label for="<?php echo $this->get_field_id('track'); ?>"><?php _e('Track video (Google Analytics/Universal Analytics)', 'youtube-widget-responsive') ?></label> 
                        </p>
                    </div>
                </div>
                <div id="<?php echo $this->get_field_id('video'); ?>-StefanoAI_YoutubeVideo_button" class='StefanoAI_YoutubeVideo_button group-collapse'>
                    <h5>
                        <i class="fa fa-youtube-square"></i>
                        <span class="channel-button"><?php _e("Button subscribe:", 'youtube-widget-responsive') ?></span>
                    </h5>
                    <div class="StefanoAI_YoutubeVideo-button">
                        <p>
                            <label for="<?php echo $this->get_field_id('button_channel'); ?>"> <?php _e("Channel Name or ID", 'youtube-widget-responsive'); ?> <a href="https://www.youtube.com/account_advanced" target="_blank" title="Get ID"><i class="fa fa-question-circle"></i></a>:</label>
                            <input class="widefat" id="<?php echo $this->get_field_id('button_channel'); ?>" name="<?php echo $this->get_field_name('button_channel'); ?>" type="text" value="<?php echo esc_attr($button_channel); ?>" />
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('button_layout'); ?>"><?php _e("Layout", 'youtube-widget-responsive'); ?>:</label>
                            <select class='widefat' id="<?php echo $this->get_field_id('button_layout'); ?>" name="<?php echo $this->get_field_name('button_layout'); ?>">
                                <option value="default" <?php echo empty($button_layout) || $button_layout == 'default' ? 'selected' : '' ?>><?php _e('Default', 'youtube-widget-responsive') ?></option>
                                <option value="full" <?php echo $button_layout == 'full' ? 'selected' : '' ?>><?php _e('Full', 'youtube-widget-responsive') ?></option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('button_theme'); ?>"><?php _e("Theme", 'youtube-widget-responsive'); ?>:</label>
                            <select class='widefat' id="<?php echo $this->get_field_id('button_theme'); ?>" name="<?php echo $this->get_field_name('button_theme'); ?>">
                                <option value="default" <?php echo empty($button_theme) || $button_theme == 'default' ? 'selected' : '' ?>><?php _e('Default', 'youtube-widget-responsive') ?></option>
                                <option value="dark" <?php echo $button_theme == 'dark' ? 'selected' : '' ?>><?php _e('Dark', 'youtube-widget-responsive') ?></option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('button_subscriber_count'); ?>"><?php _e("Subscriber count", 'youtube-widget-responsive'); ?>:</label>
                            <select class='widefat' id="<?php echo $this->get_field_id('button_subscriber_count'); ?>" name="<?php echo $this->get_field_name('button_subscriber_count'); ?>">
                                <option value="default" <?php echo empty($button_subscriber_count) || $button_subscriber_count == 'default' ? 'selected' : '' ?>><?php _e('Default (shown)', 'youtube-widget-responsive') ?></option>
                                <option value="hidden" <?php echo $button_subscriber_count == 'hidden' ? 'selected' : '' ?>><?php _e('Hidden', 'youtube-widget-responsive') ?></option>
                            </select>
                        </p>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery("#<?php echo $this->get_field_id('video') ?>-tab-video .group-collapse").css('border', '1px solid #eee');
                        jQuery("#<?php echo $this->get_field_id('video') ?>-tab-video .group-collapse").css('padding', '5px 3px');
                        jQuery("#<?php echo $this->get_field_id('video') ?>-tab-video .group-collapse label").css('padding-left', '5px');
                        jQuery("#<?php echo $this->get_field_id('video') ?>-tab-video .group-collapse label").css('width', '93%');
                        jQuery("#<?php echo $this->get_field_id('video') ?>-tab-video .group-collapse label.maxw").css('width', 'auto');
                        jQuery("#<?php echo $this->get_field_id('video') ?>-tab-video .group-collapse>h5").css('cursor', 'pointer');
                        jQuery("#<?php echo $this->get_field_id('video') ?>-tab-video .group-collapse>h5").click(function () {
                            jQuery(this).next('div').fadeToggle('fast');
                        }).click();
                    });
                </script>
            </div>
            <div id="<?php echo $this->get_field_id('video') ?>-tab-schemaorg" class="StefanoAI_YoutubeVideo_preview">
                <p>
                    <label for="<?php echo $this->get_field_id('schemaorg_name'); ?>"><?php _e('Name', 'youtube-widget-responsive') ?>*: </label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('schemaorg_name'); ?>" name="<?php echo $this->get_field_name('schemaorg_name'); ?>" type="text" value="<?php echo esc_attr($schemaorg_name); ?>" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('schemaorg_thumbnail'); ?>"><?php _e('Thumbnail Url', 'youtube-widget-responsive') ?>*: </label> 
                    <!--<input class="widefat" id="<?php // echo $this->get_field_id('schemaorg_thumbnail');                         ?>" name="<?php echo $this->get_field_name('schemaorg_thumbnail'); ?>" type="text" value="<?php echo esc_attr($schemaorg_thumbnail); ?>" />-->
                    <span style="text-align: center;display: block;">
                        <img src="<?php echo esc_attr($src1); ?>" class="image_preview" alt="" style="width:90%;background-color: #eee;<?php echo empty($schemaorg_thumbnail) ? 'display:none' : ''; ?>"/>
                    </span>
                    <input type="hidden" class="image_preview" name="<?php echo $this->get_field_name('schemaorg_thumbnail'); ?>" value="<?php echo esc_attr($schemaorg_thumbnail); ?>" />
                </p>
                <div style="text-align: center;display: block;width: 100%;">
                    <input type="button" class="button-primary upload" value="Upload thumbnail" style="width: 45%;" />
                    <input type="button" class="button-secondary noimage" value="No preview" style="width: 45%;" />
                </div>
                <p>
                    <label for="<?php echo $this->get_field_id('schemaorg_uploaddate'); ?>"><?php _e('Upload date', 'youtube-widget-responsive') ?>*: </label> 
                    <input class="widefat" id="<?php echo $this->get_field_id('schemaorg_uploaddate'); ?>" name="<?php echo $this->get_field_name('schemaorg_uploaddate'); ?>" type='text' value="<?php echo esc_textarea($schemaorg_uploaddate); ?>" pattern='[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}' maxlength="10" placeholder="<?php echo date('Y-m-d'); ?>" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('schemaorg_description'); ?>"><?php _e('Description', 'youtube-widget-responsive') ?>*: </label> 
                    <textarea class="widefat" style="min-height: 90px;" id="<?php echo $this->get_field_id('schemaorg_description'); ?>" name="<?php echo $this->get_field_name('schemaorg_description'); ?>"><?php echo esc_textarea($schemaorg_description); ?></textarea>
                </p>
                <p>
                    <input  id="<?php echo $this->get_field_id('schemaorg_description_visible'); ?>" name="<?php echo $this->get_field_name('schemaorg_description_visible'); ?>" type="checkbox" value="1" <?php echo!empty($schemaorg_description_visible) ? 'checked' : ''; ?> />
                    <label for="<?php echo $this->get_field_id('schemaorg_description_visible'); ?>"><?php _e('Description visible?', 'youtube-widget-responsive') ?>: </label> 
                </p>
                <p>
                    <?php _e('Duration', 'youtube-widget-responsive') ?>
                <table class='widefat'>
                    <thead>
                        <tr>
                            <th><label for="<?php echo $this->get_field_id('schemaorg_durationm'); ?>"><?php _e('min', 'youtube-widget-responsive') ?>: </label></th>
                            <th><label for="<?php echo $this->get_field_id('schemaorg_durations'); ?>"><?php _e('sec', 'youtube-widget-responsive') ?>: </label></th>
                        </tr>
                    </thead>
                    <tr class='alternate'>
                        <td>
                            <input class="widefat" id="<?php echo $this->get_field_id('schemaorg_durationm'); ?>" name="<?php echo $this->get_field_name('schemaorg_durationm'); ?>" type='number' value="<?php echo esc_textarea($schemaorg_durationm); ?>" pattern='[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}' maxlength="10"/>
                        </td>
                        <td>
                            <input class="widefat" id="<?php echo $this->get_field_id('schemaorg_durations'); ?>" name="<?php echo $this->get_field_name('schemaorg_durations'); ?>" type='number' value="<?php echo esc_textarea($schemaorg_durations); ?>" pattern='[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}' maxlength="2" style="width: 70px;" />
                        </td>
                    </tr>
                </table>
                </p>
                <tiny style='color:gray;font-size:0.8em;'>*field required to print schema.org</tiny>
            </div>
            <div id="<?php echo $this->get_field_id('video') ?>-tab-shortcode">
                <tiny style='color:gray;font-size:0.8em;'><?php _e('Save to display the new shortcode', 'youtube-widget-responsive'); ?></tiny>
                <textarea class='widefat' style="min-height: 300px;">[youtube <?php
                    foreach ($instance as $k => $v) {
                        if (!empty($v)) {
                            if ($k == 'w3c') {
                                continue;
                            }
                            echo "    $k=\"" . esc_textarea(esc_attr($v)) . '"';
                        }
                    }
                    ?>]</textarea>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery(".StefanoAI_YoutubeVideo-tabs").each(function () {
                    if (jQuery(this).closest('form').children('.widget-content').children("#widget-youtube_responsive-__i__-video-tabs").length === 0) {
                        if (jQuery(this).attr('jsAIon') != "1") {
                            jQuery(this).attr('jsAIon', '1');
                            jQuery(this).tabs();
                        }
                    }
                });

                jQuery('.StefanoAI_YoutubeVideo_preview input.noimage').each(function () {
                    if (jQuery(this).closest('form').children('.widget-content').children("#widget-youtube_responsive-__i__-video-tabs").length === 0) {
                        if (jQuery(this).attr('jsAIon') != "1") {
                            jQuery(this).attr('jsAIon', '1');
                            var div = jQuery(this).closest('div.StefanoAI_YoutubeVideo_preview');
                            jQuery(this).click(function () {
                                jQuery(div).find("input.image_preview").val("");
                                jQuery(div).find("img").attr("src", '');
                                jQuery(div).closest('form').find('.autoplay').removeAttr('disabled');
                                jQuery(div).find("img").css("display", 'none');
                            });
                        }
                    }
                });

                jQuery('.StefanoAI_YoutubeVideo_preview input.upload').each(function () {
                    if (jQuery(this).closest('form').children('.widget-content').children("#widget-youtube_responsive-__i__-video-tabs").length === 0) {
                        if (jQuery(this).attr('jsAIon') != "1") {
                            jQuery(this).attr('jsAIon', '1');
                            var div = jQuery(this).closest('div.StefanoAI_YoutubeVideo_preview');
                            jQuery(this).click(function () {
                                var image = wp.media({
                                    title: 'Upload Image',
                                    // mutiple: true if you want to upload multiple files at once
                                    multiple: false
                                }).open()
                                        .on('select', function (e) {
                                            // This will return the selected image from the Media Uploader, the result is an object
                                            var uploaded_image = image.state().get('selection').first();
                                            // We convert uploaded_image to a JSON object to make accessing it easier
                                            // Output to the console uploaded_image
                                            //console.log(uploaded_image);
                                            var image_url = uploaded_image.toJSON().url;
                                            var image_id = uploaded_image.toJSON().id;
                                            // Let's assign the url value to the input field
                                            jQuery(div).find('img').attr('src', image_url);
                                            jQuery(div).find('img').css('display', 'initial');
                                            jQuery(div).find('input.image_preview').val(image_id);
                                            jQuery(div).closest('form').find('.autoplay').attr('disabled', 'disabled');
                                        });
                            });
                        }
                    }
                });
            });
        </script>
        <?php
    }

    function visual_composer() {
        require_once plugin_dir_path(__FILE__) . 'js_composer.php';
    }

    static function shortcode($args) {
        if (!empty($args['video'])) {
            return YouTubeResponsive::makeEmbedUrl($args);
        }
    }

}

function register_youtuberesponsive_widgets() {
    register_widget('YouTubeResponsive');
}

add_action('widgets_init', 'register_youtuberesponsive_widgets');
add_action('wp_footer', array('YouTubeResponsive', 'wp_footer'), 9999);
add_action('wp_head', array('YouTubeResponsive', 'wp_head'), 99);
add_action('plugins_loaded', 'youtube_widget_responsive_load_textdomain');

function youtube_widget_responsive_load_textdomain() {
    load_plugin_textdomain('youtube-widget-responsive', FALSE, plugin_dir_path('/youtube-widget-responsive/youtube-widget-responsive.php') . 'lang/');
}
