<?php 

require_once 'init.web.php';

//print_array($_POST);
//print_array($_FILES);


// exit;
// edit_new
// back_url
// title
// 

// 

 $editid=$_REQUEST["editid"];
 $title=$_REQUEST["title"];
 $active=$_REQUEST["active"];
 $keywords=$_REQUEST["keywords"];
 $description=$_REQUEST["description"];
 //$title=$_REQUEST["title"];
 $back_url=$_REQUEST["back_url"];
 $ckeditor=$_REQUEST["ckeditor"];
 
 $short_url=$_REQUEST["short_url"];
 
 $url=translit($title);
 
 
 $title = mysqli_real_escape_string($conn, $title);
 $keywords = mysqli_real_escape_string($conn, $keywords);
 $description = mysqli_real_escape_string($conn, $description);
 
 
 $publish_date=$_REQUEST["publish_date"];
 
 
 
 if (isset($short_url) && !empty($short_url) ) {
	  
	  $gotrec=0;
	  	if ($result = mysqli_query($conn, "SELECT short_url.*
	FROM short_url 
	WHERE short_url.press_id=".$editid)) {
		$result->fetch_array(MYSQLI_ASSOC);
		
		foreach ($result as $row)	
		{
		  $gotrec=1;	
		}
		$result->close();
	}
	  
	  
	  if ($gotrec==1) {
		
		 $query="UPDATE short_url SET  short_url='".$short_url."' WHERE  press_id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	  } else
      {
		  
		  $query_insert="INSERT INTO short_url (press_id, short_url) VALUES (".$editid.", '".$short_url."')";
		  mysqli_query($conn, $query_insert);
		  
	  }		  
}
 
 
 
 
 if (isset($title) && !empty($title) ) {
		
		 $query="UPDATE press SET  title='".$title."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
  if (isset($active) && !empty($active) ) {
		
		 $query="UPDATE press SET  active=".$active." WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 if (isset($keywords)) {
		
		 $query="UPDATE press SET  keywords='".$keywords."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 if (isset($description)) {
		
		 $query="UPDATE press SET  description='".$description."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 
 if (isset($publish_date) && !empty($publish_date) ) {
		
		 $query="UPDATE press SET  publish_date='".$publish_date."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 // if (isset($url) && !empty($url) ) {
		 // $url="/press/".$url;
		 // $query="UPDATE press SET  url='".$url."' WHERE  id=".$editid;
		 // if ($result = mysqli_query($conn, $query)) {
	
		// } else {
		// //error;
		// }
	 // }
 
 
 
 
 
 
	 if (isset($ckeditor) && !empty($ckeditor) ) {
		 $ckeditor = mysqli_real_escape_string($conn, $ckeditor);
		 $query="UPDATE press SET  html='".$ckeditor."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 
 
   if (isset($_FILES) && isset($_FILES['small_pic']) && !empty($_FILES['small_pic']['name']) ) {
    $file_name = $_FILES['small_pic']['name'];
    $file_name_tmp = $_FILES['small_pic']['tmp_name'];
    //$file_new_name = '/home/romir18530/f.romir18530.nichost.ru/docs/upload/pics/';
	$file_new_name = PICS_UPLOAD_FOLDER;
    $full_path = $file_new_name.$file_name;
	//$url='http://f.romir18530.nichost.ru/upload/pics/'.$file_name;
	$url='/upload/pics/'.$file_name;
    $http_path = $url;
    $error = '';
    if( move_uploaded_file($file_name_tmp, $full_path) ) {
		$query="UPDATE press SET  small_pic='".$url."' WHERE  id=".$editid;
		//echo $query; exit;
		if ($result = mysqli_query($conn, $query)) {
		//$result->fetch_array(MYSQLI_ASSOC);
		
			//$result->close();
		}
		
		
    } else {
    //error;
    }
   }
   
   
   
   
   if (isset($_FILES) && isset($_FILES['big_pic']) && !empty($_FILES['big_pic']['name']) ) {
    $file_name = $_FILES['big_pic']['name'];
    $file_name_tmp = $_FILES['big_pic']['tmp_name'];
    //$file_new_name = '/home/romir18530/f.romir18530.nichost.ru/docs/upload/pics/';
	$file_new_name = PICS_UPLOAD_FOLDER;
    $full_path = $file_new_name.$file_name;
	//$url='http://f.romir18530.nichost.ru/upload/pics/'.$file_name;
	$url='/upload/pics/'.$file_name;
    $http_path = $url;
    $error = '';
    if( move_uploaded_file($file_name_tmp, $full_path) ) {
		$query="UPDATE press SET  big_pic='".$url."' WHERE  id=".$editid;
		//echo $query; exit;
		if ($result = mysqli_query($conn, $query)) {
		//$result->fetch_array(MYSQLI_ASSOC);
		
			//$result->close();
		}
		
		
    } else {
    //error;
    }
   }
   
   
   
header("Location: ".$back_url); exit;  


?>