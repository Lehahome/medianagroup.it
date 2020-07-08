<?php

function debug($msg, $options = null, $return = false) {
    return \Common\Util::debug($msg, $options, $return);
}

function plog($msg, $return = false) {
    return \Common\Util::debug($msg, array('dismiss' => false), $return);
}

function clog($msg, $newline = true, $return = false) {
    return \Common\Util::debug($msg, array('newline' => $newline, 'dismiss' => false), $return);
}

function get($field, $data = null, $default = null) {
    return \Common\Util::get($field, $data, $default);
}

function br2nl($text) {
    return \Common\Util::br2nl($text);
}

function array_delete($array, $items) {
    return array_diff($array, is_array($items) ? $items : array($items));
}

function clear_cookie()
{
		if (isset($_COOKIE['sa_u'])) {
		unset($_COOKIE['sa_u']);
		setcookie('sa_u', null, -1, '/');
	 
	}
}

function CheckShortUrl($url)
{
	//$userinfo=CheckUserFromCookie();
	global $conn;
	if (isset($url) && !empty($url)) {
				
				$short_url=0;
		
				if ($result = mysqli_query($conn, "SELECT short_url.* FROM short_url WHERE short_url='".$url."'")) {
					$result->fetch_array(MYSQLI_ASSOC);
					foreach ($result as $row)	
					{ 
						$short_url=1;
					}
					$result->close();
				}
				
				
				$new_url=0;
				
				if ($result = mysqli_query($conn, "SELECT news.* FROM news WHERE url='".$url."'")) {
					$result->fetch_array(MYSQLI_ASSOC);
					foreach ($result as $row)	
					{ 
						$new_url=1;
					}
					$result->close();
				}
				
				
				
				$page_url=0;
				
				if ($result = mysqli_query($conn, "SELECT pages.* FROM pages WHERE url='".$url."'")) {
					$result->fetch_array(MYSQLI_ASSOC);
					foreach ($result as $row)	
					{ 
						$page_url=1;
					}
					$result->close();
				}
				
				
				
				
				$press_url=0;
				
				if ($result = mysqli_query($conn, "SELECT press.* FROM press WHERE url='".$url."'")) {
					$result->fetch_array(MYSQLI_ASSOC);
					foreach ($result as $row)	
					{ 
						$press_url=1;
					}
					$result->close();
				}
				
				
				
				
					$study_url=0;
				
				if ($result = mysqli_query($conn, "SELECT studies.* FROM studies WHERE url='".$url."'")) {
					$result->fetch_array(MYSQLI_ASSOC);
					foreach ($result as $row)	
					{ 
						$study_url=1;
					}
					$result->close();
				}
				
		
				if ($short_url==0 && $new_url==0 && $page_url==0 && $press_url==0 && $study_url==0){
					return false;
				}	
				else
				{
					return true;
				}	
					
		
	}
}	


function CreateShortUrlMain()
{
		 $rand = '/';
	
		$userinfo=CheckUserFromCookie();
		if ($userinfo["loggin"]==true) {
		 $seed = str_split('abcdefghijklmnopqrstuvwxyz');
		 shuffle($seed);
		
		 foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
		
		}
		return $rand;
}


function CreateShortUrl()
{
	$url=CreateShortUrlMain();
	 
	 if (CheckShortUrl($url)==false) {
		 return $url;
	 }
	 else
	 {
		 CreateShortUrl(); 
	 }	 
	
	
}	



















function CheckUserFromCookie()
{
	$rez=array();
	$rez["loggin"]=false;
	global $conn;
	if (isset($_COOKIE['sa_u'])) {
		if ($result = mysqli_query($conn, "SELECT users.* FROM users")) {
			$result->fetch_array(MYSQLI_ASSOC);
			foreach ($result as $row)	
			{ 
				if (md5($row["email"].$row["password"]."1qazxsw2")==$_COOKIE['sa_u']) {
					$rez["loggin"]=true;
					$rez["fio"]=$row["fio"];
					$rez["email"]=$row["email"];
					$rez["phone"]=$row["phone"];
					$rez["role"]=$row["role"];
					$rez["user_id"]=$row["id"];
					//$rez["menu_id"]=GetUserMenuId($rez["user_id"])
				}
			}
			$result->close();
		} 
	}
	
	if ($rez["loggin"]==true) {
		$rez["menu_id"]=GetUserMenuId($rez["user_id"]);
	}
	
	return $rez;
}


function GetUserMenuId($user_id)
{
	$menu_id=array();
	
	global $conn;
	
	if ($result_menu = mysqli_query($conn, "SELECT user_menu_visibility.* 
	FROM user_menu_visibility 
	WHERE user_menu_visibility.user_id=".$user_id)) {
		$result_menu->fetch_array(MYSQLI_ASSOC);
		foreach ($result_menu as $row)	
		{ 
			$menu_id[]=$row["menu_id"];
		}
		$result_menu->close();
	} 
	
	
	return $menu_id;
}



function translit($s) {
  $s = (string) $s; // преобразуем в строковое значение
  $s = strip_tags($s); // убираем HTML-теги
  $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
  $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
  $s = trim($s); // убираем пробелы в начале и конце строки
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
  $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
  return $s; // возвращаем результат
}

function print_array($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
?>