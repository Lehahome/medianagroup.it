<?php 
 
$pieces=array();
$a_str=$_SERVER['REQUEST_URI'];
$in_pieces=explode("/",$a_str);
reset($in_pieces);
if (count($in_pieces)>0) {

	while (list($key, $val) = each($in_pieces)) {
	 if (isset($val{0}) && $val{0}!="?" && $val!="") {$pieces[]=$val;}
	}

}
 
//short_url

	$short_user_url="";
	$lastsymbol=substr($a_str, -1);
	if ($lastsymbol=="/"){
		$a_str1=$a_str;
		$a_str2=substr($a_str,0,-1);
	}
	else
	{
		$a_str1=$a_str;
		$a_str2=$a_str."/";
	}	

	// if ($result_f = mysqli_query($conn, "SELECT short_url.*, news.url AS new_url, studies.url AS study_url, press.url AS press_url, pages.url AS page_url
		// FROM short_url  
		// LEFT JOIN news ON news.id=short_url.new_id
		// LEFT JOIN studies ON studies.id=short_url.study_id
		// LEFT JOIN press ON press.id=short_url.press_id
		// LEFT JOIN pages ON pages.id=short_url.page_id
		// WHERE short_url='".$a_str1."' OR short_url='".$a_str2."'")) {
		// $result_f->fetch_array(MYSQLI_ASSOC);
		// $short_url_total=0;
		// $new_url="";
		// $study_url="";
		// $press_url="";
		// $page_url="";
		
		// foreach ($result_f as $row_f)	
		// {
			// $short_url_total=$short_url_total+1;
			// $new_url=$row_f["new_url"];
			// $study_url=$row_f["study_url"];
			// $press_url=$row_f["press_url"];
			// $page_url=$row_f["page_url"];
		// }
		
		// if ($short_url_total>0){
			// if ($new_url!=""){
				// header('Location: '.$new_url,true, 301);
			// } 
			
			// if ($study_url!=""){
				// header('Location: '.$study_url,true, 301);
			// } 
			
			// if ($press_url!=""){
				// header('Location: '.$press_url,true, 301);
			// } 
			
			// if ($page_url!=""){
				// header('Location: '.$page_url,true, 301);
			// }
			
			
			// exit;
		// }
	// }	
		

//short_url



if (count($pieces)==1 && $pieces[0]=="cart") {
	
	include("cart.php"); exit;
}

if ($a_str=="/") {
	include("htmlindex.php"); exit;
}

 

 

