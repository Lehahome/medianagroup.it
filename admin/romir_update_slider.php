<?php 

require_once 'init.web.php';

 $editid=$_REQUEST["editid"];
 
 
 $title=$_REQUEST["title"];
 $back_url=$_REQUEST["back_url"];
 $ckeditor=$_REQUEST["ckeditor"];
  $page_url=$_REQUEST["page_url"];
 
 
 
 if (isset($title) && !empty($title) ) {
		
		 $query="UPDATE slider SET  title='".$title."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 if (isset($page_url) && !empty($page_url) ) {
		
		 $query="UPDATE slider SET  page_url='".$page_url."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 
 
 
	 if (isset($ckeditor) && !empty($ckeditor) ) {
		 $ckeditor = mysqli_real_escape_string($conn, $ckeditor);
		 $query="UPDATE slider SET  text='".$ckeditor."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 
 
   if (isset($_FILES) && isset($_FILES['background_image_url']) && !empty($_FILES['background_image_url']['name']) ) {
    $file_name = $_FILES['background_image_url']['name'];
    $file_name_tmp = $_FILES['background_image_url']['tmp_name'];
    //$file_new_name = '/home/romir18530/f.romir18530.nichost.ru/docs/upload/pics/';
	$file_new_name = PICS_UPLOAD_FOLDER;
    $full_path = $file_new_name.$file_name;
	//$url='http://f.romir18530.nichost.ru/upload/pics/'.$file_name;
	$url='/upload/pics/'.$file_name;
    $http_path = $url;
    $error = '';
    if( move_uploaded_file($file_name_tmp, $full_path) ) {
		$query="UPDATE slider SET  background_image_url='".$url."' WHERE  id=".$editid;
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