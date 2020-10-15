<?php
	function categoryDocument($input)
	{
		global $modelOption;
		global $urlHomes;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('documentCategory');

			setVariable('listData',$listData);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function saveCategory($input)
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
				$listData= $modelOption->getOption('documentCategory');
				
				if($dataSend['id']=='')
				{
					$listData['Option']['value']['tData'] += 1;
					$listData['Option']['value']['allData'][ $listData['Option']['value']['tData'] ]= array( 'id'=> $listData['Option']['value']['tData'], 'name'=>$name,'slug'=>$slug );
				}
				else
				{
					$idClassEdit= (int) $dataSend['id'];
					$listData['Option']['value']['allData'][$idClassEdit]['name']= $name;
					$listData['Option']['value']['allData'][$idClassEdit]['slug']= $slug;
				}
				
				$modelOption->saveOption('documentCategory',$listData['Option']['value']);
				
			}
			else if($type=='delete')
			{
				$idDelete= (int) $dataSend['id'];
				$listData= $modelOption->getOption('documentCategory');
				unset($listData['Option']['value']['allData'][$idDelete]);
				$modelOption->saveOption('documentCategory',$listData['Option']['value']);
			}
			
			if($dataSend['redirect']>0)
			{
				$modelOption->redirect($urlPlugins.'admin/document-view-categoryDocument.php');
			}
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function listDocument($input)
	{
		global $urlHomes;
		global $modelOption;

		if(checkAdminLogin()){
			$modelDocument= new Document();
	    	$page= isset($_GET['page'])?(int) $_GET['page']:0;
	    	if($page<=0) $page=1;
	    	$limit= 15;
	        $listNotices= $modelDocument->getPage($page,$limit,$conditions=array());
		  	$listDataCategory= $modelOption->getOption('documentCategory');
	        
	        $total= $modelDocument->find('count');
			$balance= $total%$limit;
			$totalPage= ($total-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
	        
	        setVariable('listNotices',$listNotices);
	        setVariable('listDataCategory',$listDataCategory);

	        setVariable('back',$back);
	        setVariable('page',$page);
	        setVariable('totalPage',$totalPage);
	        setVariable('next',$next);
	    }else{
			$modelOption->redirect($urlHomes);
		}
	}
	
	function addDocument($input)
	{	
		global $modelOption;
		global $urlHomes;

		if(checkAdminLogin()){
			$listData= $modelOption->getOption('document');
		  	$listDataCategory= $modelOption->getOption('documentCategory');
			$modelDocument= new Document();
			
			if(isset($input['request']->params['pass'][1])){
				$data= $modelDocument->getDocument($input['request']->params['pass'][1]);
				setVariable('data',$data);
			}

		  	setVariable('listData',$listData);
		  	setVariable('listDataCategory',$listDataCategory);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
	
	function saveDocument($input)
	{
		global $urlPlugins;
		global $urlHomes;

		if(checkAdminLogin()){
			$modelDocument= new Document();
			
			$dataSend= $input['request']->data;
			
			$document['name']= $dataSend['name'];
			$document['file']= $dataSend['file'];
			$document['category']= $dataSend['category'];
			$document['content']= $dataSend['content'];
			$document['image']= $dataSend['image'];

			$today= getdate();
			
			if($dataSend['ngay'] && $dataSend['thang'] && $dataSend['nam'])
			{
			  $document['time']= mktime($today['hours'], $today['minutes'], $today['seconds'], $dataSend['thang'], $dataSend['ngay'], $dataSend['nam']);
			}
			else
			{
			  $document['time']= $today[0];
			}

			$modelDocument->saveDocument($document,$dataSend['id']);
			
			$modelDocument->redirect($urlPlugins.'admin/document-view-listDocument.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	
	}
	function deleteDocument($input) {
		global $urlPlugins;
		global $urlHomes;

		if(checkAdminLogin()){
			$modelDocument= new Document();
			$data= $modelDocument->deleteDocument($input['request']->params['pass'][1]);

			$modelDocument->redirect($urlPlugins.'admin/document-view-listDocument.php');
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
	function viewDetails($input) {
		global $urlHomes;
		
		$modelDocument= new Document();
		$data= $modelDocument->getDocument($input['request']->params['pass'][1]);
		
		if(!empty($data['Document']['file'])){
			$urlDocument = urlencode($urlHomes.$data['Document']['file']);
			$urlViewFile= "http://docs.google.com/viewer?url=".$urlDocument."&amp;embedded=true";
			//$urlViewFile= 'https://view.officeapps.live.com/op/view.aspx?src='.$urlDocument;
	        //$urlViewFile= $urlHomes.'viewPDF?url='.$urlDocument;
	        //$urlViewFile= $urlHomes.$data['Document']['file'];
		}else{
			$urlViewFile= null;
		}
        
		
		setVariable('data',$data);
		setVariable('urlViewFile',$urlViewFile);
	}

	function listCategoryDocument($input)
	{
		global $modelOption;
		$modelDocument= new Document();
	  
		if(isset($_GET['page'])){
		$page= (int) $_GET['page'];
		} else {
		$page=1;
		}
		$limit= 16;
		$input['request']->params['pass'][1] = str_replace('.html', '', $input['request']->params['pass'][1]);

		$data = $modelOption->getOption('documentCategory');
		$category= $modelDocument->getcat($data['Option']['value']['allData'],$input['request']->params['pass'][1],'slug');
	
		$listNotices= $modelDocument->getPage($page,$limit,array('category'=> (string)$category['id']));
		
		
		// $listNotices = showListDocument($limit, $conditions);
		$conditions= array();
		$totalData= $modelDocument->find('count',array('conditions' => $conditions));

		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;

		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;

		setVariable('listNotices',$listNotices);
		setVariable('category', $category);

		setVariable('next',$next);
		setVariable('back',$back);
		setVariable('totalPage',$totalPage);
		setVariable('page',$page);
	}
	 
?>