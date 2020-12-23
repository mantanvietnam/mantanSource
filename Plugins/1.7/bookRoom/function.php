<?php
	$menus= array();
	$menus[0]['title']= 'Booking';
	$menus[0]['sub'][0]= array('name'=>'List Book',
							   'classIcon'=>'fa-list',
							   'permission'=>'listBooking',
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