if (count($pieces)==1 && $pieces[0]=="post-request"&&isset($_POST["post"])) {
		$out_arr=array("errors"=>array());
		$out_arr["result"]=false;		
		
		$fio = mysqli_real_escape_string($conn, $_POST["name"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
		$address = mysqli_real_escape_string($conn, $_POST["address"]);
		$payment_type = mysqli_real_escape_string($conn, $_POST["payment_type"]);
		if ($payment_type=="payment_online"){
			$payment_type = "0";
		}
		if ($payment_type=="payment_on_delivery"){
			$payment_type = "2";
		}
		if ($payment_type=="payment_cash_moscow"){
			$payment_type = "3";
		}
		
		
		$cart = mysqli_real_escape_string($conn, $_POST["ctr"]);
		$cart_arr = explode(";",$cart);
		
		
		$query="INSERT INTO customers (fio, email, phone,address) VALUE ('".$fio."', '".$email."', '".$phone."','".$address."')";
		 if ($result = mysqli_query($conn, $query)) {
			 
			 
					$customer_id=mysqli_insert_id($conn);
					$out_arr["last_id"]=$last_id;	
					
					  $query_short_url="INSERT INTO orders (customer_id, payment) VALUE ('".$customer_id."','".$payment_type."')";
					 if ($result_short_url = mysqli_query($conn, $query_short_url)) {
							$order_id=mysqli_insert_id($conn);
							$out_arr["order_id"]=$order_id;
							$out_arr["result"]=$result_short_url;
							
							
							foreach ($cart_arr as $obj){
								if (!empty($obj)){
									$obj_arr = explode(",", $obj);
									$good_id = $obj_arr[0];
									$quantity = $obj_arr[1];
									$query_item="INSERT INTO order_items (order_id, good_id, quantity) VALUE ('".$order_id."', '".$good_id."', '".$quantity."')";
									 if ($result_item = mysqli_query($conn, $query_item)) {
										 
								
									}
								}
								
							}
							
							
							
							
					} else {
					//error;
					}
				
	
		} else {
		//error;
		}
		
		
		
		$out_arr["post"]=$_POST;
		
		echo(json_encode($out_arr, JSON_UNESCAPED_UNICODE));
		exit;
}




 

 
function print_array($aArray)
{
    echo '<pre>';
    print_r($aArray);
    echo '</pre>';
}

 

function check_404()
{
	global $conn, $pieces, $a_str;
	
	
	
	$this_page=0;
	if ($result = mysqli_query($conn, "SELECT pages.* FROM pages WHERE pages.url='$a_str'")) {
		if (mysqli_num_rows($result)>0) {
			$this_page=1;
		}
	    $result->close();	
	}
	
	$this_new=0;
	if ($result = mysqli_query($conn, "SELECT news.* FROM news WHERE news.url='$a_str'")) {
		if (mysqli_num_rows($result)>0) {
			$this_new=1;
		}
	    $result->close();	
	}
	
	
	$this_press=0;
	if ($result = mysqli_query($conn, "SELECT press.* FROM press WHERE press.url='$a_str'")) {
		if (mysqli_num_rows($result)>0) {
			$this_press=1;
		}
	    $result->close();	
	}
	
	
	$this_study=0;
	if ($result = mysqli_query($conn, "SELECT studies.* FROM studies WHERE studies.url='$a_str'")) {
		if (mysqli_num_rows($result)>0) {
			$this_study=1;
		}
	    $result->close();	
	}
	
	$count_get=0;
	if (isset($_GET)) {
		$count_get=count($_GET);
	}
	
	$count_post=0;
	if (isset($_POST)) {
		$count_post=count($_POST);
	}
	
	
	
	
	$this_main_page=0;
	if ($a_str=="/" || (count($pieces)==1 && $pieces[0]=="eng") ) {$this_main_page=1;}
	
	$news_page=0;
	if ($a_str=="/news" || $a_str=="/news-eng") {$news_page=1;}
	if (count($pieces)==1 && ($pieces[0]=="news" || $pieces[0]=="news-eng") && isset($_GET["from"])  && isset($_GET["to"])  && $count_get==3) {$news_page=1; }
	
	if (count($pieces)==1 && ($pieces[0]=="news" || $pieces[0]=="news-eng") && isset($_GET["page"])  && $count_get==2) {
		$news_page=1; 
	}
	
	if (count($pieces)==1 && ($pieces[0]=="news" || $pieces[0]=="news-eng") && isset($_GET["from"])  && isset($_GET["to"])  &&  isset($_GET["page"]) && $count_get==4) {$news_page=1; }
	
	
	
	
	
	$search_page=0;
	
	if (count($pieces)==1 && $pieces[0]=="search-result") {
		$search_page=1;
	}
	
	
	
	
	
	$press_page=0;
	//if ($a_str=="/press" || $a_str=="/press-eng") {$press_page=1;}
	if ($a_str=="/press") {$press_page=1;}
	//if (count($pieces)==1 && ($pieces[0]=="press" || $pieces[0]=="press-eng") && isset($_GET["from"])  && isset($_GET["to"])  && $count_get==3) {$press_page=1; }
	if (count($pieces)==1 && $pieces[0]=="press" && isset($_GET["from"])  && isset($_GET["to"])  && $count_get==3) {$press_page=1; }
	
	//if (count($pieces)==1 && ($pieces[0]=="press" || $pieces[0]=="press-eng") && isset($_GET["page"])  && $count_get==2) {
	if (count($pieces)==1 && $pieces[0]=="press"  && isset($_GET["page"])  && $count_get==2) {	
		$press_page=1; 
	}
	
	
	//if (count($pieces)==1 && ($pieces[0]=="press" || $pieces[0]=="press-eng") && isset($_GET["from"])  && isset($_GET["to"])  &&  isset($_GET["page"]) && $count_get==4) {$press_page=1; }
	if (count($pieces)==1 && $pieces[0]=="press" && isset($_GET["from"])  && isset($_GET["to"])  &&  isset($_GET["page"]) && $count_get==4) {$press_page=1; }
	
	
	
	
	$studies_page=0;
	if ($a_str=="/studies" || $a_str=="/studies-eng") {$studies_page=1;}
	if (count($pieces)==1 && ($pieces[0]=="studies" || $pieces[0]=="studies-eng") && isset($_GET["from"])  && isset($_GET["to"])  && $count_get==3) {$studies_page=1; }
	
	if (count($pieces)==1 && ($pieces[0]=="studies" || $pieces[0]=="studies-eng") && isset($_GET["page"])  && $count_get==2) {
		$studies_page=1; 
	}
	
	
	
	if (count($pieces)==1 && ($pieces[0]=="studies" || $pieces[0]=="studies-eng") && isset($_GET["from"])  && isset($_GET["to"])  &&  isset($_GET["page"]) && $count_get==4) {$studies_page=1; }
	
	
	
	$vacancy_professional_page=0;
	if ($a_str=="/vacancy/professional") {$vacancy_professional_page=1;}
	
	$vacancy_trainee_page=0;
	if ($a_str=="/vacancy/trainee") {$vacancy_trainee_page=1;}
	
	
	$vacancy_student_page=0;
	if ($a_str=="/vacancy/student") {$vacancy_student_page=1;}
	
	// $subscribe_page=0;
	// if ($a_str=="/subscribe") {$subscribe_page=1;}
	
	
	
	$subscribe_page=0;
	
	if (count($pieces)==1 && $pieces[0]=="subscribe") {
		$subscribe_page=1;
	}
	
	$event_page=0;
	
	if (count($pieces)==1 && $pieces[0]=="event") {
		$event_page=1;
	}
    
    
    $event_entertainment_page=0;
	
	if (count($pieces)==1 && $pieces[0]=="event_entertainment") {
		$event_entertainment_page=1;
	}
	
	// --> ";
	
	if (
		$this_page==0 && $this_new==0 && $this_press==0 && 
		$this_study==0 && $this_main_page==0 && $news_page==0 &&
		$press_page==0 && $studies_page==0 && $vacancy_professional_page==0
		&& $vacancy_trainee_page==0 && $vacancy_student_page==0 &&
		$search_page==0 && $subscribe_page==0 && $event_page==0 && $event_entertainment_page==0
		) 
		{
			//header( "HTTP/1.1 404 Not Found" );
			//header("Location: /error404.php"); 
			 header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
			include('error404.php');
			exit;
		}
}


 



function is_page()
{
	global $conn, $pieces, $a_str, $page_html, $rus_link, $eng_link, $global_language_id,$page_title,$keywords,$description;
	$html="";
	$get_template=0;
	if ($result = mysqli_query($conn, "SELECT pages.* FROM pages WHERE pages.url='$a_str'")) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			
			
			$keywords=$row["keywords"];
			$description=$row["description"];
			
			
			$page_title=$row["short_name"];
			
			$page_id=$row["id"];
			$parent_page_id=$row["parent_page_id"];
			
			if ($row["language_id"]==1) {
			  $rus_link=$row["url"];
			  $eng_link=FindChildPageLink($page_id, 2);
			  $global_language_id=1;
			  		  
			}
			if ($row["language_id"]==2) {
			  $eng_link=$row["url"];
			  $rus_link=FindParentPageLink($parent_page_id, 1);
			  $global_language_id=2;
			  		  
			}
			
			
			
			$page_html=$row["html"];
			
			//$html=$row["html"];
			// if (isset($row["template_id"])&&$row["template_id"]>0) {
				// $get_template=$row["template_id"];
				// include("templates/".$row["templates_url"]);
				
			// }
		}
	    $result->close();	
	}
	// if ($get_template==0)
	// {
		// echo $html;	
	// }	
	
	
}


  



 ?>
