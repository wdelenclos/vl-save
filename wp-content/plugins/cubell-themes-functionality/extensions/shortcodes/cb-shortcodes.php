<?php
// Video Gallery Shortcode
if ( ! function_exists( 'videogallery_shortcode' ) ) {
	function cb_videogallery_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(

		  'video1' => '',
		  'url1' => '',
		  'image1' => '',
		  'caption1' => '',
		  'video2' => '',
		  'url2' => '',
		  'image2' => '',
		  'caption2' => '',
		  'video3' => '',
		  'url3' => '',
		  'image3' => '',
		  'caption3' => '',
		  'video4' => '',
		  'url4' => '',
		  'image4' => '',
		  'caption4' => '',
		  ), $atts ) );

        $size = 1;

        if ( $video1 == 'youtube' ) { $cb_url_1   = 'http://www.youtube.com/embed/' . $url1; }
		if ( $video1 == 'vimeo' ) { $cb_url_1   = 'http://player.vimeo.com/video/' . $url1; }
		if ( $video1 == 'daily' ) { $cb_url_1   = 'http://www.dailymotion.com/video/' . $url1; }

		if ( $video2 == 'youtube' ) { $cb_url_2 = 'http://www.youtube.com/embed/' . $url2;	}
		if ( $video2 == 'vimeo' )	{ $cb_url_2 = 'http://player.vimeo.com/video/' . $url2; }
		if ( $video2 == 'daily' )	{ $cb_url_2 = 'http://www.dailymotion.com/video/' . $url2; }

        if ( $video2 != NULL ) { $size++; }

        if ( $video3 != NULL ) {

        	$size++;
			if ( $video3 == 'youtube' ) { $cb_url_3 = 'http://www.youtube.com/embed/' . $url3; }
	        if ( $video3 == 'vimeo' ) { $cb_url_3 = 'http://player.vimeo.com/video/' . $url3; }
	        if ( $video3 == 'daily' )	{ $cb_url_3 = 'http://www.dailymotion.com/video/' . $url3; }
        }
        if ( $video4 != NULL ) {
        	$size++;
        	if ( $video4 == 'youtube' ) {	$cb_url_4 = 'http://www.youtube.com/embed/' . $url4; }
			if ( $video4 == 'vimeo' )	{ $cb_url_4 = 'http://player.vimeo.com/video/' . $url4; }
			if ( $video4 == 'daily' )	{ $cb_url_4 = 'http://www.dailymotion.com/video/' . $url4; }
        }


		if ( $size == 2 ) {
		  return '<div class="cb-video-gallery">' . do_shortcode('[column size=one_half position=first ]<a class="cb-lightbox" title="' . esc_attr( $caption1 ) . '" href="' . esc_url( $cb_url_1 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image1 ) . '" alt="video gallery"></a>[/column][column size=one_half position=last ]<a class="cb-lightbox" title="' . esc_attr( $caption2 ) . '" href="' . esc_url( $cb_url_2 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image2 ) . '" alt="video gallery"/></a>[/column]').'</div>';
		} elseif ( $size == 3 ) {


    		 return '<div class="cb-video-gallery">' . do_shortcode('[column size=one_third position=first ]<a class="cb-lightbox" title="' . esc_attr( $caption1 ) . '" href="' . esc_url( $cb_url_1 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image1 ) . '" alt="video gallery"></a>[/column][column size=one_third position=middle]<a class="cb-lightbox" title="' . esc_attr( $caption2 ) . '" href="' . esc_url( $cb_url_2 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image2 ) . '" alt="video gallery"></a>[/column][column size=one_third position=last ]<a class="cb-lightbox" title="' . esc_attr( $caption3 ) . '" href="' . esc_url( $cb_url_3 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image3 ) . '" alt="video gallery"></a>[/column]') . '</div>';
		} elseif ( $size == 4 ) {

    		return '<div class="cb-video-gallery">' . do_shortcode('[column size=one_quarter position=first ]<a class="cb-lightbox" title="' . esc_attr( $caption1 ) . '" href="' . esc_url( $cb_url_1 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image1 ) . '" alt="video gallery"></a>[/column][column size=one_quarter position=middle ]<a class="cb-lightbox" title="' . esc_url( $caption2 ) . '" href="' . esc_url( $cb_url_2 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image2 ) . '" alt=video gallery"></a>[/column][column size=one_quarter position=middle ]<a class="cb-lightbox" title="' . esc_attr( $caption3 ) . '" href="' . esc_url( $cb_url_3 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image3 ) . '" /></a>[/column][column size=one_quarter position=last ]<a class="cb-lightbox" title="' . esc_url( $caption4 ) . '" href="' . esc_url( $cb_url_4 ) . '" rel="video_gallery"><div class="cb-media-icon"><i class="fa fa-play"></i></div><img class="alignnone size-medium" src="' . esc_url( $image4 ) . '" alt="video gallery"></a>[/column]') . '</div>';
		}
	}
	add_shortcode('videogallery', 'cb_videogallery_shortcode');
}

