<?php

//initilize the page
require_once 'init.web.php';
$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}
/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Пресса о нас";

/* ---------------- END PHP Custom Scripts ------------- */




$all_arr=array();

	$newstext="";
	if ($result = mysqli_query($conn, "SELECT * FROM news ORDER BY publish_date DESC")) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			
			$timestamp = $row["timestamp"];
			$datetimeFormat = 'Y-m-d';

			$date = new \DateTime();
			// If you must have use time zones
			// $date = new \DateTime('now', new \DateTimeZone('Europe/Helsinki'));
			$date->setTimestamp($timestamp);
			//echo $date->format($datetimeFormat);
			
			$start_url="/news/".translit($row["title"]);
			
			 $ret_url="";
			  if ($result_q = mysqli_query($conn, "SELECT * FROM news WHERE url='".$start_url."'")) {
				$result_q->fetch_array(MYSQLI_ASSOC);
				$tot_url=0;
				foreach ($result_q as $row_q)	
				{
					$tot_url=$tot_url+1;
				}
				
				 //echo $tot_url."<br>";
				
				$result_q->close();
				
				if ($tot_url>1) {
					$ret_url=$start_url."-new-".($tot_url);
					 $check_url= array("res"=>true,"url"=>$ret_url);
				}
				else
				{
					 $check_url= array("res"=>false);
				}	
			  }
			
			
			
			$out_url="";
			//$check_url=SameTitle("/news/".translit($row["title"]));
			if ($check_url["res"]==true) {
				$out_url=$check_url["url"];
			}	
			else
			{
				$out_url=$start_url;
			}	
			
			$all_arr[]=array(
			"id"=>$row["id"],
			"url"=>$out_url,
			"small_pic"=>"http://f.romir18530.nichost.ru/img/".$row["small_pic"],
			"publish_date"=>$date->format($datetimeFormat)
			);
			//$result_update = mysqli_query($conn, "UPDATE news SET url='".$out_url."' WHERE id=".$row["id"]);
			//print_array($result_update);
			
		}
		$result->close();
	} 
	
	
	
	foreach ($all_arr as $row)	
	{
		$result = mysqli_query($conn, "UPDATE news SET url='".$row["url"]."', small_pic='".$row["small_pic"]."', publish_date='".$row["publish_date"]."' WHERE id=".$row["id"]);
		//$result = mysqli_query($conn, "UPDATE news SET url='".$row["url"]."' WHERE id=".$row["id"]);
		print_array($result);
	}	
	
	
	print_array($all_arr);
	
	
	
  function SameTitle($oldurl)
  {
	 
	  $ret_url="";
	  if ($result_q = mysqli_query($conn, "SELECT * FROM news WHERE url='".$oldurl."'")) {
		$result_q->fetch_array(MYSQLI_ASSOC);
		$tot_url=0;
		foreach ($result_q as $row_q)	
		{
			$tot_url=$tot_url+1;
		}
		
		 echo $tot_url."<br>";
		
		$result->close();
		
		if ($tot_url>0) {
			$ret_url=$oldurl."-new-".($tot_url+1);
			return array("res"=>true,"url"=>$ret_url);
		}
		else
		{
			return array("res"=>false);
		}	
	  }
  }


?>