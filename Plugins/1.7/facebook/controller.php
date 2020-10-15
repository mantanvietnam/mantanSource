<?php
	function setting($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$mess= '';
			$data= $modelOption->getOption('settingFacebook');
			if($isRequestPost){
				$dataSend= $input['request']->data;
				$data['Option']['value']['idApp']= $dataSend['idApp'];
				$data['Option']['value']['idAdmin']= $dataSend['idAdmin'];
				$data['Option']['value']['linkFanpage']= $dataSend['linkFanpage'];
				$data['Option']['value']['nameFanpage']= $dataSend['nameFanpage'];
				$data['Option']['value']['url_share_facebook']= $dataSend['url_share_facebook'];
				$data['Option']['value']['urlShare']= (isset($dataSend['urlShare']))?$dataSend['urlShare']:'url_currently';
				$data['Option']['value']['image']= $dataSend['image'];
				
				$modelOption->saveOption('settingFacebook', $data['Option']['value']);
				$mess= $languageMantan['saveSuccess'];
			}
			
			setVariable('mess',$mess);
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>