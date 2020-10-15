<?php
	function setting($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$mess= '';
			$data= $modelOption->getOption('static');
			if($isRequestPost){
				$dataSend= $input['request']->data;
				$data['Option']['value']['mday']= (int) $dataSend['mday'];
				$data['Option']['value']['mon']= (int) $dataSend['mon'];
				$data['Option']['value']['total']= (int) $dataSend['total'];
				
				$modelOption->saveOption('static', $data['Option']['value']);
				$mess= $languageMantan['saveSuccess'];
			}
			
			setVariable('mess',$mess);
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>