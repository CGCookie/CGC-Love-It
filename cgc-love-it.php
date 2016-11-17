<?php
/**
 *
 * @package   CGC Love It 2.0
 * @author    Nick Haskins <nick@cgcookie.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 *
 * Plugin Name:       CGC Love It
 * Plugin URI:        http://cgcookie.com
 * Description:       Creates a social following/follower system
 * Version:           5.2.1
 * GitHub Plugin URI: https://github.com/cgcookie/cgc-loveit
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Set some constants
define('CGC_LOVEIT_VERSION', '5.2.1');
define('CGC_LOVEIT_DIR', plugin_dir_path( __FILE__ ));
define('CGC_LOVEIT_URL', plugins_url( '', __FILE__ ));

require_once( plugin_dir_path( __FILE__ ) . 'public/class-cgc-love-it.php' );

register_activation_hook( __FILE__, array( 'CGC_Loveit', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'CGC_Loveit', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'CGC_Loveit', 'get_instance' ) );

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-cgc-love-it-admin.php' );
	add_action( 'plugins_loaded', array( 'CGC_Loveit_Admin', 'get_instance' ) );

}
