<?php
	$menus= array();
	$menus[0]['title']= 'ManMo3H';
     $menus[0]['sub'][0]= array('name'=>'Danh sách Đăng ký','classIcon'=>'fa-comments-o','url'=>$urlPlugins.'admin/manmo3h-listDK.php', 'permission'=>'listDK');
    
    addMenuAdminMantan($menus);

    if(!empty($_GET['utm_source'])) $_SESSION['utm_source']= @$_GET['utm_source'];
    if(!empty($_GET['utm_content'])) $_SESSION['utm_content']= @$_GET['utm_content'];
    if(!empty($_GET['utm_campaign'])) $_SESSION['utm_campaign']= @$_GET['utm_campaign'];

?>