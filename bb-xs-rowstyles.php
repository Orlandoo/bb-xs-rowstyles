<?php
/**
 * bb-xs-rowstyles
 *
 * @package     XS-Rowstyles
 * @author      Roland Dietz
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Beaver Builder Xitesolution Rowstyles
 * Plugin URI:  http://www.xitesolution.de/
 * Description: Add an animated gradient as a full width background on any row, right from the Row-settings panel.
 * Version:     0.1
 * Author:      Roland Dietz
 * Author URI:  http://www.xitesolution.de/
 * Text Domain: bb-xs-rowstyles
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define( 'BB-XS-ROWSTYLES_VERSION' , '0.' );
define( 'BB-XS-ROWSTYLES_DIR', plugin_dir_path( __FILE__ ) );
define( 'BB-XS-ROWSTYLES_URL', plugins_url( '/', __FILE__ ) );

//textdomain
load_plugin_textdomain( 'bb-xs-rowstyles', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

add_action( 'init', 'bb_xs_rowstyles_plugin_start' );

function bb_xs_rowstyles_plugin_start() {

  if ( class_exists( 'FLBuilder' ) ) {

       require_once ( 'includes/xs-rowstyles.php' );

  }

}

/**
 * Updater
 */

if( ! class_exists( 'Smashing_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}
$updater = new Smashing_Updater( __FILE__ );
$updater->set_username( 'badabingbreda' );
$updater->set_repository( 'bb-xs-rowstyles' );

$updater->initialize();


