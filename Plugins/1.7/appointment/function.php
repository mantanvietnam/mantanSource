<?php
	$menus= array();
	$menus[0]['title']= 'Appointment Management';
	$menus[0]['sub'][0]= array('name'=>'Appointment List',
							   'classIcon'=>'fa-list',
		 					   'url'=>$urlPlugins.'admin/appointment-listAppointments.php');
	$menus[0]['sub'][1]= array('name'=>'Appointment Settings',
							   'classIcon'=>'fa-cog',
		 					   'url'=>$urlPlugins.'admin/appointment-setting.php');
    
    addMenuAdminMantan($menus);
    
    $category= array(array( 'title'=>'Appointment',
							'sub'=>array(	array (
										      'url' => $urlHomes.'appointment',
										      'name' => 'Appointment'
										    )
										)
						  )
					);
	addMenusAppearance($category);
?>