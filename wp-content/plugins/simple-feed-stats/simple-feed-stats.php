<?php
/*
	Plugin Name: Simple Feed Stats
	Plugin URI: https://perishablepress.com/simple-feed-stats/
	Description: Tracks your feeds, adds custom content, and displays your feed statistics on your site.
	Tags: feed, stats, statistics, subscribers, feedburner,  count, tracking, atom, rdf, rss, feeds, posts, comments
	Author: Jeff Starr
	Author URI: https://plugin-planet.com/
	Donate link: https://monzillamedia.com/donate.html
	Contributors: specialk
	Requires at least: 4.1
	Tested up to: 4.9
	Stable tag: 20180820
	Version: 20180820
	Requires PHP: 5.2
	Text Domain: simple-feed-stats
	Domain Path: /languages
	License: GPL v2 or later
*/

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 
	2 of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	with this program. If not, visit: https://www.gnu.org/licenses/
	
	Copyright 2018 Monzilla Media. All rights reserved.
*/

if (!defined('ABSPATH')) die();

require_once('sfs-admin.php');
require_once('sfs-shortcodes.php');

$sfs_wp_vers = '4.1';
$sfs_version = '20180820';
$sfs_options = get_option('sfs_options', sfs_default_options());

define('SFS_PLUGIN_FILE', 'simple-feed-stats/simple-feed-stats.php');
define('SFS_PLUGIN_PATH', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, 'sfs_on_activate');
register_deactivation_hook(__FILE__, 'sfs_delete_options_on_deactivation');
register_deactivation_hook(__FILE__, 'sfs_delete_table_on_deactivation');
add_filter('plugin_action_links', 'sfs_plugin_action_links', 10, 2);
add_filter('plugin_row_meta', 'add_sfs_links', 10, 2);
add_action('admin_init', 'sfs_require_wp_version');



// enable shortcodes in widgets & post content
if (isset($sfs_options['sfs_enable_shortcodes']) && $sfs_options['sfs_enable_shortcodes']) {
	
	add_filter('the_content', 'do_shortcode', 10);
	add_filter('widget_text', 'do_shortcode', 10); 
	
}



// random string
function sfs_randomizer() {
	
	$sfs_randomizer = rand(1000000, 9999999);
	
	return $sfs_randomizer;
	
}



// string cleaner
function sfs_clean($string) {
	
	$string = trim($string); 
	$string = strip_tags($string);
	$string = htmlspecialchars($string, ENT_QUOTES, get_option('blog_charset', 'UTF-8'));
	$string = str_replace("\n", "", $string);
	$string = trim($string);
	 
	return $string;
	
}



// boolval fallback
if (!function_exists('boolval')) {
	
	function boolval($val) {
		
		return (bool) $val;
		
	}
	
}



// inline css
function sfs_include_badge_styles() {
	
	global $sfs_options;
	
	if (isset($sfs_options['sfs_custom_styles']) && !empty($sfs_options['sfs_custom_styles'])) {
		
		$sfs_badge_styles = wp_strip_all_tags($sfs_options['sfs_custom_styles']);
		
		echo '<style type="text/css">'. "\n";
		echo $sfs_badge_styles . "\n";
		echo '</style>'. "\n";
		
	}
	
}
add_action('wp_head', 'sfs_include_badge_styles');



// custom footer content
function sfs_feed_content($content) {
	
	global $sfs_options;
	
	if (
		(isset($sfs_options['sfs_feed_content_before']) && !empty($sfs_options['sfs_feed_content_before'])) || 
		(isset($sfs_options['sfs_feed_content_after'])  && !empty($sfs_options['sfs_feed_content_after']))
	) {
		
		if (is_feed()) {
			
			return $sfs_options['sfs_feed_content_before'] . $content . $sfs_options['sfs_feed_content_after'];
			
		}
		
	}
	
	return $content;
	
}
add_filter('the_content', 'sfs_feed_content');
add_filter('the_excerpt', 'sfs_feed_content');
	


