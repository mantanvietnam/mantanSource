<?php
	function saveQuestion($input)
	{
		global $urlHomes;
		$dataSend= arrayMap($input['request']->data);

		$email= $dataSend['email'];	
		$fullName= $dataSend['fullName'];	
		$fone= $dataSend['fone'];	
		$content= $dataSend['content'];
		$title= $dataSend['title'];	
		$address= $dataSend['address'];	
		$category= $dataSend['category'];	


		$modelQuestion= new Question();
		$modelQuestion->saveQuestion($title,$fullName,$email,$fone,$content,$address,$category);

		$modelQuestion->redirect($urlHomes.'question?status=1');
	}

	function question($input)
	{
		global $modelOption;
		global $urlNow;

		$questionAnswerCategory= $modelOption->getOption('questionAnswerCategory');

		$modelQuestion= new Question();
		$page= (isset($_GET['page']))? (int) $_GET['page']:1;
    	if($page<=0) $page=1;
    	$limit= 15;
    	$conditions= array('active'=>1);
    	
        $listData= $modelQuestion->getPage($page,$limit,$conditions);

        $totalData= $modelQuestion->find('count',array('conditions' => $conditions));
	
		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
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
			if(count($_GET)>=1){
				$urlPage= $urlPage.'&page=';
			}else{
				$urlPage= $urlPage.'page=';
			}
		}else{
			$urlPage= $urlPage.'?page=';
		}

		setVariable('listData',$listData);
		setVariable('page',$page);
		setVariable('totalPage',$totalPage);
		setVariable('back',$back);
		setVariable('next',$next);
		setVariable('urlPage',$urlPage);

		setVariable('questionAnswerCategory',$questionAnswerCategory);
	}

	function viewAnswer($input)
	{
		global $urlHomes;
		$modelQuestion= new Question();

		if(!empty($input['request']->params['pass'][1])){
			$question= $modelQuestion->getQuestion($input['request']->params['pass'][1]);

			if($question){
				setVariable('question',$question);
			}else{
				$modelQuestion->redirect($urlHomes);
			}
		}else{
			$modelQuestion->redirect($urlHomes);
		}
	}
?>