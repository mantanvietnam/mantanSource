<?php
	$menus= array();
	$menus[0]= array('name'=>'Booking Management',
    				 'url'=>$urlPlugins.'admin/booking-listBooking.php',
    				 'sub'=> array( array('name'=>'Booking List',
    				 					  'url'=>$urlPlugins.'admin/booking-listBooking.php'),
    				 				array('name'=>'Booking Settings',
    				 					  'url'=>$urlPlugins.'admin/booking-setting.php'),
    				 
    				 		 )
    			   );
    
    addMenuAdminMantan($menus);
?>