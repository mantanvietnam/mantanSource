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

	function listPostFacebook($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$mess= '';
			$listData= $modelOption->getOption('listPostFacebook');
			
			if($isRequestPost){
				$dataSend= $input['request']->data;
				$type= $dataSend['type'];
				$link= '';
				if(isset($dataSend['link'])){
					$link= $dataSend['link'];
				}
				
				if($link!='' && $type=='save')
				{
					if($dataSend['id']=='')
					{
						if(!isset($listData['Option']['value']['tData'])){
							$listData['Option']['value']['tData']= 0;
						}
						$listData['Option']['value']['tData'] += 1;
						$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'link'=>$link );
					}
					else
					{
						$idClassEdit= (int) $dataSend['id'];
						$listData['Option']['value']['allData'][$idClassEdit]['link']= $link;
					}
					
					$modelOption->saveOption('listPostFacebook',$listData['Option']['value']);
					$mess= 'Lưu dữ liệu thành công';
				}elseif($type=='delete'){
					$idDelete= (int) $input['request']->data['id'];
					unset($listData['Option']['value']['allData'][$idDelete]);
					$modelOption->saveOption('listPostFacebook',$listData['Option']['value']);
					die;
				}
			}
			
			setVariable('mess',$mess);
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>