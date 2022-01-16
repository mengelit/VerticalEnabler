<?php
/**
 * @package Reports
 * @author MengelIT
 * @version 0.1
 */
/*
Plugin Name: Reports
Plugin URI: http://wordpress.org/#
Description: This reporting plugin is built from the hello dolly plugin
Author: MengelIT
Version: 0.1
Author URI: http://www.mengelit.com
*/

/*
Unless otherwise specified herein, MengelIT makes no warranty to customer
or any other person or entity, whether express, implied or statutory, as to the
description, quality, merchantability, completeness or fitness for any purpose,
or any services or products provided hereunder.

Limitation of Liability: The Agreement does not cover losses or corruption
of data, damage due to external causes not limited to unauthorized services
rendered by other than MengelIT, acts of God or any other situation out of the
control of MengelIT. MengelIT will not be liable to customer or any third party for
any indirect, consequential, incidental, reliance, special exemplary, or punitive
damages (including lost profits and lost revenues). In no event will MengelIT be
liable to Customer for any amount in excess of the aggregate amount MengelIT
has collected from Customer.

*/
// Hook for adding admin menus
add_action('admin_menu', 'mt_add_reports_pages');

// action function for above hook
function mt_add_reports_pages() {

    // Add a new top-level menu:
    add_menu_page('Reports', 'Reports', 'administrator', 'mt-top-level-handle', 'mt_toplevel_page');

    // Add a submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', 'Sponsors & Leads', 'Sponsors & Leads', 'administrator', 'sub-page', 'mt_sublevel_page');

}

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function mt_toplevel_page() {
    echo "<h2>Reports:</h2>";
	echo "<p>Please select one of the available reports.</p><hr>";
}

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function mt_sublevel_page() {
    echo "<h2>Sponsors & Leads</h2>";
	echo "<hr>";
	CREATEDATEPICKERFORM();
}

