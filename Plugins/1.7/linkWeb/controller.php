<?php
	function categoryLinkWeb($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$mess= '';
			$listData= $modelOption->getOption('linkWebCategory');
			
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
					
					$modelOption->saveOption('linkWebCategory',$listData['Option']['value']);
					$mess= 'Lưu dữ liệu thành công';
				}elseif($type=='delete'){
					$idDelete= (int) $input['request']->data['id'];
					unset($listData['Option']['value']['allData'][$idDelete]);
					$modelOption->saveOption('linkWebCategory',$listData['Option']['value']);
					die;
				}
			}
			
			setVariable('mess',$mess);
			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
	
	function deleteLinkWeb($input)
	{
		global $modelOption;
		global $urlHomes;

		if(checkAdminLogin()){
			$dataSend= $input['request']->data;
			$idDelete= (int) $dataSend['id'];
			$listData= $modelOption->getOption('linkWeb');
			unset($listData['Option']['value']['allData'][$idDelete]);
			$modelOption->saveOption('linkWeb',$listData['Option']['value']);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listLinkWeb($input)
	{
		global $modelOption;
		global $isRequestPost;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$listData= $modelOption->getOption('linkWeb');
			$listDataCategory= $modelOption->getOption('linkWebCategory');
			
			$mess= '';
			if($isRequestPost){
				$dataSend= $input['request']->data;
				
				$type= $dataSend['type'];
				
				if($type=='delete')
				{
					$idDelete= (int) $dataSend['id'];
					$listData= $modelOption->getOption('linkWeb');
					unset($listData['Option']['value']['allData'][$idDelete]);
					$modelOption->saveOption('linkWeb',$listData['Option']['value']);
				}else{
					$category= (int)$dataSend['category'];
					$name= $dataSend['name'];
					$image= $dataSend['image'];
					$link= $dataSend['link'];
					
					if($name!='' && $type=='save'){
						if($dataSend['id']=='')
						{
							if(isset($listData['Option']['value']['tData'])){
								$listData['Option']['value']['tData'] += 1;
							}else{
								$listData['Option']['value']['tData'] = 1;
							}
							$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array('id'=> $listData['Option']['value']['tData'], 
																													'name'=>$name,
																													'image'=>$image,
																													'category'=>$category,
																													'link'=>$link );
						}
						else
						{
							$idClassEdit= (int) $dataSend['id'];
							$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
							$listData['Option']['value']['allData'][$idClassEdit]['image']= $image;
							$listData['Option']['value']['allData'][$idClassEdit]['link']= $link;
							$listData['Option']['value']['allData'][$idClassEdit]['category']= $category;
						}
						
						$modelOption->saveOption('linkWeb',$listData['Option']['value']);
						$mess= 'Lưu dữ liệu thành công';
					}
				}
			}
			
			setVariable('listData',$listData);
			setVariable('listDataCategory',$listDataCategory);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>