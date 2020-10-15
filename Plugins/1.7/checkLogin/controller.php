<?php
function checkLogin($input)
{
	if(!empty($_POST) && $_POST['user']=='admin' && $_POST['pass']=='admin123'){
		$_SESSION['userLoginDetail']= 'ok';
		header('Location: /');
		exit;
	}
}
?>