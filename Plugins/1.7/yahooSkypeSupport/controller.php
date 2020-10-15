<?php
	function categorySupport($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		
		$mess= '';
		$listData= $modelOption->getOption('yahooSkypeSupportCategory');
		
		if($isRequestPost){
			$dataSend= $input['request']->data;
			$type= $dataSend['type'];
			$name= '';
			if(isset($dataSend['name'])){
				$name= $dataSend['name'];
			}
			
			if($name!='' && $type=='save')
			{
				if($dataSend['id']=='')
				{
					if(!isset($listData['Option']['value']['tData'])){
						$listData['Option']['value']['tData']= 0;
					}
					$listData['Option']['value']['tData'] += 1;
					$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name );
				}
				else
				{
					$idClassEdit= (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
				}
				
				$modelOption->saveOption('yahooSkypeSupportCategory',$listData['Option']['value']);
				$mess= 'Tạo mới nhóm hỗ trợ thành công';
			}elseif($type=='delete'){
				$idDelete= (int) $input['request']->data['id'];
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('yahooSkypeSupportCategory',$listData['Option']['value']);
				die;
			}
		}
		
		setVariable('mess',$mess);
		setVariable('listData',$listData);
	}
	
	function listSupport($input)
	{
		global $modelOption;
		global $isRequestPost;
		
		$listData= $modelOption->getOption('yahooSkypeSupport');
		$listDataCategory= $modelOption->getOption('yahooSkypeSupportCategory');
		
		$mess= '';
		if($isRequestPost){
			$dataSend= $input['request']->data;
			
			$type= $dataSend['type'];
			
			if($type=='delete')
			{
				$idDelete= (int) $dataSend['id'];
				$listData= $modelOption->getOption('yahooSkypeSupport');
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('yahooSkypeSupport',$listData['Option']['value']);
			}else{
				$nick= $dataSend['nick'];
				$info= $dataSend['info'];
				$category= (int)$dataSend['category'];
				$typeNick= $dataSend['typeNick'];
				$style= (int)$dataSend['style'];
				
				if($nick!='' && $type=='save'){
					if($dataSend['id']=='')
					{
						if(!isset($listData['Option']['value']['tData'])){
							$listData['Option']['value']['tData']= 0;
						}
						
						$listData['Option']['value']['tData'] += 1;
						$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'nick'=>$nick,'info'=>$info,'style'=>$style,'category'=>$category,'typeNick'=>$typeNick );
					}
					else
					{
						$idClassEdit= (int) $dataSend['id'];
						$listData['Option']['value']['allData'][$idClassEdit]['nick']= $nick;
						$listData['Option']['value']['allData'][$idClassEdit]['info']= $info;
						$listData['Option']['value']['allData'][$idClassEdit]['style']= $style;
						$listData['Option']['value']['allData'][$idClassEdit]['category']= $category;
						$listData['Option']['value']['allData'][$idClassEdit]['typeNick']= $typeNick;
					}
					
					$modelOption->saveOption('yahooSkypeSupport',$listData['Option']['value']);
					$mess= 'Lưu dữ liệu thành công';
				}
			}
		}
		
		setVariable('listData',$listData);
		setVariable('listDataCategory',$listDataCategory);
		setVariable('mess',$mess);
	}
?>