// ip address
function sfs_get_ip_address($override = false) {
	
	global $sfs_options;
	
	$disable = isset($sfs_options['sfs_disable_ip']) ? $sfs_options['sfs_disable_ip'] : 0;
	
	if (isset($_SERVER)) {
		
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
			
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
			
		}
		
	} else {
		
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
			
		} elseif (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
			
		} else {
			$ip_address = getenv('REMOTE_ADDR');
			
		}
		
	}
	
	$ip_address = ($disable && !$override) ?  esc_html__('IP data disabled', 'simple-feed-stats') : $ip_address;
	
	return $ip_address;
	
}



// custom key/value parameter
function sfs_custom_parameter() {
	
	global $sfs_options;
	
	$custom_key = '';
	$custom_value = '';
	
	if (
		(isset($sfs_options['sfs_custom_key'])   && !empty($sfs_options['sfs_custom_key'])) && 
		(isset($sfs_options['sfs_custom_value']) && !empty($sfs_options['sfs_custom_value']))
	) {
		
		$custom_key   = $sfs_options['sfs_custom_key'];
		$custom_value = $sfs_options['sfs_custom_value'];
		
	}
	
	return array($custom_key, $custom_value);
	
}



// get query-string parameters
function sfs_get_query_params() {
	
	$params = array();
	
	if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		
		$args = explode('&', htmlspecialchars_decode($_SERVER['QUERY_STRING'], ENT_QUOTES));
		
		foreach($args as $key => $value) {
			
			$string = explode('=', $value);
			
			$a = isset($string[0]) ? sfs_clean($string[0]) : null;
			$b = isset($string[1]) ? sfs_clean($string[1]) : null;
			
			$params[$a] = $b;
			
		}
		
	}
	
	return $params;
	
}



// ignored bots
function sfs_ignore_bots() {
	
	$bots = array(
		'aolbuild', 
		'adsbot-google',
		'googlebot', 
		'googleproducer', 
		'google-site-verification', 
		'google-test', 
		'mediapartners-google', 
		'baidu', 
		'bingbot', 
		'bingpreview', 
		'duckduckgo',
		'msnbot', 
		'yandex', 
		'sosospider', 
		'sosoimagespider', 
		'exabot', 
		'sogou', 
		'teoma',
		'slurp',
		'yandex',
		'facebookexternalhit', 
		'feedfetcher-google',
	);
	
	return apply_filters('sfs_filter_bots', $bots);
	
}





