<?php
	function saveSetting($dataSend)
	{
		global $modelOption;
		global $urlPlugins;
		global $isRequestPost;
		global $urlHomes;

		if(checkAdminLogin() && $isRequestPost){
			$data= $modelOption->getOption('popupHome');
			$data['Option']['value']['content']= $dataSend['request']->data['content'];
			$data['Option']['value']['status']= (int)$dataSend['request']->data['status'];
			
			
			$modelOption->saveOption('popupHome', $data['Option']['value']);
			$modelOption->redirect($urlPlugins.'admin/popupHome-setting.php?status=1');

		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function setting($input)
	{
		global $modelOption;
		global $urlPlugins;
		global $isRequestPost;
		global $urlHomes;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('popupHome');
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>