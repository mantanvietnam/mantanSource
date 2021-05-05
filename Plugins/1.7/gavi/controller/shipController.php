<?php
    function listShipAdmin($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách yêu cầu chuyển hàng';
        

        $dataSend = $input['request']->data;
        $modelShip= new Ship();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listShipAdmin', $_SESSION['infoStaff']['Staff']['permission']))){

                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions=array();
                //$order = array('status'=>'ASC');
                $order = array('created'=>'DESC');
                $fields= array();
                
                if(!empty($_GET['codeAgency'])){
                    $conditions['codeAgency']= strtoupper($_GET['codeAgency']);
                }

                if(!empty($_GET['codeShip'])){
                    $conditions['code']= strtoupper($_GET['codeShip']);
                }

                if(!empty($_GET['idStatus'])){
                    $conditions['status']= (int) $_GET['idStatus'];
                }
                
                $listData= $modelShip->getPage($page, $limit , $conditions, $order, $fields );

                $totalData= $modelShip->find('count',array('conditions' => $conditions));
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
                    if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
                        $urlPage= $urlPage.'&page=';
                    }else{
                        $urlPage= $urlPage.'page=';
                    }
                }else{
                    $urlPage= $urlPage.'?page=';
                }

                setVariable('listData',$listData);
                setVariable('statusShip',getStatusShip());

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
            }else{
                $modelShip->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelShip->redirect($urlHomes.'admin?status=-2');
        }
    } 

    function viewShipAdmin($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $contactSite;
        global $smtpSite;
        $metaTitleMantan= 'Thông tin yêu cầu gửi hàng';

        $modelShip= new Ship();
        $modelLog= new Log();
        $modelAgency= new Agency();
        $modelWarehouse= new Warehouse();
        $modelHistory= new History();
        $modelEmail= new Email();

        $today= getdate();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewShipAdmin', $_SESSION['infoStaff']['Staff']['permission']))){

                $mess= '';
                $data= array();
                $listStatusShip= getStatusShip();
                if(!empty($_GET['id'])){
                    $data= $modelShip->getShip($_GET['id']);
                    $checkProduct= true;
                    $agency= $modelAgency->getAgency($data['Ship']['idAgency'],array('email','fullName','product','code','phone'));
                    if(!empty($data['Ship']['product'])){
                        foreach($data['Ship']['product'] as $product){
                            if($agency['Agency']['product'][$product['id']]<$product['quantily']){
                                $checkProduct= false;
                                $mess= 'Số lượng sản phẩm '.$product['name'].' trong kho ảo của đại lý không đủ để xuất kho';
                                break;
                            }
                        }
                    }

                    if ($isRequestPost & $checkProduct) {
                        $dataSend= arrayMap($input['request']->data);
                        
                        $data['Ship']['address']['name']= $dataSend['name'];
                        $data['Ship']['address']['address']= $dataSend['address'];
                        $data['Ship']['address']['phone']= $dataSend['phone'];
                        $data['Ship']['address']['date']= $dataSend['date'];
                        $data['Ship']['note']= $dataSend['note'];
                        $data['Ship']['status']= (int) $dataSend['status'];
                        $data['Ship']['city']= (int) $dataSend['city'];
                        $data['Ship']['money']= (int) str_replace('.', '', $dataSend['money']);
                        $data['Ship']['moneyShip']= (int) str_replace('.', '', $dataSend['moneyShip']);
                        // nếu admin từ chối vận chuyển hoặc vận chuyển thành công thì tiền phạt là 0
                        if(in_array($data['Ship']['status'], array(3,5))){
                            $data['Ship']['moneyPenalties']= 0;
                        }else{
                            $data['Ship']['moneyPenalties']= (int) str_replace('.', '', $dataSend['moneyPenalties']);
                        }

                        if($modelShip->save($data)){
                            $mess= 'Lưu dữ liệu thành công';

                            
                            if(!empty($agency['Agency']['email'])){
                                $from=array($contactSite['Option']['value']['email']);
                                $to=array($agency['Agency']['email']);
                                $cc=array();
                                $bcc=array();
                                $subject='['.$smtpSite['Option']['value']['show'].'] Thông báo trạng thái yêu cầu chuyển hàng';
                                $content= ' <p>Xin chào '.$agency['Agency']['fullName'].' !</p>

                                            <p>Yêu cầu chuyển hàng số <b>'.$data['Ship']['code'].'</b> của bạn đã được chuyển sang trạng thái: '.$listStatusShip[$dataSend['status']]['name'].'</p>
                                            ';

                                $modelAgency->sendMail($from,$to,$cc,$bcc,$subject,$content);
                            }

                            // Gửi thông báo vào hộp thư
                            $saveEmail['Email']['subject']= 'Thông báo trạng thái yêu cầu chuyển hàng '.$data['Ship']['code'];
                            $saveEmail['Email']['content']= 'Yêu cầu chuyển hàng số <b>'.$data['Ship']['code'].'</b> của bạn đã được chuyển sang trạng thái: '.$listStatusShip[$dataSend['status']]['name'];
                            $saveEmail['Email']['time']= time();
                            $saveEmail['Email']['timeUpdate']= time();
                            $saveEmail['Email']['type']= 'system';
                            $saveEmail['Email']['codeAgency']= $agency['Agency']['code'];
                            $saveEmail['Email']['idAgency']= $agency['Agency']['id'];
                            $saveEmail['Email']['phoneAgency']= $agency['Agency']['phone'];
                            $saveEmail['Email']['nameFrom']= 'Hệ thống';
                            $saveEmail['Email']['listView']= array();
                            $modelEmail->save($saveEmail);

                            // nếu xử lý thành công
                            if($data['Ship']['status']==5){
                                // cộng tiền trong ví ảo
                                $saveAgency['$inc']['wallet.waitingShip']= $data['Ship']['money']; // tiền nhờ thu hộ
                                $saveAgency['$inc']['wallet.ship']= $data['Ship']['moneyShip']; // tiền phí vận chuyển
                                // trừ số lượng sản phẩm trong tài khoản người dùng
                                if(!empty($data['Ship']['product'])){
                                    foreach($data['Ship']['product'] as $product){
                                        $saveAgency['$inc']['product.'.$product['id']]= 0-$product['quantily'];

                                        // trừ số lượng sản phẩm trong kho ảo của người dùng
                                        $conditionsWarehous= array('idAgency'=>$data['Ship']['idAgency'], 'product.'.$product['id'].'quantily'=>array('$gte'=>0));
                                        $listWarehousAgency= $modelWarehouse->find('all', array('conditions'=>$conditionsWarehous) );

                                        if($listWarehousAgency){
                                            foreach($listWarehousAgency as $warehousAgency){
                                                $saveWarehouse= array();
                                                if($warehousAgency['Warehouse']['product'][$product['id']]['quantily']>=$product['quantily']){
                                                    $saveWarehouse['$inc']['product.'.$product['id'].'quantily']= 0-$product['quantily'];
                                                    $dkWarehouse= array('_id'=> new MongoId($warehousAgency['Warehouse']['id']));
                                                    $modelWarehouse->create();
                                                    $modelWarehouse->updateAll($saveWarehouse,$dkWarehouse);
                                                    break;
                                                }else{
                                                    $product['quantily'] -= $warehousAgency['Warehouse']['product'][$product['id']]['quantily'];
                                                    $saveWarehouse['$set']['product.'.$product['id'].'quantily']= 0;
                                                    $dkWarehouse= array('_id'=> new MongoId($warehousAgency['Warehouse']['id']));
                                                    $modelWarehouse->create();
                                                    $modelWarehouse->updateAll($saveWarehouse,$dkWarehouse);
                                                }
                                            }
                                        }
                                    }
                                }
                                $conditionsAgency= array('_id'=>new MongoId($data['Ship']['idAgency']));
                                $modelAgency->updateAll($saveAgency,$conditionsAgency);

                                // Lưu lịch sử giao dịch
                                $saveHistory['History']['mess']= 'Hệ thống cộng '.number_format($data['Ship']['money']).'đ tiền thu hộ vào tài khoản chờ xử lý của bạn sau khi vận chuyển thành công yêu cầu '.$data['Ship']['code'];
                                $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                $saveHistory['History']['time']['time']= time();
                                $saveHistory['History']['price']= $data['Ship']['money'];
                                $saveHistory['History']['idAgency']= $data['Ship']['idAgency'];
                                $saveHistory['History']['codeAgency']= $data['Ship']['codeAgency'];
                                $saveHistory['History']['typeExchange']= 10; // mua hàng
                                $modelHistory->create();
                                $modelHistory->save($saveHistory);

                                $saveHistory['History']['mess']= 'Hệ thống trừ '.number_format($data['Ship']['moneyShip']).'đ tiền phí vận chuyển từ tài khoản khả dụng của bạn sau khi vận chuyển thành công yêu cầu '.$data['Ship']['code'];
                                $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                $saveHistory['History']['time']['time']= time();
                                $saveHistory['History']['price']= $data['Ship']['moneyShip'];
                                $saveHistory['History']['idAgency']= $data['Ship']['idAgency'];
                                $saveHistory['History']['codeAgency']= $data['Ship']['codeAgency'];
                                $saveHistory['History']['typeExchange']= 10; // mua hàng
                                $modelHistory->create();
                                $modelHistory->save($saveHistory);

                            }elseif($data['Ship']['status']==4){
                                // cộng tiền phạt và tiền ship trong ví ảo để chờ xử lý
                                $saveAgency['$inc']['wallet.penalties']= $data['Ship']['moneyPenalties'];
                                $saveAgency['$inc']['wallet.ship']= $data['Ship']['moneyShip'];
                                $saveAgency['$inc']['walletStatic.penalties.'.$today['year'].'.'.$today['mon'] ]= $data['Ship']['moneyPenalties'];

                                $conditionsAgency= array('_id'=>new MongoId($data['Ship']['idAgency']));
                                $modelAgency->updateAll($saveAgency,$conditionsAgency);

                                // Lưu lịch sử giao dịch
                                $saveHistory['History']['mess']= 'Hệ thống trừ '.number_format($data['Ship']['moneyPenalties']).'đ tiền phạt do hàng bị trả lại từ tài khoản khả dụng của bạn sau khi yêu cầu '.$data['Ship']['code'].' bị trả lại hàng';
                                $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                $saveHistory['History']['time']['time']= time();
                                $saveHistory['History']['price']= $data['Ship']['moneyPenalties'];
                                $saveHistory['History']['idAgency']= $data['Ship']['idAgency'];
                                $saveHistory['History']['codeAgency']= $data['Ship']['codeAgency'];
                                $saveHistory['History']['typeExchange']= 2; // mua hàng
                                $modelHistory->create();
                                $modelHistory->save($saveHistory);

                                $saveHistory['History']['mess']= 'Hệ thống trừ '.number_format($data['Ship']['moneyShip']).'đ tiền phí vận chuyển từ tài khoản khả dụng của bạn sau khi vận chuyển theo yêu cầu '.$data['Ship']['code'];
                                $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                $saveHistory['History']['time']['time']= time();
                                $saveHistory['History']['price']= $data['Ship']['moneyShip'];
                                $saveHistory['History']['idAgency']= $data['Ship']['idAgency'];
                                $saveHistory['History']['codeAgency']= $data['Ship']['codeAgency'];
                                $saveHistory['History']['typeExchange']= 10; // mua hàng
                                $modelHistory->create();
                                $modelHistory->save($saveHistory);
                            }
                        }else{
                            $mess= 'Lưu dữ liệu thất bại';
                        }
                    }   
                    setVariable('mess',$mess);
                    setVariable('data',$data);
                    setVariable('listStatusShip',$listStatusShip);
                    setVariable('checkProduct',$checkProduct);
                }else{
                    $modelOption->redirect($urlHomes.'listShipAdmin');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }
    //--------------------------------------------------------------------------------
    function listShip($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;

        if(!empty($_SESSION['infoAgency'])){
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array('idAgency'=>$_SESSION['infoAgency']['Agency']['id']);
            $order = array('created'=>'DESC');
            $fields= array();
            $modelShip= new Ship();
            $mess= '';

            if(!empty($_GET['idStatus'])){
                $conditions['status']= (int) $_GET['idStatus'];
            }

            if(!empty($_GET['code'])){
                $conditions['code']= strtoupper($_GET['code']);
            }

            if(!empty($_GET['city'])){
                $conditions['city']= $_GET['city'];
            }

            if(!empty($_GET['phone'])){
                $conditions['address.phone']= $_GET['phone'];
            }
            
            if(!empty($_GET['dateStart'])){
                $dateStart= explode('/', $_GET['dateStart']);
                $date= mktime(0,0,0,$dateStart[1],$dateStart[0],$dateStart[2]);
                $conditions['dateCreate.time']['$gte']= $date;
            }

            if(!empty($_GET['dateEnd'])){
                $dateEnd= explode('/', $_GET['dateEnd']);
                $date= mktime(23,59,59,$dateEnd[1],$dateEnd[0],$dateEnd[2]);
                $conditions['dateCreate.time']['$lte']= $date;
            }
        
            $listData= $modelShip->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelShip->find('count',array('conditions' => $conditions));
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
                if(count($_GET)>1 ||  (count($_GET)==1 && !isset($_GET['page']))){
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
            setVariable('mess',$mess);

            setVariable('statusShip',getStatusShip());
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

	function addShip($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $contactSite;
        global $smtpSite;
        global $productPenalties;

        if(!empty($_SESSION['infoAgency'])){
            $modelProduct= new Product();
            $modelAgency= new Agency();
            $modelShip= new Ship();

            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id'],array('product','wallet','code'));
            $listProduct= array();
            if(!empty($agency['Agency']['product'])){
            	foreach($agency['Agency']['product'] as $key=>$quantily){
            		$product= $modelProduct->getProduct($key, array('name','productContainer','priceShipContainer','freeShipContainer'));

            		if($product && $quantily>0){
            			$product['Product']['quantity']= $quantily;
            			$listProduct[]= $product;
            		}
            	}
            }
           
            $mess= '';
            if(!empty($_GET['status'])){
                if($_GET['status']=='emptyQuantity'){
                    $mess= 'Bạn không được để trống số lượng hàng hóa cần chuyển';
                }
            }

            if($isRequestPost){
            	$dataSend = $input['request']->data;
                if(!empty($dataSend['date'])){
                    $date= explode('/', $dataSend['date']);
                    $timedate= mktime(23,59,59,$date[1],$date[0],$date[2]);
                }else{
                    $timedate= '';
                }

                if(empty($timedate) || $timedate>time()){

                	$save['Ship']['codeAgency']= $agency['Agency']['code'];
                	$save['Ship']['idAgency']= $agency['Agency']['id'];
                    $save['Ship']['address']['name']= $dataSend['name'];
                    $save['Ship']['address']['address']= $dataSend['address'];
                    $save['Ship']['address']['phone']= $dataSend['phone'];
                    $save['Ship']['address']['date']= $dataSend['date'];
                    $save['Ship']['note']= $dataSend['note'];
                    $save['Ship']['city']= $dataSend['city'];
                    $save['Ship']['money']= (int) str_replace('.', '', $dataSend['money']);
                    $save['Ship']['moneyShip']= (int) str_replace('.', '', $dataSend['priceShip']); // phí vận chuyển 
                    $save['Ship']['moneyPenalties']= (int)$dataSend['numberContainer']*$productPenalties; // phí phạt trả hàng
                    $save['Ship']['status']= 1; // yêu cầu mới
                    $save['Ship']['product']= array();
                    $save['Ship']['dateCreate']['time']= time(); 
                    $save['Ship']['dateCreate']['text']= date('H:i:s d/m/Y',$save['Ship']['dateCreate']['time']); 

                    $checkQuantity= false;
                    if(!empty($dataSend['quantity'])){
                        foreach($dataSend['quantity'] as $key=>$value){
                            if($value>0){
                                $checkQuantity= true;
                                $checkProduct= $modelProduct->getProduct($key,array('name'));
                                $save['Ship']['product'][]= array(  'name'=>$checkProduct['Product']['name'],
                                                                    'id'=>$checkProduct['Product']['id'],
                                                                    'quantily'=>(int) $value
                                                                );
                            }
                        }
                    }

                    if(!$checkQuantity) $modelOption->redirect($urlHomes.'addShip?status=emptyQuantity');

                    $code= $modelOption->getOption('codeShipGavi');
                    $code['Option']['value']['count']= (isset($code['Option']['value']['count']))?$code['Option']['value']['count']+1:1;
                    $save['Ship']['code']= 'CH'.$code['Option']['value']['count'];
                    $modelOption->saveOption('codeShipGavi',$code['Option']['value']);

                    if($modelShip->save($save)){
                    	$mess= 'Tạo yêu cầu chuyển hàng thành công, mã yêu cầu '.$save['Ship']['code'];

                        $from=array($contactSite['Option']['value']['email']);
                        $to=array($contactSite['Option']['value']['email']);
                        $cc=array();
                        $bcc=array();
                        $subject='['.$smtpSite['Option']['value']['show'].'] Thông báo có yêu cầu chuyển hàng';
                        $content= '<p>Yêu cầu chuyển hàng số <b>'.$save['Ship']['code'].'</b> của đại lý '.$save['Ship']['codeAgency'].' đã được tạo thành công</p>';

                        $modelAgency->sendMail($from,$to,$cc,$bcc,$subject,$content);
                    }else{
                    	$mess= 'Tạo yêu cầu thất bại';
                    }
                }else{
                    $mess= 'Không được nhập ngày giao hàng trong quá khứ';
                }
            }

            $_SESSION['infoAgency']['Agency']['wallet']= $agency['Agency']['wallet'];
            $_SESSION['infoAgency']['Agency']['product']= @$agency['Agency']['product'];

            setVariable('listProduct',$listProduct);
            setVariable('agency',$agency);
            setVariable('mess',$mess);
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function viewShipAgency($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $contactSite;
        global $smtpSite;
        global $productPenalties;

        $modelShip= new Ship();
        $modelLog= new Log();
        $modelAgency= new Agency();
        $modelWarehouse= new Warehouse();
        $modelHistory= new History();
        $modelEmail= new Email();

        $today= getdate();

        if(!empty($_SESSION['infoAgency'])){
            $mess= '';
            $data= array();
            $listStatusShip= getStatusShip();
            if(!empty($_GET['id'])){
                $data= $modelShip->getShip($_GET['id']);

                setVariable('data',$data);
                setVariable('listStatusShip',$listStatusShip);
            }else{
                $modelOption->redirect($urlHomes.'listShipAdmin');
            }
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function deleteShipAgency($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;
        global $contactSite;
        global $smtpSite;

        if(!empty($_SESSION['infoAgency'])){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelShip= new Ship();
            $modelLog= new Log();
            $modelAgency= new Agency();
            $modelHistory= new History();
            $modelEmail= new Email();

            if(!empty($_GET['id'])){
                $ship= $modelShip->getShip($_GET['id']);
                if($ship){
                    $save['$set']['status']= 3;
                    $save['$set']['moneyPenalties']= 0;

                    $dk= array('_id'=> new MongoId($_GET['id']));
                    if($modelShip->updateAll($save,$dk)){

                        // Gửi email thông báo cho admin
                        $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                        $to = array($contactSite['Option']['value']['email']);
                        $cc = array();
                        $bcc = array();
                        $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo đại lý hủy yêu cầu chuyển hàng';

                        $content= 'Đại lý '.$_SESSION['infoAgency']['Agency']['code'].' đã hủy yêu cầu chuyển hàng '.$ship['Ship']['code'];

                        $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);

                        // Gửi thông báo vào hộp thư
                        $saveEmail['Email']['subject']= 'Thông báo đại lý hủy yêu cầu chuyển hàng, mã yêu cầu '.$ship['Ship']['code'];
                        $saveEmail['Email']['content']= 'Đại lý '.$_SESSION['infoAgency']['Agency']['code'].' đã hủy yêu cầu chuyển hàng '.$ship['Ship']['code'];
                        $saveEmail['Email']['time']= time();
                        $saveEmail['Email']['timeUpdate']= time();
                        $saveEmail['Email']['type']= 'system';
                        $saveEmail['Email']['codeAgency']= '';
                        $saveEmail['Email']['idAgency']= '';
                        $saveEmail['Email']['phoneAgency']= '';
                        $saveEmail['Email']['nameFrom']= 'Hệ thống';
                        $saveEmail['Email']['listView']= array();
                        $modelEmail->create();
                        $modelEmail->save($saveEmail);

                        $modelOption->redirect($urlHomes.'listShip?status=deleteShipAgencyDone');
                    }else{
                        $modelOption->redirect($urlHomes.'listShip?status=deleteShipAgencyFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listShip?status=deleteShipAgencyFail');
                }
            }else{
                $modelOption->redirect($urlHomes.'listShip');
            }
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }
?>