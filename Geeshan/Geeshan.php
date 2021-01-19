<?php
/**
 * @package Geeshan
 */
/*
Plugin Name:  Woocommerce CSV Export By Geeshan
Plugin URI: https://wordpress.com/
Description: Export the woocommerce products to CSV format.
Version: 1.0
Author: Geeshan
Author URI: https://wordpress.com/
License: GPLv2 or Later
Text Domain: Geeshan
*/

defined( 'ABSPATH' ) or die('Say No to Hackers!');

class Geeshan {
	
	public $pluginname;
	
	
	function __construct() {
	//add_action('init', array($this, 'custom_post_type'));
    $this->pluginname = plugin_basename( __FILE__ );
	}
	
	function register() {
		add_action('admin_enqueue_scripts', array ($this, 'custom_enqueue'));
		
		add_action('admin_menu', array($this, 'admin_pages'));
		
		add_filter('plugin_action_links_'. $this->pluginname, array ($this, 'custom_settings_link'));
	}
	
	public function custom_settings_link($links) {
		
		$settings_link = '<a href="admin.php?page=Geeshan_plugin">Settings</a>';
		array_push($links, $settings_link);
		return $links;
	}
	
	
	function activate() {
		$this->custom_post_type();
		flush_rewrite_rules();
	}
	
	function deactivate() {
		
		flush_rewrite_rules();
	}
	
	function uninstall() {
	}
	
	function custom_post_type() {
		register_post_type( 'Export', ['public' => true, 'label' => 'Export to CSV']);
	}
	
	function custom_enqueue() {
		wp_enqueue_style('geeshanstyle', plugins_url( '/assests/geeshan.css', __FILE__ ));
	}
	
	public function admin_pages () {
		add_menu_page('Export to CSV', 'Export to CSV' , 'manage_options', 'Geeshan_plugin', array($this,'admin_index'), 'dashicons-products', 100);
	}
	
	public function admin_index() {
		require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
	}
}

if(class_exists('Geeshan')) {
	$Geeshan = new Geeshan();
	$Geeshan->register();
}

register_activation_hook( __FILE__, array($Geeshan, 'activate'));

register_deactivation_hook( __FILE__, array($Geeshan, 'deactivate'));

