<?php
	$menus= array();
	$menus[0]['title']= 'Book Room';
	$menus[0]['sub'][0]= array('name'=>'List Book',
							   'classIcon'=>'fa-list',
		 					   'url'=>$urlPlugins.'admin/bookRoom-listBook.php');
    addMenuAdminMantan($menus);
    
    $category= array(array( 'title'=>'Contact',
							'sub'=>array(	array (
										      'url' => '/contact',
										      'name' => 'Contact'
										    )
										)
						  )
					);
	addMenusAppearance($category);
?>