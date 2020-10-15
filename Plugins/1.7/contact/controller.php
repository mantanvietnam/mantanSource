<?php 
	function contact($input)
	{
		global $isRequestPost;
		global $modelOption;
		$contact= $modelOption->getOption('contactSettings');
		
		$dataSend= arrayMap($input['request']->data);
		$returnSend= array('code'=>-1,'mess'=>'');
		
		if($isRequestPost && isset($dataSend['email']) && $dataSend['email']!='')
		{
			if(isset($_SESSION['capchaCode']) && $_SESSION['capchaCode']==$dataSend['captcha']){
				$email= (isset($dataSend['email']))? $dataSend['email']:'';	
				$fullName= (isset($dataSend['fullName']))? $dataSend['fullName']:'';
				$fone= (isset($dataSend['fone']))? $dataSend['fone']:'';
				$content= (isset($dataSend['content']))? $dataSend['content']:'';
				$address= (isset($dataSend['address']))? $dataSend['address']:'';
				$facebook= (isset($dataSend['facebook']))? $dataSend['facebook']:'';
				$description= (isset($dataSend['description']))? $dataSend['description']:'';
				$file= (isset($dataSend['file']))? $dataSend['file']:'';
	
				$contentFull= nl2br($content).'<br/>'.$file;
	
				$modelContact= new Contact();
				
				$modelContact->saveContact($fullName,$email,$fone,$contentFull,$address,$facebook,$description);
				
				if(isset($contact['Option']['value']['sendEmail']) && $contact['Option']['value']['sendEmail']==1)
				{
					$to= explode(',', $contact['Option']['value']['email']);
					$from= array($to[0] =>  $contact['Option']['value']['displayName']);
					
					$cc= array();
					$bcc= array();
					$subject= '['.$contact['Option']['value']['displayName'].'] Contact from website';
					$content='Full name: '.$fullName.'<br/> 
								Address: '.$address.'<br/> 
								Email: '.$email.'<br/> 
								Phone: '.$fone.'<br/>
								Facebook: '.$facebook.'<br/>
								Link file: '.$file.'<br/>
								Content: '.nl2br($content).'<br/>
								Description: '.$description;

					
					$modelContact->sendMail($from,$to,$cc,$bcc,$subject,$content);
				}
				
				$returnSend= array('code'=>1,'mess'=>'Data sent successfully');
			}else{
				$returnSend= array('code'=>0,'mess'=>'Captcha error');
			}
		}
		
		$cap_code= rand(100000, 999999);
		$_SESSION['capchaCode'] = $cap_code;
		
		setVariable('returnSend',$returnSend);
		setVariable('contact',$contact);
		setVariable('capchaCode',$cap_code);
	}
	
	function deleteContact($input)
	{
		global $urlHomes;
		global $urlPlugins;
		$modelContact= new Contact();
		
		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1]))
			{
				$idDelete= new MongoId($input['request']->params['pass'][1]);
				
				$modelContact->delete($idDelete);
			}
			$modelContact->redirect($urlPlugins.'admin/contact-listContacts.php');
		}else{
			$modelContact->redirect($urlHomes);
		}
	}
	
	function listContacts($input)
	{
		global $modelOption;
		global $urlHomes;
		global $urlNow;
		
		$modelContact= new Contact();
		
		if(checkAdminLogin()){
			$page= (isset($_GET['page']))? (int) $_GET['page']:1;
        	if($page<=0) $page=1;
        	
	    	$limit= 15;
	    	$conditions= array();
	    	$listData= $modelContact->getPage($page,$limit);

	    	$totalData= $modelContact->find('count',array('conditions' => $conditions));
		
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
			$modelContact->redirect($urlHomes);
		}
	}
	
	function setting($input)
	{
		global $urlHomes;
		global $modelOption;
		global $isRequestPost;
		
		if(checkAdminLogin()){
			$data= $modelOption->getOption('contactSettings');
			$mess= '';
			
			if($isRequestPost){
	
				$dataSend= $input['request']->data;
				$data['Option']['value']['info']= isset($dataSend['info'])?$dataSend['info']:'';
				$data['Option']['value']['map']= isset($dataSend['map'])?$dataSend['map']:'';
				
				$data['Option']['value']['sendEmail']= (isset($_POST['sendEmail']))? (int) $_POST['sendEmail']:0;
				$data['Option']['value']['displayName']= $dataSend['displayName'];
				$data['Option']['value']['email']= $dataSend['email'];
				
				$modelOption->saveOption('contactSettings', $data['Option']['value']);
				
				$mess= 'Save Success';
			}
			
			setVariable('data',$data);
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>