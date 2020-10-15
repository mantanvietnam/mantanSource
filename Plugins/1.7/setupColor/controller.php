<?php 
	function setup($input)
	{
		$modelColor=new Color();
		global $urlHomes;
		global $urlNow;
		if(checkAdminLogin()){
			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
        	
	    	$limit= 15;
			if (isset($_POST['codeColor']))
				$conditions= array('code'=>array('$regex' => $_POST['codeColor']));
			else
				$conditions=array();
	    	$listData= $modelColor->getPage($page,$limit,$conditions);

	    	$totalData= $modelColor->find('count',array('conditions' => $conditions));
		
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
	        //debug ($listData);
	        setVariable('listData',$listData);
			
	        setVariable('page',$page);
			setVariable('totalPage',$totalPage);
			setVariable('back',$back);
			setVariable('next',$next);
			setVariable('urlNow',$urlNow);
	    }else{
			$modelColor->redirect($urlHomes);
		}
		setVariable('listData',$listData);
	}
	function saveSetup()
	{
		$modelColor=new Color();
		
		if ($_POST['type']=='save')
		{
			if (isset($_POST['code']))
				$code=(string) $_POST['code'];
			else
				$code='';
			if (isset($_POST['color']))
				$color=(string) $_POST['color'];
			else
				$color='';
			if (isset($_POST['img']))
				$img=$_POST['img'];
			else
				$img='';

			if (isset($_POST['id']))
			{
				$id=(string) $_POST['id'];
				$modelColor->saveColor($code,$color,$img,$id);
			}
			else
				$modelColor->saveColor($code,$color,$img);
			//debug ($code);
			global $urlPlugins;
			$modelColor->redirect($urlPlugins.'admin/setupColor-setup.php');
		}
		elseif ($_POST['type']=='delete')
		{
			if (isset($_POST['id']))
				$id=(string) $_POST['id'];
			$modelColor->deleteColor($id);
		}
	}
?>