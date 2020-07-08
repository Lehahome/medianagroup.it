<?php
 //настройки
 defined("PICS_UPLOAD_FOLDER") ? null : define("PICS_UPLOAD_FOLDER", "/home/romir-1/romir.ru/docs/upload/pics/");






// configure database connection


defined("DB_HOST") ? null : define("DB_HOST", "h905153210.mysql");
defined("DB_USER") ? null : define("DB_USER", "h905153210_it");
defined("DB_PASSWORD") ? null : define("DB_PASSWORD", "5ZSV-jfS");
defined("DB_NAME") ? null : define("DB_NAME", "h905153210_it");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_query($conn, 'SET NAMES utf8');

?>