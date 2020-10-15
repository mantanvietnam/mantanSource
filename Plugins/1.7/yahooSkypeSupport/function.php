<?php
	$menus= array();
	$menus[0]['title']= 'Hỗ trợ trực tuyến';
    $menus[0]['sub'][0]= array('name'=>'Danh sách hỗ trợ','classIcon'=>'fa-list-alt','url'=>$urlPlugins.'admin/yahooSkypeSupport-listSupport.php','permission'=>'listSupportSetting');
    $menus[0]['sub'][1]= array('name'=>'Nhóm hỗ trợ','classIcon'=>'fa-users','url'=>$urlPlugins.'admin/yahooSkypeSupport-categorySupport.php','permission'=>'categorySupportSetting');
    
    
    addMenuAdminMantan($menus);
    
	function getListSupport()
	{
		global $modelOption;
		
		$listData= $modelOption->getOption('yahooSkypeSupport');
		$listDataCategory= $modelOption->getOption('yahooSkypeSupportCategory');
		
		$category= array();
		if(isset($listData['Option']['value']['allData']) && count($listData['Option']['value']['allData'])>0){
			foreach($listData['Option']['value']['allData'] as $components)
			{
				if(!isset($category[ $components['category'] ]))
				{
					$category[ $components['category'] ]= array();
				}
				array_push($category[ $components['category'] ], $components);
			}
			
			foreach($category as $key=>$components)
		    {
				$listDataCategory['Option']['value']['allData'][ $key ]['listSupport']= $components;
		    } 
			
			return $listDataCategory['Option']['value']['allData'];
		}
		return null;
	}
?>