/*
	Default Tracking
	Tracks all feed requests
	Recommended for most users
*/
function simple_feed_stats() {
	
	global $sfs_options, $wpdb;
	
	if (!is_feed()) return; 
	
	if (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_default_tracking') {
		
		$protocol = is_ssl() ? 'https://' : 'http://';
		
		$host    = isset($_SERVER['HTTP_HOST'])       ? sfs_clean($_SERVER['HTTP_HOST'])                         : 'n/a';
		$request = isset($_SERVER['REQUEST_URI'])     ? esc_url_raw($protocol . $host . $_SERVER['REQUEST_URI']) : 'n/a';
		$referer = isset($_SERVER['HTTP_REFERER'])    ? esc_url_raw($_SERVER['HTTP_REFERER'])                    : 'n/a';
		$qstring = isset($_SERVER['QUERY_STRING'])    ? sfs_clean($_SERVER['QUERY_STRING'])                      : 'n/a';
		$agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sfs_clean($_SERVER['HTTP_USER_AGENT'])                   : 'n/a';
		
		if (isset($sfs_options['sfs_ignore_bots']) && $sfs_options['sfs_ignore_bots'] && preg_match('/'. implode('|', sfs_ignore_bots()) .'/i', $agent)) return;
		
		$address = sfs_get_ip_address();
		
		$date_format = get_option('date_format');
		$time_format = get_option('time_format');
		$logtime = date("{$date_format} {$time_format}", current_time('timestamp'));
		
		$feed_rdf       = get_bloginfo('rdf_url');
		$feed_atom      = get_bloginfo('atom_url');
		$feed_rss2      = get_bloginfo('rss2_url');
		$feed_coms_atom = get_bloginfo('comments_atom_url');
		$feed_coms      = get_bloginfo('comments_rss2_url');
		
		if     (strpos($request, $feed_rdf)       !== false) $type = 'RDF';
		elseif (strpos($request, $feed_atom)      !== false) $type = 'Atom';
		elseif (strpos($request, $feed_rss2)      !== false) $type = 'RSS2';
		elseif (strpos($request, $feed_coms_atom) !== false) $type = 'Comments';
		elseif (strpos($request, $feed_coms)      !== false) $type = 'Comments';
		else                                                 $type = 'Other';
		
		$tracking = 'default';
		
		$table = $wpdb->prefix .'simple_feed_stats';
		
		$wpdb->insert($table, array(
				
				'logtime'  => $logtime, 
				'request'  => $request, 
				'referer'  => $referer, 
				'type'     => $type, 
				'qstring'  => $qstring, 
				'address'  => $address, 
				'tracking' => $tracking, 
				'agent'    => $agent, 
				
			), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
		
	}
	
}
add_action('wp', 'simple_feed_stats');





/*
	Custom Tracking
	Tracks via embedded post image
	Recommended if redirecting your feed to a service like Feedburner
*/
function sfs_feed_tracking($content) {
	
	global $sfs_options, $wp_query;
	
	if (!is_feed()) return $content; 
	
	if (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_custom_tracking') {
		
		$custom = sfs_custom_parameter();
		
		$custom_key = isset($custom[0]) ? sfs_clean($custom[0]) : 'custom_key';
		$custom_val = isset($custom[1]) ? sfs_clean($custom[1]) : 'custom_value';
		
		if (get_option('permalink_structure')) {
			
			$parse = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI']) : array();
			
			$path = isset($parse['path']) ? sfs_clean($parse['path']) : '';
			
			if (strpos($path, '/comments/') !== false) {
				
				$feed = 'comments';
				
			} else {
				
				$feed = 'rss2';
				
				if     (strpos($path, '/feed/rdf')  !== false) $feed = 'rdf';
				elseif (strpos($path, '/feed/atom') !== false) $feed = 'atom';
				
			}
			
		} else {
			
			$feed = isset($_GET['feed']) ? sfs_clean($_GET['feed']) : 'rss2'; // get_query_var('feed') returns incorrect feed vars when permalinks enabled
			
			if ($feed === 'comments-rss2' || $feed === 'comments-atom') $feed = 'comments';
			
		} 
		
		$query = array('sfs_tracking' => 'true', 'feed_type' => $feed, $custom_key => $custom_val, 'v' => sfs_randomizer());
		
		$url = add_query_arg($query, plugins_url('/simple-feed-stats/tracker.php'));
		
		if (($wp_query->current_post === 0) || ($wp_query->current_comment === 0)) {
			
			return '<img src="'. esc_url_raw($url) .'" width="1" height="1" alt=""> '. $content;
			
		}
		
	}
	
	return $content;
	
}
add_filter('the_excerpt_rss',  'sfs_feed_tracking');
add_filter('comment_text_rss', 'sfs_feed_tracking');
add_filter('comment_text',     'sfs_feed_tracking');





/*
	Alt Tracking
	Tracks via embedded feed image
	Experimental tracking method
*/
function sfs_alt_tracking_rdf() {
	
	global $sfs_options; 
	
	if (!is_feed()) return; 
	
	if (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_alt_tracking') {
		
		$custom = sfs_custom_parameter();
		
		$custom_key = isset($custom[0]) ? sfs_clean($custom[0]) : 'custom_key';
		$custom_val = isset($custom[1]) ? sfs_clean($custom[1]) : 'custom_value';
		
		$query = array('sfs_tracking' => 'true', 'feed_type' => 'rdf', $custom_key => $custom_val, 'v' => sfs_randomizer());
		
		$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($query, '', '&amp;'));
		
		?>
		
		<image rdf:resource="<?php echo esc_url_raw($url); ?>">
			<title><?php bloginfo_rss('name'); ?></title>
			<url><?php echo esc_url_raw($url); ?></url>
			<link><?php bloginfo_rss('url'); ?></link>
			<description><?php bloginfo('description'); ?></description>
		</image>
		
<?php }
	
}
add_action('rdf_header', 'sfs_alt_tracking_rdf');