// Columns Shortcode
if ( ! function_exists( 'cb_column_shortcode' ) ) {
	function cb_column_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
		  'size' => 'normal',
		  'position' => 'first',
		  ), $atts ) );

		$clearfix = NULL;
		if ($position == 'middle') { $position = '';}
		if ($position == 'first') { $position = ' first';}
		if ($position == 'last') { $position = ' last'; $clearfix = '<div class="clearfix"></div>';}
		if ($size == 'one_half') { $size = 'sixcol';}
		if ($size == 'one_third') { $size = 'fourcol';}
		if ($size == 'two_third') { $size = 'eightcol';}
		if ($size == 'one_quarter') { $size = 'threecol';}
		if ($size == 'three_quarter') { $size = 'ninecol';}

        return '<div class="' . $size . $position.'">'. do_shortcode( $content ) .'</div>'. $clearfix;

	}
	add_shortcode('column', 'cb_column_shortcode');
}

// Dropcap Shortcode
if ( ! function_exists( 'cb_dropcap_shortcode' ) ) {
		function cb_dropcap_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
		  'size' => 'small',
		  'text' => '',
		  ), $atts ) );

		return '<span class="cb-dropcap-'.$size.'">' .  $content  . '</span>';
	}
	add_shortcode('dropcap', 'cb_dropcap_shortcode');
}

// Video Embed Shortcode
if ( ! function_exists( 'cb_embedvideo_shortcode' ) ) {
	function cb_embedvideo_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
		  'id' => '',
		  'website' => '',
		  ), $atts ) );
		 if ($website == 'youtube'){
			return '<div class="cb-video-frame"><iframe width="600" height="330" src="http://www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe></div>';
		 } else{
		 	return '<div class="cb-video-frame"><iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
		 }
	}
	add_shortcode('embedvideo', 'cb_embedvideo_shortcode');
}

// Alert Shortcode
if ( ! function_exists( 'cb_alert_shortcode' ) ) {
	function cb_alert_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
		  'type' => '',
		  ), $atts ) );

		return '<div class="cb-alert cb-' . $type . '">' . $content . '</div>';
	}
	add_shortcode('alert', 'cb_alert_shortcode');
}

// Author Box Shortcode
if ( ! function_exists( 'cb_author_box_shortcode' ) ) {
	function cb_author_box_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
		  'authorid' => '',
		  'title' => '',
		  ), $atts ) );
		global $post;
		return cb_author_box( $post, $authorid, $title);
	}
	add_shortcode('authorbox', 'cb_author_box_shortcode');
}

