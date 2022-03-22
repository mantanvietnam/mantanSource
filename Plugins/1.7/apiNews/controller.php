<?php
	function getListCategoryAPI($input)
	{
		global $modelOption;

		$return= $modelOption->getOption('categoryNotice');
		
		$return= (!empty($return['Option']['value']['category']))?$return['Option']['value']['category']:array();

		echo json_encode($return);
	}

	function getNoticeInCategoryAPI($input)
	{
		global $modelNotice;
		global $modelOption;
		global $urlHomes;

		$category= $modelOption->getOption('categoryNotice');

		$dataSend= $input['request']->data;
		$page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions= array();
        $fields= array('title','image','author','introductory','time');

		$return= $modelNotice->getOtherNotice(array((int)$dataSend['category']),$limit,$conditions,$page,$fields);

		if($return){
			foreach ($return as $key => $value) {
				$return[$key]['Notice']['url']= $urlHomes.'viewNoticeAPI?id='.$value['Notice']['id'];
			}
		}

		echo json_encode($return);
	}

	function viewNoticeAPI($input)
	{
		if(!empty($_GET['id'])){
			global $modelNotice;
			global $metaTitleMantan;
			global $metaImageMantan;

			$data= $modelNotice->getNotice($_GET['id']);
			$metaTitleMantan= @$data['Notice']['title'];
			$metaKeywordsMantan= @$data['Notice']['key'];
			$metaImageMantan= @$data['Notice']['image'];

			setVariable('data',$data);
		}
	}

	function getNoticeHotAPI($input)
	{
		global $modelNotice;
		global $urlHomes;

		$dataSend= $input['request']->data;
		
		$page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions= array();
        $fields= array('title','image','author','introductory','time');

		$return= $modelNotice->getTopEventNotice($limit,$fields,$page);

		if($return){
			foreach ($return as $key => $value) {
				$return[$key]['Notice']['url']= $urlHomes.'viewNoticeAPI?id='.$value['Notice']['id'];
			}
		}


		echo json_encode($return);
	}

	function getNoticeNewAPI($input)
	{
		global $modelNotice;
		global $urlHomes;
		
		$dataSend= $input['request']->data;
		
		$page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions= array();
        $fields= array('title','image','author','introductory','time');

		$return= $modelNotice->getNewNotice($limit,$fields,$page);

		if($return){
			foreach ($return as $key => $value) {
				$return[$key]['Notice']['url']= $urlHomes.'viewNoticeAPI?id='.$value['Notice']['id'];
			}
		}


		echo json_encode($return);
	}
?>