<?php
/**
* @package Divi_Image_N10S
* @version 4.0,1
*/

/*
* Plugin Name: Divi Image Intense
* Plugin URI: https://besuperfly.com/product/image-intense/
* Description: A hybrid mix of the Image, Text and Button modules. Includes Superfly text, overlay, blend, hover, button and background effect options!
* Author: Superfly
* Version: 4.0.1
* Author URI: https://besuperfly.com/about-superfly/
* License: GPL3
*/


// 4.0.0 - update

if ( ! function_exists( 'n10s_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 4.0.0
 */
function n10s_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/ImageIntense.php';
}
add_action( 'divi_extensions_init', 'n10s_initialize_extension' );

add_action('wp_ajax_get_image_url_by_size', 'get_image_url_by_size' );
add_action('wp_ajax_nopriv_get_image_url_by_size', 'get_image_url_by_size');
function get_image_url_by_size() {

	if (isset($_REQUEST)) {

		$size = $_REQUEST['size'];
		$image_url = $_REQUEST['src'];
		
		global $wpdb;
		$prefix = $wpdb->prefix;		// wp_ is not always the table prefix!
		$table  = $prefix . 'posts';

		//$attachment = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM {$table} WHERE guid = %s;", $image_url ));

		$attachment = attachment_url_to_postid($image_url);
		
		// If the media size was not found, let's try using the full attachment URL to find the right GUID
		if ( !isset( $attachment ) || $attachment == false ) {

			// Add the site URL to the image attachment info
			$site_url = site_url();

			$attachment = attachment_url_to_postid($site_url . $image_url );
		}
		
		// If we didn't find media size the 2nd time, we will just return the original image.
		//  It's possible the site URL has changed, which means it will not be possible to
		//  get media sizes until the wp_posts table attachments have the guid field updated.
		if ( !isset( $attachment ) || $attachment == false ) {
			$image_url_by_size = $image_url;
		} else {
			
			// Attempt to get the image for the specified media size
			$image_thumb = wp_get_attachment_image_src( $attachment, $size );

			// Test for empty result. If the URL wasn't found, it might not have been uploaded through media,
			//  and we'll need to leave it as it was typed in.  Regenerate Thumbnails plugin might fix this problem.
			if ( !isset( $image_thumb ) || $image_thumb == false ) {
				$image_url_by_size = $image_url;
			} else {
				// Success in finding the right image!
				$image_url_by_size = $image_thumb[0];
			}
		}

		wp_send_json_success ($image_url_by_size);
		wp_die();
	}
}

function image_intense_et_builder_load_actions( $actions ) {
	$actions[] = 'get_image_url_by_size';

	return $actions;
}

add_filter( 'et_builder_load_actions', 'image_intense_et_builder_load_actions' );

endif;

/* Plugin updater section - 
	courtesy of Jānis Elsts at GitHub https://github.com/YahnisElsts/wp-update-server
*/

// Make it harder to find latest version. Keeps the honest people honest.
$updater = base64_decode('aHR0cHM6Ly9iZXN1cGVyZmx5LmNvbS90aGVtZXMtcGx1Z2lucy11cGRhdGVyL3BhY2thZ2VzL2ltYWdlLWludGVuc2UvaW1hZ2UtaW50ZW5zZS5qc29u');

require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    $updater,
    __FILE__,
    'image-intense'
);