// Buttons Shortcode
if ( ! function_exists( 'cb_shortcode_buttons' ) ) {
    function cb_shortcode_buttons( $atts, $content = NULL ) {

        extract( shortcode_atts( array(
          'color' => 'white',
          'size' => 'normal',
          'text' => '',
          'rel' => 'follow',
          'alignment' => 'none',
          'openin' => 'samewindow',
          'url' => '',
          ), $atts ) );

        if ( $openin == 'samewindow' ) { $cb_target = 'target="_self"'; } else { $cb_target = 'target="_blank"'; }

        if ($url != NULL) {
                return '<span class="cb-button cb-'. $color . ' cb-' . $size .' cb-'. $alignment .'"><a href="' . esc_url( $url ) . '" '. $cb_target .' rel="'. esc_attr( $rel ) .'">' . $content . '</a></span>';
        } else {
                return '<span class="cb-button cb-'. $color . ' cb-' . $size .' cb-'. $alignment .' cb-no-url">' . $content . '</span>';
       }
    }

    add_shortcode('button', 'cb_shortcode_buttons');
}

// Highlight Shortcode
if ( ! function_exists( 'cb_highlight_shortcode' ) ) {
	function cb_highlight_shortcode( $atts, $content = NULL ) {

		  extract( shortcode_atts( array(
		  'color' => '',
		  'text' => '',
		  ), $atts ) );

		if ($color){
			return '<span class="cb-highlight" style="background-color:'.$color.'">' .  $content . '</span>';
		}else{
			return '<span class="cb-highlight user-bg">' . $content  .'</span>';
		}
	}
	add_shortcode('highlight', 'cb_highlight_shortcode');
}

// Divider Shortcode
if ( ! function_exists( 'cb_divider_shortcode' ) ) {
	function cb_divider_shortcode( $atts, $content = NULL ) {

		  extract( shortcode_atts( array(
		  'text' => '',
		  ), $atts ) );

			return '<div class="cb-divider clearfix"><span class="cb-title">' .  $content . '</span></div>';
	}
	add_shortcode('divider', 'cb_divider_shortcode');
}

// Toggler Shortcode
if ( ! function_exists( 'cb_shortcode_toggler' ) ) {
	function cb_shortcode_toggler( $atts, $content = NULL ) {
	 extract( shortcode_atts( array(
		  'title' => 'Secret Text',
		  'text' => '',
		  ), $atts ) );
	 // CBTODO make $content output decoded urls var_dump(htmlspecialchars_decode ($content));
		return '<div class="cb-toggler"><i class="fa fa-plus"></i><i class="fa fa-minus"></i><a href="#" class="cb-toggle">'.$title.'</a><div class="cb-toggle-content">'. do_shortcode( ($content) ).'</div></div>';
	 }
	 add_shortcode('toggler', 'cb_shortcode_toggler');
}

// Tabs Shortcode
if ( ! function_exists( 'cb_tabs' ) ) {
	function cb_tabs( $atts, $content ){

        extract( shortcode_atts( array(
          'title1' => '',
          'title2' => '',
          'title3' => '',
          'title4' => '',
          'text1' => '',
          'text2' => '',
          'text3' => '',
          'text4' => '',
          ), $atts ) );

          $cb_arr = array();
          $i = 1;
          $cb_output = NULL;

          if ($title1 != NULL) {

                   $cb_1 = array($title1, $text1);
                    array_push($cb_arr, $cb_1 );
          }
          if ($title2 != NULL) {
                   $cb_2 = array($title2, $text2);
                    array_push($cb_arr, $cb_2 );
          }
          if ($title3 != NULL) {
                   $cb_3 = array($title3, $text3);
                    array_push($cb_arr, $cb_3 );
          }
          if ($title4 != NULL) {
                   $cb_4 = array($title4, $text4);
                    array_push($cb_arr, $cb_4 );
          }

         $cb_output .= '<div class="cb-tabs"><ul>';
         foreach ($cb_arr as $tab) {
              $cb_output .= '<li><a href="#">'. do_shortcode($tab[0]) .'</a></li>';
         }

         $cb_output .= '</ul><div class="cb-panes">';

          foreach ($cb_arr as $tab) {
               $cb_output .= '<div class="cb-tab-content">'. do_shortcode($tab[1]) .'</div>';
         }

         $cb_output .= '</div></div>';


		return $cb_output;
	}
	add_shortcode( 'tabs', 'cb_tabs' );
}

