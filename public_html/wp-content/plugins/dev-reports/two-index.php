<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang = "en">
<head>
<link href = "style.css" type="text/css" rel=stylesheet>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="calendar/calendar.js"></script>
</head>
<body>

<form action="somewhere.php" method="post">
<?php
//get class into the page
require_once('calendar/classes/tc_calendar.php');

//instantiate class and set properties
	  $myCalendar = new tc_calendar("date3", true, false);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setDate(date('d', strtotime($date1))
            , date('m', strtotime($date1))
            , date('Y', strtotime($date1)));
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(1970, 2020);
	  $myCalendar->writeScript();	  
	  
	  $myCalendar = new tc_calendar("date4", true, false);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setDate(date('d', strtotime($date2))
           , date('m', strtotime($date2))
           , date('Y', strtotime($date2)));
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(1970, 2020);
//output the calendar
$myCalendar->writeScript();	  
?>
</form>


<?php

include_once('reports-config.php');

global $wpdb;

//Retrieve File Download Activity -> class_downloadactivity.php
$filedownloads = get_downloadinfo();

//set up array of FileDL classes -> class_downloadactivity.php
$deleteFileDL = new FileDL;
$arrayof_FileDL = array ($deleteclass);
global $arrayof_FileDL;
array_pop($arrayof_FileDL);

//Fill Array of FileDL classes -> class_downloadactivity.php
Fill_FileDL_Array($filedownloads);

//set up array of Lead classes -> class_leads.php
$deleteLead = new Lead;
$arrayof_Leads = array ($deleteLead);
global $arrayof_Leads;
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
?>
</body>
</html>