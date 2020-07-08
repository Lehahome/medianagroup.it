<?php

require_once 'init.web.php';
$rez_arr=array("result"=>false);


//пользователи
$user=$_POST["user"];
$user_id=$_POST["user_id"];
$fio=$_POST["fio"];
$email=$_POST["email"];
$password=$_POST["password"];
$phone=$_POST["phone"];
$role=$_POST["role"];
$user_menu_id=$_POST["user_menu_id"];


	

$update_sub=$_POST["update_sub"];
$update_parent=$_POST["update_parent"];
$insert_sub=$_POST["insert_sub"];
$upmenu=$_POST["upmenu"];
$lang=$_POST["lang"];
$downmenu=$_POST["downmenu"];

$page=$_POST["page"];

$page_id=$_POST["page_id"];
$new_id=$_POST["new_id"];
$press_id=$_POST["press_id"];
$study_id=$_POST["study_id"];

$vacancy_id=$_POST["vacancy_id"];


$html=$_POST["html"];



 $oper=$_POST["oper"];
 $index_id=$_POST["id"];
 $sort=$_POST["sort"];
 $active=$_POST["active"];
 $title=$_POST["title"];
 
 $short_url=$_POST["short_url"];
 
 $keywords=$_POST["keywords"];
 
 $description=$_POST["description"];
 
 $count=$_POST["count"];
 $time=$_POST["time"];
 $amount=$_POST["amount"];
 $amount_year=$_POST["amount_year"];
 $amount_start_year=$_POST["amount_start_year"];
 $language_id=$_POST["language_id"];
 
 $media=$_POST["media"];
 
 $period_geograpfy=$_POST["period_geograpfy"];
 $ca=$_POST["ca"];
 $cell1=$_POST["cell1"];
 $cell2=$_POST["cell2"];
 $cell3=$_POST["cell3"];
 $cell4=$_POST["cell4"];
 $cell5=$_POST["cell5"];
 $cell6=$_POST["cell6"];
 
 
 $type=$_POST["type"];
 $name=$_POST["name"];
 $start_day=$_POST["start_day"];
 //$language_id=$_POST["language_id"];
 //$amount_year=$_POST["amount_year"];
 $submission=$_POST["submission"];
 $start=$_POST["start"];
 $result=$_POST["result"];

$page_url=$_POST["page_url"];

//$rez_arr["txtresult"]=$result;



 

$rez_arr["update_sub"]=$update_sub;
$rez_arr["update_parent"]=$update_parent;
$rez_arr["insert_sub"]=$insert_sub;
$rez_arr["upmenu"]=$upmenu;
$rez_arr["lang"]=$lang;
$rez_arr["downmenu"]=$downmenu;
$rez_arr["page"]=$page;
$rez_arr["page_id"]=$page_id;
$rez_arr["oper"]=$oper;


$rez_arr["post"]=$_POST;







