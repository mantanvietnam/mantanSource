<?php
	function getListQuestionAPI($input)
	{
		global $urlHomes;
		$modelQuestion= new Question();

		$page= (isset($_GET['page']))? (int) $_GET['page']:1;
    	if($page<=0) $page=1;
    	$limit= 15;
    	$conditions= array('active'=>1);
    	$fields=array('title');
    	
        $listData= $modelQuestion->getPage($page,$limit,$conditions,$fields);

        if(!empty($listData)){
        	foreach($listData as $key=>$value){
        		$listData[$key]['Question']['url']= $urlHomes.'viewAnswerAPI/?id='.$listData[$key]['Question']['id'];
        	}
        }

        echo json_encode($listData);
	}

	function viewAnswerAPI($input)
	{
		if(!empty($_GET['id'])){
			$modelQuestion= new Question();

			$id= new MongoID($_GET['id']);
			$data= $modelQuestion->getQuestion($id);

			setVariable('data', $data);
		}
	}
?>