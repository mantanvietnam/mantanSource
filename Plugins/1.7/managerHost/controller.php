<?php
	function add_subscribe($input)
	{
		global $isRequestPost;
		
		if($isRequestPost){
			add_email_subscribe($input['request']->data['email']);
		}
	}
	
	function check_domains($input)
	{
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		$listType= array();
		if(!isset($input['request']->query['type'])){
			$input['request']->query['type']= 'all';
		}
		if(isset($input['request']->query['domain'])){
			$domain = $input['request']->query['domain'];
			if($input['request']->query['type']!='all'){
				$listType = array($input['request']->query['type']);
			} else {
				$listType = array('vn', 'com.vn', 'net.vn', 'org.vn', 'info.vn', 'gov.vn', 'biz.vn', 'int.vn', 'pro.vn', 'health.vn', 'name.vn', 'edu.vn', 'com', 'net', 'org', 'biz', 'info', 'cc', 'name', 'asia', 'me', 'mobi', 'us', 'tel', 'eu', 'in', 'tv', 'co', 'tw', 'ws', 'cn', 'xxx', 'ac.vn', 'top', 'photo', 'xyz' ,'club');
			}
		} else {
			$domain = '';
		}
		
		$typeSelect= $input['request']->query['type'];
		
		$listIDDomain= array(
							'vn'=>'5521395a47c7dec6208b4567',
							'com.vn'=>'55213ac947c7dec3208b4567',
							'net.vn'=>'55213ae847c7dec1208b4567',
							'org.vn'=>'55213b0847c7dee4208b4567',
							'info.vn'=>'55213b2047c7dec6208b4568',
							'gov.vn'=>'55213b3947c7dec3208b4568',
							'biz.vn'=>'55213b5947c7dec1208b4568',
							'int.vn'=>'55213b7047c7dee4208b4568',
							'pro.vn'=>'55213b8847c7dec6208b4569',
							'health.vn'=>'55213ba147c7dec3208b4569',
							'name.vn'=>'55213bba47c7dec1208b4569',
							'edu.vn'=>'55213bd147c7dee4208b4569',
							'ac.vn'=>'55213bec47c7dec6208b456a',
							'com'=>'55213c0f47c7dee4208b456a',
							'net'=>'55213c2647c7dec6208b456b',
							'org'=>'55213c5747c7dec1208b456a',
							'biz'=>'55213c7447c7dec3208b456a',
							'info'=>'55213c8a47c7dee4208b456b',
							'cc'=>'55213ca547c7dec6208b456c',
							'name'=>'55213cbe47c7dec1208b456b',
							'asia'=>'55213cd547c7dec3208b456b',
							'me'=>'55213cf447c7dee4208b456c',
							'mobi'=>'55213d8447c7dec1208b456c',
							'us'=>'55213ddc47c7dec3208b456c',
							'tel'=>'55213df847c7dee4208b456d',
							'eu'=>'55213e2a47c7dec6208b456d',
							'in'=>'55213e8d47c7dec1208b456d',
							'tv'=>'55213ea447c7dec3208b456d',
							'co'=>'55213f1747c7dee4208b456e',
							'tw'=>'55213f6f47c7dec6208b456e',
							'ws'=>'55213f8747c7dec1208b456e',
							'cn'=>'55213faa47c7dec3208b456e',
							'xxx'=>'55213fcd47c7dee4208b456f',
							'top'=>'55213fe647c7dec6208b456f',
							'photo'=>'55213ffd47c7dec1208b456f',
							'xyz'=>'55925e3447c7ded82a8b4568',
							'club'=>'57e2748aa7f82178078b4570',
		);
		
		setVariable('listType',json_encode($listType));
		setVariable('listIDDomain',json_encode($listIDDomain));
		
		setVariable('domain',$domain);
		setVariable('typeSelect',$typeSelect);
	}
	
	function logout()
	{
		global $urlHomes;
		global $modelOption;
		
		session_destroy();
		$modelOption->redirect($urlHomes);
	}
	
	function login($input)
	{
		global $isRequestPost;
		global $urlHomes;
		
		$modelUser = new Usermantan();
		
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		if(isset($_SESSION['infoUser'])){
			$modelUser->redirect($urlHomes.'navigation-panel');
		}
		
		$messReg= 'Bạn cần đăng nhập mới có thể đặt hàng';
		if($isRequestPost){
			$user = $modelUser->checkLogin($input['request']->data['email'],$input['request']->data['password']);
			if($user){
				$_SESSION['infoUser']= $user;
				
				if(isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!='' && in_array($_SESSION['codeGiftUser'],$_SESSION['infoUser']['User']['giftCode'])){
					get_remove_gift_code();
				}
				
				$modelUser->redirect($urlHomes.'navigation-panel?action=login');
			} else{
				$messReg= 'Email hoặc mật khẩu không đúng';
			}
		}
		
		setVariable('messReg',$messReg);
		setVariable('data',$input['request']->data);
	}
	
	function register($input)
	{
		global $isRequestPost;
		global $urlHomes;
		global $modelOption;
		
		$modelUser = new Usermantan();
		
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		if(isset($_SESSION['infoUser'])){
			$modelUser->redirect($urlHomes.'navigation-panel');
		}
		
		$messReg= '';
		if($isRequestPost){
			$data= $input['request']->data;
			if($data['name']!='' && $data['email']!='' && $data['pass']!='' && $data['passAgain']!=''){
				if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
					$messReg= 'Định dạng email không hợp lệ';
				} elseif(mb_strlen($data['pass'])<6){
					$messReg= 'Mật khẩu quá ngắn, tối thiểu 6 ký tự';
				} elseif($data['pass']!=$data['passAgain']){
					$messReg= 'Mật khẩu nhập lại chưa đúng';
				} else{
					$userCheck= $modelUser->getUserBy('email',$data['email']);
					if($userCheck){
						$messReg= 'Email đã có người đăng ký';
					} else{
						$modelUser->saveUser($data);
						$idUserNew= $modelUser->getLastInsertId();

						$messReg= 'Đăng ký thành công, bạn vui lòng <a href="'.$urlHomes.'login">đăng nhập</a> để sử dụng';
						
						// add email subscribe
						add_email_subscribe($data['email']);
						
						// send email for user
						$configManagerHost= $modelOption->getOption('configManagerHost');
						if(!isset($configManagerHost['Option']['value']['email'])){
							$configManagerHost['Option']['value']['email']= 'mantansource@gmail.com';
						}
						if(!isset($configManagerHost['Option']['value']['displayName'])){
							$configManagerHost['Option']['value']['displayName']= 'Mantan Source';
						}
						if(!isset($configManagerHost['Option']['value']['signature'])){
							$configManagerHost['Option']['value']['signature']= '';
						}
						
						$from= array($configManagerHost['Option']['value']['email'] =>  $configManagerHost['Option']['value']['displayName']);
						$to= array($data['email']);
						$cc= array();
						$bcc= array();
						$subject= '['.$configManagerHost['Option']['value']['displayName'].'] Đăng ký thành công';
						$content= 'Chúc mừng bạn đã đăng ký thành công tài khoản trên hệ thống <a href="'.$urlHomes.'">Mantan Host</a><br/><br/>
									Trang đăng nhập: <a href="'.$urlHomes.'login">'.$urlHomes.'login</a><br/>
									Email đăng nhập: '.$data['email'].'<br/>
									Mật khẩu: '.$data['pass'].'<br/>
									Link giới thiệu bạn bè: '.$urlHomes.'?refCode='.$idUserNew.'<br/><br/>'.$configManagerHost['Option']['value']['signature'];
						
						$modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
					}
				}
			}else{
				$messReg= 'Không được để trống các trường có dấu *';
			}
		}
		
		setVariable('messReg',$messReg);
		setVariable('data',$input['request']->data);
	}
	
	function revenue($input)
	{
		global $urlHomes;
		$modelRevenue= new Revenue();
		
		if(!isset($_SESSION['infoUser'])){
			$modelRevenue->redirect($urlHomes.'login');
		}else{
			if(isset($_GET['page'])){
				$page= (int) $_GET['page'];
			} else {
				$page=1;
			}
			$limit= 15;
			$conditions['referral']= $_SESSION['infoUser']['User']['email'];
			
			$order= array('created' => 'desc');
			$listData= $modelRevenue->getPage($page,$limit,$conditions,$order);
			
			$totalData= $modelRevenue->find('count',array('conditions' => $conditions));
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
			
			setVariable('listData',$listData);
			
			setVariable('next',$next);
			setVariable('back',$back);
			setVariable('totalPage',$totalPage);
			setVariable('page',$page);
		}
	}
	
	function manage_services($input)
	{
		global $urlHomes;
		$modelService= new Service();
		
		if(!isset($_SESSION['infoUser'])){
			$modelService->redirect($urlHomes.'login');
		}else{
			global $typeStatusDomain;
			global $typeService;
		
			if(isset($_GET['page'])){
				$page= (int) $_GET['page'];
			} else {
				$page=1;
			}
			$limit= 15;
			$conditions['user_email']= $_SESSION['infoUser']['User']['email'];
			
			$order= array('timeEnd'=>'asc','created' => 'desc');
			$listData= $modelService->getPage($page,$limit,$conditions,$order);
			
			$totalData= $modelService->find('count',array('conditions' => $conditions));
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
			
			setVariable('listData',$listData);
			setVariable('typeStatusDomain',$typeStatusDomain);
			setVariable('typeService',$typeService);
			
			setVariable('next',$next);
			setVariable('back',$back);
			setVariable('totalPage',$totalPage);
			setVariable('page',$page);
		}
	}
	
	function account($input)
	{
		global $urlHomes;
		global $isRequestPost;
		$modelUser= new Usermantan();
		
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		if(!isset($_SESSION['infoUser'])){
			$modelUser->redirect($urlHomes.'login');
		}else{
			$messReg= '';
			if($isRequestPost){
				$data= $input['request']->data;
				if($data['name']!=''){
					$checkData= true;
					
					if($data['passOld']!='' && $data['pass']!='' && $data['passAgain']!=''){
						if(md5($data['passOld'])==$_SESSION['infoUser']['User']['pass']){
							if(mb_strlen($data['pass'])<6){
								$messReg= 'Mật khẩu quá ngắn, tối thiểu 6 ký tự';
								$checkData= false;
							} elseif($data['pass']!=$data['passAgain']){
								$messReg= 'Mật khẩu nhập lại chưa đúng';
								$checkData= false;
							}
						}else{
							$messReg= 'Mật khẩu cũ chưa đúng';
							$checkData= false;
						}
					}
					
					if($checkData){
						$modelUser->saveUser($data);
						$_SESSION['infoUser']= $modelUser->getUser($_SESSION['infoUser']['User']['id']);
						$messReg= 'Lưu thông tin thành công';
					}
				}else{
					$messReg= 'Bạn không được để trống Họ tên';
				}
			}
			
			if(count($input['request']->data)>0){
				$data= $input['request']->data;
			}else{
				$data= $_SESSION['infoUser']['User'];
			}
			setVariable('messReg',$messReg);
			setVariable('data',$data);
		}
	}

	function add_coin($input)
	{
		global $isRequestPost;
		global $urlHomes;
		global $typePay;
		global $modelOption;

		$modelUser = new Usermantan();

		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);

		if(!isset($_SESSION['infoUser'])){
			$modelUser->redirect($urlHomes.'login');
		}

		$messReg= '';
		if($isRequestPost){
			if($input['request']->data['type']=='cardmobi'){
				$telco = $input['request']->data['lstTelco'];
				$code = $input['request']->data['txtCode'];
				$seri = $input['request']->data['txtSeri'];
				$account = "mantanhost@gmail.com";


				$data = array('action'=>'processCard',"seri"=>$seri,"code"=> $code,"network"=> $telco, "account"=>$account);
				//$url = 'http://nganhangthecao.com/api';
				$url = 'http://vnonpay.com/charging-api2';

				$result = json_decode(sendData($url,$data), true) ;

				//print_r($result);
				if($result['status']==1 && $result['price'] >= 10000)
				{
					$valueCard= round($result['price']*0.75);
					$messReg= "Nạp thành công: ".number_format($valueCard).'đ';
					$modelUser->updateCoin($_SESSION['infoUser']['User']['id'],$valueCard);
					$_SESSION['infoUser']= $modelUser->getUser($_SESSION['infoUser']['User']['id']);
					//Nap tien thanh cong, $result['resultCode'] là mệnh giá thẻ khách nạp
					
					// send email for user
					$configManagerHost= $modelOption->getOption('configManagerHost');
					if(!isset($configManagerHost['Option']['value']['email'])){
						$configManagerHost['Option']['value']['email']= 'mantansource@gmail.com';
					}
					if(!isset($configManagerHost['Option']['value']['displayName'])){
						$configManagerHost['Option']['value']['displayName']= 'Mantan Source';
					}
					if(!isset($configManagerHost['Option']['value']['signature'])){
						$configManagerHost['Option']['value']['signature']= '';
					}
					
					$from= array($configManagerHost['Option']['value']['email'] =>  $configManagerHost['Option']['value']['displayName']);
					$to= array($configManagerHost['Option']['value']['email'],$_SESSION['infoUser']['User']['email']);
					$cc= array();
					$bcc= array();
					$subject= '['.$configManagerHost['Option']['value']['displayName'].'] Nạp tiền thành công';
					$content= 'Chúc mừng bạn đã nạp tiền thành công cho tài khoản '.$_SESSION['infoUser']['User']['email'].' trên hệ thống <a href="'.$urlHomes.'">Mantan Host</a><br/><br/>
								Mã số thẻ: '.$code.'<br/>
								Số seri: '.$seri.'<br/>
								Mệnh giá thẻ: '.number_format($result['price']).'đ<br/>
								Số tiền nạp được: '.number_format($valueCard).'đ<br/><br/>'.$configManagerHost['Option']['value']['signature'];
					
					$modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
				}
				else
				{
					//Lỗi nạp tiền, dựa vào bảng mã lỗi để show thông tin khách hàng lên
					$messReg= $result['info'];
					/*
					switch($result[0])
					{
						case -1: $messReg= 'Thẻ đã sử dụng, bị khóa, hết hạn sử dụng, chưa được kích hoạt hoặc không tồn tại !';break;
						case -2: $messReg= 'Mã thẻ sai định dạng !';break;
						case -3: $messReg= 'Nhập sai quá số lần cho phép!';break;
						case -4: $messReg= 'Thẻ không sử dụng được (thẻ Vinaphone) !';break;
						case -5: $messReg= 'Serial hoặc mã thẻ không đúng !';break;
						case -6: $messReg= 'Nhà cung cấp không tồn tại !';break;
						case -7: $messReg= 'Hệ thống tạm thời bận !';break;
						case -8: $messReg= 'Hệ thống nhà cung cấp gặp lỗi !';break;
						case -9: $messReg= 'IP khong duoc phep truy cap vui long quay lai sau 5 phut !';break;
						default: $messReg= 'Giao dịch thất bại !';break;
					}
					*/
				}
			}
		}

		$configManagerHost= $modelOption->getOption('configManagerHost');
		$linkRefCode= $urlHomes.'?refCode='.$_SESSION['infoUser']['User']['id'];

		setVariable('linkRefCode',$linkRefCode);

		setVariable('messReg',$messReg);
		setVariable('typePay',$typePay);
		setVariable('infoBank',$configManagerHost['Option']['value']['infoBank']);
		setVariable('data',$input['request']->data);
	}
	
	function history_order($input)
	{
		global $urlHomes;
		global $typePay;
	    global $typePayStatus;
	    global $typeProcessStatus;
		
		$modelOrder= new Order();
		
		if(!isset($_SESSION['infoUser'])){
			$modelOrder->redirect($urlHomes.'login');
		}
		
		if(isset($_GET['page'])){
    		$page= (int) $_GET['page'];
    	} else {
	    	$page=1;
    	}
    	$limit= 15;
    	$conditions= array('user_id'=>$_SESSION['infoUser']['User']['id']);
    	
        $listData= $modelOrder->getPage($page,$limit,$conditions);
        $totalData= $modelOrder->find('count',array('conditions' => $conditions));
		
		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;
        
        setVariable('listData',$listData);
		setVariable('typePay',$typePay);
        setVariable('typePayStatus',$typePayStatus);
        setVariable('typeProcessStatus',$typeProcessStatus);
		
        setVariable('next',$next);
        setVariable('back',$back);
        setVariable('totalPage',$totalPage);
        setVariable('page',$page);
	}
	
	function register_product($input)
	{
		global $urlHomes;
		
		$modelProduct= new Product();
		$modelGift= new Gift();
		
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		if(isset($input['request']->params['pass'][2])){
			
			$data= $modelProduct->getProduct($input['request']->params['pass'][2]);
			if($data){
				$data['Product']['year'] = 1;
				if(isset($_SESSION['userOrder'])){
					$listOrder= $_SESSION['userOrder'];
				}else{
					$listOrder= array();
				}
				
				if(isset($input['request']->params['pass'][3])){
					$data['Product']['info']= $input['request']->params['pass'][3];
				}
				
				if(isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!=''){
					$gift= $modelGift->getGiftCode($_SESSION['codeGiftUser'],$data['Product']['id']);
					$today= getdate();
					
					if($gift
						&& $today[0]>=$gift['Gift']['timeStart'] 
						&& $today[0]<=$gift['Gift']['timeEnd'] 
						&& ($gift['Gift']['number']==0 || $gift['Gift']['numberOrder']<$gift['Gift']['number'])
						&& (!isset($_SESSION['infoUser']) || !in_array($gift['Gift']['code'],$_SESSION['infoUser']['User']['giftCode']) )
					){
						switch($gift['Gift']['type']){
							case 'price': $data['Product']['discount']= $gift['Gift']['value'];break;
							case 'percent': $data['Product']['discount']= round($data['Product']['priceMainten']*$gift['Gift']['value']/100);break;
						}
						
					}
				}
				//$listOrder[$data['Product']['id']]= $data;
				array_push($listOrder, $data);
				$_SESSION['userOrder']= $listOrder;
				
			}
		}
		$modelProduct->redirect($urlHomes.'cart');
	}
	
	function checkout($input)
	{
		global $urlHomes;
		global $isRequestPost;
		global $contactSite;
		global $modelOption;
		
		$modelOrder= new Order();
		$modelUser= new Usermantan();
		$modelGift= new Gift();
		
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		if(!isset($_SESSION['infoUser'])){
			$modelOrder->redirect($urlHomes.'login');
		}else{
			if(isset($_SESSION['codeGiftUser'])){
				$checkUseGiftCode= $modelUser->checkUseGiftCode($_SESSION['codeGiftUser'],$_SESSION['infoUser']['User']['id']);
				if($checkUseGiftCode){
					get_remove_gift_code();
				}
			}
			
			if(isset($_SESSION['userOrder']) && count($_SESSION['userOrder'])>0){
				$listOrder= $_SESSION['userOrder'];
				$referral= '';
				
				if(isset($_SESSION['referral']) && $_SESSION['referral']!=$_SESSION['infoUser']['User']['id']){
					$checkUserReferral= $modelUser->getUser($_SESSION['referral']);
					if($checkUserReferral){
						$referral= $checkUserReferral['User']['email'];
					}
				}
				
				if(isset($_SESSION['codeGiftUser'])){
					$codeGift= $_SESSION['codeGiftUser'];
				}else{
					$codeGift= '';
				}
				
				if(isset($_SESSION['totalOrder'])){
					$total= (int) $_SESSION['totalOrder'];
				}else{
					$total= '';
				}

				$configManagerHost= $modelOption->getOption('configManagerHost');

				if($isRequestPost){
					$modelOrder->saveOrder($listOrder,$_SESSION['infoUser'],$input['request']->data,$referral,$total,$codeGift);
					
					// add number gift code
					if(trim($codeGift)!=''){
						foreach($listOrder as $productSave){
							$modelGift->addOrderGift(trim($codeGift),$productSave['Product']['id']);
						}
					}

					if(!isset($configManagerHost['Option']['value']['email'])){
						$configManagerHost['Option']['value']['email']= 'mantansource@gmail.com';
					}
					if(!isset($configManagerHost['Option']['value']['displayName'])){
						$configManagerHost['Option']['value']['displayName']= 'Mantan Source';
					}
					if(!isset($configManagerHost['Option']['value']['signature'])){
						$configManagerHost['Option']['value']['signature']= '';
					}
					// send email for user and admin
					$from= array($configManagerHost['Option']['value']['email'] =>  $configManagerHost['Option']['value']['displayName']);
					$to= array($_SESSION['infoUser']['User']['email'],$configManagerHost['Option']['value']['email']);
					$cc= array();
					$bcc= array();
					$subject= '['.$configManagerHost['Option']['value']['displayName'].'] Đặt hàng thành công';
					$content= getContentEmailOrderSuccess($listOrder,$input['request']->data).'<br/><br/><b>Thông tin chuyển khoản</b><br/>'.$configManagerHost['Option']['value']['infoBank'].'<br/>'.$configManagerHost['Option']['value']['signature'];
					
					$modelOrder->sendMail($from,$to,$cc,$bcc,$subject,$content);
					
					unset($_SESSION['userOrder']);
					unset($_SESSION['codeGiftUser']);
					unset($_SESSION['totalOrder']);
					
					$modelOrder->redirect($urlHomes.'navigation-panel?action=order');
				}
				
				if(isset($_SESSION['codeGiftUser'])){
					$codeGift= $_SESSION['codeGiftUser'];
				}else{
					$codeGift= '';
				}
				
				$linkRefCode= $urlHomes.'?refCode='.$_SESSION['infoUser']['User']['id'];
				
				setVariable('listOrder',$listOrder);
				setVariable('linkRefCode',$linkRefCode);
				setVariable('codeGift',$codeGift);
				setVariable('infoUserLogin',$_SESSION['infoUser']);
				setVariable('infoBank',$configManagerHost['Option']['value']['infoBank']);
			}else{
				$modelOrder->redirect($urlHomes.'cart');
			}
		}
		
	}
	
	function navigation_panel($input)
	{
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		$mess= '';
		
		if(isset($input['request']->query['action'])){
			switch($input['request']->query['action']){
				case 'login': $mess= 'Đăng nhập thành công';break;
				case 'order': $mess= 'Đặt hàng thành công. Cảm ơn quý khách đã sử dụng dịch vụ của Mantan Host';break;
			}
		}
		
		setVariable('mess',$mess);
	}
	
	function cart($input)
	{
		if(isset($_SESSION['userOrder'])){
			$listOrder= $_SESSION['userOrder'];
		}else{
			$listOrder= array();
		}
		
		if(isset($_SESSION['codeGiftUser'])){
			$codeGift= $_SESSION['codeGiftUser'];
		}else{
			$codeGift= '';
		}
		
		if(isset($_GET['addCode']) && $_GET['addCode']==-1){
			$messAddCode= 'Bạn không được sử dụng mã khuyến mại này';
		}else{
			$messAddCode= '';
		}
		
		setVariable('listOrder',$listOrder);
		setVariable('codeGift',$codeGift);
		setVariable('messAddCode',$messAddCode);
	}
	
	function delete_product_cart($input)
	{
		global $urlHomes;
		$modelProduct= new Product();
		
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		if(isset($_SESSION['userOrder']) && isset($input['request']->params['pass'][1])){
			$listOrder= $_SESSION['userOrder'];
			unset($listOrder[$input['request']->params['pass'][1]]);
			$listOrder= array_values($listOrder);
			$_SESSION['userOrder']= $listOrder;
		}
		$modelProduct->redirect($urlHomes.'cart');
	}
	
	function update_cart($input)
	{
		global $urlHomes;
		$modelProduct= new Product();
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
		
		if(isset($_SESSION['userOrder']) && isset($input['request']->data['number'])){
			$listOrder= $_SESSION['userOrder'];
			$listOrder[$input['request']->data['number']]['Product']['year']= (double)$input['request']->data['year'];
			$_SESSION['userOrder']= $listOrder;
			return true;
		}
		$modelProduct->redirect($urlHomes.'cart');
	}
	
	function add_gift_code($input)
	{
		global $urlHomes;
		$modelProduct= new Product();
		$modelGift= new Gift();
		
		$input['request']->data= arrayMap($input['request']->data);
		$input['request']->params= arrayMap($input['request']->params);
		$input['request']->query= arrayMap($input['request']->query);
				
		if(isset($input['request']->data['code']) && isset($_SESSION['userOrder']) && count($_SESSION['userOrder'])>0 ){
			$today= getdate();
			$number= -1;
			$listOrder= $_SESSION['userOrder'];
			$return= -1;
			
			foreach($listOrder as $order){
				$number++;
				$gift= $modelGift->getGiftCode($input['request']->data['code'],$order['Product']['id']);
				if($gift 
					&& $today[0]>=$gift['Gift']['timeStart'] 
					&& $today[0]<=$gift['Gift']['timeEnd'] 
					&& ($gift['Gift']['number']==0 || $gift['Gift']['numberOrder']<$gift['Gift']['number'])
					&& (!isset($_SESSION['infoUser']) || !in_array($gift['Gift']['code'],$_SESSION['infoUser']['User']['giftCode']) ) ){
						switch($gift['Gift']['type']){
							case 'price':   $listOrder[$number]['Product']['discount']= $gift['Gift']['value'];
                                            $listOrder[$number]['Product']['discountVat']= $gift['Gift']['vat'];
                                            break;
							case 'percent': $listOrder[$number]['Product']['discount']= round($order['Product']['priceMainten']*$gift['Gift']['value']/100);
                                            $listOrder[$number]['Product']['discountVat']= round($order['Product']['priceMainten']*$gift['Gift']['vat']/100);
                                            break;
						}
						
						$_SESSION['codeGiftUser']= $input['request']->data['code'];	
						$return= 1;
				}
			}
					
			$_SESSION['userOrder']= $listOrder;
			
		}
		
		$modelProduct->redirect($urlHomes.'cart?addCode='.$return);
	}
	
	function remove_gift_code($input)
	{
		global $urlHomes;
		$modelProduct= new Product();
		
		get_remove_gift_code();
		
		$modelProduct->redirect($urlHomes.'cart');
	}
	// Admin quan ly nguoi dung
	function list_user($input)
	{	
		global $urlHomes;
		$modelUser= new Usermantan();
		
		if(checkAdminLogin()){
			if(isset($_GET['page'])){
	    		$page= (int) $_GET['page'];
	    	} else {
		    	$page=1;
	    	}
	    	$limit= 15;
	    	$conditions= array();
	    	if(isset($_GET['email']) && $_GET['email']!='')
	    	{
				$conditions['email']= $_GET['email'];
	    	}
	    	
	    	if(isset($_GET['name']) && $_GET['name']!='')
	    	{
				$conditions['name']['$regex']= trim($_GET['name']);
	    	}
			
			if(isset($_GET['phone']) && $_GET['phone']!='')
	    	{
				$conditions['phone']= $_GET['phone'];
	    	}
	    	
			$order= array('created' => 'desc');
	        $listData= $modelUser->getPage($page,$limit,$conditions,$order);
	        
	        $totalData= $modelUser->find('count',array('conditions' => $conditions));
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
	        
	        setVariable('listData',$listData);
			
	        setVariable('next',$next);
	        setVariable('back',$back);
	        setVariable('totalPage',$totalPage);
	        setVariable('page',$page);
		}else{
			$modelUser->redirect($urlHomes);
		}
	}
	
	
	function add_user($input)
	{
		global $isRequestPost;
		global $urlHomes;
		
		$modelUser= new Usermantan();
		
		if(checkAdminLogin()){
			$messSave= '';
			if($isRequestPost){
				$modelUser->saveUserAdmin($input['request']->data);
				$messSave= 'Lưu dữ liệu thành công';
			}
			
			if(isset($input['request']->params['pass'][1])){
				$data= $modelUser->getUser($input['request']->params['pass'][1]);
				setVariable('data',$data);
			}
			
			setVariable('messSave',$messSave);
		}else{
			$modelUser->redirect($urlHomes);
		}
	}
	
	// Admin quan ly dich vụ khach thue
	function list_service($input)
	{
		global $typeStatusDomain;
		global $typeService;
		global $urlHomes;
		
		$modelService= new Service();
		
		if(checkAdminLogin()){
			if(isset($_GET['page'])){
	    		$page= (int) $_GET['page'];
	    	} else {
		    	$page=1;
	    	}
	    	$limit= 15;
	    	$conditions= array('lock'=>array('$ne'=>true));
	    	if(isset($_GET['email']) && $_GET['email']!='')
	    	{
				$conditions['user_email']= $_GET['email'];
	    	}
	    	
	    	if(isset($_GET['key']) && $_GET['key']!='')
	    	{
				$conditions['info']['$regex']= trim($_GET['key']);
	    	}
			
			if(isset($_GET['phone']) && $_GET['phone']!='')
	    	{
				$conditions['phone']= $_GET['phone'];
	    	}
            
            if(isset($_GET['typeService']) && $_GET['typeService']!='')
	    	{
				$conditions['typeService']= (int) $_GET['typeService'];
	    	}
	    	
			$order= array('timeEnd'=>'asc','created' => 'desc');
	        $listData= $modelService->getPage($page,$limit,$conditions,$order);
	        
	        $totalData= $modelService->find('count',array('conditions' => $conditions));
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
	        
	        setVariable('listData',$listData);
			setVariable('typeStatusDomain',$typeStatusDomain);
			setVariable('typeService',$typeService);
			
	        setVariable('next',$next);
	        setVariable('back',$back);
	        setVariable('totalPage',$totalPage);
	        setVariable('page',$page);
		}else{
			$modelService->redirect($urlHomes);
		}
	}
    
    function delete_service($input)
    {
        global $urlPlugins;
		global $urlHomes;
		
		$modelService= new Service();
		
		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1])){
				$save['$set']['lock']= true;
				$id= new MongoId($input['request']->params['pass'][1]);
				$dk= array('_id'=>$id);
				$modelService->updateAll($save,$dk);

				//$data= $modelService->delete($input['request']->params['pass'][1]);
			}
			$modelService->redirect($urlPlugins.'admin/managerHost-admin-list_service.php');
		}else{
			$modelService->redirect($urlHomes);
		}
    }
    
	function add_service($input)
	{
		global $isRequestPost;
		global $urlPlugins;
		global $typeStatusDomain;
		global $modelOption;
		global $typeService;
		global $urlHomes;
		
		$modelService= new Service();
		$modelGift= new Gift();
		$modelProduct= new Product();
		$modelRevenue= new Revenue();
		$modelUser= new Usermantan();
		$modelOrder= new Order();
		
		if(checkAdminLogin()){
			$listProduct= $modelProduct->find('all');
			
			$messSave= '';
			if($isRequestPost){
				$data= $input['request']->data;
				
				$productSelect= $modelProduct->getProduct($data['product_id']);
				$data['product_name']= $productSelect['Product']['title'];
				$modelService->saveService($data);
				$messSave= 'Lưu dữ liệu thành công';
				$serviceID= $modelService->getInsertID();
				
				if($data['id']==''){
					// send email for list notification
					$configManagerHost= $modelOption->getOption('configManagerHost');
					if(!isset($configManagerHost['Option']['value']['email'])){
						$configManagerHost['Option']['value']['email']= 'mantansource@gmail.com';
					}
					if(!isset($configManagerHost['Option']['value']['displayName'])){
						$configManagerHost['Option']['value']['displayName']= 'Mantan Source';
					}
					if(!isset($configManagerHost['Option']['value']['signature'])){
						$configManagerHost['Option']['value']['signature']= '';
					}
					
					$from= array($configManagerHost['Option']['value']['email'] =>  $configManagerHost['Option']['value']['displayName']);
					$to= explode(',',trim($data['notification']));
					$cc= array();
					$bcc= array();
					
					if($data['typeService']==1){
						$subject= '['.$configManagerHost['Option']['value']['displayName'].'] Thông tin tên miền '.$data['info'];
						$content= 'Chúc mừng bạn đã đăng ký thành công tên miền '.$data['info'].' trên hệ thống <a href="'.$urlHomes.'">Mantan Host</a><br/><br/>';
					}elseif($data['typeService']==2 || $data['typeService']==3){
						$subject= '['.$configManagerHost['Option']['value']['displayName'].'] Thông tin máy chủ gói '.$data['product_name'];
						$content= 'Gói dịch vụ '.$data['product_name'].' của quý khách đã được khởi tạo thành công trên hệ thống <a href="'.$urlHomes.'">Mantan Host</a><br/><br/>';
					}elseif($data['typeService']==4){
						$subject= '['.$configManagerHost['Option']['value']['displayName'].'] Dịch vụ '.$data['product_name'];
						$content= 'Dịch vụ '.$data['product_name'].' của quý khách đã được khởi tạo thành công trên hệ thống <a href="'.$urlHomes.'">Mantan Host</a><br/><br/>';
					}else{
						$subject= '['.$configManagerHost['Option']['value']['displayName'].'] Thông tin dịch vụ Mantan Host';
						$content= 'Dịch vụ '.$data['product_name'].' của quý khách đã được khởi tạo thành công trên hệ thống <a href="'.$urlHomes.'">Mantan Host</a><br/><br/>';
					}
					
					if($data['typeService']==1 || $data['typeService']==2 || $data['typeService']==3){
						$content= $content.'Trang đăng nhập: <a href="'.$data['urlPanel'].'">'.$data['urlPanel'].'</a><br/>
									Tài khoản: '.$data['account'].'<br/>
									Mật khẩu: '.$data['pass'].'<br/>
									Thời gian: '.$data['timeStart'].' - '.$data['timeEnd'].' (mm/dd/YYYY)<br/><br/>'.$configManagerHost['Option']['value']['signature'];
					}else{
						$content= $content.nl2br($data['info']).'<br/>Thời gian: '.$data['timeStart'].' - '.$data['timeEnd'].' (mm/dd/YYYY)<br/><br/>'.$configManagerHost['Option']['value']['signature'];
					}

					if($data['sendMail']==1){
						$modelOrder->sendMail($from,$to,$cc,$bcc,$subject,$content);
					}
					
					// add number gift code
					if(trim($data['gift'])!=''){
						$modelGift->addOrderGiftActive(trim($data['gift']),$data['product_id']);
						$modelUser->addOrderGiftActive(trim($data['user_email']),trim($data['gift']));
					}
					
					// add referral
					if($data['referral']!=''){
						$timeUsed= $data['timeStart'].' - '.$data['timeEnd'];
						$checkUserReferral= $modelUser->getUserBy('email',$data['referral']);
						if($checkUserReferral){
							$reward = $data['priceTotal']*$checkUserReferral['User']['percent'];
							$modelUser->updateCoin($checkUserReferral['User']['id'],$reward);
							$modelRevenue->addOrderRevenue(trim($data['referral']),$serviceID,$data['product_id'],$data['product_name'],$timeUsed,$data['priceTotal'],$reward);
						}
					}
				}
			}
			
			if(isset($input['request']->params['pass'][1])){
				$data= $modelService->getService($input['request']->params['pass'][1]);
				
				if(isset($data['Service']['timeStart']) && $data['Service']['timeStart']>0){
					$timeStart= getdate($data['Service']['timeStart']);
					$data['Service']['timeStart']= $timeStart['mon'].'/'.$timeStart['mday'].'/'.$timeStart['year'];
				}
				
				if(isset($data['Service']['timeEnd']) && $data['Service']['timeEnd']>0){
					$timeEnd= getdate($data['Service']['timeEnd']);
					$data['Service']['timeEnd']= $timeEnd['mon'].'/'.$timeEnd['mday'].'/'.$timeEnd['year'];
				}
				
				setVariable('data',$data);
			}elseif(isset($_GET['orderID'])&&isset($_GET['productID'])){
				$order= $modelOrder->getOrder($_GET['orderID']);
				if($order){
					foreach($order['Order']['listOrder'] as $product){
						if($product['Product']['id']==$_GET['productID']){
							$data['Service']['typeService']= $product['Product']['typeService'];
							$data['Service']['product_id']= $product['Product']['id'];
							$data['Service']['info']= $product['Product']['info'];
							$data['Service']['user_email']= $order['Order']['user_email'];
							$data['Service']['referral']= $order['Order']['referral'];
							
							if(isset($product['Product']['discount'])){
								$priceMainten= $product['Product']['discount'];
								$priceVat= (isset($product['Product']['discountVat']))?$product['Product']['discountVat']:$product['Product']['discount']*0.1;
							}else{
								$priceMainten= $product['Product']['priceMainten'];
								$priceVat= (isset($product['Product']['priceVat']))?$product['Product']['priceVat']:$product['Product']['priceMainten']*0.1;
							}
							
							if($product['Product']['year']>1){
                    			$data['Service']['priceTotal']= $product['Product']['priceInstall']+$priceMainten+$priceVat+ ($product['Product']['priceMainten']+$product['Product']['priceVat'])*($product['Product']['year']-1);
                        	}else{
                        		$data['Service']['priceTotal']= $product['Product']['priceInstall']+($priceMainten+$priceVat)*$product['Product']['year'];
                        	}
							
                            $priceVatMainten= (isset($product['Product']['priceVat']))?$product['Product']['priceVat']:$product['Product']['priceMainten']*0.1;
							$data['Service']['priceMainten']= ($product['Product']['priceMainten']+$priceVatMainten)*$product['Product']['year'];
							$data['Service']['gift']= $order['Order']['infoOrder']['codeGift'];
							
							$data['Service']['name']= $order['Order']['infoOrder']['name'];
							$data['Service']['emailManager']= $order['Order']['infoOrder']['email'];
							$data['Service']['notification']= $order['Order']['infoOrder']['notification'];
							$data['Service']['phone']= $order['Order']['infoOrder']['phone'];
							$data['Service']['address']= $order['Order']['infoOrder']['address'];
							
							
							$order['Order']['created']= getdate($order['Order']['created']->sec);
							$endYear= $order['Order']['created']['year']+$product['Product']['year'];
							$data['Service']['timeStart']= $order['Order']['created']['mon'].'/'.$order['Order']['created']['mday'].'/'.$order['Order']['created']['year'];
							$data['Service']['timeEnd']= $order['Order']['created']['mon'].'/'.$order['Order']['created']['mday'].'/'.$endYear;
							
							setVariable('data',$data);
							break;
						}
					}
					
				}
			}
			
			setVariable('messSave',$messSave);
			setVariable('typeService',$typeService);
			setVariable('listProduct',$listProduct);
			setVariable('typeStatusDomain',$typeStatusDomain);
		}else{
			$modelService->redirect($urlHomes);
		}
	}
	
	// Admin - Quản lý dịch vụ
	function list_product($input)
	{
		global $typeService;
		global $urlHomes;
		
		$modelProduct= new Product();
		
		if(checkAdminLogin()){
			if(isset($_GET['page'])){
	    		$page= (int) $_GET['page'];
	    	} else {
		    	$page=1;
	    	}
	    	$limit= 15;
	    	$conditions= array();
	    	if(isset($_GET['title']) && $_GET['title']!='')
	    	{
				$conditions['title']= array('$regex' => $_GET['title'] );
	    	}
	    	
	    	if(isset($_GET['id']) && $_GET['id']!='')
	    	{
				$conditions['_id']= new MongoId($_GET['id']);
	    	}
	    	
	        $listData= $modelProduct->getPage($page,$limit,$conditions);
	        
	        $totalData= $modelProduct->find('count',array('conditions' => $conditions));
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
	        
	        setVariable('listData',$listData);
	        setVariable('typeService',$typeService);
	        
	        setVariable('next',$next);
	        setVariable('back',$back);
	        setVariable('totalPage',$totalPage);
	        setVariable('page',$page);
		}else{
			$modelProduct->redirect($urlHomes);
		}
	}
	
	function add_product($input)
	{
		global $isRequestPost;
		global $urlPlugins;
		global $typeService;
		global $urlHomes;
		
		$modelProduct= new Product();
		
		if(checkAdminLogin()){
			$messSave= '';
			if($isRequestPost){
				$modelProduct->saveProduct($input['request']->data);
				$messSave= 'Lưu dữ liệu thành công';
			}
			
			if(isset($input['request']->params['pass'][1])){
				$data= $modelProduct->getProduct($input['request']->params['pass'][1]);
				setVariable('data',$data);
			}
			
			setVariable('messSave',$messSave);
			setVariable('typeService',$typeService);
		}else{
			$modelProduct->redirect($urlHomes);
		}
	}
	
	function delete_product($input)
	{
		global $urlPlugins;
		global $urlHomes;
		
		$modelProduct= new Product();
		
		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1])){
				$data= $modelProduct->delete($input['request']->params['pass'][1]);
			}
			$modelProduct->redirect($urlPlugins.'admin/managerHost-admin-list_product.php');
		}else{
			$modelProduct->redirect($urlHomes);
		}
	}
	
	// Admin- quan ly ma khuyen mai
	function list_gift($input)
	{
		global $urlHomes;
		
		$modelGift= new Gift();
		$modelProduct= new Product();
		
		if(checkAdminLogin()){
			if(isset($_GET['page'])){
	    		$page= (int) $_GET['page'];
	    	} else {
		    	$page=1;
	    	}
	    	$limit= 15;
	    	$conditions= array();
	    	if(isset($_GET['code']) && $_GET['code']!='')
	    	{
				$conditions['code']= array('$regex' => $_GET['code'] );
	    	}
	    	
	        $listData= $modelGift->getPage($page,$limit,$conditions);
			$listProduct= array();
			foreach($listData as $gift){
				if(!isset($listProduct[$gift['Gift']['product_id']])){
					$product= $modelProduct->getProduct($gift['Gift']['product_id']);
					$listProduct[$gift['Gift']['product_id']]['Product']= $product['Product'];
				}
			}
	        
	        $totalData= $modelGift->find('count',array('conditions' => $conditions));
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
	        
	        setVariable('listData',$listData);
			setVariable('listProduct',$listProduct);
			
	        setVariable('next',$next);
	        setVariable('back',$back);
	        setVariable('totalPage',$totalPage);
	        setVariable('page',$page);
	    }else{
			$modelProduct->redirect($urlHomes);
		}
	}
	
	function add_gift($input)
	{
		global $isRequestPost;
		global $urlPlugins;
		global $urlHomes;
		
		$modelGift= new Gift();
		
		if(checkAdminLogin()){
			$messSave= '';
			if($isRequestPost){
				$modelGift->saveGift($input['request']->data);
				$messSave= 'Lưu dữ liệu thành công';
			}
			
			if(isset($input['request']->params['pass'][1])){
				$data= $modelGift->getGift($input['request']->params['pass'][1]);
				setVariable('data',$data);
			}
			
			$modelProduct= new Product();
			$listProduct= $modelProduct->find('all');
			
			setVariable('messSave',$messSave);
			setVariable('listProduct',$listProduct);
		}else{
			$modelGift->redirect($urlHomes);
		}
	}
	
	function delete_gift($input)
	{
		global $urlPlugins;
		global $urlHomes;
		
		$modelGift= new Gift();
		
		if(checkAdminLogin()){
			if(isset($input['request']->params['pass'][1])){
				$data= $modelGift->delete($input['request']->params['pass'][1]);
			}
			$modelGift->redirect($urlPlugins.'admin/managerHost-admin-list_gift.php');
		}else{
			$modelGift->redirect($urlHomes);
		}
	}
	
	// Admin quan ly don hang
	function list_order($input)
	{
		global $typePay;
	    global $typePayStatus;
	    global $typeProcessStatus;
	    global $urlHomes;
		
		$modelOrder= new Order();
		
		if(checkAdminLogin()){
			$payStatus= -1;
			$processStatus= 0;
		
			if(isset($_GET['page'])){
	    		$page= (int) $_GET['page'];
	    	} else {
		    	$page=1;
	    	}
	    	$limit= 15;
	    	$conditions= array();
	    	if(isset($_GET['email']) && $_GET['email']!='')
	    	{
				$conditions['user_email']= $_GET['email'];
	    	}
			
			if(isset($_GET['payStatus']))
	    	{
				if($_GET['payStatus']!=-1){
					$conditions['payStatus']= (int) $_GET['payStatus'];
				}
				$payStatus= $_GET['payStatus'];
	    	}
			
			$conditions['processStatus']= $processStatus;
			if(isset($_GET['processStatus']))
	    	{
				$processStatus= (int) $_GET['processStatus'];
				if($_GET['processStatus']!=-1){
					$conditions['processStatus']= (int) $_GET['processStatus'];
				}else{
					unset($conditions['processStatus']);
				}
	    	}
	    	
	    	$order= array('processStatus'=>'asc','payStatus'=>'asc','created' => 'asc');
	    
	        $listData= $modelOrder->getPage($page,$limit,$conditions,$order);
	        
	        $totalData= $modelOrder->find('count',array('conditions' => $conditions));
			
			$balance= $totalData%$limit;
			$totalPage= ($totalData-$balance)/$limit;
			if($balance>0)$totalPage+=1;
			
			$back=$page-1;$next=$page+1;
			if($back<=0) $back=1;
			if($next>=$totalPage) $next=$totalPage;
	        
	        setVariable('listData',$listData);
	        setVariable('typePay',$typePay);
	        setVariable('typePayStatus',$typePayStatus);
	        setVariable('typeProcessStatus',$typeProcessStatus);
			setVariable('processStatus',$processStatus);
			setVariable('payStatus',$payStatus);
			
	        setVariable('next',$next);
	        setVariable('back',$back);
	        setVariable('totalPage',$totalPage);
	        setVariable('page',$page);
	    }else{
			$modelOrder->redirect($urlHomes);
		}
	}
	
	function process_order($input)
	{
		global $typePay;
	    global $typePayStatus;
	    global $typeProcessStatus;
	    global $isRequestPost;
	    global $urlHomes;
		global $urlPlugins;
	    
	    $modelOrder= new Order();
	    
	    if(checkAdminLogin()){
	    	$messSave= '';
		    
		    if(isset($input['request']->params['pass'][1])){
			    $data= $modelOrder->getOrder($input['request']->params['pass'][1]);
			    if(!$data){
				    $modelOrder->redirect($urlPlugins.'admin/managerHost-admin-list_order.php');
			    }else{
				    if($isRequestPost){
					    $data['Order']['infoOrder']['priceDiscount']= (int) $input['request']->data['priceDiscount'];
					    $data['Order']['infoOrder']['pay']= $input['request']->data['pay'];
						
						$data['Order']['infoOrder']['name']= $input['request']->data['name'];
						$data['Order']['infoOrder']['email']= $input['request']->data['email'];
						$data['Order']['infoOrder']['notification']= $input['request']->data['notification'];
						$data['Order']['infoOrder']['phone']= $input['request']->data['phone'];
						$data['Order']['infoOrder']['address']= $input['request']->data['address'];
					    
					    $data['Order']['payStatus']= (int) $input['request']->data['payStatus'];
					    $data['Order']['processStatus']= (int) $input['request']->data['processStatus'];
					    
					    foreach($data['Order']['listOrder'] as $key=>$order){
					    	$data['Order']['listOrder'][$key]['Product']['info']= $input['request']->data['info'][$order['Product']['id']];
						}
						
						$modelOrder->save($data);
						
						$messSave= 'Lưu đơn hàng thành công';
				    }
				    
				    $data['Order']['created']= getdate($data['Order']['created']->sec);
					$data['Order']['created']= $data['Order']['created']['mday'].'/'.$data['Order']['created']['mon'].'/'.$data['Order']['created']['year'];
			    }
		    }else{
			    $modelOrder->redirect($urlPlugins.'admin/managerHost-admin-list_order.php');
		    }
			
			setVariable('data',$data);
			setVariable('messSave',$messSave);
			setVariable('typePay',$typePay);
	        setVariable('typePayStatus',$typePayStatus);
	        setVariable('typeProcessStatus',$typeProcessStatus);
	    }else{
			$modelOrder->redirect($urlHomes);
		}
	}
	// Admin cai dat chung
	function setting($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
		
		if(checkAdminLogin()){
			$mess= '';
			$data= $modelOption->getOption('configManagerHost');
			if($isRequestPost){
				$dataSend= $input['request']->data;
				$data['Option']['value']['email']= $dataSend['email'];
				$data['Option']['value']['displayName']= $dataSend['displayName'];
				$data['Option']['value']['signature']= $dataSend['signature'];
				$data['Option']['value']['infoBank']= $dataSend['infoBank'];
				
				$modelOption->saveOption('configManagerHost', $data['Option']['value']);
				$mess= $languageMantan['saveSuccess'];
			}
			
			setVariable('mess',$mess);
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
	
	// admin quan ly nhan thong bao
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
	
	function send_subscribe($input)
	{
		global $isRequestPost;
		global $modelOption;
		global $languageMantan;
		global $urlHomes;
        global $typeService;
		
		$mess= '';
		$modelUser= new Usermantan();
		$modelService= new Service();
        
		if(checkAdminLogin()){
			if($isRequestPost){
				$listEmail= array();
				
				if($input['request']->data['typeUser']==1){
					$listEmail= $modelOption->getOption('listSubscribe');
					$listEmail= $listEmail['Option']['value']['listSubscribe'];
				}elseif($input['request']->data['typeUser']==2){
					$listUser= $modelUser->getUserFields(array('email'));
					$listEmail= array();
					if($listUser){
						foreach($listUser as $user){
							array_push($listEmail, $user['User']['email']);
						}
					}
				}	
				
				if(mb_strlen(trim($input['request']->data['otherUser']))>0){
					$listOtherUser= explode(',', trim($input['request']->data['otherUser']));
					
					$listEmail= array_merge($listEmail,$listOtherUser);
				}
				
				$listEmail= array_unique($listEmail);
				
				// send email for user
				$configManagerHost= $modelOption->getOption('configManagerHost');
				if(!isset($configManagerHost['Option']['value']['email'])){
					$configManagerHost['Option']['value']['email']= 'mantansource@gmail.com';
				}
				if(!isset($configManagerHost['Option']['value']['displayName'])){
					$configManagerHost['Option']['value']['displayName']= 'Mantan Source';
				}
				if(!isset($configManagerHost['Option']['value']['signature'])){
					$configManagerHost['Option']['value']['signature']= '';
				}
				
				$from= array($configManagerHost['Option']['value']['email'] =>  $configManagerHost['Option']['value']['displayName']);
				$to= array($listEmail[0]);
				unset($listEmail[0]);
				$cc= array();
				$bcc= $listEmail;
				$subject= '['.$configManagerHost['Option']['value']['displayName'].'] '.$input['request']->data['title'];
				$content= $input['request']->data['content'].'<br/><br/>'.$configManagerHost['Option']['value']['signature'];
				
				$modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
				$mess= 'Email được gửi đi thành công !';
			}
            
            $typeUser= 1;
            $otherUser= '';
            $title= '';
            $content= '';
            if(isset($_GET['idService'])){
                $typeUser= 3;
                $service= $modelService->getService($_GET['idService']);
                $configManagerHost= $modelOption->getOption('configManagerHost');
                
                $timeEnd= getdate($service['Service']['timeEnd']);
                $yearEnd= $timeEnd['year']+1;
                
                $otherUser= $service['Service']['notification'];
                $title= 'Thông báo hết hạn dịch vụ';
                $content= 'Kính gửi: '.$service['Service']['name'].'
                            <br/>Đây là thông báo về việc hết hạn dịch vụ của quý khách.
                            <br/>Hình thức thanh toán: trực tiếp hoặc chuyển khoản
                            <br/>Tổng số tiền: '.number_format($service['Service']['priceMainten']).'đ
                            <br/>Ngày hết hạn: '.$timeEnd['mday'].'/'.$timeEnd['mon'].'/'.$timeEnd['year'].'
                            <br/><br/><b>Thông tin gói '.$typeService[$service['Service']['typeService']].':</b>
                            <br/>'.nl2br($service['Service']['info']).'
                            <br/>- Thời gian gia hạn: 12 tháng ('.$timeEnd['mday'].'/'.$timeEnd['mon'].'/'.$timeEnd['year'].' - '.$timeEnd['mday'].'/'.$timeEnd['mon'].'/'.$yearEnd.')
                            <br/><br/><b>Thông tin chuyển khoản:</b>
                            <br/>'.$configManagerHost['Option']['value']['infoBank'].'
                            ';
            }
			
			setVariable('mess',$mess);
            setVariable('typeUser',$typeUser);
            setVariable('otherUser',$otherUser);
            setVariable('title',$title);
            setVariable('content',$content);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}
?>