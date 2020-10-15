<?php
	$menus= array();
	$menus[0]['title']= 'Setup Color';
	$menus[0]['sub'][0]= array('name'=>'Setup code',
							   'classIcon'=>'fa-list',
							   'permission'=>'setupColor',
		 					   'url'=>$urlPlugins.'admin/setupColor-setup.php');
	addMenuAdminMantan($menus);

	function getSetupColorByCode($code=null)
	{
		if($code){
			$modelColor= new Color();
			$data=  $modelColor->getColorByCode($code);
			if($data){
				return $data['Color'];
			}
		}

		return null;
	}
?>