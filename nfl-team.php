<?php
/**
 * Plugin Name: NFL Team
 * Plugin URI: http://localhost/acme-sports/
 * Description: NFL Team plugin is used to display data by ACME Sports.
 * Version: 1.0
 * Author: Taranjit Kaur
 */

//js and css files
function nfl_team_admin_init() {
	wp_enqueue_style( 'stylenfl', '/wp-content/plugins/nfl-team/assets/css/stylenfl.css');
	wp_enqueue_style('dataTables.bootstrap.min', '/wp-content/plugins/nfl-team/assets/css/dataTables.bootstrap.min.css');	
	wp_enqueue_style( 'bootstrap.min', '/wp-content/plugins/nfl-team/assets/css/bootstrap.min.css');		
	wp_enqueue_script( 'jquery-3.5.1', '/wp-content/plugins/nfl-team/assets/js/jquery-3.5.1.js');
	wp_enqueue_script( 'jquery.dataTables.min', '/wp-content/plugins/nfl-team/assets/js/jquery.dataTables.min.js');
	wp_enqueue_script( 'dataTable.bootstrap.min', '/wp-content/plugins/nfl-team/assets/js/dataTable.bootstrap.min.js');	
}
add_action( 'wp_enqueue_scripts', 'nfl_team_admin_init', 80);

//get data using CURL 
function nfl_dataoutput($atts) {
	$url = 'http://delivery.chalk247.com/team_list/NFL.JSON?api_key=74db8efa2a6db279393b433d97c2bc843f8e32b0';
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
	$result = curl_exec($curl);	
	$arr = json_decode($result, true);		
	$data = $arr['results']['data']['team'];
	$columns = $arr['results']['columns'];
	include( plugin_dir_path( __FILE__ ) . 'views/index.php');
}
add_shortcode('nfl-list', 'nfl_dataoutput');

//create page on plugin installation with shortcode
define( 'NFL_PLUGIN_FILE', __FILE__ );
register_activation_hook( NFL_PLUGIN_FILE, 'nfl_plugin_activation' );
function nfl_plugin_activation() {  
  if ( ! current_user_can( 'activate_plugins' ) ) return;  
  global $wpdb;  
  if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'nfl-team'", 'ARRAY_A' ) ) {     
    $current_user = wp_get_current_user();    
    // create post object
    $page = array(
      'post_title'  => __( 'NFL TEAMS' ),
      'post_status' => 'publish',
      'post_author' => $current_user->ID,
      'post_type'   => 'page',
	  'post_content' => '[nfl-list]'
    );    
    // insert the post into the database
    wp_insert_post( $page );
  }
}
//remove page on Plugin Deactivation
function nfl_plugin_deactivation() {
	global $wpdb;  
    $sql = 'DELETE FROM `'. $wpdb->prefix .'posts` WHERE `post_name` = %d;';
    try {
        $wpdb->query($wpdb->prepare($sql, array('nfl-team')));
        return true;
    } catch (Exception $e) {
        return 'Error! '. $wpdb->last_error;
    }
}
register_deactivation_hook( __FILE__, 'nfl_plugin_deactivation' );
