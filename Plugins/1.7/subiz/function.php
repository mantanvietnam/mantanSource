<?php
	$menus= array();
	$menus[0]['title']= 'Subiz Support Online';
    $menus[0]['sub'][0]= array('name'=>'Support Online','url'=>$urlPlugins.'admin/subiz-subiz.php','classIcon'=>'fa-life-ring','permission'=>'subizSuppoetOnline');
    $menus[0]['sub'][1]= array('name'=>'Subiz Code','url'=>$urlPlugins.'admin/subiz-setting.php','classIcon'=>'fa-wrench','permission'=>'subizAddCode');
    
    addMenuAdminMantan($menus);
    
    function showSubizHome()
    {
	    global $modelOption;
	    
	    $data= $modelOption->getOption('subizCode');
	    
	    echo (isset($data['Option']['value']))?$data['Option']['value']:'';
    }
?>