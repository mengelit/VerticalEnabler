<?php


function Create_Sponsor_N_Leads_Report()
{
	global $wpdb, $SDATE, $EDATE;
	global $arrayof_Leads;
	//Global Array of Lead Objects (class_leads.php
	global $arrayof_FileDL;
	//Global Array of FileDL Objects (clss_downloadactivity.php)
	$s = "<table cellspacing=\"1\" cellpadding=\"1\" style=\"font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px; color: #333333; 	border: 1px solid #666666;	background-color: #CCDEDA;	margin: 0px 0px 0px 8px; width:600px\;\" align=\"left\">";
	
	
	/*$results_downaloadmonitor = $wpdb->get_results('SELECT DISTINCT wp_download_monitor_files.category_id FROM wp_download_monitor_log, wp_download_monitor_files WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id order by wp_download_monitor_files.category_id');*/
	
	
	$results_downaloadmonitor = $wpdb->get_results('SELECT DISTINCT (wp_download_monitor_relationships.taxonomy_id) FROM wp_download_monitor_relationships, wp_download_monitor_log WHERE wp_download_monitor_relationships.download_id = wp_download_monitor_log.download_id');
	
	//adjust above for date range
	
	foreach($results_downaloadmonitor as $row)
	{
		$s = $s . "<tr><th style=\"font-weight: bold; background-color: #003366; color: #FFFFFF; padding: 2px 8px; text-align:left;\">Sponsor Name: " .  $row->taxonomy_id  . "</th></tr>";
		#$s = $s . "<tr><th>Lead</th><td>&nbsp;</td><th>Download / Link Activity </th><td>Date</td></tr>";
		
		$s = $s . "<tr><td><table>";
		$counter = 1;
		
		$strQuery = "SELECT DISTINCT wp_download_monitor_log.user_id FROM wp_download_monitor_log, wp_download_monitor_files WHERE wp_download_monitor_log.download_id = wp_download_monitor_files.id AND (wp_download_monitor_files.category_id = %d OR wp_download_monitor_files.category_id is null) AND date >= %s AND date <= %s";
		//need more data to better filter at *A
		
		//$strQuery = "UPDATE wp_eventuser_tbl SET fname = %s, lname = %s, active = %d WHERE id = %d";

		$results_leads = $wpdb->get_results($wpdb->prepare( $strQuery,  $row->taxonomy_id, $SDATE, $EDATE) );


	 	foreach($results_leads as $rl_row)
		{	
				//loop through leads & find corresponding user id
				foreach($arrayof_Leads as $lead)
				{
					//*A need better filter
					if($lead->user_id == $rl_row->user_id)
					{
						$s = $s . "<tr style=\"background-color: #E5EAEF\"><td width=\"250\"><table>";
						$s = $s . "<tr><th>Lead # " . $counter ."</th><td> &nbsp;</td></tr>";				
						$s = $s . "<tr><td>First Last Name: </td><td>" . $lead->first_name . " " . $lead->last_name ."</td></tr>";				
						$s = $s . "<tr><td>Company: </td><td>" . $lead->companyname ."</td></tr>";	
						$s = $s . "<tr><td>Title: </td><td>" . $lead->companytitle ."</td></tr>";		
						$s = $s . "<tr><td>Address: </td><td>" . $lead->addr1 . "</td></tr>";		
						$s = $s . "<tr><td>City: </td><td>" . $lead->city ."</td></tr>";			
						$s = $s . "<tr><td>State: </td><td>" . $lead->thestate ."</td></tr>";			
						$s = $s . "<tr><td>Zip Code: </td><td>" . $lead->zip ."</td></tr>";				
						$s = $s . "<tr><td>Country: </td><td>" . $lead->country ."</td></tr>";				
						$s = $s . "<tr><td>Email Address: </td><td>" . $lead->nickname ."</td></tr>";			
						$s = $s . "<tr><td>Phone: </td><td>" . $lead->phone1 ."</td></tr>";	
						$s = $s . "</table></td>";	
						$counter ++;												
					}
				}
				
				$s = $s . "<td td valign=\"top\" width=\"400\"><table><tr><th style=\"font-weight: bold; background-color: #003366; color: #FFFFFF; padding: 2px 8px; text-align:left;\">Download / Link Activity</th><th style=\"font-weight: bold; background-color: #003366; color: #FFFFFF; padding: 2px 8px; text-align:left;\">Date</th></tr>";	
				//Loop through File download activity 
				foreach($arrayof_FileDL as $downloads)
				{
					if($downloads->user_id == $rl_row->user_id && $downloads->sponsor == $row->taxonomy_id)
					{
						$s = $s . "<tr><td>" . $downloads->title . "</td><td>" . $downloads->datets . "</td></tr>";
					} 
				}
				$s = $s . "</table></td></tr>";
				
		}
		$s = $s . "</table></td></td><td>&nbsp;</td><td>&nbsp;</td></tr>";	
	}
	
	
	
	$s = $s . "</table></table><p><br><br>&nbsp;<br><br></p></div></div><p><br><br>&nbsp;<br><br></p></div>";
	return $s;
} //end Create_Sponsor_N_Leads_Report()

?>