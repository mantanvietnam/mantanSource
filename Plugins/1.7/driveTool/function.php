<?php 
$menus= array();
$menus[0]['title']= 'Drive Tool';
$menus[0]['sub'][0]= array('name'=>'Album hình ảnh',
						   'classIcon'=>'fa-list',
	 					   'url'=>$urlPlugins.'admin/driveTool-view-listAlbumsDrive.php',
	 					   'permission'=>'listAlbumsDrive'
	 					   );

$menus[0]['sub'][1]= array('name'=>'Cài đặt',
						   'classIcon'=>'fa-list',
	 					   'url'=>$urlPlugins.'admin/driveTool-view-settingDrive.php',
	 					   'permission'=>'settingDrive'
	 					   );

addMenuAdminMantan($menus);


?>