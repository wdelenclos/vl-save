<?php // Simple Feed Stats - Admin Functions



// i18n
function sfs_i18n_init() {
	
	load_plugin_textdomain('simple-feed-stats', false, dirname(plugin_basename(SFS_PLUGIN_FILE)) .'/languages/');
	
}
add_action('plugins_loaded', 'sfs_i18n_init');



// whitelist settings
function sfs_init() {
	
	register_setting('sfs_plugin_options', 'sfs_options', 'sfs_validate_options');
	
}
add_action('admin_init', 'sfs_init');



// add the options page
function sfs_add_options_page() {
	
	add_options_page('Simple Feed Stats', 'Simple Feed Stats', 'manage_options', 'sfs-options', 'sfs_render_form');
	
}
add_action('admin_menu', 'sfs_add_options_page');



// display settings link on plugin page
function sfs_plugin_action_links($links, $file) {
	
	if ($file === plugin_basename(SFS_PLUGIN_FILE)) {
		
		$link = '<a href="'. get_admin_url() .'options-general.php?page=sfs-options">'. esc_html__('Settings', 'simple-feed-stats') .'</a>';
		
		array_unshift($links, $link);
		
	}
	
	return $links;
	
}



// rate plugin link
function add_sfs_links($links, $file) {
	
	if ($file === plugin_basename(SFS_PLUGIN_FILE)) {
		
		$href  = 'https://wordpress.org/support/plugin/simple-feed-stats/reviews/?rate=5#new-post';
		$title = esc_html__('Give us a 5-star rating at WordPress.org', 'simple-feed-stats');
		$text  = esc_html__('Rate this plugin', 'simple-feed-stats') .'&nbsp;&raquo;';
		
		$links[] = '<a target="_blank" rel="noopener noreferrer" href="'. $href .'" title="'. $title .'">'. $text .'</a>';
		
	}
	
	return $links;
	
}



// require minimum version
function sfs_require_wp_version() {
	
	global $sfs_wp_vers;
	
	if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
		
		$plugin      = plugin_basename(SFS_PLUGIN_FILE);
		$plugin_data = get_plugin_data(SFS_PLUGIN_PATH .'simple-feed-stats.php', false);
		$wp_version  = get_bloginfo('version');
		
		if (version_compare($wp_version, $sfs_wp_vers, '<')) {
			
			if (is_plugin_active($plugin)) {
				
				deactivate_plugins($plugin);
				
				$msg  = '<p><strong>'. $plugin_data['Name'] .'</strong> '. esc_html__('requires WordPress ', 'simple-feed-stats') . $sfs_wp_vers;
				$msg .= esc_html__(' or higher, and has been deactivated! ', 'simple-feed-stats');
				$msg .= esc_html__('Please upgrade WordPress and try again. Return to the', 'simple-feed-stats');
				$msg .= ' <a href="'. get_admin_url() .'update-core.php">'. esc_html__('WordPress Admin area', 'simple-feed-stats') .'</a>.</p>';
				
				wp_die($msg);
				
			}
			
		}
		
	}
	
}



// sfs table (supports multisite network activate)
function sfs_create_table() {
	
	global $wpdb;
	
	$charset_collate = $wpdb->get_charset_collate();
	$table_name      = $wpdb->prefix .'simple_feed_stats';
	$check_table     = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
	
	if ($check_table != $table_name) {
		
		$sql = "CREATE TABLE ". $table_name ." (
			id       mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			logtime  varchar(200)  NOT NULL DEFAULT '',
			request  varchar(200)  NOT NULL DEFAULT '',
			referer  varchar(200)  NOT NULL DEFAULT '',
			type     varchar(200)  NOT NULL DEFAULT '',
			qstring  varchar(200)  NOT NULL DEFAULT '',
			address  varchar(200)  NOT NULL DEFAULT '',
			tracking varchar(200)  NOT NULL DEFAULT '',
			agent    varchar(200)  NOT NULL DEFAULT '',
			PRIMARY KEY (id),
			cur_timestamp TIMESTAMP
		) ". $charset_collate .";";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
	}
	
}

function sfs_on_activate($network_wide) {
	
	global $wpdb;
	
	if (is_multisite() && $network_wide) {
		
		$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		
		foreach ($blog_ids as $blog_id) {
			
			switch_to_blog($blog_id);
			sfs_create_table();
			restore_current_blog();
			
		}
		
	} else {
		
		sfs_create_table();
		
	}
	
}

function sfs_on_create_blog($blog_id, $user_id, $domain, $path, $site_id, $meta) {
	
	if (is_plugin_active_for_network('simple-feed-stats/simple-feed-stats.php')) {
		
		switch_to_blog($blog_id);
		sfs_create_table();
		restore_current_blog();
		
	}
	
}
add_action('wpmu_new_blog', 'sfs_on_create_blog', 10, 6);

function sfs_on_delete_blog($tables) {
	
    global $wpdb;
    
    $tables[] = $wpdb->prefix .'simple_feed_stats';
    
    return $tables;
    
}
add_filter('wpmu_drop_tables', 'sfs_on_delete_blog');



// version control
function sfs_version_control() {
	
	global $sfs_version;
	
	$screen = get_current_screen();
	
	if ($screen->id !== 'settings_page_sfs-options') return;
	
	if (isset($_GET['sfs-alert']) && wp_verify_nonce($_GET['sfs-alert'], 'sfs-alert')) {
		
		if (isset($_GET['sfs_alert']) && $_GET['sfs_alert']) update_option('sfs_alert', 1);
		
	}
	
	$version_current  = intval($sfs_version);
	$version_previous = intval(get_option('sfs_version', $version_current));
	$sfs_alert        = get_option('sfs_alert', 0);
	
	if ($version_current > $version_previous) {
		
		update_option('sfs_version', $version_current);
		update_option('sfs_alert', 0);
		
	} else {
		
		update_option('sfs_version', $version_previous);
		update_option('sfs_alert', $sfs_alert);
		
	}
	
}
add_action('current_screen', 'sfs_version_control');



// default options
function sfs_default_options() {
	
	return array(
		'default_options'         => 0,
		'sfs_custom'              => '0', // string
		'sfs_custom_enable'       => 0,
		'sfs_number_results'      => '3',
		'sfs_tracking_method'     => 'sfs_default_tracking',
		'sfs_open_image_url'      => plugins_url('/simple-feed-stats/testing.gif'),
		'sfs_delete_table'        => 0,
		'sfs_feed_content_before' => '',
		'sfs_feed_content_after'  => '',
		'sfs_strict_stats'        => 0,
		'sfs_custom_key'          => 'custom_key',
		'sfs_custom_value'        => 'custom_value',
		'sfs_ignore_bots'         => 0,
		'sfs_enable_shortcodes'   => 0,
		'sfs_custom_styles'       => sfs_default_badge_styles(),
		'sfs_disable_ip'          => 0,
	);
	
}



