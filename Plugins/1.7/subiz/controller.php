<?php
	function saveSetting($dataSend)
	{
		global $modelOption;
		global $urlPlugins;
		global $isRequestPost;
		global $urlHomes;

		if(checkAdminLogin() && $isRequestPost){
			$data= $modelOption->getOption('subizCode');
			$data['Option']['value']= $dataSend['request']->data['subizCode'];
			
			$modelOption->saveOption('subizCode', $data['Option']['value']);
			$modelOption->redirect($urlPlugins.'admin/subiz-setting.php?status=1');
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
			$data= $modelOption->getOption('subizCode');
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>