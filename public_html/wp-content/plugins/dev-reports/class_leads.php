<?php

class Lead
{
		public $user_id;
		public $first_name; 	//first name
		public $last_name;       //Last Name
		public $addr1;           //address
		public $city;            //(City)
		public $thestate;        //(State)
		public $zip;          	//(Zip Code)
		public $country;     	//(Country)
		public $phone1;	        //(Phone)
		public $companyname;     //(Company)
		public $companytitle;    //(Title)
		public $nickname;       //(email)
		//public $SQL;
}

function parse_leadmeta($id)
{
	global $wpdb;
	$lead = new Lead;

	$results_usermeta = $wpdb->get_results('SELECT wp_usermeta.meta_key, wp_usermeta.meta_value FROM wp_usermeta WHERE wp_usermeta.user_id = ' . $id); 
	
	//$lead->SQL = $results_usermeta;
	$lead->user_id = $id;
	foreach($results_usermeta as $row)
	{
		if (preg_match("/first_name/", $row->meta_key )) 
		{
			$lead->first_name = $row->meta_value;
		}
		elseif (preg_match("/last_name/", $row->meta_key )) 
		{
			$lead->last_name = $row->meta_value;
		}
		elseif (preg_match("/addr1/", $row->meta_key )) 
		{
			$lead->addr1 = $row->meta_value;
		}
		elseif (preg_match("/city/", $row->meta_key )) 
		{
			$lead->city = $row->meta_value;
		}
		elseif (preg_match("/thestate/", $row->meta_key )) 
		{
			$lead->thestate = $row->meta_value;
		}
		elseif (preg_match("/zip/", $row->meta_key )) 
		{
			$lead->zip = $row->meta_value;
		}
		elseif (preg_match("/country/", $row->meta_key )) 
		{
			$lead->country = $row->meta_value;
		}
		elseif (preg_match("/phone1/", $row->meta_key )) 
		{
			$lead->phone1 = $row->meta_value;
		}
		elseif (preg_match("/companyname/", $row->meta_key )) 
		{
			$lead->companyname = $row->meta_value;
		}
		elseif (preg_match("/companytitle/", $row->meta_key )) 
		{
			$lead->companytitle = $row->meta_value;
		}
		elseif (preg_match("/nickname/", $row->meta_key )) 
		{
			$lead->nickname = $row->meta_value;
		}
	} //END FOREACH LOOP
	return $lead;
}

function Fill_Leads_Array()
{
	//The role of this Function is to loop through the array of FileDL Objects, extract each unique
	//user ID and create a corresponding object containing user information in Array of Leads.
	global $arrayof_Leads;
	//Global Array of Lead Objects
	global $arrayof_FileDL;
	//Global Array of FileDL Objects (clss_downloadactivity.php)
	foreach($arrayof_FileDL as $filedownloads)
	{
		//Loop through Array of FileDl objects
		if( count($arrayof_Leads) < 1 )
		{
			//if no lead objects have been created, make the first one
			$templead = new Lead;
			$templead = parse_leadmeta($filedownloads->user_id);
			array_push($arrayof_Leads, $templead);
		}
		else 
		{
			if(!find_duplicate_leads($filedownloads->user_id))
			{
				$templead = new Lead;
				$templead = parse_leadmeta($filedownloads->user_id);
				array_push($arrayof_Leads, $templead);
			}
		}
	}
}

function find_duplicate_leads($idnum)
{
	global $arrayof_Leads;
	foreach($arrayof_Leads as $existingLeads)
	{
		if($existingLeads->user_id == $idnum)
		{
			return true;
		}
	}
	return false;
}
?>