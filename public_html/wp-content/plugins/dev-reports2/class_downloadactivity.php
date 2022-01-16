<?php
include_once('reports-config.php');

class FileDL
{
	public $title;
	public $datets;
	public $user_id;
	public $sponsor;
}

/************** FUNCTIONS **************/

function get_downloadinfo()
{
	global $wpdb, $SDATE, $EDATE;
	$strQuery = "SELECT wp_download_monitor_relationships.taxonomy_id, wp_download_monitor_log.user_id, wp_download_monitor_files.title, wp_download_monitor_log.date
FROM wp_download_monitor_log, wp_download_monitor_files, wp_download_monitor_relationships
WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id
AND wp_download_monitor_log.download_id = wp_download_monitor_relationships.download_id AND wp_download_monitor_log.date >= %s AND wp_download_monitor_log.date <= %s order by wp_download_monitor_files.category_id, wp_download_monitor_log.user_id, wp_download_monitor_log.date"; 
	
	//AND date >= %s AND date <= %s";
		
		
	//$strQuery = "UPDATE wp_eventuser_tbl SET fname = %s, lname = %s, active = %d WHERE id = %d";

	$results_downaloadmonitor = $wpdb->get_results($wpdb->prepare( $strQuery,  $SDATE, $EDATE) );
	
	return $results_downaloadmonitor;
}

function Fill_FileDL_Array($fdls)
{
	global $arrayof_FileDL;
	foreach($fdls as $row)
	{
		$tempclass = new FileDL;
		$tempclass->title = $row->title;
		$tempclass->datets = $row->date;
		$tempclass->user_id = $row->user_id;
		if(!isset($row->taxonomy_id))
		{
			$tempclass->sponsor = 0;
		}
		else { 
			$tempclass->sponsor = $row->taxonomy_id;
		}
		array_push($arrayof_FileDL, $tempclass);
	}
}

/************** FUNCTIONS **************/

?>