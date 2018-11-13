<?php // uninstall remove options

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) exit();

class SFS_Uninstall {
		
	public static function init() {
		
		global $network_wide, $wpdb; 
		
		if (!current_user_can('activate_plugins')) return;
		
		if (is_multisite()) {
			
			$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			
			if ($blog_ids) {
				
				foreach ($blog_ids as $blog_id) {
					
					switch_to_blog($blog_id);
					
					self::uninstall();
					
					restore_current_blog();
					
				}
				
			}
			
		} else {
			
			self::uninstall();
			
		}
		
	}
	
	private static function uninstall() {
		
		self::remove_options();
		self::remove_transients();
		self::remove_cron();
		self::remove_tables();
		
	}
	
	private static function remove_options() {
		
		$options = array(
			
			'sfs_options',
			'sfs_version',
			'sfs_alert',
		);
		
		foreach($options as $option) {
			
			delete_option($option);
			
		}
		
	}
	
	private static function remove_cron() {
		
		$timestamp = wp_next_scheduled('sfs_create_transients');
		wp_unschedule_event($timestamp,'sfs_create_transients');
		
	}
	
	private static function remove_transients() {
		
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
	
	private static function remove_tables() {
		
		global $wpdb;
		
		$prefix = $wpdb->prefix;
		
		$tables = array($prefix .'simple_feed_stats');
		
		$wpdb->query('DROP TABLE IF EXISTS '. implode(',', $tables));
		
	}
	
}

SFS_Uninstall::init();