if (
isset($oper)&&$oper=="edit" &&isset($sort) &&isset($language_id) &&isset($title)&&isset($period_geograpfy)&&isset($ca)&&isset($cell1) &&isset($cell2) &&isset($cell3) &&isset($cell4)  &&isset($cell5) &&isset($cell6)  &&isset($index_id)
) 
{

	$rez_arr["in_edit_media"]="in_edit_media";
	
	$query_update="";
	
	if (!empty($index_id)) {
		
		if (!empty($title)){
			$title = mysqli_real_escape_string($conn, $title);	
			$query_update="UPDATE indexes_media SET title='".$title."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		}
		if (!empty($period_geograpfy)){
			$period_geograpfy = mysqli_real_escape_string($conn, $period_geograpfy);	
			$query_update="UPDATE indexes_media SET period_geograpfy='".$period_geograpfy."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		}
		if (!empty($ca)){
			$ca = mysqli_real_escape_string($conn, $ca);	
			$query_update="UPDATE indexes_media SET ca='".$ca."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		}
		
			$cell1 = mysqli_real_escape_string($conn, $cell1);	
			$query_update="UPDATE indexes_media SET cell1='".$cell1."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		
			$cell2 = mysqli_real_escape_string($conn, $cell2);	
			$query_update="UPDATE indexes_media SET cell2='".$cell2."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		 
			$cell3 = mysqli_real_escape_string($conn, $cell3);	
			$query_update="UPDATE indexes_media SET cell3='".$cell3."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		 
		 
			$cell4 = mysqli_real_escape_string($conn, $cell4);	
			$query_update="UPDATE indexes_media SET cell4='".$cell4."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		 
			$cell5 = mysqli_real_escape_string($conn, $cell5);	
			$query_update="UPDATE indexes_media SET cell5='".$cell5."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		 
			$cell6 = mysqli_real_escape_string($conn, $cell6);	
			$query_update="UPDATE indexes_media SET cell6='".$cell6."' WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		 
		
		if (!empty($language_id)){
			$query_update="UPDATE indexes_media SET language_id=".$language_id." WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		}
		
		if (!empty($sort)){
			$query_update="UPDATE indexes_media SET sort=".$sort." WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		}
		
		if (isset($active)){
			$query_update="UPDATE indexes_media SET active=".$active." WHERE id=".$index_id;
			mysqli_query($conn, $query_update);
		}
  	
	
	}
	
	
	

	
	//if (!empty($query_update)){
		//mysqli_query($conn, $query_update);
	//}
	
	//$rez_arr["query_update"]=$query_update;
	
	$rez_arr["result"]=true;	
	
}




if (
isset($oper)&&$oper=="add" &&isset($sort) &&isset($language_id) &&isset($title)&&isset($period_geograpfy)&&isset($ca)&&isset($cell1) &&isset($cell2) &&isset($cell3) &&isset($cell4)  &&isset($cell5) &&isset($cell6)  &&isset($index_id)
) 
{

	$rez_arr["in_add_media"]="in_add_media";
 
	
	
	$title = mysqli_real_escape_string($conn, $title);	
	$query_insert="INSERT INTO indexes_media (title, language_id, active) VALUES ('".$title."', ".$language_id.", ".$active.")";
	mysqli_query($conn, $query_insert);
	
	$edit_id=mysqli_insert_id($conn);
	
	
	if (isset($edit_id) && !empty($edit_id)) {
		
		
		if (!empty($period_geograpfy)){
			$period_geograpfy = mysqli_real_escape_string($conn, $period_geograpfy);	
			$query_update="UPDATE indexes_media SET period_geograpfy='".$period_geograpfy."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		}
		if (!empty($ca)){
			$ca = mysqli_real_escape_string($conn, $ca);	
			$query_update="UPDATE indexes_media SET ca='".$ca."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		}
		
			$cell1 = mysqli_real_escape_string($conn, $cell1);	
			$query_update="UPDATE indexes_media SET cell1='".$cell1."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		
			$cell2 = mysqli_real_escape_string($conn, $cell2);	
			$query_update="UPDATE indexes_media SET cell2='".$cell2."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		 
			$cell3 = mysqli_real_escape_string($conn, $cell3);	
			$query_update="UPDATE indexes_media SET cell3='".$cell3."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		 
	
		 
			$cell4 = mysqli_real_escape_string($conn, $cell4);	
			$query_update="UPDATE indexes_media SET cell4='".$cell4."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		 
			$cell5 = mysqli_real_escape_string($conn, $cell5);	
			$query_update="UPDATE indexes_media SET cell5='".$cell5."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		 
			$cell6 = mysqli_real_escape_string($conn, $cell6);	
			$query_update="UPDATE indexes_media SET cell6='".$cell6."' WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		 
		
	
		
		if (!empty($sort)){
			$query_update="UPDATE indexes_media SET sort=".$sort." WHERE id=".$edit_id;
			mysqli_query($conn, $query_update);
		}
		
		
  	
	
	}
	
	
	
 
	
	$rez_arr["result"]=true;	
	
}







//пользователи

if (isset($oper)&&$oper=="update_user" &&isset($user) &&$user==1 &&isset($user_id)  &&isset($fio) &&isset($email)&&isset($password)&&isset($phone)&&isset($role) ) {
	 
	
	$fio = mysqli_real_escape_string($conn, $fio);
	$email = mysqli_real_escape_string($conn, $email);
	$password = mysqli_real_escape_string($conn, $password);
	$phone = mysqli_real_escape_string($conn, $phone);
	
	
	$query_update="UPDATE users SET fio='".$fio."', email='".$email."', password='".$password."', phone='".$phone."', role=".$role." WHERE id=".$user_id;
	mysqli_query($conn, $query_update);
	
	
	$rez_arr["query_update"]=$query_update;
	
	if (isset($user_menu_id) && count($user_menu_id)>0){
		$rez_arr["user_menu_id"]=$user_menu_id;
		$query_delete="DELETE FROM user_menu_visibility  WHERE user_id=".$user_id;
		mysqli_query($conn, $query_delete);
		$rez_arr["query_delete"]=$query_delete;
		
		$query = 'INSERT INTO user_menu_visibility (user_id,menu_id) VALUES ';
		foreach( $user_menu_id as $item ){
			$query .= "( ".$user_id.", ".$item." ),";
		}

		$query = rtrim( $query, ',');
		mysqli_query($conn, $query);
		$rez_arr["query_insert"]=$query;
		
	}
	
	
	
	$rez_arr["result"]=true;
}





if (isset($oper)&&$oper=="add_user" &&isset($user) &&$user==1   &&isset($fio) &&isset($email)&&isset($password)&&isset($phone)&&isset($role) ) {
	 
	
	$fio = mysqli_real_escape_string($conn, $fio);
	$email = mysqli_real_escape_string($conn, $email);
	$password = mysqli_real_escape_string($conn, $password);
	$phone = mysqli_real_escape_string($conn, $phone);
	
	

	
	$query = "INSERT INTO users (fio,email,password,phone,role) VALUES( '".$fio."', '".$email."', '".$password."', '".$phone."', ".$role." )";
	mysqli_query($conn, $query);
	
	$user_id=mysqli_insert_id($conn);
	
	$rez_arr["query"]=$query;
	$rez_arr["user_id"]=$user_id;
	
	
	if (isset($user_menu_id) && count($user_menu_id)>0){
		$rez_arr["user_menu_id"]=$user_menu_id;
		
		
		$query = 'INSERT INTO user_menu_visibility (user_id,menu_id) VALUES ';
		foreach( $user_menu_id as $item ){
			$query .= "( ".$user_id.", ".$item." ),";
		}

		$query = rtrim( $query, ',');
		mysqli_query($conn, $query);
		$rez_arr["query_insert"]=$query;
		
	}
	
	
	
	$rez_arr["result"]=true;
}





if (isset($oper)&&$oper=="delete_user" &&isset($user) &&$user==1 &&isset($user_id)) {
	
	$query_delete="DELETE FROM users  WHERE id=".$user_id;
	mysqli_query($conn, $query_delete);
	$rez_arr["query_delete"]=$query_delete;
	
	
	$query_menu_visibility_delete="DELETE FROM user_menu_visibility  WHERE user_id=".$user_id;
	mysqli_query($conn, $query_menu_visibility_delete);
	$rez_arr["query_menu_visibility_delete"]=$query_menu_visibility_delete;
	
	$rez_arr["result"]=true;
}





if (isset($oper)&&$oper=="check_url" &&isset($title) ) {
	 $title=$_REQUEST["title"];
	 $new_url=translit($title);
	 $rez_arr["new_url"]=$new_url;
	 
	 if (isset($page_url) && $page_url!="") {
		$rez_arr["page_url"]=$page_url;
		$new_url=$page_url;		
	 }
	 
	 //$rez_arr["new_url"]=$new_url;
	 $rez_arr["goturl"]=false;
	 $query="SELECT * FROM pages WHERE url='/".$new_url."'";
	 $rez_arr["query"]=$query;
	 
	 if ($result = mysqli_query($conn, $query)) {
		//$result->fetch_array(MYSQLI_ASSOC);
		if (mysqli_num_rows($result)>0) {
			$rez_arr["goturl"]=true;
		}
		
		$result->close();
	} 
	 
}	



if (isset($oper)&&$oper=="GetShortUrl") {
	 
	$rez_arr["result"]=true;
	$rez_arr["short_url"]=CreateShortUrl();
	
}




if (isset($oper)&&$oper=="delete_page" && isset($page_id)) {
	$query_delete="DELETE FROM pages WHERE id=".$page_id;
	$rez_arr["result"]=mysqli_query($conn, $query_delete);
	
	
	$query_delete_short_url="DELETE FROM short_url WHERE page_id=".$page_id;
	mysqli_query($conn, $query_delete_short_url);
	
	
}



if (isset($oper)&&$oper=="delete_new" && isset($new_id)) {
	$query_delete="DELETE FROM news WHERE id=".$new_id;
	$rez_arr["result"]=mysqli_query($conn, $query_delete);
	
	$query_delete_short_url="DELETE FROM short_url WHERE new_id=".$new_id;
	mysqli_query($conn, $query_delete_short_url);
	
}




if (isset($oper)&&$oper=="delete_press" && isset($press_id)) {
	$query_delete="DELETE FROM press WHERE id=".$press_id;
	$rez_arr["result"]=mysqli_query($conn, $query_delete);
	
	$query_delete_short_url="DELETE FROM short_url WHERE press_id=".$press_id;
	mysqli_query($conn, $query_delete_short_url);
	
}




if (isset($oper)&&$oper=="delete_vacancy" && isset($vacancy_id)) {
	$query_delete="DELETE FROM vacancy WHERE id=".$vacancy_id;
	$rez_arr["result"]=mysqli_query($conn, $query_delete);
}



if (isset($oper)&&$oper=="delete_study" && isset($study_id)) {
	$query_delete="DELETE FROM studies WHERE id=".$study_id;
	$rez_arr["result"]=mysqli_query($conn, $query_delete);
	
	
	$query_delete_short_url="DELETE FROM short_url WHERE study_id=".$study_id;
	mysqli_query($conn, $query_delete_short_url);
	
	
}



if (isset($oper)&&$oper=="edit" &&isset($index_id) &&isset($active) &&isset($type)&&isset($name)&&isset($start_day)&&isset($submission) &&isset($result) &&isset($language_id) ) {
		
	$name = mysqli_real_escape_string($conn, $name);
	$submission = mysqli_real_escape_string($conn, $submission);
	// $start = mysqli_real_escape_string($conn, $start);
	$result = mysqli_real_escape_string($conn, $result);
	
	$query_update="UPDATE omnibus SET language_id=".$language_id.", active=".$active.", type=".$type.", name='".$name."', start_day='".$start_day."',	submission='".$submission."', result='".$result."' WHERE id=".$index_id;
	mysqli_query($conn, $query_update);
	
	$rez_arr["result"]=true;
}


if (isset($oper)&&$oper=="add"  &&isset($active) &&isset($type)&&isset($name)&&isset($start_day)&&isset($submission) &&isset($result) &&isset($language_id) ) {
	 
	
	$name = mysqli_real_escape_string($conn, $name);
	$submission = mysqli_real_escape_string($conn, $submission);
	// $start = mysqli_real_escape_string($conn, $start);
	$result = mysqli_real_escape_string($conn, $result);
	
	$query_insert="INSERT INTO omnibus (language_id, active,type,name,start_day,submission,result) VALUES (".$language_id.", ".$active.", ".$type.", '".$name."', '".$start_day."',	'".$submission."', '".$result."')";
	//$rez_arr["query_insert"]=$query_insert;
	mysqli_query($conn, $query_insert);
	
	$rez_arr["result"]=true;
}





if (isset($oper)&&$oper=="edit" &&isset($index_id) &&isset($active)  &&isset($sort) &&isset($title)&&isset($count)&&isset($time)&&isset($amount)&&isset($amount_year)&&isset($amount_start_year)&&isset($language_id)&&isset($media) ) {
	 
	 //$media
	
	$title = mysqli_real_escape_string($conn, $title);
	
	
	$add_update="";
	if (!empty($amount)) {
		$add_update.=", amount=".$amount;
	}
	else
	{
		$add_update.=", amount=NULL";
	}	
	
	
	if (!empty($amount_year)) {
		$add_update.=", amount_year=".$amount_year;
	}
	else
	{
		$add_update.=", amount_year=NULL";
	}
	
	
	if (!empty($amount_start_year)) {
		$add_update.=", amount_start_year=".$amount_start_year;
	}
	else
	{
		$add_update.=", amount_start_year=NULL";
	}	
	
	
	
	
	if (!empty($media)) {
		$media_txt=mysqli_real_escape_string($conn, $media); 
		$add_update.=", media='".$media_txt."'";
	}
	else
	{
		$add_update.=", media=NULL";
	}
	
	
	
	
	
	
	$query_update="UPDATE indexes SET language_id=".$language_id.", active=".$active.", sort=".$sort.", title='".$title."', count='".$count."',	time='".$time."'".$add_update." WHERE id=".$index_id;
	mysqli_query($conn, $query_update);
	
	
	$rez_arr["query_update"]=$query_update;
	
	$rez_arr["result"]=true;
}

if (isset($oper)&&$oper=="add"&&isset($active) &&isset($title)&&isset($count)&&isset($time)&&isset($amount)&&isset($amount_year)&&isset($amount_start_year)&&isset($sort)&&isset($media) ) {
	
	if (!empty($title)) {	
		$title = mysqli_real_escape_string($conn, $title);
	}
     else
	 {
		$title=''; 
	 } 
	
	if (empty($amount)) {
		$amount='NULL';
	}
	if (empty($amount_year)) {
		$amount_year='NULL';
	}
	if (empty($amount_start_year)) {
		$amount_start_year='NULL';
	}
	
	if (empty($sort)) {
		$sort=0;
	}
	
	if (!empty($media)) {
		$media = mysqli_real_escape_string($conn, $media);
	}
		else
	{
		$media='';
	}	

	
	
	 $query_insert="INSERT INTO indexes (media,sort,language_id,active,title,count,time,amount,amount_year,amount_start_year) VALUES ('".$media."',".$sort.",".$language_id.",".$active.", '".$title."', '".$count."', '".$time."', ".$amount.", ".$amount_year.", ".$amount_start_year.")";
	 mysqli_query($conn, $query_insert);
	
	
	
	// $stmt = $mysqli->prepare("INSERT INTO indexes (media,sort,language_id,active,title,count,time,amount,amount_year,amount_start_year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	
	// $stmt->bind_param('ss', $media, $sort, $language_id, $active, $title, $count,$time, $amount,$amount_year,$amount_start_year );



	// $stmt->execute();
	
	
	
	
	
	$rez_arr["query_insert"]=$query_insert;
	
	$rez_arr["post"]=$_POST;
	
	$rez_arr["result"]=true;
}





if (isset($page)) {
	$rez_arr["html"]=$html;
	$html = mysqli_real_escape_string($conn, $html);
	
	
	
	
	
	
	if (isset($short_url) && $short_url!="") {
		 $gotrec=0;
	  	if ($result = mysqli_query($conn, "SELECT short_url.*
	FROM short_url 
	WHERE short_url.page_id=".$page_id)) {
		$result->fetch_array(MYSQLI_ASSOC);
		
		foreach ($result as $row)	
		{
		  $gotrec=1;	
		}
		$result->close();
	}
	  
	  
	  if ($gotrec==1) {
		
		 $query="UPDATE short_url SET  short_url='".$short_url."' WHERE  page_id=".$page_id;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	  } else
      {
		  
		  $query_insert="INSERT INTO short_url (page_id, short_url) VALUES (".$page_id.", '".$short_url."')";
		  mysqli_query($conn, $query_insert);
		  
	  }		
	}
	
	
	
	
	
	if (isset($title) && $title!="") {
		 $title = mysqli_real_escape_string($conn, $title);
		 $query_update="UPDATE pages SET short_name='".$title."' WHERE id=".$page_id;
		mysqli_query($conn, $query_update);
	}
	
	
	if (isset($keywords)) {
		 $keywords = mysqli_real_escape_string($conn, $keywords);
		 $query_update="UPDATE pages SET keywords='".$keywords."' WHERE id=".$page_id;
		 mysqli_query($conn, $query_update);
	}
	
	
	if (isset($description)) {
		 $description = mysqli_real_escape_string($conn, $description);
		 $query_update="UPDATE pages SET description='".$description."' WHERE id=".$page_id;
		 mysqli_query($conn, $query_update);
	}
	
	 
	 if (isset($page_url) && $page_url!="") {
		$rez_arr["page_url"]=$page_url;
		$page_url = str_replace('/','',$page_url);
		$new_url="/".$page_url;
		 $query_update="UPDATE pages SET url='".$new_url."' WHERE id=".$page_id;
		mysqli_query($conn, $query_update);
		
	 }
	
	
	$query_update="UPDATE pages SET html='".$html."' WHERE id=".$page_id;
	mysqli_query($conn, $query_update);
	//$rez_arr["query_update"]=$query_update;
	$rez_arr["result"]=true;
}	


if (isset($upmenu)) {
		if (isset($insert_sub)) {
			$query_insert="insert into footer_menu (title, url, parent, sort, language_id) VALUES ";
			foreach($insert_sub as $item)
			{
			  $query_insert.="('".$item['title']."', '".$item['url']."', ".$item['parent_id'].", ".$item['sort'].", ".$lang."),";
			  
			}	
			$query_insert=substr($query_insert, 0, -1);
			$rez_arr["query_insert"]=$query_insert;
			if ($result = mysqli_query($conn, $query_insert)) {
			  $rez_arr["result"]=true;
			} 
		} 




	if (isset($update_sub)) {
		
				
		foreach($update_sub as $item)
		{
		  $query_update="UPDATE footer_menu SET title='".$item['title']."', url='".$item['url']."', sort=".$item['sort'].", active=".$item['active'].", language_id=".$lang." WHERE id=".$item["id"];
		  mysqli_query($conn, $query_update);
		  
		}	
		
		  $rez_arr["result"]=true;
		
	}




	if (isset($update_parent)) {
		
				
		foreach($update_parent as $item)
		{
		  $query_update="UPDATE footer_menu SET title='".$item['title']."', text='".$item['text']."', sort=".$item['sort'].", language_id=".$lang." WHERE id=".$item["id"];
		  mysqli_query($conn, $query_update);
		  
		}	
		
		  $rez_arr["result"]=true;
		
	}
}


if (isset($downmenu)) {
		if (isset($insert_sub)) {
			$query_insert="insert into header_menu (title, url, parent, sort, language_id) VALUES ";
			foreach($insert_sub as $item)
			{
			  $query_insert.="('".$item['title']."', '".$item['url']."', ".$item['parent_id'].", ".$item['sort'].", ".$lang."),";
			  
			}	
			$query_insert=substr($query_insert, 0, -1);
			$rez_arr["query_insert"]=$query_insert;
			if ($result = mysqli_query($conn, $query_insert)) {
			  $rez_arr["result"]=true;
			} 
		} 




	if (isset($update_sub)) {
		
				
		foreach($update_sub as $item)
		{
		  $query_update="UPDATE header_menu SET title='".$item['title']."', url='".$item['url']."', sort=".$item['sort'].", active=".$item['active'].", language_id=".$lang." WHERE id=".$item["id"];
		  mysqli_query($conn, $query_update);
		  
		}	
		
		  $rez_arr["result"]=true;
		
	}




	if (isset($update_parent)) {
		
				
		foreach($update_parent as $item)
		{
		  $query_update="UPDATE header_menu SET title='".$item['title']."',  sort=".$item['sort'].", language_id=".$lang." WHERE id=".$item["id"];
		  mysqli_query($conn, $query_update);
		  
		}	
		
		  $rez_arr["result"]=true;
		
	}
}



		
echo (json_encode($rez_arr,JSON_UNESCAPED_UNICODE));
?>