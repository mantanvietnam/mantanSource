<?php
	$menus= array();
	$menus[0]['title']= 'Host Manager';
	$menus[0]['sub'][0]= array('name'=>'Dịch vụ','url'=>$urlPlugins.'admin/managerHost-admin-list_product.php','classIcon'=>'fa-cart-plus','permission'=>'list_product');
	$menus[0]['sub'][1]= array('name'=>'Khuyến mại','url'=>$urlPlugins.'admin/managerHost-admin-list_gift.php','classIcon'=>'fa-gift','permission'=>'list_gift');
    $menus[0]['sub'][2]= array('name'=>'Đơn hàng','url'=>$urlPlugins.'admin/managerHost-admin-list_order.php','classIcon'=>'fa-bars','permission'=>'list_order');
    $menus[0]['sub'][3]= array('name'=>'Dịch vụ khách thuê','url'=>$urlPlugins.'admin/managerHost-admin-list_service.php','classIcon'=>'fa-newspaper-o','permission'=>'list_service');
    $menus[0]['sub'][4]= array('name'=>'Khách hàng','url'=>$urlPlugins.'admin/managerHost-admin-list_user.php','classIcon'=>'fa-user-plus','permission'=>'list_user');
	$menus[0]['sub'][5]= array('name'=>'Cấu hình chung','url'=>$urlPlugins.'admin/managerHost-admin-setting.php','classIcon'=>'fa-wrench','permission'=>'setting_all');
    
    $menus[1]['title']= 'Subscribe';
	$menus[1]['sub'][0]= array('name'=>'Gửi email thông báo','url'=>$urlPlugins.'admin/managerHost-admin-send_subscribe.php','classIcon'=>'fa-envelope-o','permission'=>'send_subscribe');
	$menus[1]['sub'][1]= array('name'=>'Danh sách email','url'=>$urlPlugins.'admin/managerHost-admin-list_subscribe.php','classIcon'=>'fa-list','permission'=>'list_subscribe');
	
    addMenuAdminMantan($menus);
    
    global $typePay;
    global $typePayStatus;
    global $typeProcessStatus;
	global $typeStatusDomain;
	global $typeService;
    
    $typePay= array('cardmobi'=>'Thẻ cào điện thoại',
					'bank'=>'Chuyển khoản ngân hàng',
    				'payPal'=>'Chuyển qua PayPal',
    				'card'=>'Credit/Debit/Prepaid Card',
    				'cash'=>'Tiền mặt',
    				'coin'=>'Trừ tiền trong tài khoản'
    				);
    $typePayStatus= array(0=>'Chưa thanh toán',
    					  1=>'Đã thanh toán'
    					);
    $typeProcessStatus= array(0=>'Chưa xử lý',
    						  1=>'Đã xử lý',
    						  2=>'Hủy bỏ'
    						);
    $typeStatusDomain=  array(1=>'Đang sử dụng',
							  2=>'Sắp hết hạn',
							  3=>'Hết hạn',
    					);	
	$typeService= array(1=>'ManMo 3H',
						2=>'ManMo Web',
						);
    
    if(isset($_GET['refCode'])){
	    $_SESSION['referral']= $_GET['refCode'];
    }
    
	function get_remove_gift_code()
	{
		unset($_SESSION['codeGiftUser']);
		if(isset($_SESSION['userOrder']) && count($_SESSION['userOrder'])>0){
			$listOrder= $_SESSION['userOrder'];
			$number= -1;
			foreach($listOrder as $order){
				$number++;
				unset($listOrder[$number]['Product']['discount']);
			}
			$_SESSION['userOrder']= $listOrder;
		}
	}
	
	function add_email_subscribe($email=null)
	{
		global $modelOption;
		
		$listSubscribe= $modelOption->getOption('listSubscribe');
		if(!isset($listSubscribe['Option']['value']['listSubscribe'])){
			$listSubscribe['Option']['value']['listSubscribe']= array();
		}
		
		if($email && !in_array($email, $listSubscribe['Option']['value']['listSubscribe'])){
			array_push($listSubscribe['Option']['value']['listSubscribe'], $email);
			$modelOption->saveOption('listSubscribe', $listSubscribe['Option']['value']);
		}
	}
	
	function getContentEmailOrderSuccess($listOrder,$data)
	{
		global $typePay;
		
		$content= 'Xin chào '.$_SESSION['infoUser']['User']['name'].' !<br/>
								Bạn đã đặt hàng thành công. Dưới đây là thông tin đơn hàng của bạn<br/><br/>
								<table width="100%" border="1">
									<thead>
										<tr>
											<th>DỊCH VỤ</th>
											<th>PHÍ KHỞI TẠO</th>
											<th>PHÍ DUY TRÌ/NĂM</th>
											<th>VAT</th>
											<th>THỜI GIAN</th>
											<th>MÔ TẢ</th>
										</tr>
									</thead>
									<tbody>';
		$total= 0;
		$number= -1;
		$saving= 0;
		foreach($listOrder as $order){
			$number++;
			if(isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!='' && isset($order['Product']['discount'])){
				$priceMainten= $order['Product']['discount'];
				$priceVat= (isset($order['Product']['discountVat']))?$order['Product']['discountVat']:$order['Product']['discount']*0.1;
				$saving= $saving+$order['Product']['priceMainten']-$order['Product']['discount'];
			}else{
				$priceMainten= $order['Product']['priceMainten'];
				$priceVat= (isset($order['Product']['priceVat']))?$order['Product']['priceVat']:$order['Product']['priceMainten']*0.1;
			}
			
			if($order['Product']['year']>1){
    			$total= $total+ $order['Product']['priceInstall']+$priceMainten+$priceVat+ ($order['Product']['priceMainten']+$order['Product']['priceVat'])*($order['Product']['year']-1);
        	}else{
        		$total= $total+ $order['Product']['priceInstall']+($priceMainten+$priceVat)*$order['Product']['year'];
        	}

        	$year= array('year0.25'=>'3 tháng',
					     'year0.5'=>'6 tháng',
					     'year1'=>'1 năm',
					     'year2'=>'2 năm',
					     'year3'=>'3 năm',
					     'year4'=>'4 năm',
					     'year5'=>'5 năm',
					     'year6'=>'6 năm',
					     'year7'=>'7 năm',
					     'year8'=>'8 năm',
					     'year9'=>'9 năm',
					     'year10'=>'10 năm',
						);

			$content .= '  <tr>
						<td>'.$order['Product']['title'].'</td>
						<td class="alignLeft">'.number_format($order['Product']['priceInstall']).'đ</td>
						<td class="alignLeft">';
						
						if($order['Product']['year']>1 && isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!='' && isset($order['Product']['discount'])){
							$content .= '- Năm đầu: '.number_format($priceMainten).'đ<br/>';
							$content .= '- Năm sau: '.number_format($order['Product']['priceMainten']).'đ';
						}else{
							$content .= number_format($priceMainten).'đ';
						}
						
			$content .= '</td><td class="alignLeft">';
									 
			 			if($order['Product']['year']>1 && isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!='' && isset($order['Product']['discount'])){
	                        $content .= '- Năm đầu: '.number_format($priceVat).'đ<br/>';
	                        $content .= '- Năm sau: '.number_format($order['Product']['priceVat']).'đ';
                        }else{
	                        $content .= number_format($priceVat).'đ';
                        }

			$content .=	'</td><td>'.$year['year'.$order['Product']['year']].'</td>
						<td class="alignLeft">'.nl2br($order['Product']['info']).'</td>
					</tr>';
		}
		
		$content .= '  <tr>
					<td colspan="4">';
					
					if(isset($_SESSION['codeGiftUser']) && $_SESSION['codeGiftUser']!=''){
						$content .= 'Mã khuyến mại được sử dụng: <input type="button" value="'.$_SESSION['codeGiftUser'].'" class="btn btn-danger">';
					}
					
		$content .=		'</td>
					<td colspan="3">
						<p><b>Tổng tiền:</b> '.number_format($total).'đ</p>';
						if($saving>0){
							$content .= '<p><b>Tiết kiệm:</b> '.number_format($saving).'đ</p>';
						}
		$content .=        '</td>
				</tr></table>
				<br/><br/>
				Phương thức thanh toán: '.$typePay[$data['pay']].' <br/><br/>
				
				<b>Thông tin người quản lý:</b><br/>
				Họ tên: '.$data['name'].'<br/>
				Email quản trị: '.$data['email'].'<br/>
				Email nhận thông báo: '.$data['notification'].'<br/>
				Điện thoại: '.$data['phone'].'<br/>
				Địa chỉ: '.$data['address'].'<br/><br/>
				
				Sau 72h nếu đơn hàng không được thanh toán sẽ tự động bị hủy. Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi. 
				';
					
		return $content;
	}

	function sendDataUrl($url,$data=null)
	{
		if($data)
		{
			$options = array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($data),
				),
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			return $result;
		}
		else
		{
			$ch = curl_init( $url );
			# Setup request to send json via POST.
			//curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded\r\n'));
			# Return response instead of printing.
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			# Send request.
			$result = curl_exec($ch);
			curl_close($ch);
			# Print response.
			return $result;

			//return file_get_contents($url);
		}
	}

	function sendData($url,$data=null)
    {
	   if($data)
	   {
			$options = array(
			    	'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => http_build_query($data),
			    ),
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			return $result;
	   }
	   else
	   {
		   return file_get_contents($url);
	   }
    }
	
?>