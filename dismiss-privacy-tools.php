<?php 
/*
 Plugin Name:       Dismiss Privacy Tools
 Plugin URI:        https://github.com/luciano-croce/dismiss-privacy-tools/
 Description:       Dismiss <strong>Privacy Tools</strong> added in WordPress 4.9.6, completely, when it is activated, or if it is in mu-plugins directory.
 Version:           0.0.1
 Requires at least: 4.9.6-alpha
 Tested up to:      5.0-alpha
 Requires PHP:      5.2.4
 Author:            Luciano Croce
 Author URI:        https://github.com/luciano-croce/
 License:           GPLv2 or later (license.txt)
 License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:       dismiss-privacy-tools
 Domain Path:       /languages
 Network:           true
 GitHub Plugin URI: https://github.com/luciano-croce/dismiss-privacy-tools/
 GitHub Branch:     master
 Requires WP:       4.9.6-alpha
 *
 * Features:
 *
 * Disable Privacy Toool /wp-admin/privacy.php
 * Disable Erase Personal Data /wp-admin/tools.php?page=erase_personal_data
 * Disable Export Personal Data /wp-admin/tools.php?page=export_personal_data
 * Dismiss pointer for the new privacy tools.
 * Remove scheduled event used to delete old export files.
 * Remove scheduled hook used to delete old export files.
 * Short circuits the option for the privacy policy page to always return 0 to avoid unnedded database query.
 * Delete uneeded database options and reset options to default.
 */

	/**
	 * Dismiss Privacy Tools
	 *
	 * Dismiss Privacy Tools added in WordPress 4.9.6 (completely) included Erase and Export Personal Data.
	 *
	 * PHPDocumentor
	 *
	 * @package    WordPress\Plugin
	 * @subpackage Dashboard\Dismiss_Privacy_tools
	 * @link       https://github.com/luciano-croce/dismiss-privacy-tools/
	 * @version    0.0.1 (Build 2018-05-10) Stable Release
	 * @since      4.9.6-alpha
	 * @author     Luciano Croce <luciano.croce@gmail.com>
	 * @copyright  2018 - Luciano Croce
	 * @license    https://www.gnu.org/licenses/gpl-2.0.html - GPLv2 or later (license.txt)
	 * @todo       Investigating possible pointer_wp496_privacy bug (future release)
	 */

	/**
	 * Completely disable the Privacy Tools added in WordPress 4.9.6 or later and greater.
	 *
	 * @param array $required_capabilities             - The primitive capabilities that are required to perform the requested meta capability.
	 * @param string $requested_capability             - The requested meta capability.
	 * @param int $user_id                             - The user ID.
	 * @param array $args                              - The object ID. (typically adds the context to the cap)
	 *
	 * @return array                                   - The primitive capabilities that are required to perform the requested meta capability.
	 *
	 * @since	2018-06-22
	 * @version	2018-06-22
	 * @author	Luciano Croce @ profiles.wordpress.org/luciano.croce
	 */
	function disable_496_privacy_tools( $required_capabilities, $requested_capability, $user_id, $args ) {
		$privacy_capabilities = array( 'manage_privacy_options', 'erase_others_personal_data', 'export_others_personal_data' );

			if ( in_array( $requested_capability, $privacy_capabilities ) ) {
				$required_capabilities[] = 'do_not_allow';
			}
			return $required_capabilities;
		}
	add_filter( 'map_meta_cap', 'disable_496_privacy_tools', 10, 4 );

	/**
	 * Short circuits the option for the privacy policy page to always return 0.
	 *
	 * The option is used by get_privacy_policy_url() among others.
	 *
	 * @since	2018-06-22
	 * @version	2018-06-22
	 * @author	Luciano Croce @ profiles.wordpress.org/luciano.croce
	 */
	add_filter( 'pre_option_wp_page_for_privacy_policy', '__return_zero' );

	/**
	 * Removes the default scheduled event used to delete old export files.
	 *
	 * @since	2018-06-22
	 * @version	2018-06-22
	 * @author	Luciano Croce @ profiles.wordpress.org/luciano.croce
	 */
	remove_action( 'init', 'wp_schedule_delete_old_privacy_export_files' );

	/**
	 * Disable the checkbox comments – privacy - approved?
	 *
	 * @since	2018-06-22
	 * @version	2018-06-22
	 * @author	Luciano Croce @ profiles.wordpress.org/luciano.croce
	 */
	function comment_form_hide_cookies_consent( $fields ) {
		unset( $fields['cookies'] );
		return $fields;
	}
	add_filter( 'comment_form_default_fields', 'comment_form_hide_cookies_consent' );

	/*
	 * Delete uneeded database options - reset to default - dismiss yellow warning on edit and other pages.
	 *
	 * @since	2018-06-22
	 * @version	2018-06-22
	 * @author	Luciano Croce @ profiles.wordpress.org/luciano.croce
	 */
	delete_option( 'wp_page_for_privacy_policy' );
	delete_option( '_wp_privacy_text_change_check' );
	delete_site_option( 'wp_page_for_privacy_policy' );
	delete_site_option( '_wp_privacy_text_change_check' );

	/**
	 * Disable and Remove Background Hook Cron.
	 *
	 * Scheduled Auto Old Privacy Files Export Delete.
	 *
	 * @since	2018-06-22
	 * @version	2018-06-22
	 * @author	Luciano Croce @ profiles.wordpress.org/luciano.croce
	 */
	function privacy_tools_scheduled_cron() {
			wp_clear_scheduled_hook( 'wp_privacy_delete_old_export_files' );
		}
	add_action( 'admin_init', 'privacy_tools_scheduled_cron' );

	/**
	 * Dismiss all the new feature pointers.
	 *
	 * @since 3.3.0
	 *
	 * All pointers can be disabled using the following:
	 *     remove_action( 'admin_enqueue_scripts', array( 'WP_Internal_Pointers', 'enqueue_scripts' ) );
	 *
	 * @param string $hook_suffix The current admin page.
	 *
	 * Dismiss a pointer for the new privacy tools.
	 *
	 * @since 4.9.6
	 *
	 * Privacy pointer can be disabled using the following:
	 *     remove_action( 'admin_print_footer_scripts', array( 'WP_Internal_Pointers', 'pointer_wp496_privacy' ) );
	 *
	 * @param string $hook_suffix The current admin page.
	 *
	 * @since	2018-06-22
	 * @version	2018-06-22
	 * @author	Luciano Croce @ profiles.wordpress.org/luciano.croce
	 */
	class dismiss_pointer_wp496_privacy{
		public function __construct(){
			add_action( 'admin_init', array( $this, 'remove_action' ) );
		}
		function remove_action(){
//			remove_action( 'admin_print_footer_scripts', array( 'WP_Internal_Pointers', 'pointer_wp496_privacy' ) ); # This for now not work: due a bug? Investigating... wp496_privacy ???
			remove_action( 'admin_enqueue_scripts', array( 'WP_Internal_Pointers', 'enqueue_scripts' ) );
		}
	}
	$dismiss_pointer_wp496_privacy = new dismiss_pointer_wp496_privacy;
