<?php 
 
header_remove("X-Powered-By");
 
session_start();

 

header('Access-Control-Allow-Origin: *'); 
$rand=rand(100, 20000);
include("_connect.php"); 
include("_f.php"); 

//check_404(); 
 

?>