<?php
//echo "SELECT * FROM users WHERE email='".$_REQUEST["email"]."' AND password='".$_REQUEST["password"]."'"; exit;

require_once 'init.web.php';

		$in=0;
		if ($result = mysqli_query($conn, "SELECT * FROM users WHERE email='".$_REQUEST["email"]."' AND password='".$_REQUEST["password"]."'")) {
			if ($result->num_rows>0) {
				$in=1;
			}
			$result->close();
		} 
	if ($in==1) {
		$md5hash=md5($_REQUEST["email"].$_REQUEST["password"]."1qazxsw2");
		setcookie("sa_u", $md5hash, time() + 3600*24*365, '/');
		header("Location: ".APP_URL); exit;
		
	}
	else
	{
		header("Location: ".APP_URL."/login.php"); exit;
	}	

?>