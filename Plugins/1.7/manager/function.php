<?php
	$menus= array();
	$menus[0]['title']= 'Nhân sự';
    $menus[0]['sub'][0]= array('name'=>'Danh sách nhân sự','classIcon'=>'fa-list-alt','url'=>$urlPlugins.'admin/manager-view-listManager.php','permission'=>'listManager');
    $menus[0]['sub'][1]= array('name'=>'Phòng ban','classIcon'=>'fa-users','url'=>$urlPlugins.'admin/manager-view-categoryManager.php','permission'=>'categoryManager');
    
    
    addMenuAdminMantan($menus);

    global $modelOption;
    // $modelOption= new Option();
    $documentCategory= $modelOption->getOption('categoryManager');
    // echo "<pre>";
    // print_r($documentCategory);
    // echo "</pre>";die;
    $category= array();
    if(!empty($documentCategory['Option']['value']['allData'])){
        $category= array(array( 'title'=>'Nhân sự',
            'sub'=>changeTypeCategoryDoc($documentCategory['Option']['value']['allData'],'/manager/')
            )
    );
    }
    

	addMenusAppearance($category);

	
?>