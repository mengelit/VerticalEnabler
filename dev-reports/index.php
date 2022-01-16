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


echo "<pre>";
print_r($arrayof_Leads);
echo "</pre>";

?>