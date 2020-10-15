<?php
	function listFeedback($input)
	{
		global $urlNow;
		global $urlHomes;
		$modelFeedback= new Feedback();

		if(checkAdminLogin()){
	    	$page= (isset($_GET['page']))? (int) $_GET['page']:1;
	    	if($page<=0) $page=1;
	    	$limit= 15;
	        $listNotices= $modelFeedback->getPage($page,$limit);

	        $totalData= $modelFeedback->find('count');
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			if($totalPage<1) $totalPage=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
			
			if(isset($_GET['page'])){
				$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
				$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
			}else{
				$urlPage= $urlNow;
			}

			if(strpos($urlPage,'?')!== false){
				if(count($_GET)>1){
					$urlPage= $urlPage.'&page=';
				}else{
					$urlPage= $urlPage.'page=';
				}
			}else{
				$urlPage= $urlPage.'?page=';
			}
	        
	        setVariable('listNotices',$listNotices);
			
	        setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlPage',$urlPage);
		}else{
			$modelFeedback->redirect($urlHomes);
		}
	}
	
	function addFeedback($input)
	{
		global $isRequestPost;
		global $urlHomes;
		global $urlPlugins;

		$modelFeedback= new Feedback();
		
		if(checkAdminLogin()){

			if(isset($input['request']->params['pass'][1])){
				$data= $modelFeedback->getFeedback($input['request']->params['pass'][1]);
			}else{
				$data= null;
			}

			setVariable('data',$data);

			if($isRequestPost){
				$dataSend= $input['request']->data;
		
				$feedback['fullName']= $dataSend['fullName'];
				$feedback['avatar']= $dataSend['avatar'];
				$feedback['positions']= $dataSend['positions'];
				$feedback['content']= $dataSend['content'];
				$feedback['link']= $dataSend['link'];

				$modelFeedback->saveFeedback($feedback,$dataSend['id']);
				
				$modelFeedback->redirect($urlPlugins.'admin/feedback-listFeedback.php');
			}

		}else{
			$modelFeedback->redirect($urlHomes);
		}
	}

	function deleteFeedback($input)
	{
		global $urlHomes;
		global $urlPlugins;
		$modelFeedback= new Feedback();
		
		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1]))
			{
				$idDelete= new MongoId($input['request']->params['pass'][1]);
				
				$modelFeedback->delete($idDelete);
			}
			$modelFeedback->redirect($urlPlugins.'admin/feedback-listFeedback.php');
		}else{
			$modelFeedback->redirect($urlHomes);
		}
	}

?>