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
 $back_url=$_REQUEST["back_url"];
 $ckeditor=$_REQUEST["ckeditor"];
 $category=$_REQUEST["category"];
 $active=$_REQUEST["active"];
 $sort=$_REQUEST["sort"];

  //$query="UPDATE vacancy SET  active=".$active." WHERE  id=".$editid;
 //echo $query;
 //print_r($_REQUEST);
 //exit;

 
 
 $title = mysqli_real_escape_string($conn, $title);
 
 
 
 if (isset($title) && !empty($title) ) {
		
		 $query="UPDATE vacancy SET  title='".$title."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
  if (isset($sort) && !empty($sort) ) {
		
		 $query="UPDATE vacancy SET  sort=".$sort." WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 
 
 
 
 if (isset($category) && !empty($category) ) {
		
		 $query="UPDATE vacancy SET  category_id=".$category." WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 if (isset($active) && $active!="" ) {
		 
		 $query="UPDATE vacancy SET  active=".$active." WHERE  id=".$editid;
		 
		 //echo $query;
		 
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 
 
 
	 if (isset($ckeditor) && !empty($ckeditor) ) {
		 $ckeditor = mysqli_real_escape_string($conn, $ckeditor);
		 $query="UPDATE vacancy SET  html='".$ckeditor."' WHERE  id=".$editid;
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
	 }
 
 
 
 
   
     
   
   
header("Location: ".$back_url); exit;  


?>