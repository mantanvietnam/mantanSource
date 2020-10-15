<?php
	$menus= array();
	$menus[0]['title']= 'Slider Nivo';
    $menus[0]['sub'][0]= array('name'=>'Slider Banner','url'=>$urlPlugins.'admin/sliderBanner-setting.php','classIcon'=>'fa-file-image-o','permission'=>'slideNivoSetting');
    addMenuAdminMantan($menus);

	function getSliderBanner()
	{ 
		global $modelOption;
		global $modelAlbum;
		global $infoSite;
		
		$idSlider= $modelOption->getOption('idSelectSliderBanner');

		if(isset($idSlider['Option']['value']['id']) && $idSlider['Option']['value']['id']!=''){
			$idSliderSelect= new MongoId($idSlider['Option']['value']['id']);
			$slider= $modelAlbum->getAlbum($idSliderSelect);

			return array('idSlider'=>$idSlider,'slider'=>$slider);
		}
		return null;
	}
?>