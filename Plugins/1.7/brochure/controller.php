<?php 
	function brochure($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $urlHome;
		$themeData = $modelOption->getOption('themeSettings');
		$brochure= $modelOption->getOption('BrochureSettings');
		$dataSend= arrayMap($input['request']->data);
		if($isRequestPost && isset($dataSend['email']) && $dataSend['email']!='')
		{
				$email= (isset($dataSend['email']))? $dataSend['email']:'';
				$fullName= (isset($dataSend['fullName']))? $dataSend['fullName']:'';
				$fone= (isset($dataSend['fone']))? $dataSend['fone']:'';
				$content= (isset($dataSend['content']))? $dataSend['content']:'';
				$contentFull= nl2br($content).'<br/>';
				$modelBrochure= new Brochure();
				$modelBrochure->saveBrochure($fullName,$email,$fone,$contentFull);
				$url =	$urlHome.$themeData['Option']['value']['brochure'];
				$modelBrochure->redirect($url);
		}
		setVariable('Brochure',$brochure);
	}
	
	function deleteBrochure($input)
	{
		global $urlHomes;
		global $urlPlugins;
		$modelBrochure= new Brochure();
		
		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1]))
			{
				$idDelete= new MongoId($input['request']->params['pass'][1]);
				$modelBrochure->delete($idDelete);
			}
			$modelBrochure->redirect($urlPlugins.'admin/brochure-listBrochures.php');
		}else{
			$modelBrochure->redirect($urlHomes);
		}
	}
	
	function listBrochures($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		
		$modelBrochure = new Brochure();
		
		if(checkAdminLogin()){
			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
	    	$limit= 15;
	    	$conditions= array();
	    	$listData= $modelBrochure->getPage($page,$limit);
	    	$totalData= $modelBrochure->find('count',array('conditions' => $conditions));
		
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
			
			if(isset($_GET['page'])){
				$urlNow= str_replace('&page='.$_GET['page'], '', $urlNow);
				$urlNow= str_replace('page='.$_GET['page'], '', $urlNow);
			}

			if(strpos($urlNow,'?')!== false){
				if(count($_GET)>1){
					$urlNow= $urlNow.'&page=';
				}else{
					$urlNow= $urlNow.'page=';
				}
			}else{
				$urlNow= $urlNow.'?page=';
			}
	        
	        setVariable('listData',$listData);
			
	        setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlNow',$urlNow);
	    }else{
			$modelBrochure->redirect($urlHomes);
		}
	}

?>