// Tabs Shortcode V2
if ( ! function_exists( 'cb_tab_v2' ) ) {
	function cb_tab_v2( $atts, $content ){

        extract( shortcode_atts( array(
          'title' => '',
          ), $atts )
        );

		$hash_title = str_replace(' ','',strtolower($title));
		$cb_title1 = '<li><a href="#' . $hash_title. '">' . $title . '</a></li>';
		$cb_content1 = '<div id="' . $hash_title . '" class="cb-tab-content">' . do_shortcode( $content ) . '</div>';

		return 'cbcut' . $cb_title1 . 'cbcut' . $cb_content1;
	}
	add_shortcode( 'cbtab', 'cb_tab_v2' );
}

if ( ! function_exists( 'cb_tabs_v2' ) ) {
	function cb_tabs_v2( $atts, $content ){

		$cb_content = explode('cbcut', do_shortcode($content) );
		$cb_tab_titles = $cb_panes = NULL;

		$cb_content_count = count($cb_content);

		for ( $i = 0; $i < $cb_content_count; $i++ ) {

			if ( isset( $cb_content[$i] ) ) {

				if ( ( $i % 2 == 0 ) ) {
					$cb_panes .= $cb_content[$i];
				} else {

					$cb_tab_titles .= $cb_content[$i];
				}
			}
		}

		$cb_output = '<div class="cb-tabs"><ul>' . $cb_tab_titles . '</ul><div class="cb-panes">' . $cb_panes . '</div></div>';

		return $cb_output;
	}
	add_shortcode( 'cbtabs', 'cb_tabs_v2' );
}

// registers the buttons for use
if ( ! function_exists( 'cb_register_shortcodes' ) ) {
	function cb_register_shortcodes( $buttons ) {

		array_push( $buttons, 'cb_button', 'toggler', 'dropcap', 'alert', 'authorbox', 'highlight', 'tabs', 'column', 'divider', 'videogallery' );
		return $buttons;
	}
}

// filters the tinyMCE buttons and adds our custom buttons
if ( ! function_exists( 'cb_shortcode_filter' ) ) {
	function cb_shortcode_filter() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}

		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			// filter the tinyMCE buttons and add our own
			add_filter('mce_external_plugins', 'cb_add_shortcodes');
			add_filter('mce_buttons_3', 'cb_register_shortcodes');
		}
	}
	// init process for button control
	add_action('init', 'cb_shortcode_filter');
}

// add the button to the tinyMCE bar
if ( ! function_exists( 'cb_add_shortcodes' ) ) {
	function cb_add_shortcodes($plugin_array) {

		$plugin_array['alert'] =  plugins_url( '/alert-shortcode.js', __FILE__ ) ;
		$plugin_array['authorbox'] =  plugins_url( '/authorbox-shortcode.js', __FILE__ ) ;
		$plugin_array['cb_button'] =  plugins_url( '/buttons-shortcode.js', __FILE__ ) ;
		$plugin_array['column'] = plugins_url( '/column-shortcode.js', __FILE__ );
		$plugin_array['divider'] = plugins_url( '/divider-shortcode.js', __FILE__ );
		$plugin_array['dropcap'] = plugins_url( '/dropcap-shortcode.js', __FILE__ );

		if ( wp_get_theme()->Name != '15zine' ) {
			$plugin_array['videogallery'] = plugins_url( '/videogallery-shortcode.js', __FILE__ );
		}

		
		$plugin_array['highlight'] = plugins_url( '/highlight-shortcode.js', __FILE__ );
		$plugin_array['tabs'] = plugins_url( '/tab-shortcode.js', __FILE__ );
		$plugin_array['toggler'] =  plugins_url( '/toggler-shortcode.js', __FILE__ );
		

		return $plugin_array;
	}
}
?>