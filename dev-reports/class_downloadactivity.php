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
	global $wpdb;
	$results_downaloadmonitor = $wpdb->get_results('SELECT wp_download_monitor_files.category_id, 			wp_download_monitor_log.user_id,   wp_download_monitor_files.title, wp_download_monitor_log.date FROM wp_download_monitor_log, wp_download_monitor_files WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id order by wp_download_monitor_files.category_id, wp_download_monitor_log.user_id, wp_download_monitor_log.date'); 
	
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
		if(!isset($row->category_id))
		{
			$tempclass->sponsor = 0;
		}
		else { 
			$tempclass->sponsor = $row->catgory_id;
		}
		array_push($arrayof_FileDL, $tempclass);
	}
}

/************** FUNCTIONS **************/

?>