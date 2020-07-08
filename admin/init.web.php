<?php

// if (!session_id()) session_start();

require_once 'init.php';

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
    "Home" => APP_URL
);

/*navigation array config

ex:
"dashboard" => array(
    "title" => "Display Title",
    "url" => "http://yoururl.com",
    "url_target" => "_self",
    "icon" => "fa-home",
    "label_htm" => "<span>Add your custom label/badge html here</span>",
    "sub" => array() //contains array of sub items with the same format as the parent
)

*/

	$menuserinfo=CheckUserFromCookie();


	 $all_page=array();
	
	if ($result = mysqli_query($conn, "SELECT * FROM pages ORDER BY id")) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			
			
			$all_page["page".$row["id"]] = array(
					"title" => $row["short_name"],
					"icon" => "fa-gear",
					"url" => APP_URL."/romir_edit_page.php?page_id=".$row["id"]
				);
			
		}
		$result->close();
	}

	

	$page_nav = array();
	
	if ($result_m = mysqli_query($conn, "SELECT * FROM user_menu ORDER BY id")) {
		$result_m->fetch_array(MYSQLI_ASSOC);
		foreach ($result_m as $row_m)	
		{
			if ($row_m["url"]!="") {
				$inarr=array(
					"id" => $row_m["id"],
					"title" => $row_m["title"],
					"icon" => $row_m["icon"],
					"url" => APP_URL."/".$row_m["url"]
				);
			}
			else
			{
				$inarr=array(
					"id" => $row_m["id"],
					"title" => $row_m["title"],
					"icon" => $row_m["icon"]
				);
				
			}	
			
			if ($row_m["index"]=="pages") {
				$inarr["sub"]=$all_page;
			}
			
			$page_nav[$row_m["index"]]=$inarr;
		}
		$result_m->close();
	}
	
 
 

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
$home_page_server_url="http://medianagroup.ru";
?>