function CREATEDATEPICKERFORM()
{
	//import class into the page
	include_once('reports-config.php');
	require_once('calendar/classes/tc_calendar.php');
	global $wpdb;
	#header("<link href = \"/wp-content/plugins/dev-reports/style.css\" type=\"text/css\" rel=stylesheet>");
	#header("");
	echo "<script language=\"javascript\" src=\"/wp-content/plugins/dev-reports/calendar/calendar.js\"></script>";
	echo "<br>";
	echo "<form action=\"\" method=\"post\" name=\"report_form\" id=\"report_form\">";
	echo "<table cellspacing=\"10\" cellpadding=\"10\" style=\"font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px; color: #333333; 	border: 1px solid #666666;	background-color: #CCDEDA;	margin: 0px 0px 0px 8px; width:600px\;\">";
	echo "<tr><td><p><b>Start Date</b></p></td><td><p><b>End Date</b></p></td></tr>";
	echo "<tr><td align=\"center\" valign=\"top\">";



	$thisweek = date('W');
	$thisyear = date('Y');						
	$dayTimes = getDaysInWeek($thisweek, $thisyear);
	//----------------------------------------
	if( isset($_REQUEST["sdate"]) && isset($_REQUEST["edate"]))
	{
		$startdate = isset($_REQUEST["sdate"]) ? $_REQUEST["sdate"] : "";
		$enddate = isset($_REQUEST["edate"]) ? $_REQUEST["edate"] : "";
		#$enddate = date( 'Y-m-d H:i:s', strtotime("+1 day", strtotime($enddate)) );
		#echo $startdate . " = selected STARTDATE<BR>";
		#echo $enddate . " = select  end DATE<BR>";
	}
	else 
	{		
		$startdate = date('Y-m-d');
		#echo $startdate . " = DEFAULT STARTDATE<BR>";
		$enddate = date('Y-m-d');
		#$enddate = date( 'Y-m-d H:i:s', strtotime("+1 day", strtotime($enddate)) );
		#echo $enddate . " = DEFAULT END DATE<BR>";
	}		
	
	$myStartCalendar = new tc_calendar("sdate");
	
	#$myStartCalendar->setIcon("");
	
	$myStartCalendar->setDate(date('d', strtotime($startdate)), date('m', strtotime($startdate)), date('Y', strtotime($startdate)));
	 $myStartCalendar->setPath("/wp-content/plugins/dev-reports/calendar");
	 $myStartCalendar->setYearInterval(1970, 2020);
	 $myStartCalendar->dateAllow('2008-05-13', '2015-03-01', false);
	 $myStartCalendar->startMonday(true);
	 $myStartCalendar->writeScript();

	echo "</td>";
	echo "<td align=\"center\" valign=\"bottom\">";
    $myEndCalendar = new tc_calendar("edate");
	 #$myEndCalendar->setIcon("iconCalendar.gif");
$myEndCalendar->setDate(date('d', strtotime($enddate)), date('m', strtotime($enddate)), date('Y', strtotime($enddate)));
	  $myEndCalendar->setPath("/wp-content/plugins/dev-reports/calendar/");
	  $myEndCalendar->setYearInterval(1970, 2020);
	  $myEndCalendar->dateAllow('2008-05-13', '2015-03-01', false);
	  $myEndCalendar->startMonday(true);
	  $myEndCalendar->writeScript();
	  
	echo "</td>";
	echo "<td>";
	echo "<input type=\"submit\" name=\"button2\" id=\"button2\" value=\"Generate Report\">";
	echo "</td><td>&nbsp;</td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
	echo "<br><br>";
if( isset($_REQUEST["sdate"]) && isset($_REQUEST["edate"]))
	{
		global $SDATE, $EDATE;
		$SDATE = isset($_REQUEST["sdate"]) ? $_REQUEST["sdate"] : "";
		$EDATE = isset($_REQUEST["edate"]) ? $_REQUEST["edate"] : "";
		$SDATE = date( 'Y-m-d H:i:s', strtotime($SDATE) );
		$EDATE = date( 'Y-m-d H:i:s', strtotime("+1 day", strtotime($EDATE)) );
		#echo "<br>" . $SDATE . "<br>" . $EDATE;

		//Retrieve File Download Activity -> class_downloadactivity.php
		$filedownloads = get_downloadinfo();
		
		//set up array of FileDL classes -> class_downloadactivity.php
		global $arrayof_FileDL;
		$deleteFileDL1 = new FileDL;
		$deleteFileDL2 = new FileDL;
		$arrayof_FileDL = array ($deleteFileDL1, $deleteFileDL2);
		
		array_pop($arrayof_FileDL);
		array_pop($arrayof_FileDL);
		

		//Fill Array of FileDL classes -> class_downloadactivity.php
		Fill_FileDL_Array($filedownloads);
		
		//set up array of Lead classes -> class_leads.php
		global $arrayof_Leads;
		$deleteLead1 = new Lead;
		$deleteLead2 = new Lead;
		$arrayof_Leads = array ($deleteLead1, $deleteLead2);
		
		array_pop($arrayof_Leads);
		array_pop($arrayof_Leads);

		//Fill Array of Leads -> class_leads.php
		Fill_Leads_Array();
		/*
		echo "<pre>";
		print_r($arrayof_FileDL);
		echo "</pre>";
		
		echo "<pre>";
		print_r($arrayof_Leads);
		echo "</pre>";
		*/
		//Call Create Sponsor And Leads Report from report-builder.php
		$report_string = Create_Sponsor_N_Leads_Report();

		echo $report_string;
		echo "<br><br>";
	}
}

function getDaysInWeek ($weekNumber, $year, $dayStart = 1) 
{		  
		  // Count from '0104' because January 4th is always in week 1
		  // (according to ISO 8601).
		  $time = strtotime($year . '0104 +' . ($weekNumber - 1).' weeks');
		  // Get the time of the first day of the week
		  $dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
		  // Get the times of days 0 -> 6
		  $dayTimes = array ();
		  for ($i = 0; $i < 7; ++$i) 
		  {
			$dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
			}
		  // Return timestamps for mon-sun.
		  return $dayTimes;
}
?>
