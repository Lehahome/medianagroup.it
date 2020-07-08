<?php 

require_once 'init.web.php';


    $callback = $_GET['CKEditorFuncNum'];
    $file_name = $_FILES['upload']['name'];
    $file_name_tmp = $_FILES['upload']['tmp_name'];
    //$file_new_name = '/home/romir18530/f.romir18530.nichost.ru/docs/upload/pics/';
	$file_new_name = PICS_UPLOAD_FOLDER;
    $full_path = $file_new_name.$file_name;
    //$http_path = 'http://f.romir18530.nichost.ru/upload/pics/'.$file_name;
	$http_path = '/upload/pics/'.$file_name;
    $error = '';
    if( move_uploaded_file($file_name_tmp, $full_path) ) {
    } else {
     $error = 'Some error occured please try again later';
     $http_path = '';
    }
    echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );</script>";


exit;



echo (json_encode($_FILES,JSON_UNESCAPED_UNICODE));

exit;

move_uploaded_file(
    $_FILES['file']['tmp_name'], 
    $_SERVER['DOCUMENT_ROOT'] . "/media/crop_products/test.png"
); 

?>