// default badge styles
function sfs_default_badge_styles() {
	
	return '.sfs-subscriber-count, .sfs-count, .sfs-count span, .sfs-stats { -webkit-box-sizing: initial; -moz-box-sizing: initial; box-sizing: initial; }
.sfs-subscriber-count { width: 88px; overflow: hidden; height: 26px; color: #424242; font: 9px Verdana, Geneva, sans-serif; letter-spacing: 1px; }
.sfs-count { width: 86px; height: 17px; line-height: 17px; margin: 0 auto; background: #ccc; border: 1px solid #909090; border-top-color: #fff; border-left-color: #fff; }
.sfs-count span { display: inline-block; height: 11px; line-height: 12px; margin: 2px 1px 2px 2px; padding: 0 2px 0 3px; background: #e4e4e4; border: 1px solid #a2a2a2; border-bottom-color: #fff; border-right-color: #fff; }
.sfs-stats { font-size: 6px; line-height: 6px; margin: 1px 0 0 1px; word-spacing: 2px; text-align: center; text-transform: uppercase; }';
	
}



// define style options
function sfs_tracking_method_options() {
	
	return array(
		'sfs_disable_tracking' => array(
			'value' => 'sfs_disable_tracking',
			'label' => '<strong>'. esc_html__('Disable tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('disables all tracking', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('No data will be deleted when using this option.', 'simple-feed-stats') .'">?</span>',
		),
		'sfs_default_tracking' => array(
			'value' => 'sfs_default_tracking',
			'label' => '<strong>'. esc_html__('Default tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('tracks via feed requests', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Default setting. Recommended for most users.', 'simple-feed-stats') .'">?</span>',
		),
		'sfs_custom_tracking' => array(
			'value' => 'sfs_custom_tracking',
			'label' => '<strong>'. esc_html__('Custom tracking', 'simple-feed-stats') . '</strong> &ndash; <em>'. esc_html__('tracks via embedded post image', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Recommended if redirecting your feed to a service like FeedBurner.', 'simple-feed-stats') .'">?</span>'
		),
		'sfs_alt_tracking' => array(
			'value' => 'sfs_alt_tracking',
			'label' => '<strong>'. esc_html__('Alternate tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('tracks via embedded feed image', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Experimental tracking method. Use only for testing purposes.', 'simple-feed-stats') .'">?</span>'
		),
		'sfs_open_tracking' => array(
			'value' => 'sfs_open_tracking',
			'label' => '<strong>'. esc_html__('Open tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('open tracking via image', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Track any feed or web page by using the open-tracking URL as the src for any image. Tip: this is a good way to track FeedBurner summary feeds. Visit m0n.co/a for details.', 'simple-feed-stats') .'">?</span>'
		),
	);
	
}



// sanitize and validate input
function sfs_validate_options($input) {
	
	if (!isset($input['sfs_custom_enable'])) $input['sfs_custom_enable'] = null;
	$input['sfs_custom_enable'] = ($input['sfs_custom_enable'] == 1 ? 1 : 0);

	if (!isset($input['sfs_delete_table'])) $input['sfs_delete_table'] = null;
	$input['sfs_delete_table'] = ($input['sfs_delete_table'] == 1 ? 1 : 0);

	if (!isset($input['sfs_strict_stats'])) $input['sfs_strict_stats'] = null;
	$input['sfs_strict_stats'] = ($input['sfs_strict_stats'] == 1 ? 1 : 0);

	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);
	
	if (!isset($input['sfs_ignore_bots'])) $input['sfs_ignore_bots'] = null;
	$input['sfs_ignore_bots'] = ($input['sfs_ignore_bots'] == 1 ? 1 : 0);
	
	if (!isset($input['sfs_enable_shortcodes'])) $input['sfs_enable_shortcodes'] = null;
	$input['sfs_enable_shortcodes'] = ($input['sfs_enable_shortcodes'] == 1 ? 1 : 0);
	
	if (!isset($input['sfs_disable_ip'])) $input['sfs_disable_ip'] = null;
	$input['sfs_disable_ip'] = ($input['sfs_disable_ip'] == 1 ? 1 : 0);
	
	if (!isset($input['sfs_tracking_method'])) $input['sfs_tracking_method'] = null;
	if (!array_key_exists($input['sfs_tracking_method'], sfs_tracking_method_options())) $input['sfs_tracking_method'] = null;

	$input['sfs_custom']         = wp_filter_nohtml_kses($input['sfs_custom']);
	$input['sfs_number_results'] = wp_filter_nohtml_kses($input['sfs_number_results']);
	$input['sfs_open_image_url'] = wp_filter_nohtml_kses($input['sfs_open_image_url']);
	$input['sfs_custom_key']     = wp_filter_nohtml_kses($input['sfs_custom_key']);
	$input['sfs_custom_value']   = wp_filter_nohtml_kses($input['sfs_custom_value']);
	
	$input['sfs_custom_styles'] = wp_strip_all_tags($input['sfs_custom_styles']);
	
	$input['sfs_feed_content_before'] = wp_kses_post($input['sfs_feed_content_before']);
	$input['sfs_feed_content_after']  = wp_kses_post($input['sfs_feed_content_after']);

	return $input;
	
}



// sfs dashboard widget 
function sfs_dashboard_widget() {
	
	$sfs_query_current = sfs_query_database('current_stats'); ?>

	<style type="text/css">
		.sfs-table table { border-collapse: collapse; }
		.sfs-table th { font-size: 12px; }
		.sfs-table td { 
			display: table-cell; vertical-align: middle; padding: 10px; color: #555; border: 1px solid #dfdfdf;
			text-align: left; text-shadow: 1px 1px 1px #fff; font: bold 18px/18px Georgia, serif; 
			}
			.sfs-table .rdf      { background-color: #d9e8f9; }
			.sfs-table .rss2     { background-color: #d5f2d5; }
			.sfs-table .atom     { background-color: #fafac0; }
			.sfs-table .comments { background-color: #fee6cc; }
	</style>
	<p><?php esc_html_e('Current Subscriber Count', 'simple-feed-stats'); ?>: <strong><?php sfs_display_subscriber_count(); ?></strong></p>
	<div class="sfs-table">
		<table class="widefat">
			<thead>
				<tr>
					<th><?php esc_html_e('RDF',      'simple-feed-stats'); ?></th>
					<th><?php esc_html_e('RSS2',     'simple-feed-stats'); ?></th>
					<th><?php esc_html_e('Atom',     'simple-feed-stats'); ?></th>
					<th><?php esc_html_e('Comments', 'simple-feed-stats'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="rdf"><?php      echo $sfs_query_current[0]; ?></td>
					<td class="rss2"><?php     echo $sfs_query_current[1]; ?></td>
					<td class="atom"><?php     echo $sfs_query_current[2]; ?></td>
					<td class="comments"><?php echo $sfs_query_current[3]; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<p><a href="<?php get_admin_url(); ?>options-general.php?page=sfs-options"><?php esc_html_e('More stats, tools, and options &raquo;', 'simple-feed-stats'); ?></a></p>

<?php }

function add_custom_dashboard_widget() {
	
	wp_add_dashboard_widget('sfs_dashboard_widget', 'Simple Feed Stats', 'sfs_dashboard_widget');
	
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');



// plugin settings page
function sfs_render_form() {
	
	global $wpdb, $sfs_options, $sfs_version;
	
	$sfs_query_current = sfs_query_database('current_stats'); 
	$sfs_query_alltime = sfs_query_database('alltime_stats');
	
	$numresults = (isset($sfs_options['sfs_number_results']) && is_numeric($sfs_options['sfs_number_results'])) ? intval($sfs_options['sfs_number_results']) : 3;
	
	$pagevar = (isset($_GET['p']) && is_numeric($_GET['p'])) ? intval($_GET['p']) : 1;
	
	$jump = (isset($_GET['jump']) && is_numeric($_GET['jump'])) ? intval($_GET['jump']) : null;
	
	$pagevar = $jump ? $jump : $pagevar;
	
	$offset = abs($pagevar - 1) * $numresults;
	
	$numrows = $wpdb->get_row("SELECT COUNT(*) FROM ". $wpdb->prefix ."simple_feed_stats", ARRAY_A);
	
	$numrows = is_array($numrows) ? $numrows['COUNT(*)'] : 'undefined';
	
	$maxpage = ceil($numrows / $numresults);
	
	if (isset($_GET['filter']) && !empty($_GET['filter'])) {
		
		$sql = '';
		
		$filter = sfs_clean($_GET['filter']);
		
		if ($filter === 'logtime' || $filter === 'type' || $filter === 'address' || $filter === 'agent' || $filter === 'tracking' || $filter === 'referer') {  
			  
			$sql = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."simple_feed_stats ORDER BY $filter ASC LIMIT %d, %d", $offset, $numresults)); // bug? can't use %s for $filter
			
		}
		
	} else {
		
		$sql = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."simple_feed_stats ORDER BY id DESC LIMIT %d, %d", $offset, $numresults));
		
	}
	
	$display_alert = boolval(get_option('sfs_alert', 0)) ? 'style="display:none;" ' : 'style="display:block;" ';
	
	?>
	
	<style type="text/css">
		.sfs-admin h1 small { line-height: 12px; font-size: 12px; color: #bbb; }
		.js .sfs-admin .postbox h2 { margin: 0; padding: 12px 0 12px 15px; font-size: 16px; cursor: pointer; }
		
		.dismiss-alert { margin: 15px 0 0 0; }
		.dismiss-alert-wrap { display: inline-block; padding: 7px 0 10px 0; }
		.dismiss-alert .description { display: inline-block; margin: -2px 15px 0 0; }
		
		.toggle { padding: 0 15px 15px 15px; }
		.toggle.sfs-overview {
			padding: 0 15px 20px 130px;
			background-image: url(<?php echo plugins_url('/simple-feed-stats/sfs-logo.jpg'); ?>); 
			background-repeat: no-repeat; background-position: 0 0; background-size: 120px 131px;
			}
		.toggle.sfs-overview p { margin: 0; }
		.toggle.toggle-support { padding: 0 15px 0 0; }
		.toggle.toggle-support p { margin-left: 15px; }
		
		.sfs-menu-item { float: left; margin: 12px 12px 12px 0; }
		.sfs-sub-item { display: inline-block; }
		.sfs-menu-row { margin: 12px 0 0 0; }
		
		.sfs-admin h3 { margin: 20px 0; font-size: 14px; }
		.sfs-admin ul { margin: 15px 15px 15px 40px; clear: both; }
		.sfs-admin li { margin: 8px 0; list-style-type: disc; }
		
		.sfs-table table { border-collapse: collapse; }
		.sfs-table th { font-size: 13px; }
		.sfs-table td { padding: 5px 10px; color: #555; border: 1px solid #dfdfdf; font: 12px/18px 'Proxima Nova Regular', 'Helvetica Neue', Helvetica, Arial, sans-serif; }
		.sfs-table .form-table td { padding: 10px; border: none; }
		.sfs-table .form-table th { padding: 10px 10px 10px 0; }
		.sfs-open-tracking-url, .sfs-open-tracking-image { background-color: #efefef; }
		
		.rdf      { background-color: #d9e8f9; }
		.rss2     { background-color: #d5f2d5; }
		.atom     { background-color: #fafac0; }
		.comments { background-color: #fee6cc; }
		.open     { background-color: #ffe3e3; }
		.other    { background-color: #efefef; }
		
		.sfs-statistics div { margin: 5px; }
		.sfs-statistics .sfs-type { padding: 0 12px; text-align: center; }
		.sfs-table .sfs-type { display: table-cell; vertical-align: middle; padding: 12px; text-align: left; text-shadow: 1px 1px 1px #fff; font: bold 20px/20px Georgia, serif; }
		.sfs-meta, .sfs-details { font-size: 12px; }
		.sfs-meta div { margin: 3px 5px; }
		.sfs-stats-type { font-size: 12px; font-weight: bold; }
		.sfs-stats-type span { color: #777; font-size: 11px; font-weight: normal; }
		
		.sfs-radio { margin: 5px 0; }
		.sfs-table-item { margin: 0 0 10px 0; }
		.sfs-admin textarea.code, .sfs-table input[type="text"] { padding: 6px; color: #777; font-size: 12px; }
		.sfs-admin input[type="checkbox"] { margin-top: -2px; }
		.sfs-last-item { margin: 24px 0 0 0; }
		
		.tooltip { 
			cursor: help; display: inline-block; width: 18px; height: 18px; margin: 0 0 0 4px; text-align: center; font: bold 12px/18px Georgia, serif;
			border: 2px solid #fff; color: #fff; background-color: #b0c6d0; -webkit-border-radius: 18px; -moz-border-radius: 18px; border-radius: 18px;
			-webkit-box-shadow: 0 0 1px rgba(0,0,0,0.3); -moz-box-shadow: 0 0 1px rgba(0,0,0,0.3); box-shadow: 0 0 1px rgba(0,0,0,0.3); 
			}
			.tooltip:hover { background-color: #0073aa; }
			
		#easyTooltip { 
			max-width: 310px; padding: 15px; font-size: 13px; line-height: 18px; border: 1px solid #96c2d5; background-color: #fdfdfd; 
			-webkit-box-shadow: 7px 7px 7px -1px rgba(0,0,0,0.3); -moz-box-shadow: 7px 7px 7px -1px rgba(0,0,0,0.3); box-shadow: 7px 7px 7px -1px rgba(0,0,0,0.3);
			}
			#easyTooltip code { padding: 2px 3px; line-height: 0; font-size: 90%; }
		
		.sfs-credits { margin-top: -10px; font-size: 12px; line-height: 18px; color: #777; }
		
		.sfs-subscriber-count { width: 88px; overflow: hidden; height: 26px; color: #424242; font: 9px Verdana, Geneva, sans-serif; letter-spacing: 1px; }
		.sfs-count { width: 86px; height: 17px; line-height: 17px; margin: 0 auto; background: #ccc; border: 1px solid #909090; border-top-color: #fff; border-left-color: #fff; }
		.sfs-count span { display: inline-block; height: 11px; line-height: 12px; margin: 2px 1px 2px 2px; padding: 0 2px 0 3px; background: #e4e4e4; border: 1px solid #a2a2a2; border-bottom-color: #fff; border-right-color: #fff; }
		.sfs-stats { font-size: 6px; line-height: 6px; margin: 1px 0 0 1px; word-spacing: 2px; text-align: center; text-transform: uppercase; }
		.current-page { margin: 0 2px 0 0; padding-top: 5px; padding-bottom: 5px; font-size: 13px; text-align: center; }
		.total-pages { display: inline-block; margin: 0 2px 0 0; }
	</style>

	<div class="wrap sfs-admin">
		<h1><?php esc_html_e('Simple Feed Stats', 'simple-feed-stats'); ?> <small><?php echo 'v'. $sfs_version; ?></small></h1>
		
		<?php if (isset($_GET['cache'])) : ?>
		<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e('Cache cleared', 'simple-feed-stats'); ?>.</strong></p></div>
		<?php endif; ?>
		
		<?php if (isset($_GET['reset'])) : ?>
		<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e('All feed stats deleted', 'simple-feed-stats'); ?>.</strong></p></div>
		<?php endif; ?>
		
		<div class="sfs-toggle-panels"><a href="<?php get_admin_url() .'options-general.php?page=sfs-options'; ?>"><?php esc_html_e('Toggle all panels', 'simple-feed-stats'); ?></a></div>
		
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				
				<div <?php echo $display_alert; ?>class="postbox">
					<h2><?php esc_html_e('Simple Feed Stats needs your support!', 'simple-feed-stats'); ?></h2>
					<div class="toggle">
						<div class="mm-panel-alert">
							<p>
								<?php esc_html_e('Please', 'simple-feed-stats'); ?> 
								<a target="_blank" rel="noopener noreferrer" href="https://monzillamedia.com/donate.html" title="<?php esc_attr_e('Make a donation via PayPal', 'simple-feed-stats'); ?>"><?php esc_html_e('make a donation', 'simple-feed-stats'); ?></a> 
								<?php esc_html_e('and/or', 'simple-feed-stats'); ?> 
								<a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/support/plugin/simple-feed-stats/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'simple-feed-stats'); ?>"><?php esc_html_e('give it a 5-star rating', 'simple-feed-stats'); ?>&nbsp;&raquo;</a>
							</p>
							<p><?php esc_html_e('Your generous support enables continued development of this free plugin. Thank you!', 'simple-feed-stats'); ?></p>
							<div class="dismiss-alert">
								<form action="">
									<div class="dismiss-alert-wrap">
										<input class="input-alert" name="sfs_alert" type="checkbox" value="1" /> 
										<label class="description" for="sfs_alert"><?php esc_html_e('Check this box if you have shown support', 'simple-feed-stats') ?></label>
										<input type="hidden" name="page" value="sfs-options" />
										<?php wp_nonce_field('sfs-alert', 'sfs-alert', false); ?>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<div class="postbox">
					<h2><?php esc_html_e('Overview', 'simple-feed-stats'); ?></h2>
					<div class="toggle sfs-overview<?php if (isset($_GET['settings-updated']) || isset($_GET['cache']) || isset($_GET['filter']) || isset($_GET['jump']) || isset($_GET['reset']) || isset($_GET['p'])) echo ' default-hidden'; ?>">
						<p>
							<?php esc_html_e('Simple Feed Stats tracks your feeds, adds custom content, and displays your feed statistics on your site.', 'simple-feed-stats'); ?> 
							<?php esc_html_e('SFS tracks your feeds automatically and displays the statistics on this page and via the Dashboard widget.', 'simple-feed-stats'); ?> 
						</p>
						<ul>
							<li><a class="sfs-options-link" href="#sfs_custom-options"><?php esc_html_e('Plugin Settings', 'simple-feed-stats'); ?></a></li>
							<li><a class="sfs-shortcodes-link" href="#sfs-shortcodes"><?php esc_html_e('Shortcodes &amp; Template Tags', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/simple-feed-stats/"><?php esc_html_e('Plugin Homepage', 'simple-feed-stats'); ?>&nbsp;&raquo;</a>
							</li>
						</ul>
						<p>
							<?php esc_html_e('If you like this plugin, please', 'simple-feed-stats'); ?> 
							<a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/support/plugin/simple-feed-stats/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'simple-feed-stats'); ?>"><?php esc_html_e('give it a 5-star rating', 'simple-feed-stats'); ?>&nbsp;&raquo;</a>
						</p>
					</div>
				</div>
				
				
				
				<?php if ($maxpage != 0) : ?>

				<div class="postbox">
					<h2><?php esc_html_e('Daily Stats', 'simple-feed-stats'); ?>: <?php sfs_display_subscriber_count(); ?></h2>
					<div class="toggle default-hidden">
						<p>
							<strong><?php esc_html_e('Daily feed statistics', 'simple-feed-stats'); ?></strong> 
							<span class="tooltip" title="<?php 
								esc_attr_e('Count totals are cached and updated every 12 hours for better performance. ', 'simple-feed-stats');
								esc_attr_e('So the count total may not always equal the sum of the individual counts, which are reported in real-time. ', 'simple-feed-stats');
								esc_attr_e('Tip: to get the numbers to match up, you can manually clear the cache via the &ldquo;Plugin Settings&rdquo; panel.', 'simple-feed-stats');
								?>">?</span>
						</p>
						<div class="sfs-table">
							<table class="widefat">
								<thead>
									<tr>
										<th><?php esc_html_e('RDF',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('RSS2',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Atom',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Comments', 'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Open',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Other',    'simple-feed-stats'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="sfs-type rdf"><?php      echo esc_attr($sfs_query_current[0]); ?></td>
										<td class="sfs-type rss2"><?php     echo esc_attr($sfs_query_current[1]); ?></td>
										<td class="sfs-type atom"><?php     echo esc_attr($sfs_query_current[2]); ?></td>
										<td class="sfs-type comments"><?php echo esc_attr($sfs_query_current[3]); ?></td>
										<td class="sfs-type open"><?php     echo esc_attr($sfs_query_current[4]); ?></td>
										<td class="sfs-type other"><?php    echo esc_attr($sfs_query_current[5]); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<?php endif; ?>
				
				
				
				<div class="postbox">
					<h2><?php esc_html_e('Total Stats', 'simple-feed-stats'); ?>: <?php sfs_display_total_count(); ?></h2>
					<div class="toggle default-hidden">
						<p>
							<strong><?php esc_html_e('Total feed statistics', 'simple-feed-stats'); ?></strong> 
							<span class="tooltip" title="<?php 
								esc_attr_e('Count totals are cached and updated every 12 hours for better performance. ', 'simple-feed-stats');
								esc_attr_e('So the count total may not always equal the sum of the individual counts, which are reported in real-time. ', 'simple-feed-stats');
								esc_attr_e('Tip: to get the numbers to match up, you can manually clear the cache via the &ldquo;Plugin Settings&rdquo; panel. ', 'simple-feed-stats');
								?>">?</span>
						</p>
						<div class="sfs-table">
							<table class="widefat">
								<thead>
									<tr>
										<th><?php esc_html_e('RDF',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('RSS2',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Atom',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Comments', 'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Open',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Other',    'simple-feed-stats'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="sfs-type rdf"><?php      echo esc_attr($sfs_query_alltime[0]); ?></td>
										<td class="sfs-type rss2"><?php     echo esc_attr($sfs_query_alltime[1]); ?></td>
										<td class="sfs-type atom"><?php     echo esc_attr($sfs_query_alltime[2]); ?></td>
										<td class="sfs-type comments"><?php echo esc_attr($sfs_query_alltime[3]); ?></td>
										<td class="sfs-type open"><?php     echo esc_attr($sfs_query_alltime[4]); ?></td>
										<td class="sfs-type other"><?php    echo esc_attr($sfs_query_alltime[5]); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				
				
				<?php if ($maxpage != 0) : ?>
				
				<div class="postbox">
					<h2><?php esc_html_e('Subscriber Info', 'simple-feed-stats'); ?></h2>
					<div class="toggle<?php if (!isset($_GET['filter']) && !isset($_GET['jump']) && !isset($_GET['p'])) echo ' default-hidden'; ?>">
	
						<?php if (isset($_GET['filter']) && !empty($_GET['filter'])) : ?>
						<div class="sfs-menu-row">
							<?php esc_html_e('Subscriber info filtered by', 'simple-feed-stats'); ?> <strong><?php echo sanitize_text_field($filter); ?></strong> 
							[ <a href="<?php echo get_admin_url(); ?>options-general.php?page=sfs-options"><?php esc_html_e('reset', 'simple-feed-stats'); ?></a> ]
						</div>
						<?php endif; ?>
						
						<div class="sfs-menu-item">
							<form class="sfs-sub-item" action="">
								<select name="filter">
									<option value="" selected="selected"><?php esc_html_e('Filter data by..', 'simple-feed-stats'); ?></option>
									<option value="logtime"><?php  esc_html_e('Log Time',   'simple-feed-stats'); ?></option>
									<option value="type"><?php     esc_html_e('Feed Type',  'simple-feed-stats'); ?></option>
									<option value="address"><?php  esc_html_e('IP Address', 'simple-feed-stats'); ?></option>
									<option value="agent"><?php    esc_html_e('User Agent', 'simple-feed-stats'); ?></option>
									<option value="tracking"><?php esc_html_e('Tracking',   'simple-feed-stats'); ?></option>
									<option value="referer"><?php  esc_html_e('Referrer',   'simple-feed-stats'); ?></option>
								</select>
								<input type="hidden" name="page" value="sfs-options">
								<input class="button" type="submit">
							</form>
						</div>
						<div class="sfs-menu-item">
							<?php if ($pagevar != 1) {
								$url = add_query_arg(array('page' => 'sfs-options', 'p' => $pagevar - 1), get_admin_url() .'options-general.php');
								echo '<a class="sfs-sub-item button" href="'. esc_url($url) .'">&laquo; '. esc_html__('Previous', 'simple-feed-stats') .'</a> ';
							} ?> 
							<form class="sfs-sub-item" action="">
								<input type="hidden" name="page" value="sfs-options">
								<input class="current-page" name="jump" type="text" size="3" value="<?php echo esc_attr($pagevar); ?>"> 
								<span class="total-pages"><?php echo esc_html__('of', 'simple-feed-stats') .' '. esc_html($maxpage); ?></span>
							</form> 
							<?php if ($pagevar != $maxpage) {
								$url = add_query_arg(array('page' => 'sfs-options', 'p' => $pagevar + 1), get_admin_url() .'options-general.php');
								echo '<a class="sfs-sub-item button" href="'. esc_url($url) .'">'. esc_html__('Next', 'simple-feed-stats') .' &raquo;</a> ';
							} ?>
						</div>
						<div class="sfs-table sfs-statistics">
							<table class="widefat">
								<thead>
									<tr>
										<th><?php esc_html_e('ID',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Meta',    'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Details', 'simple-feed-stats'); ?></th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th><?php esc_html_e('ID',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Meta',    'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Details', 'simple-feed-stats'); ?></th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach($sql as $s) { ?>
									<tr>
										<td class="sfs-type <?php echo esc_attr(strtolower($s->type)); ?>"><?php echo sanitize_text_field($s->id); ?></td>
										<td class="sfs-meta">
											<div class="sfs-stats-type"><?php echo sanitize_text_field($s->type); ?></div>
											<div class="sfs-stats-tracking"><?php echo sanitize_text_field(ucfirst($s->tracking)) .'&nbsp;'. esc_html__('tracking', 'simple-feed-stats'); ?></div>
											<div class="sfs-stats-ip"><?php echo sanitize_text_field($s->address); ?></div>
											<div class="sfs-stats-time"><?php $logtime = preg_replace('/\s+/', '&nbsp;', $s->logtime); echo sanitize_text_field($logtime); ?></div>
										</td>
										<td class="sfs-details">
											<div class="sfs-stats-referrer"><strong><?php esc_html_e('Referrer',   'simple-feed-stats'); ?>:</strong> <?php echo sanitize_text_field($s->referer); ?></div>
											<div class="sfs-stats-request"><strong><?php  esc_html_e('Request',    'simple-feed-stats'); ?>:</strong> <?php echo sanitize_text_field($s->request); ?></div>
											<div class="sfs-stats-agent"><strong><?php    esc_html_e('User Agent', 'simple-feed-stats'); ?>:</strong> <?php echo sanitize_text_field($s->agent);   ?></div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php endif; ?>
				
				
				
				<div id="sfs_custom-options" class="postbox">
					<h2><?php esc_html_e('Plugin Settings', 'simple-feed-stats'); ?></h2>
					<div class="toggle<?php if (!isset($_GET['cache']) && !isset($_GET['reset']) && !isset($_GET['settings-updated'])) echo ' default-hidden'; ?>">
						<form method="post" action="options.php">
							<?php settings_fields('sfs_plugin_options'); ?>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_tracking_method]"><?php esc_html_e('Tracking method', 'simple-feed-stats'); ?></label></th>
										<td>
											<?php if (!isset($checked)) $checked = '';
												foreach (sfs_tracking_method_options() as $option) {
													$radio_setting = $sfs_options['sfs_tracking_method'];
													if ('' != $radio_setting) {
														if ($sfs_options['sfs_tracking_method'] == $option['value']) {
															$checked = "checked=\"checked\"";
														} else {
															$checked = '';
														}
													} ?>
													<div class="sfs-radio">
														<input type="radio" name="sfs_options[sfs_tracking_method]" class="sfs-<?php if ($option['value'] == 'sfs_open_tracking') echo 'open-'; ?>tracking" value="<?php echo esc_attr($option['value']); ?>" <?php echo $checked; ?> /> 
														<?php echo $option['label']; ?>
													</div>
											<?php } ?>
										</td>
									</tr>
									<tr class="sfs-open-tracking-url<?php if ($sfs_options['sfs_tracking_method'] !== 'sfs_open_tracking') echo ' default-hidden'; ?>">
										<th scope="row"><label class="description"><?php esc_html_e('Open Tracking URL', 'simple-feed-stats'); ?></label></th>
										<td>
											<div class="sfs-table-item">
												<?php esc_html_e('For use with the &ldquo;Open Tracking&rdquo; method. Use this tracking URL as the', 'simple-feed-stats'); ?> 
												<code>src</code> <?php esc_html_e('for any', 'simple-feed-stats'); ?> <code>img</code>: 
												<span class="tooltip" title="<?php esc_attr_e('Important: any ampersands in the tracking URL must be encoded as HTML entities.', 'simple-feed-stats'); ?>">?</span>
											</div>
											<div class="sfs-table-item">
												<input class="sfs-code-input regular-text" type="text" value="<?php echo plugins_url('/simple-feed-stats/tracker.php?sfs_tracking=true&amp;amp;sfs_type=open'); ?>" />
											</div>
											<div class="sfs-table-item">
												<?php esc_html_e('Example code:', 'simple-feed-stats'); ?> 
											</div>
											<div class="sfs-table-item">
												<input class="sfs-code-input regular-text" type="text" value='&lt;img src="<?php echo plugins_url('/simple-feed-stats/tracker.php?sfs_tracking=true&amp;amp;sfs_type=open'); ?>" alt="" /&gt;' />
											</div>
										</td>
									</tr>
									<tr class="sfs-open-tracking-image<?php if ($sfs_options['sfs_tracking_method'] !== 'sfs_open_tracking') echo ' default-hidden'; ?>">
										<th scope="row"><label class="description" for="sfs_options[sfs_open_image_url]"><?php esc_html_e('Open Tracking Image', 'simple-feed-stats'); ?></label></th>
										<td>
											<div class="sfs-table-item">
												<?php esc_html_e('For use with the &ldquo;Open Tracking&rdquo; method. Here you may specify the URL for the tracking image:', 'simple-feed-stats'); ?> 
												<span class="tooltip" title="<?php esc_attr_e('Tip: change the name of the image to tracker.gif to use a transparent 1x1 pixel image.', 'simple-feed-stats'); ?>">?</span>
											</div>
											<div class="sfs-table-item">
												<input class="sfs-code-input regular-text" type="text" maxlength="200" name="sfs_options[sfs_open_image_url]" value="<?php echo esc_attr($sfs_options['sfs_open_image_url']); ?>" />
											</div>
											<div class="sfs-table-item">
												<?php esc_html_e('Current image being used for Open Tracking:', 'simple-feed-stats'); ?> 
												<img src="<?php echo esc_attr($sfs_options['sfs_open_image_url']); ?>" alt="" />
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_strict_stats]"><?php esc_html_e('Strict reporting', 'simple-feed-stats'); ?></label></th>
										<td><input name="sfs_options[sfs_strict_stats]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_strict_stats'])) checked($sfs_options['sfs_strict_stats']); ?> /> 
											<?php esc_html_e('Enable strict reporting of feed statistics', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('This will result in a more accurate reporting of feed stats;', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('however, if you have been using SFS for awhile, you may notice that the feed count is lower with this option enabled.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Tip: after changing this option, click the &ldquo;Clear the cache&rdquo; link below to reset the cache.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_ignore_bots]"><?php esc_html_e('Ignore bots', 'simple-feed-stats'); ?></label></th>
										<td><input name="sfs_options[sfs_ignore_bots]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_ignore_bots'])) checked($sfs_options['sfs_ignore_bots']); ?> /> 
											<?php esc_html_e('Ignore feed requests from the most common bots', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('This will result in a more accurate reporting of feed stats;', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('however, if you have been using SFS for awhile, you may notice that the feed count is lower with this option enabled.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Tip: the bot list for this feature may be customized via the hook, sfs_filter_bots.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_disable_ip]"><?php esc_html_e('Disable IP', 'simple-feed-stats'); ?></label></th>
										<td><input name="sfs_options[sfs_disable_ip]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_disable_ip'])) checked($sfs_options['sfs_disable_ip']); ?> /> 
											<?php esc_html_e('Disable collection of all IP address data', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('When this setting is enabled, no IP address data will be collected.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('This is useful for things like GDPR compliance.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom]"><?php esc_html_e('Custom count', 'simple-feed-stats'); ?></label></th>
										<td>
											<input type="text" size="20" maxlength="100" name="sfs_options[sfs_custom]" value="<?php echo esc_attr($sfs_options['sfs_custom']); ?>" /> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: use this feature for a day or so after resetting the feed stats (check the next box to enable).', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom_enable]"><?php esc_html_e('Enable custom count', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[sfs_custom_enable]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_custom_enable'])) checked($sfs_options['sfs_custom_enable']); ?> /> 
											<?php esc_html_e('Display your custom feed count instead of the recorded value', 'simple-feed-stats'); ?>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom_key]"><?php esc_html_e('Custom key/value', 'simple-feed-stats'); ?></label></th>
										<td>
											<div class="sfs-table-item">
												<input type="text" size="20" maxlength="100" name="sfs_options[sfs_custom_key]" value="<?php echo esc_attr($sfs_options['sfs_custom_key']); ?>" /> 
												<label class="description" for="sfs_options[sfs_custom_key]"><?php esc_html_e('Custom key', 'simple-feed-stats'); ?></label> 
												<span class="tooltip" title="<?php esc_attr_e('Add custom key/value parameter for either &ldquo;custom&rdquo; or &ldquo;alt&rdquo; tracking methods.', 'simple-feed-stats'); ?> 
												<?php esc_html_e('Important: include only alphanumeric characters, underscores, and hyphens. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
												<br />
												<input type="text" size="20" maxlength="100" name="sfs_options[sfs_custom_value]" value="<?php echo esc_attr($sfs_options['sfs_custom_value']); ?>" /> 
												<label class="description" for="sfs_options[sfs_custom_value]"><?php esc_html_e('Custom value', 'simple-feed-stats'); ?></label> 
												<span class="tooltip" title="<?php esc_attr_e('Including a custom key/value in the tracking URL can be used with 3rd-party services such as Google Analytics.', 'simple-feed-stats'); ?> 
												<?php esc_html_e('This feature will be extended in future versions, send feedback with any requests.', 'simple-feed-stats'); ?>">?</span>
											</div>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_enable_shortcodes]"><?php esc_html_e('Enable Widget Shortcodes', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[sfs_enable_shortcodes]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_enable_shortcodes'])) checked($sfs_options['sfs_enable_shortcodes']); ?> /> 
											<?php esc_html_e('Enable shortcodes in widget areas and post content', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('By default, WordPress does not enable shortcodes in widgets.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('This setting enables shortcodes to work when they are added to widgets, and also ensures that shortcodes will work when they are added to post/page content.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Note: this setting applies to any/all shortcodes, even those of other plugins.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_number_results]"><?php esc_html_e('Number of results per page', 'simple-feed-stats'); ?></label></th>
										<td>
											<input type="number" min="1" max="999" name="sfs_options[sfs_number_results]" value="<?php echo esc_attr($sfs_options['sfs_number_results']); ?>" /> 
											<?php esc_html_e('Applies to &ldquo;Subscriber Info&rdquo; panel on this page', 'simple-feed-stats'); ?>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom_styles]"><?php esc_html_e('Custom CSS for count badge', 'simple-feed-stats'); ?></label></th>
										<td>
											<textarea class="large-text code" cols="50" rows="3" name="sfs_options[sfs_custom_styles]"><?php echo esc_textarea($sfs_options['sfs_custom_styles']); ?></textarea><br />
											<?php esc_html_e('CSS/text only, no markup', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: see the &ldquo;Shortcodes &amp; Template Tags&rdquo; panel for count-badge shortcode and template tag.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Default styles replicate the FeedBurner chicklet. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_feed_content_before]"><?php esc_html_e('Display before each feed item', 'simple-feed-stats'); ?></label></th>
										<td>
											<textarea class="large-text code" cols="50" rows="3" name="sfs_options[sfs_feed_content_before]"><?php echo esc_textarea($sfs_options['sfs_feed_content_before']); ?></textarea><br />
											<?php esc_html_e('Text and basic markup allowed', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: you can has shortcodes. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_feed_content_after]"><?php esc_html_e('Display after each feed item', 'simple-feed-stats'); ?></label></th>
										<td>
											<textarea class="large-text code" cols="50" rows="3" name="sfs_options[sfs_feed_content_after]"><?php echo esc_textarea($sfs_options['sfs_feed_content_after']); ?></textarea><br />
											<?php esc_html_e('Text and basic markup allowed', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: you can has shortcodes. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description"><?php esc_html_e('Clear the cache', 'simple-feed-stats'); ?></label></th>
										<td>
											<strong><a href="<?php get_admin_url(); ?>options-general.php?page=sfs-options&amp;cache=clear"><?php esc_html_e('Clear cache', 'simple-feed-stats'); ?></a></strong> 
											<span class="tooltip" title="<?php esc_attr_e('Note: it is safe to clear the cache at any time. WordPress automatically will cache fresh data.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description"><?php esc_html_e('Reset feed stats', 'simple-feed-stats'); ?></label></th>
										<td>
											<strong><a class="reset" href="<?php get_admin_url(); ?>options-general.php?page=sfs-options&amp;reset=true"><?php esc_html_e('Reset stats', 'simple-feed-stats'); ?></a></strong> 
											<span class="tooltip" title="<?php esc_attr_e('Warning: this will delete all feed stats! Note: deletes data only, not options.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><label class="description" for="sfs_options[default_options]"><?php esc_html_e('Restore default settings', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[default_options]" type="checkbox" value="1" id="sfs_restore_defaults" <?php if (isset($sfs_options['default_options'])) { checked('1', $sfs_options['default_options']); } ?> /> 
											<?php esc_html_e('Restore default options upon plugin deactivation/reactivation', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: leave this setting unchecked to keep your options if the plugin is deactivated.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Note: this setting applies to plugin options only, does not affect feed stats.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><label class="description" for="sfs_options[sfs_delete_table]"><?php esc_html_e('Delete database table', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[sfs_delete_table]" type="checkbox" value="1" id="sfs_delete_table" <?php if (isset($sfs_options['sfs_delete_table'])) { checked('1', $sfs_options['sfs_delete_table']); } ?> /> 
											<?php esc_html_e('Delete the stats table the next time plugin is deactivated', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: leave this setting unchecked to keep your feed stats if the plugin is deactivated.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Note: this setting applies to plugin *deactivation* only. If you *uninstall* (i.e., delete) the plugin, all data including feed stats will be removed.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-last-item">
								<input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Settings', 'simple-feed-stats'); ?>" />
							</div>
							
						</form>
					</div>
				</div>
				
				
				
				<div class="postbox">
					<h2><?php esc_html_e('Your Feed Info', 'simple-feed-stats'); ?></h2>
					<div class="toggle default-hidden">
						<p>
							<?php esc_html_e('Here are some helpful things to know when working with feeds.', 'simple-feed-stats'); ?> 
							<span class="tooltip" title="<?php esc_attr_e('Tip: to generate some feed data to look at, click on a few of these links and then refresh the SFS settings page.', 'simple-feed-stats'); ?> :)">?</span>
						</p>
						<?php 
							
							$feed_rdf       = get_bloginfo('rdf_url');           // RDF feed
							$feed_rss2      = get_bloginfo('rss2_url');          // RSS feed
							$feed_atom      = get_bloginfo('atom_url');          // Atom feed
							$feed_coms      = get_bloginfo('comments_rss2_url'); // RSS2 comments
							$feed_coms_atom = get_bloginfo('comments_atom_url'); // Atom comments
							
							$date_format = get_option('date_format');
							$time_format = get_option('time_format');
							$curtime = date("{$date_format} {$time_format}", current_time('timestamp'));
							
							$address = sfs_get_ip_address(true);
							
							$agent = isset($_SERVER['HTTP_USER_AGENT']) ? sfs_clean($_SERVER['HTTP_USER_AGENT']) : 'n/a'; 
							
						?>
	
						<p><strong><?php esc_html_e('Your feed URLs', 'simple-feed-stats'); ?></strong></p>
						<div class="sfs-table">
							<ul>
								<li><?php esc_html_e('Content RDF',   'simple-feed-stats'); ?> &ndash; <a target="_blank" rel="noopener noreferrer" href="<?php echo esc_attr($feed_rdf);       ?>"><code><?php echo esc_url($feed_rdf);       ?></code></a></li>
								<li><?php esc_html_e('Content RSS2',  'simple-feed-stats'); ?> &ndash; <a target="_blank" rel="noopener noreferrer" href="<?php echo esc_attr($feed_rss2);      ?>"><code><?php echo esc_url($feed_rss2);      ?></code></a></li>
								<li><?php esc_html_e('Content Atom',  'simple-feed-stats'); ?> &ndash; <a target="_blank" rel="noopener noreferrer" href="<?php echo esc_attr($feed_atom);      ?>"><code><?php echo esc_url($feed_atom);      ?></code></a></li>
								<li><?php esc_html_e('Comments RSS2', 'simple-feed-stats'); ?> &ndash; <a target="_blank" rel="noopener noreferrer" href="<?php echo esc_attr($feed_coms);      ?>"><code><?php echo esc_url($feed_coms);      ?></code></a></li>
								<li><?php esc_html_e('Comments Atom', 'simple-feed-stats'); ?> &ndash; <a target="_blank" rel="noopener noreferrer" href="<?php echo esc_attr($feed_coms_atom); ?>"><code><?php echo esc_url($feed_coms_atom); ?></code></a></li>
							</ul>
						</div>
						<p><strong><?php esc_html_e('More about WordPress feeds', 'simple-feed-stats'); ?></strong></p>
						<ul>
							<li><a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/simple-feed-stats/"><?php esc_html_e('Simple Feed Stats Homepage', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" rel="noopener noreferrer" href="http://codex.wordpress.org/WordPress_Feeds"><?php esc_html_e('WP Codex: WordPress Feeds', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" rel="noopener noreferrer" href="https://perishablepress.com/what-is-my-wordpress-feed-url/"><?php esc_html_e('What is my WordPress Feed URL?', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" rel="noopener noreferrer" href="http://feedburner.google.com/"><?php esc_html_e('Google/Feedburner', 'simple-feed-stats'); ?></a></li>
						</ul>
						<p><strong><?php esc_html_e('Your browser/IP info', 'simple-feed-stats'); ?></strong></p>
						<ul>
							<li><?php esc_html_e('IP Address:', 'simple-feed-stats'); ?> <code><?php echo sfs_clean($address); ?></code></li>
							<li>
								<?php esc_html_e('Approx. Time:', 'simple-feed-stats'); ?> <code><?php echo sfs_clean($curtime); ?></code>
								<span class="tooltip" title="<?php esc_attr_e('Denotes date/time of most recent page-load (useful when monitoring feed stats).', 'simple-feed-stats'); ?>">?</span>
							</li>
							<li><?php esc_html_e('User Agent:', 'simple-feed-stats'); ?> <code><?php echo sfs_clean($agent); ?></code></li>
						</ul>
					</div>
				</div>
				
				
				
				<div id="sfs-shortcodes" class="postbox">
					<h2><?php esc_html_e('Shortcodes &amp; Template Tags', 'simple-feed-stats'); ?></h2>
					<div class="toggle default-hidden">
						
						<h3><?php esc_html_e('Shortcodes', 'simple-feed-stats'); ?></h3>
						
						<p><?php esc_html_e('Display daily count for all feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>[sfs_subscriber_count]</code></p>
						
						<p>
							<?php esc_html_e('Display daily count for all feeds with a FeedBurner-style badge:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: visit the &ldquo;Plugin Settings&rdquo; panel to style your badge with some custom CSS. Also, check out the plugin FAQs for info on wrapping the FeedBurner count badge with a link to your feed.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><code>[sfs_count_badge]</code></p>
						
						<p>
							<?php esc_html_e('Display daily count for all feeds with a simple (linked) badge:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: to wrap the badge with a link to your feed, include the &ldquo;link&rdquo; attribute with your feed URL. See the second example below.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><code>[sfs_count_simple]</code></p>
						<p><code>[sfs_count_simple link="https://example.com/feed/"]</code></p>
						
						<p><?php esc_html_e('Display daily count for RSS2 feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>[sfs_rss2_count]</code></p>
						
						<p><?php esc_html_e('Display daily count for comment feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>[sfs_comments_count]</code></p>
						
						
						<h3><?php esc_html_e('Template Tags', 'simple-feed-stats'); ?></h3>
						
						<p><?php esc_html_e('Display daily count for all feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>&lt;?php if (function_exists('sfs_display_subscriber_count')) sfs_display_subscriber_count(); ?&gt;</code></p>
						
						<p>
							<?php esc_html_e('Display daily count for all feeds with a FeedBurner-style badge:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: visit the &ldquo;Plugin Settings&rdquo; panel to style your badge with some custom CSS. Also, check out the plugin FAQs for info on wrapping the FeedBurner count badge with a link to your feed.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><code>&lt;?php if (function_exists('sfs_display_count_badge')) sfs_display_count_badge(); ?&gt;</code></p>
						
						<p>
							<?php esc_html_e('Display daily count for all feeds with a simple (linked) badge:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: to wrap the badge with a link to your feed, use the second example below and replace the example URL with your own.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><code>&lt;?php if (function_exists('sfs_display_count_simple')) sfs_display_count_simple(); ?&gt;</code></p>
						<p><code>&lt;?php if (function_exists('sfs_display_count_simple')) sfs_display_count_simple(array('link' => 'https://example.com/feed/')); ?&gt;</code></p>
						
						<p><?php esc_html_e('Display total count for all feeds as plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>&lt;?php if (function_exists('sfs_display_total_count')) sfs_display_total_count(); ?&gt;</code></p>
						
						
						<h3><?php esc_html_e('Examples', 'simple-feed-stats'); ?></h3>
						<p>
							<?php esc_html_e('Example of the plain-text shortcodes/tags:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: the plain-text shortcodes/tags enable you to create custom badges, links, and so forth.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><?php sfs_display_subscriber_count(); ?></p>
						<p>
							<?php esc_html_e('Example of the FeedBurner-style badge:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: the FeedBurner badge can be displayed using a shortcode or template tag.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><?php sfs_display_count_badge(); ?></p>
						
						<p>
							<?php esc_html_e('Example of the simple (linked) badge:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: the simple badge can be displayed using a shortcode or template tag.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><?php sfs_display_count_simple(); ?></p>
					</div>
				</div>
				
				
				
				<div class="postbox">
					<h2><?php esc_html_e('Show Support', 'simple-feed-stats'); ?></h2>
					<div class="toggle toggle-support<?php if (isset($_GET['settings-updated']) || isset($_GET['cache']) || isset($_GET['filter']) || isset($_GET['jump']) || isset($_GET['reset']) || isset($_GET['p'])) echo ' default-hidden'; ?>">
						<?php require_once('support-panel.php'); ?>
					</div>
				</div>
				
			</div>
		</div>
		<div class="sfs-credits">
			<a target="_blank" rel="noopener noreferrer" href="https://perishablepress.com/simple-feed-stats/" title="<?php esc_attr_e('Plugin Homepage', 'simple-feed-stats'); ?>">Simple Feed Stats</a> <?php esc_html_e('by', 'simple-feed-stats'); ?> 
			<a target="_blank" rel="noopener noreferrer" href="https://twitter.com/perishable" title="<?php esc_attr_e('Jeff Starr on Twitter', 'simple-feed-stats'); ?>">Jeff Starr</a> @ 
			<a target="_blank" rel="noopener noreferrer" href="https://monzillamedia.com/" title="<?php esc_attr_e('Obsessive Web Design &amp; Development', 'simple-feed-stats'); ?>">Monzilla Media</a>
		</div>
	</div>
	
	<script type="text/javascript">
		// auto-submit
		function myF(targ, selObj, restore){
			eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
			if (restore) selObj.selectedIndex = 0;
		}
		// prevent accidents (delete stats)
		jQuery('.reset').click(function(event){
			event.preventDefault();
			var r = confirm("<?php esc_html_e('Are you sure you want to delete all the feed stats? (this action cannot be undone)', 'simple-feed-stats'); ?>");
			if (r == true){  
				window.location = jQuery(this).attr('href');
			}
		});
		// prevent accidents (restore options)
		if(!jQuery("#sfs_restore_defaults").is(":checked")){
			jQuery('#sfs_restore_defaults').click(function(event){
				var r = confirm("<?php esc_html_e('Are you sure you want to restore all default options? (this action cannot be undone)', 'simple-feed-stats'); ?>");
				if (r == true){  
					jQuery("#sfs_restore_defaults").attr('checked', true);
				} else {
					jQuery("#sfs_restore_defaults").attr('checked', false);
				}
			});
		}
		// prevent accidents (delete table)
		if(!jQuery("#sfs_delete_table").is(":checked")){
			jQuery('#sfs_delete_table').click(function(event){
				var r = confirm("<?php esc_html_e('Are you sure you want to delete the stats table and all of its data? (this action cannot be undone)', 'simple-feed-stats'); ?>");
				if (r == true){  
					jQuery("#sfs_delete_table").attr('checked', true);
				} else {
					jQuery("#sfs_delete_table").attr('checked', false);
				}
			});
		}
		// Easy Tooltip 1.0 - Alen Grakalic
		(function($) {
			$.fn.easyTooltip = function(options){
				var defaults = {	
					xOffset: 10,		
					yOffset: 25,
					tooltipId: "easyTooltip",
					clickRemove: false,
					content: "",
					useElement: ""
				}; 
				var options = $.extend(defaults, options);  
				var content;	
				this.each(function() {  				
					var title = $(this).attr("title");				
					$(this).hover(function(e){											 							   
						content = (options.content != "") ? options.content : title;
						content = (options.useElement != "") ? $("#" + options.useElement).html() : content;
						$(this).attr("title","");								  				
						if (content != "" && content != undefined){			
							$("body").append("<div id='"+ options.tooltipId +"'>"+ content +"</div>");		
							$("#" + options.tooltipId).css("position","absolute").css("top",(e.pageY - options.yOffset) + "px")
								.css("left",(e.pageX + options.xOffset) + "px").css("display","none").fadeIn("fast")
						}
					},
					function(){	
						$("#" + options.tooltipId).remove();
						$(this).attr("title",title);
					});	
					$(this).mousemove(function(e){
						$("#" + options.tooltipId)
						.css("top",(e.pageY - options.yOffset) + "px")
						.css("left",(e.pageX + options.xOffset) + "px")					
					});	
					if(options.clickRemove){
						$(this).mousedown(function(e){
							$("#" + options.tooltipId).remove();
							$(this).attr("title",title);
						});				
					}
				});
			};
		})(jQuery);
		jQuery(".tooltip").easyTooltip();
		// toggle stuff
		jQuery(document).ready(function(){
			jQuery('.sfs-toggle-panels a').click(function(){
				jQuery('.toggle').slideToggle(300);
				return false;
			});
			jQuery('.default-hidden').hide();
			jQuery('h2').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('.sfs-options-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#sfs_custom-options .toggle').slideToggle(300);
				return true;
			});
			jQuery('.sfs-shortcodes-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#sfs-shortcodes .toggle').slideToggle(300);
				return true;
			});
			jQuery('.sfs-open-tracking').click(function(){
				jQuery('.sfs-open-tracking-image, .sfs-open-tracking-url').slideDown('fast');
			});
			jQuery('.sfs-tracking').click(function(){
				jQuery('.sfs-open-tracking-image, .sfs-open-tracking-url').slideUp('fast');
			});
			//dismiss_alert
			if (!jQuery('.dismiss-alert-wrap input').is(':checked')){
				jQuery('.dismiss-alert-wrap input').one('click',function(){
					jQuery('.dismiss-alert-wrap').after('<input type="submit" class="button" value="<?php esc_attr_e('Save Preference', 'simple-feed-stats'); ?>" />');
				});
			}
		});
	</script>

<?php }
