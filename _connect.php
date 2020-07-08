<?php
include('db_config.php');
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
mysqli_query($conn, 'SET NAMES utf8');
?>