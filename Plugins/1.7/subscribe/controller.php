<?php
	function add_subscribe($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $urlHomes;
		
		$mess= '';
		if($isRequestPost){
			if(!empty($input['request']->data['email'])){
				add_email_subscribe($input['request']->data['email']);
				$mess= 'Đăng ký nhận tin thành công!';
			}else{
				$mess = 'Đăng ký nhận tin không thành công!';
			}
			
		}else{
			$modelOption->redirect($urlHomes);
		}
		setVariable('mess',$mess);
	}

	function send_subscribe($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		global $smtpSite;
		
		$mess= '';
		
		if(checkAdminLogin()){
			if($isRequestPost){
				$listEmail= array();
				
				if($input['request']->data['typeUser']==1){
					$listEmail= $modelOption->getOption('listSubscribe');
					$listEmail= $listEmail['Option']['value']['listSubscribe'];
				}
				
				if(mb_strlen(trim($input['request']->data['otherUser']))>0){
					$listOtherUser= explode(',', trim($input['request']->data['otherUser']));
					
					$listEmail= array_merge($listEmail,$listOtherUser);
				}
				
				$listEmail= array_unique($listEmail);
				
				// send email for user
				if(isset($smtpSite['Option']['value']['show']) && isset($smtpSite['Option']['value']['account'])){
					$from= array($smtpSite['Option']['value']['account'] =>  $smtpSite['Option']['value']['show']);
					$to= array($listEmail[0]);
					unset($listEmail[0]);
					$cc= array();
					$bcc= $listEmail;
					$subject= '['.$smtpSite['Option']['value']['show'].'] '.$input['request']->data['title'];
					$content= $input['request']->data['content'];
					
					$sendEmail= $modelOption->sendMail($from,$to,$cc,$bcc,$subject,$content);

					if($sendEmail){
						$mess= 'Email được gửi đi thành công !';
					}else{
						$mess= 'Gửi mail thất bại do cấu hình email sai';
					}
				}else{
					$mess= 'Gửi mail thất bại do chưa cấu hình email';
				}
			}
			
			setVariable('mess',$mess);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function list_subscribe($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$mess= '';
			$data= $modelOption->getOption('listSubscribe');
			if($isRequestPost){
				if(mb_strlen(trim($input['request']->data['listSubscribe']))>0){
					$listSubscribe= explode(',', trim($input['request']->data['listSubscribe']));
				}else{
					$listSubscribe= array();
				}
				
				$data['Option']['value']['listSubscribe']= array_unique($listSubscribe);
				
				$modelOption->saveOption('listSubscribe', $data['Option']['value']);
				$mess= $languageMantan['saveSuccess'];
			}
			
			setVariable('mess',$mess);
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>