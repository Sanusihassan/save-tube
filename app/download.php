<?php 

$extention = isset($_GET['extension']) ? '.' . $_GET['extention'] : '.mp4';
$file_name = isset($_GET['title']) ? $_GET['title'] : '';
$file_url = isset($_GET['url']) ? $_GET['url'] : '' ;
//$file_url = urldecode($file_url);
$file_url = '';
//die('<a href="' . $file_url . '">Go to download</a>');
var_dump(file_get_contents($file_url)); exit;
header('Content-Transfer-Encoding: Binary');
header('Content-Type: video/mp4');
header("Content-Disposition: attachment; filename={$file_name}.{$extention}");

ob_end_clean();
readfile($file_url);

//exit;

?> 