function sfs_alt_tracking_rss() {
	
	global $sfs_options; 
	
	if (!is_feed()) return; 
	
	if (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_alt_tracking') {
		
		$custom = sfs_custom_parameter();
		
		$custom_key = isset($custom[0]) ? sfs_clean($custom[0]) : 'custom_key';
		$custom_val = isset($custom[1]) ? sfs_clean($custom[1]) : 'custom_value';
		
		$query = array('sfs_tracking' => 'true', 'feed_type' => 'rss2', $custom_key => $custom_val, 'v' => sfs_randomizer());
		
		$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($query, '', '&amp;')); 
		
		?>
		
		<image>
			<title><?php bloginfo_rss('name'); ?></title>
			<url><?php echo esc_url_raw($url); ?></url>
			<link><?php bloginfo_rss('url'); ?></link>
			<width>1</width><height>1</height>
			<description><?php bloginfo('description'); ?></description>
		</image>
		
<?php }
	
}
add_action('rss2_head', 'sfs_alt_tracking_rss');



function sfs_alt_tracking_atom() {
	
	global $sfs_options; 
	
	if (!is_feed()) return; 
	
	if (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_alt_tracking') {
		
		$custom = sfs_custom_parameter();
		
		$custom_key = isset($custom[0]) ? sfs_clean($custom[0]) : 'custom_key';
		$custom_val = isset($custom[1]) ? sfs_clean($custom[1]) : 'custom_value';
		
		$query = array('sfs_tracking' => 'true', 'feed_type' => 'atom', $custom_key => $custom_val, 'v' => sfs_randomizer());
		
		$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($query, '', '&amp;')); 
		
		?>
		
		<icon><?php echo esc_url_raw($url); ?></icon>
		
<?php }
	
}
add_action('atom_head', 'sfs_alt_tracking_atom');



function sfs_alt_tracking_comments_rss() {
	
	global $sfs_options; 
	
	if (!is_feed()) return; 
	
	if (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_alt_tracking') {
		
		$custom = sfs_custom_parameter();
		
		$custom_key = isset($custom[0]) ? sfs_clean($custom[0]) : 'custom_key';
		$custom_val = isset($custom[1]) ? sfs_clean($custom[1]) : 'custom_value';
		
		$query = array('sfs_tracking' => 'true', 'feed_type' => 'comments', $custom_key => $custom_val, 'v' => sfs_randomizer());
		
		$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($query, '', '&amp;')); 
		
		?>
		
		<image>
			<title><?php esc_html_e('Comments for ', 'simple-feed-stats') . bloginfo_rss('name'); ?></title>
			<url><?php echo esc_url_raw($url); ?></url>
			<link><?php bloginfo_rss('url'); ?></link>
			<width>1</width><height>1</height>
			<description><?php bloginfo('description'); ?></description>
		</image>
		
<?php }
	
}
add_action('commentsrss2_head', 'sfs_alt_tracking_comments_rss');



