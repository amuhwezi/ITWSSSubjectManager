<?php 
// If uninstall/delete not called from WordPress then exit 
if( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) )
exit ();
// Delete option from options table
delete_option( 'gmp_options_arr' );
//remove any additional options and custom tables
global $wpdb;
$table1 = $wpdb->prefix . "subject";
$table2 = $wpdb->prefix . "combination";
$table3 = $wpdb->prefix . "paper";

$sql1 = "DROP TABLE " . $table1 . ";";
$sql2 = "DROP TABLE " . $table2 . ";";
$sql3 = "DROP TABLE " . $table3 . ";";
//execute the query deleting the table
$wpdb->query($sql1);
$wpdb->query($sql2);
$wpdb->query($sql3);
require_once(ABSPATH .'wp-admin/includes/upgrade.php');
dbDelta($sql1); 
dbDelta($sql2); 
dbDelta($sql3); 
?>
