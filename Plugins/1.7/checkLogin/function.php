<?php
$url= explode('/', $_SERVER['REQUEST_URI']);
//var_dump($url[1]);die;
if((empty($url[1]) || $url[1]!='checkLogin') && empty($_SESSION['userLoginDetail'])){
	header('Location: /checkLogin');
	exit;
}
?>