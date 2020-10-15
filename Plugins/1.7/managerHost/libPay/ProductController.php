<?php 
    public function buyAction(){
		$conf['paypal']['url']                  = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $conf['paypal']['apiUsername'] 			= 'web_1341385779_biz_api1.gmail.com';
        $conf['paypal']['apiPassword'] 			= '1341385817';
        $conf['paypal']['apiSignature'] 		= 'Az6ayG.K.3HuHCueR9S.kvqpnCHfAe16U-lSdIR-GtxMjqcwR.YvI8jI';
        $conf['paypal']['apiEndpoint'] 			= 'https://api-3t.sandbox.paypal.com/nvp';
        $paypal_order_temp = '';
        $myOrder = new Admin_Model_Order();
        $myOrder->create();
        $paypal_order_temp = $myOrder->invoiceId;
		$price1 = round($price/20000,2);
    	if($this->_request->isPost()){
    		if($this->_request->getParam('thanhtoan')==1){
                $checker = new Admin_Model_PaypalExpressCheckout($conf['paypal']['apiUsername'], $conf['paypal']['apiPassword'], $conf['paypal']['apiSignature'], $conf['paypal']['apiEndpoint']);
                $checker->invoiceNum 		= $myOrder->invoiceId;
                $checker->priceTotalItem 	= $price1;
                $checker->priceShipping 	= 0;
                $checker->priceTax 			= 0;
                $checker->priceTotalAmount 	= $price1;
                $checker->ipaddress 		= $_SERVER['REMOTE_ADDR'];
                $checker->logoUrl			= 'http://internship.edu.vn/ds.jpg';
                $checker->returnUrl			= 'http://internship.edu.vn/trainingstore/product/buy?return=1';
                $checker->cancelUrl			= 'http://internship.edu.vn/trainingstore/product/buy';
                for($i=0; $i < 1; $i++)
                {
                     $nvpStrItems = '&L_NAME'.$i.'='.($_SESSION['orderid']).'&L_NUMBER'.$i.'='.($i+1).'&L_DESC'.$i.'='.urlencode($user['company']).'&L_AMT'.$i.'='.urlencode($price1).'&L_QTY'.$i.'=1';
                }
                $httpParsedResponseAr = '';
                $checker->nvpStrItems = $nvpStrItems;   
    			if($checker ->setexpress())
                {
                    $paypalUrl = $conf['paypal']['url'] . '?cmd=_express-checkout&token=' . urldecode($checker->httpResponseArray['TOKEN']) . '&useraction=commit';
                    $this->_redirect($paypalUrl);
                }
                else
                {
                     exit('SetExpressCheckout failed: ' . print_r($httpParsedResponseAr, true));
                     $this->_redirect($checker->cancelUrl);
                }
    		}
    		if($this->_request->getParam('thanhtoan')==2){
    			$receiver='congtruqn@gmail.com';

                //Khai báo url trả về 
                $return_url='http://internship.edu.vn/trainingttore/product/buy';

                //Giá của cả giỏ hàng 
                $price2=$price;

                //Mã giỏ hàng 
                $order_code='Hãy lập trình mã giỏ hàng của bạn vào đây';

                //Thông tin giao dịch
                $transaction_info='Hãy lập trình thông tin giao dịch của bạn vào đây';

                //Khai báo đối tượng của lớp NL_Checkout
                $nl=new Admin_Model_NganLuong();

                //Tạo link thanh toán đến nganluong.vn
                $url=$nl->buildCheckoutUrl($return_url, $receiver, $transaction_info,  $order_code, $price2);
                $this->_redirect($url);
    		}
    		else{
    			$username='';
    			$auth = Zend_Auth::getInstance ();
                 if($auth->hasIdentity()){
                 	 $username = $_SESSION['Zend_Auth']['storage']->username;
                 }
                 if($username == null || $username == '') $username = $_SESSION['usernameid'];
              	 $orderid = $_SESSION['orderid'];
                 $date = date('d').'/'.date('m').'/'.date('Y');
                 $insert = new Admin_Model_User();
                 $insert->InsertOrder($orderid, $username, $price, $date,0);
                 foreach ($_SESSION['idproduct'] as $value){
                 	$productid=$value['id'];
                 	$productprice = $model->getProductInfo($productid);
                 	$productprice1=$productprice['price'];
                 	$insert->insert_user_to_order($username, $productid, $orderid,$productprice1,0);
                 }
    		}
    	}
    	if(isset($_GET['return'])){
                    if($_GET['return'] == 1){
                        $checker = new Admin_Model_PaypalExpressCheckout($conf['paypal']['apiUsername'], $conf['paypal']['apiPassword'], $conf['paypal']['apiSignature'], $conf['paypal']['apiEndpoint']);
                                    $checker->invoiceNum 		= $paypal_order_temp;
                                    $checker->priceTotalItem 	= $price1;
                                    $checker->priceShipping 	= 0;
                                    $checker->priceTax 			= 0;
                                    $checker->priceTotalAmount 	= $price1;
                                    $checker->ipaddress 		= $_SERVER['REMOTE_ADDR'];
                                    for($i=0; $i < 1; $i++)
                                    {
                                             $nvpStrItems = '&L_NAME'.$i.'='.($_SESSION['orderid']).'&L_NUMBER'.$i.'='.($i+1).'&L_DESC'.$i.'='.urlencode($user['company']).'&L_AMT'.$i.'='.urlencode($price1).'&L_QTY'.$i.'=1';
                                    }
                        $checker->nvpStrItems = $nvpStrItems;  
                        $checker -> payerId = $_GET['PayerID'];
                        $checker -> token = $_GET['token'];
                        $validate = $checker ->checkout();
                    }
                    if($validate){
                       $user = $_SESSION['Zend_Auth']['storage']->id;
                       if($user == null || $user == '') $user = $_SESSION['usernameid'];
              		   $orderid = $_SESSION['orderid'];
                       $date = date('d').'/'.date('m').'/'.date('Y');
                       $insert = new Admin_Model_User();
                       $this->view->temp = $validate;
                    }
    	}
    }
   