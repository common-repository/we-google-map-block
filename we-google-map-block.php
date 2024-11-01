<?php
/*
Plugin Name: WE - Google Map Gutenberg Block
Plugin URI: https://wordpress.org/plugins/we-google-map-block/
Description: WE - Google Map Gutenberg Block for Gutenberg editor powered by Google Maps. Simple. Fast. User Friendly.
Tags: map, google maps, block, gutenberg, gutenberg block, gutenberg editor, google maps for gutenberg, maps for gutenberg, gutenberg maps
Author: wordprEsteem
Author URI: https://profiles.wordpress.org/wordpresteem
Version: 1.2.3
Text Domain: we-google-map-gutenberg-block
Contributors: wordprEsteem
Requires PHP: 5.6.3
Tested up to: 6.2.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
  
Copyright 2018  wordprEsteem  (email : wordpresteem@gmail.com)
*/


//  Exit if accessed directly.
defined('ABSPATH') || exit;

class WE_MAP_BLOCK {

	static $version;

	// get plugin version from header
	static function getCurrentPluginVersion() {
		$plugin_data = get_file_data(__FILE__, array('version' => 'Version'), 'plugin');
		self::$version = $plugin_data['version'];

		return $plugin_data['version'];
	} // getCurrentPluginVersion


	// hook things up
	static function init() {
		if (is_admin()) {
		  if (false === self::checkGutenbergInstall()) {
		    return false;
		  }

		  add_action( 'enqueue_block_editor_assets', array(__CLASS__, 'we_google_map_script_fn'));

		}
	} // init

	// some things have to be loaded earlier
	static function checkPluginsLoaded() {
		self::$version = self::getCurrentPluginVersion();
	} // checkPluginsLoaded


	// check if Gutenberg is available
	static function checkGutenbergInstall() {
		if (false === defined('GUTENBERG_VERSION') && false === version_compare(get_bloginfo('version'), '5.0', '>=')) {
		    add_action('admin_notices', array(__CLASS__, 'notice_gutenberg_missing'));
		    return false;
		}
	} // checkGutenbergInstall


	// complain if Gutenberg is not available
	static function notice_gutenberg_missing() {
		echo '<div class="error"><p><b>WE - Google Map Gutenberg Block</b> plugin requires the Gutenberg plugin to work. It is after all a block for Gutenberg ;)<br>Install the <a href="https://wordpress.org/plugins/gutenberg/" target="_blank">Gutenberg plugin</a> and this notice will go away.</p></div>';
	}

	static function we_google_map_script_fn() {
	    wp_register_script(
	        'we-google-map-gutenberg-block',
	        plugins_url( 'js/map.editor.block.js', __FILE__ ),
	        array( 'wp-editor', 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components' )
	    );

	    register_block_type( 'we-google-map-gutenberg-block/google-map-gutenberg', array(
	        'editor_script' => 'we-google-map-gutenberg-block',
	    ) );
	}


} // class

// start now
add_action('init', array('WE_MAP_BLOCK', 'init'));
add_action('plugins_loaded', array('WE_MAP_BLOCK', 'checkPluginsLoaded'));