<?php
	function setting($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		global $modelAlbum;
		
		if(checkAdminLogin()){
			$mess= '';

			$idSlider= $modelOption->getOption('idSelectSliderBanner');
			$allSlider= $modelAlbum->find('all');

			if($isRequestPost){
				$dataSend= $input['request']->data;
				$info= array('id'=>$dataSend['idSelectSliderBanner'],
							'width'=>$dataSend['width'],
							'height'=>$dataSend['height']);
				$idSlider['Option']['value']= $info;

				$modelOption->saveOption('idSelectSliderBanner',$info);
				$mess= $languageMantan['saveSuccess'];
			}
			
			setVariable('mess',$mess);
			setVariable('idSlider',$idSlider);
			setVariable('allSlider',$allSlider);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>