<?php
	$menus = array();
	$menus[0]['title'] = 'Mobile App Api';
	$menus[0]['sub'][0] = array('name' => 'Setting', 'url' => $urlPlugins . 'admin/mobileAppApi-setting.php', 'classIcon' => 'fa-search','permission'=>'settingMobileAppApi');

	$menus[0]['sub'][1] = array('name' => 'Notification', 'url' => $urlPlugins . 'admin/mobileAppApi-notification-listNotification.php', 'classIcon' => 'fa-search','permission'=>'noticeMobileAppApi');

	addMenuAdminMantan($menus);

	function checkInfoProductAPI($listData= array())
	{
		global $urlHomes;

		$today= getdate();

		if(!empty($listData)){
            foreach($listData as $key=>$value){
                $listData[$key]['Product']['urlProductDetail']= $urlHomes.getLinkProduct().$listData[$key]['Product']['slug'].'.html';
                $listData[$key]['Product']['timeNow']= $today[0];

                if(!empty($listData[$key]['Product']['images'])){
                	foreach($listData[$key]['Product']['images'] as $keyIMG=>$img){
		                if(empty($img)){
		                    $listData[$key]['Product']['images'][$keyIMG]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
		                }else{
		                    $http= substr($img,1,4);
		                    if($http!='http'){
		                        $listData[$key]['Product']['images'][$keyIMG]= $urlHomes.$img;
		                    }
		                }
	            	}
            	}else{
            		$listData[$key]['Product']['images'][0]= $urlHomes.'/app/Plugin/product/images/no_image-100x100.jpg';
            	}
            }
        }

        return $listData;
	}
?>