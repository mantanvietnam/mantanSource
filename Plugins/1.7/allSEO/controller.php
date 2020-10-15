<?php
	function setting($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$listData= $modelOption->getOption('allSeo');
			$mess= '';
			if($isRequestPost){
				$dataSend= $input['request']->data;
				
				$listData['Option']['value']['general']['title']= $dataSend['generalTitle'];
				$listData['Option']['value']['general']['keyword']= $dataSend['generalKeyword'];
				$listData['Option']['value']['general']['description']= $dataSend['generalDescription'];
				$listData['Option']['value']['general']['image']= $dataSend['image'];
				
				$listData['Option']['value']['category']['title']= $dataSend['categoryTitle'];
				$listData['Option']['value']['category']['keyword']= $dataSend['categoryKeyword'];
				$listData['Option']['value']['category']['description']= $dataSend['categoryDescription'];
				
				$listData['Option']['value']['post']['title']= $dataSend['postTitle'];
				$listData['Option']['value']['post']['keyword']= $dataSend['postKeyword'];
				$listData['Option']['value']['post']['description']= $dataSend['postDescription'];
				
				$listData['Option']['value']['expand']['title']= $dataSend['expandTitle'];
				$listData['Option']['value']['expand']['keyword']= $dataSend['expandKeyword'];
				$listData['Option']['value']['expand']['description']= $dataSend['expandDescription'];
				
				$modelOption->saveOption('allSeo',$listData['Option']['value']);
				
				$mess= 'Save success';
			}
			
			setVariable('listData',$listData);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>