function sfs_alt_tracking_comments_atom() {
	
	global $sfs_options; 
	
	if (!is_feed()) return; 
	
	if (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_alt_tracking') {
		
		$custom = sfs_custom_parameter();
		
		$custom_key = isset($custom[0]) ? sfs_clean($custom[0]) : 'custom_key';
		$custom_val = isset($custom[1]) ? sfs_clean($custom[1]) : 'custom_value';
		
		$query = array('sfs_tracking' => 'true', 'feed_type' => 'comments', $custom_key => $custom_val, 'v' => sfs_randomizer());
		
		$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($query, '', '&amp;')); 
		
		?>
		
		<icon><?php echo esc_url_raw($url); ?></icon>
		
<?php }
	
}
add_action('comments_atom_head', 'sfs_alt_tracking_comments_atom'); 





// sfs feed tracker
function sfs_tracker() {
	
	global $sfs_options, $wpdb;
	
	$params = sfs_get_query_params();
	
	if (isset($params['sfs_tracking']) && !empty($params['sfs_tracking'])) {
		
		$date_format = get_option('date_format');
		$time_format = get_option('time_format');
		
		$logtime = date("{$date_format} {$time_format}", current_time('timestamp'));
		
		$protocol = is_ssl() ? 'https://' : 'http://';
		
		$address = sfs_get_ip_address();
		
		$host    = isset($_SERVER['HTTP_HOST'])       ? sfs_clean($_SERVER['HTTP_HOST'])                         : 'n/a';
		$request = isset($_SERVER['REQUEST_URI'])     ? esc_url_raw($protocol . $host . $_SERVER['REQUEST_URI']) : 'n/a';
		$referer = isset($_SERVER['HTTP_REFERER'])    ? esc_url_raw($_SERVER['HTTP_REFERER'])                    : 'n/a';
		$qstring = isset($_SERVER['QUERY_STRING'])    ? sfs_clean($_SERVER['QUERY_STRING'])                      : 'n/a';
		$agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sfs_clean($_SERVER['HTTP_USER_AGENT'])                   : 'n/a';
		
		if (isset($sfs_options['sfs_ignore_bots']) && $sfs_options['sfs_ignore_bots'] && preg_match('/'. implode('|', sfs_ignore_bots()) .'/i', $agent)) exit;
		
		$feed_type = isset($params['feed_type']) ? $params['feed_type'] : 'undefined';
		
		if (isset($params['sfs_type']) && $params['sfs_type'] === 'open') $feed_type = 'open';
		
		if     ($feed_type == 'rdf')      $type = 'RDF';
		elseif ($feed_type == 'rss2')     $type = 'RSS2';
		elseif ($feed_type == 'atom')     $type = 'Atom';
		elseif ($feed_type == 'comments') $type = 'Comments';
		elseif ($feed_type == 'open')     $type = 'Open';
		else                              $type = 'Other';
		
		$tracking = 'default';
		
		if (isset($sfs_options['sfs_tracking_method'])) {
			
			if     (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_custom_tracking') $tracking = 'custom';
			elseif (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_alt_tracking')    $tracking = 'alt';
			elseif (isset($sfs_options['sfs_tracking_method']) && $sfs_options['sfs_tracking_method'] === 'sfs_open_tracking')   $tracking = 'open';
			
		}
		
		$table = $wpdb->prefix .'simple_feed_stats';
		
		$insert = $wpdb->insert($table, array(
				
				'logtime'  => $logtime, 
				'request'  => $request, 
				'referer'  => $referer, 
				'type'     => $type, 
				'qstring'  => $qstring, 
				'address'  => $address, 
				'tracking' => $tracking, 
				'agent'    => $agent,
				
			), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
		
		$open_tracker = isset($sfs_options['sfs_open_image_url']) ? $sfs_options['sfs_open_image_url'] : null;
		
		$tracker_image = ('open' === $tracking && !empty($open_tracker)) ? $open_tracker : plugins_url('/simple-feed-stats/tracker.gif');
		
		wp_redirect(esc_url_raw($tracker_image));
		
		exit;
		
	}
	
}





// clear cache (single site only)
function sfs_clear_cache() {
	
	if (isset($_GET['cache']) && $_GET['cache'] === 'clear') {
		
		if (current_user_can('activate_plugins')) {
			
			sfs_delete_transients();
			sfs_create_transients();
			
		}
		
	}
	
}
add_action('init', 'sfs_clear_cache');



// reset stats (single site only)
function sfs_reset_stats() {
	
	global $wpdb;
	
	if ((isset($_GET['reset'])) && ($_GET['reset'] === 'true')) {
		
		if (current_user_can('activate_plugins')) {
			
			$truncate = $wpdb->query("TRUNCATE ". $wpdb->prefix ."simple_feed_stats");
			
			sfs_delete_transients();
			sfs_create_transients();
			
		}
		
	}
	
}
add_action('init', 'sfs_reset_stats');



// delete options (single site only)
function sfs_delete_options_on_deactivation() {
	
	global $sfs_options;
	
	if (isset($sfs_options['default_options']) && $sfs_options['default_options']) {
		
		delete_option('sfs_options');
		delete_option('sfs_alert');
		delete_option('sfs_version');
		
	}
	
}



// delete stats table (single site only)
function sfs_delete_table_on_deactivation() {
	
	global $sfs_options, $wpdb;
	
	if (isset($sfs_options['sfs_delete_table']) && $sfs_options['sfs_delete_table']) {
		
		$result = $wpdb->query("DROP TABLE ". $wpdb->prefix ."simple_feed_stats");
		
		sfs_delete_transients();
		
	}
	
}



// cron: add on activate (supports multisite network activate)
function sfs_cron_activation() {
	
	global $wpdb;
	
	if (is_multisite() && is_network_admin()) {
		
		$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		
		if ($blog_ids) {
			
			foreach ($blog_ids as $blog_id) {
				
				switch_to_blog($blog_id);
				
				if (!wp_next_scheduled('sfs_create_transients')) {
					
					wp_schedule_event(time(), 'twicedaily', 'sfs_create_transients');
					
				}
				
				restore_current_blog();
				
			}
			
		}
		
	} else {
		
		if (!wp_next_scheduled('sfs_create_transients')) {
			
			wp_schedule_event(time(), 'twicedaily', 'sfs_create_transients');
			
		}
		
	}
	
}
register_activation_hook(__FILE__, 'sfs_cron_activation');



// cron: remove on deactivate (supports multisite network activate)
function sfs_cron_cleanup() {
	
	global $wpdb;
	
	if (is_multisite() && is_network_admin()) {
		
		$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		
		if ($blog_ids) {
			
			foreach ($blog_ids as $blog_id) {
				
				switch_to_blog($blog_id);
				
				$timestamp = wp_next_scheduled('sfs_create_transients');
				
				wp_unschedule_event($timestamp,'sfs_create_transients');
				
				restore_current_blog();
				
			}
			
		}
		
	} else {
		
		$timestamp = wp_next_scheduled('sfs_create_transients');
		
		wp_unschedule_event($timestamp,'sfs_create_transients');
		
	}
	
}
register_deactivation_hook(__FILE__, 'sfs_cron_cleanup');



// delete transients
function sfs_delete_transients() {
	
	delete_transient('all_count');
	delete_transient('feed_count');
	delete_transient('rss2_count');
	delete_transient('comments_count');
	
	delete_transient('_transient_all_count');
	delete_transient('_transient_feed_count');
	delete_transient('_transient_rss2_count');
	delete_transient('_transient_comments_count');
	
	delete_transient('_transient_timeout_all_count');
	delete_transient('_transient_timeout_feed_count');
	delete_transient('_transient_timeout_rss2_count');
	delete_transient('_transient_timeout_comment_count');
	
}



// create transients
function sfs_create_transients() {
	
	global $sfs_options, $wpdb;
	
	$all_stats = $daily_stats = $rss2_stats = $comment_stats = 0;
	
	$count = (isset($sfs_options['sfs_strict_stats']) && $sfs_options['sfs_strict_stats']) ? 'COUNT(DISTINCT address)' : 'COUNT(*)';
	
	$table_name = $wpdb->prefix .'simple_feed_stats';
	
	$check_table = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
	
	if ($check_table === $table_name) {
		
		// all stats
		$all_stats_query = "SELECT ". $count ." FROM ". $table_name;
		
		$all_stats = $wpdb->get_row($all_stats_query, ARRAY_A);
		
		$all_stats = is_array($all_stats) ? $all_stats[$count] : 0;
		
		
		// daily stats
		$daily_stats_query = "SELECT ". $count ." FROM ". $table_name ." WHERE cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()";
		
		$daily_stats = $wpdb->get_row($daily_stats_query, ARRAY_A);
		
		$daily_stats = is_array($daily_stats) ? $daily_stats[$count] : 0;
		
		
		// daily stats RSS2 only
		$rss2_stats_query = "SELECT ". $count ." FROM ". $table_name ." WHERE type='RSS2' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()";
		
		$rss2_stats = $wpdb->get_row($rss2_stats_query, ARRAY_A);
		
		$rss2_stats = is_array($rss2_stats) ? $rss2_stats[$count] : 0;
		
		
		// daily comment stats
		$comment_stats_query = "SELECT ". $count ." FROM ". $table_name ." WHERE type='Comments' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()";
		
		$comment_stats = $wpdb->get_row($comment_stats_query, ARRAY_A);
		
		$comment_stats = is_array($comment_stats) ? $comment_stats[$count] : 0;
		
	}
	
	$duration = 60*60*24; // 12 hour cache 60*60*12 // 24 hour cache = 60*60*24
	
	set_transient('all_count',     $all_stats,     $duration);
	set_transient('feed_count',    $daily_stats,   $duration); 
	set_transient('rss2_count',    $rss2_stats,    $duration);
	set_transient('comment_count', $comment_stats, $duration);
	
}
add_action('sfs_create_transients', 'sfs_create_transients');



// query database for stats
function sfs_query_database($query) {
	
	global $sfs_options, $wpdb;
	
	$table = $wpdb->prefix .'simple_feed_stats';
	
	$count = (isset($sfs_options['sfs_strict_stats']) && $sfs_options['sfs_strict_stats']) ? 'COUNT(DISTINCT address)' : 'COUNT(*)';
	
	$range = ($query === 'current_stats') ? " AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()" : "";
	
	$rdf_query      = "SELECT ". $count ." FROM ". $table ." WHERE type='RDF'      ". $range;
	$rss2_query     = "SELECT ". $count ." FROM ". $table ." WHERE type='RSS2'     ". $range;
	$atom_query     = "SELECT ". $count ." FROM ". $table ." WHERE type='Atom'     ". $range;
	$comments_query = "SELECT ". $count ." FROM ". $table ." WHERE type='Comments' ". $range;
	$open_query     = "SELECT ". $count ." FROM ". $table ." WHERE type='Open'     ". $range;
	$other_query    = "SELECT ". $count ." FROM ". $table ." WHERE type='Other'    ". $range;
	
	$rdf = $wpdb->get_row($rdf_query, ARRAY_A);
	$rdf = is_array($rdf) ? $rdf[$count] : 0;
	
	$rss2 = $wpdb->get_row($rss2_query, ARRAY_A);
	$rss2 = is_array($rss2) ? $rss2[$count] : 0;
	
	$atom = $wpdb->get_row($atom_query, ARRAY_A);
	$atom = is_array($atom) ? $atom[$count] : 0;
	
	$comments = $wpdb->get_row($comments_query, ARRAY_A);
	$comments = is_array($comments) ? $comments[$count] : 0;
	
	$open = $wpdb->get_row($open_query, ARRAY_A);
	$open = is_array($open) ? $open[$count] : 0;
	
	$other = $wpdb->get_row($other_query, ARRAY_A);
	$other = is_array($other) ? $other[$count] : 0;
	
	$stats = array($rdf, $rss2, $atom, $comments, $open, $other);
	
	return $stats;
	
}
