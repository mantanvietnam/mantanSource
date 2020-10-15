<?php
	$menus= array();
	$menus[0]['title']= 'Export Import Data';
    $menus[0]['sub'][0]= array('name'=>'Export Product','classIcon'=>'fa-file-image-o','url'=>$urlPlugins.'admin/exportImportData-exportData.php','permission'=>'exportData');
    $menus[0]['sub'][2]= array('name'=>'Export Cart','classIcon'=>'fa-file-image-o','url'=>$urlPlugins.'admin/exportImportData-exportCart.php','permission'=>'exportCart');
    $menus[0]['sub'][1]= array('name'=>'Import Product','classIcon'=>'fa-file-image-o','url'=>$urlPlugins.'admin/exportImportData-importData.php','permission'=>'importData');
    $menus[0]['sub'][3]= array('name'=>'Export User','classIcon'=>'fa-file-image-o','url'=>$urlPlugins.'admin/exportImportData-exportUser.php','permission'=>'exportUser');
    
    addMenuAdminMantan($menus);
    
?>