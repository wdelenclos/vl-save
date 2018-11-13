<?php // Simple Feed Stats - Shortcodes & Template Tags



// shortcode: daily count for all feeds in plain-text
function sfs_subscriber_count() { 
	
	global $sfs_options;
	
	if (isset($sfs_options['sfs_custom_enable']) && $sfs_options['sfs_custom_enable'] == 1) {
		
		return $sfs_options['sfs_custom'];
		
	} else {
		
		$feed_count = get_transient('feed_count');	
		
		if ($feed_count) return $feed_count;
		
		else return '0';
		
	}
	
}
add_shortcode('sfs_subscriber_count','sfs_subscriber_count');



// shortcode: daily count for all feeds via feedburner badge
function sfs_count_badge() {
	
	global $sfs_options;
	
	if ($sfs_options['sfs_custom_enable']) {
		
		$count = isset($sfs_options['sfs_custom']) ? intval($sfs_options['sfs_custom']) : 0;
		
	} else {
		
		$count = (get_transient('feed_count')) ? intval(get_transient('feed_count')) : 0;
		
	}
	
	$text_1 = sprintf(_n('reader', 'readers', $count, 'simple-feed-stats'), $count);
	$text_2 = esc_html__('Simple Feed Stats', 'simple-feed-stats');
	
	$badge_prepend = '<div class="sfs-subscriber-count"><div class="sfs-count"><span>';
	$badge_append  = '</span> '. $text_1 .'</div><div class="sfs-stats">'. $text_2 .'</div></div>';
	
	$badge = $badge_prepend . sanitize_text_field($count) . $badge_append;
	
	return $badge;
	
}
add_shortcode('sfs_count_badge','sfs_count_badge');



// shortcode: daily count for all feeds via simple badge
function sfs_count_simple($atts) {
	
	global $sfs_options;
	
	$atts =  extract(shortcode_atts(array(
		
		'link' => '',
		
	), $atts, 'sfs_count_simple'));
	
	$prepend = empty($link) ? '' : '<a target="_blank" rel="noopener noreferrer" href="'. esc_url($link) .'">';
	$append  = empty($link) ? '' : '</a>';
	
	if ($sfs_options['sfs_custom_enable']) {
		
		$count = isset($sfs_options['sfs_custom']) ? intval($sfs_options['sfs_custom']) : 0;
		
	} else {
		
		$count = (get_transient('feed_count')) ? intval(get_transient('feed_count')) : 0;
		
	}
	
	$digits = strlen((string) $count);
	
	if     ($digits > 6)   $width = '200px';
	elseif ($digits === 6) $width = '180px';
	elseif ($digits === 5) $width = '170px';
	elseif ($digits === 4) $width = '160px';
	elseif ($digits === 3) $width = '150px';
	elseif ($digits === 2) $width = '140px';
	elseif ($digits === 1) $width = '130px';
	
	$text = sprintf(_n('subscriber', 'subscribers', $count, 'simple-feed-stats'), $count);
	
	$count = apply_filters('sfs_badge_simple_count', number_format($count));
	
	$style  = '<style>.sfs-count-simple { text-align: center; text-shadow: 0 1px 1px rgba(0,0,0,0.3); ';
	$style .= 'font: 16px/40px "Helvetica Neue", Helvetica, Arial, sans-serif; border-radius: 1px; } ';
	$style .= '.sfs-count-simple, .sfs-count-simple a:link, .sfs-count-simple a:visited, .sfs-count-simple a:hover, ';
	$style .= '.sfs-count-simple a:active { display: block; width: '.  $width .'; ';
	$style .= 'height: 40px; margin: 0; padding: 0; color: #fff; background-color: #f99000; } ';
	$style .= '.sfs-count-simple a:hover { background-color: #ff9d0a; }</style>';
	
	$badge = '<div class="sfs-count-simple">'. $prepend . $count .' '. $text . $append .'</div>';
	
	return $style . $badge;
	
}
add_shortcode('sfs_count_simple','sfs_count_simple');



// shortcode: daily count for rss2 feeds in plain-text
function sfs_rss2_count() { 
	
	global $sfs_options;
	
	$feed_count = get_transient('rss2_count');
		
	if ($feed_count) return $feed_count;
	
	else return '0';
	
}
add_shortcode('sfs_rss2_count','sfs_rss2_count');



// shortcode: daily count for comment feeds in plain-text
function sfs_comments_count() {
	
	global $sfs_options;
	
	$feed_count = get_transient('comment_count');
		
	if ($feed_count) return $feed_count;
	
	else return '0';
	
}
add_shortcode('sfs_comments_count','sfs_comments_count');










// template tag: daily count for all feeds in plain-text
function sfs_display_subscriber_count() {
	
	global $sfs_options;
	
	if (isset($sfs_options['sfs_custom_enable']) && $sfs_options['sfs_custom_enable'] == 1) {
		
		echo $sfs_options['sfs_custom'];
		
	} else {
		
		$feed_count = get_transient('feed_count');	
		
		if ($feed_count) echo $feed_count;
		
		else echo '0';
		
	}
	
}



// template tag: daily count for all feeds via feedburner badge
function sfs_display_count_badge() {
	
	echo sfs_count_badge();
	
}



// template tag: daily count for all feeds via simple badge
function sfs_display_count_simple($atts = array()) {
	
	echo sfs_count_simple($atts);
	
}



// template tag: total count for all feeds as plain-text
function sfs_display_total_count() {
	
	global $sfs_options; 
	
	$all_count = get_transient('all_count');
	
	if ($all_count) echo $all_count;
	
	else echo '0';
	
}


