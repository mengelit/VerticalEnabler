<?php

include_once('reports-config.php');
include_once('reports-classes.php');

$results_downaloadmonitor = $wpdb->get_results('SELECT wp_download_monitor_files.category_id, wp_download_monitor_log.user_id,   wp_download_monitor_files.title, wp_download_monitor_log.date FROM wp_download_monitor_log, wp_download_monitor_files WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id order by wp_download_monitor_files.category_id, wp_download_monitor_log.user_id, wp_download_monitor_log.date'); 


foreach($results_downaloadmonitor as $row)
{
	echo "<pre>";
   		print_r($row);
	echo "</pre>";
}

$sponsor_name = "";


$results_categoryids = $wpdb->get_results('SELECT DISTINCT(wp_download_monitor_files.category_id) FROM wp_download_monitor_log, wp_download_monitor_files WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id order by wp_download_monitor_files.category_id, wp_download_monitor_log.user_id, wp_download_monitor_log.date'); 

echo "<table>";
foreach($results_categoryids as $sponsor)
{
	if(isset($sponsor->category_id))
	{
		$sponsor_name = $sponsor->category_id;
	}
	else 
	{
		$sponsor_name = "<em>Sponsor name is not set</em>";
	}
	echo "<tr><td><b>Sponsor Name:</b>&nbsp;</td><td>" . $sponsor_name . "</td></tr>";
	/*Get Lead Information*/
	/*$results_leadids = $wpdb->get_results('SELECT DISTINCT(wp_download_monitor_files.user_id) FROM wp_download_monitor_log, wp_download_monitor_files WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id WHERE wp_download_monitor_files.category_id === ' . $sponsor->category_id . 'order by wp_download_monitor_files.category_id, wp_download_monitor_log.user_id, wp_download_monitor_log.date'); */
	$results_leadids = $wpdb->get_results('SELECT DISTINCT(wp_download_monitor_log.user_id) FROM wp_download_monitor_log, wp_download_monitor_files WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id order by wp_download_monitor_files.category_id, wp_download_monitor_log.user_id, wp_download_monitor_log.date'); 
	foreach($results_leadids as $leads)
	{
			echo "<tr><td>";
			echo $leads->user_id;
			$results_usermeta = $wpdb->get_results('SELECT wp_usermeta.meta_key, wp_usermeta.meta_value FROM wp_usermeta WHERE wp_usermeta.user_id = ' . $leads->user_id); 
			foreach($results_usermeta as $usermeta)
			{
				echo "<pre>"; echo print_r($usermeta); echo "</pre>";
			}
			echo "</tr></td>";
	}
	

}

echo "</table>";