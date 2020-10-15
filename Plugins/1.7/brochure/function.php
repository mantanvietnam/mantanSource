<?php
	$menus= array();
	$menus[0]['title']= 'Danh sách người dùng tải Brochure';
	$menus[0]['sub'][0]= array('name'=>'Danh sách người dùng',
							   'classIcon'=>'fa-list',
		 					   'url'=>$urlPlugins.'admin/brochure-listBrochures.php',
		 					   'permission'=>'listUserDownBrochure'
		 					   );

    addMenuAdminMantan($menus);
    
    $category= array(array( 'title'=>'Danh sách',
							'sub'=>array(	array (
										      'url' => '/brochure',
										      'name' => 'Danh sách'
										    )
										)
						  )
					);
	addMenusAppearance($category);
?>