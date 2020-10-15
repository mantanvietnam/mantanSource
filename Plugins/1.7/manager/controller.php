<?php
	function categoryManager($input)
	{
		global $modelOption;
		global $urlHomes;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('categoryManager');

			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveCategoryManager($input)
	{
		global $modelOption;
		global $urlPlugins;
		global $urlHomes;

		if(checkAdminLogin()){
			$dataSend= $input['request']->data;
			$name= $dataSend['name'];
			$type= $dataSend['type'];
			$slug = createSlugMantan($dataSend['name']);
			
			if($name!='' && $type=='save')
			{
				$listData= $modelOption->getOption('categoryManager');
				
				if($dataSend['id']=='')
				{
					if(!empty($listData['Option']['value']['tData'])){
						$listData['Option']['value']['tData'] += 1;
					}else{
						$listData['Option']['value']['tData'] = 1;
					}

					
					$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug );
				}
				else
				{
					$idClassEdit= (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
					$listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
				}
				
				$modelOption->saveOption('categoryManager',$listData['Option']['value']);
				
			}
			else if($type=='delete')
			{
				$idDelete= (int) $dataSend['id'];
				$listData= $modelOption->getOption('categoryManager');
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('categoryManager',$listData['Option']['value']);
			}
			
			if($dataSend['redirect']>0)
			{
				$modelOption->redirect($urlPlugins.'admin/manager-view-categoryManager.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listManager($input)
	{
		global $urlHomes;
		global $modelOption;

		if(checkAdminLogin()){
			$modelManager= new Manager();
	    	$page= isset($_GET['page'])?(int) $_GET['page']:0;
	    	if($page<=0) $page=1;
	    	$limit= 15;
	        $listData= $modelManager->getPage($page,$limit,$conditions=array());
		  	$listDataCategory= $modelOption->getOption('categoryManager');
	        
	        $total= $modelManager->find('count');
			$balance= $total%$limit;
			$totalPage= ($total-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
	        
	        setVariable('listData',$listData);
	        setVariable('listDataCategory',$listDataCategory);

	        setVariable('back',$back);
	        setVariable('page',$page);
	        setVariable('totalPage',$totalPage);
	        setVariable('next',$next);
	    }else{
			$modelOption->redirect($urlHomes);
		}
	}
	
	function addManager($input)
	{	
		global $modelOption;
		global $urlHomes;

		if(checkAdminLogin()){
			
		  	$listDataCategory= $modelOption->getOption('categoryManager');
			$modelManager= new Manager();
			
			if(isset($input['request']->params['pass'][1])){
				$data= $modelManager->getManager($input['request']->params['pass'][1]);
				setVariable('data',$data);
			}

		  
		  	setVariable('listDataCategory',$listDataCategory);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
	
	function saveManager($input)
	{
		global $urlPlugins;
		global $urlHomes;

		if(checkAdminLogin()){
			$modelManager= new Manager();
			
			$dataSend= $input['request']->data;
			
			$data['name']= $dataSend['name'];
			$data['avatar']= $dataSend['avatar'];
			$data['category']= $dataSend['category'];
			$data['content']= $dataSend['content'];
			$data['chucvu']= $dataSend['chucvu'];
			$data['row']= $dataSend['row'];

			$modelManager->saveManager($data,@$dataSend['id']);
			
			$modelManager->redirect($urlPlugins.'admin/manager-view-listManager.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	
	}
	function deleteManager($input) {
		global $urlPlugins;
		global $urlHomes;

		if(checkAdminLogin()){
			$modelManager= new Manager();
			$data= $modelManager->deleteManager($input['request']->params['pass'][1]);

			$modelManager->redirect($urlPlugins.'admin/manager-view-listManager.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
	

	function listCategoryManager($input)
	{
		global $modelOption;
		$modelManager= new Manager();
	  
		$page= 1;
		$limit= null;
		$input['request']->params['pass'][1] = str_replace('.html', '', $input['request']->params['pass'][1]);

		$data = $modelOption->getOption('categoryManager');
		$category= $modelManager->getcat($data['Option']['value']['allData'],$input['request']->params['pass'][1],'slug');
	
		$listData= $modelManager->getPage($page,$limit,array('category'=> (string)$category['id']));
		
		$listCheck= array();
		if($listData){
			foreach($listData as $data){
				$listCheck[$data['Manager']['row']][]= $data;
			}
			ksort($listCheck);
		}
		
		setVariable('listData',$listCheck);
		setVariable('category', $category);
	}
	 
?>