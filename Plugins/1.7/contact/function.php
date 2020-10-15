<?php
	$menus= array();
	$menus[0]['title']= 'Contact Management';
	$menus[0]['sub'][0]= array('name'=>'Contact List',
							   'classIcon'=>'fa-list',
		 					   'url'=>$urlPlugins.'admin/contact-listContacts.php',
		 					   'permission'=>'contactListSetting'
		 					   );
	$menus[0]['sub'][1]= array('name'=>'Contact Settings',
							   'classIcon'=>'fa-cog',
		 					   'url'=>$urlPlugins.'admin/contact-setting.php',
		 					   'permission'=>'contactSetting'
		 					   );
    
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

	function getCapchaContact()
	{
		if(empty($_SESSION['capchaCode'])){
			$cap_code= rand(100000, 999999);
			$_SESSION['capchaCode'] = $cap_code;
		}

		return $_SESSION['capchaCode'];
	}
?>