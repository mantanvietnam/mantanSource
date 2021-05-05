<?php
    function listOrderAdmin($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách đơn hàng';
        

        $dataSend = $input['request']->data;
        $modelOrder= new Order();
        $modelAgency= new Agency();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listOrderAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
                

                if(!empty($_GET['status'])){
                    switch ($_GET['status']) {
                        case 'activeOrderAdminFailByImport':$mess='Duyệt đơn thất bại do hàng trong kho không đủ để bán cho đại lý';break;
                        case 'activeOrderAdminDone':$mess='Duyệt đơn thành công';break;
                        case 'activeOrderAdminFail':$mess='Duyệt đơn thất bại';break;
                    }
                }

                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions=array('toAgency'=>'');
                //$order = array('status'=>'ASC');
                $order = array('created'=>'DESC');
                $fields= array();
                $statusOrder= getStatusOrder();
                
                if(!empty($_GET['codeAgency'])){
                    $conditions['codeAgency']= strtoupper($_GET['codeAgency']);
                }

                if(!empty($_GET['codeOrder'])){
                    $conditions['code']= strtoupper($_GET['codeOrder']);
                }

                if(!empty($_GET['idStatus'])){
                    $conditions['status']= (int) $_GET['idStatus'];
                }
                
                if(!empty($_GET['excel'])){
                    $table = array(
                                    array('label' => __('Ngày tạo'), 'width' => 25),
                                    array('label' => __('Mã đơn'), 'width' => 10),
                                    array('label' => __('Đại lý'), 'width' => 40),
                                    array('label' => __('Số tiền'), 'width' => 20),
                                    array('label' => __('Sản phẩm'), 'width' => 40),
                                    array('label' => __('Loại giao dịch'), 'width' => 30),
                    );
                    $listDataExcel = $modelOrder->find('all',array('conditions'=>$conditions,'order'=>$order));

                    $listAgency= array();
                    if($listDataExcel){
                        foreach($listDataExcel as $key=>$data){
                            if(empty($listAgency[$data['Order']['idAgency']])){
                                $listAgency[$data['Order']['idAgency']]= $modelAgency->getAgency($data['Order']['idAgency'],array('code','level','phone','fullName'));
                            }
                        }
                    }

                    $data= array();
                    if(!empty($listDataExcel)){
                        foreach ($listDataExcel as $key => $value) {
                            $listProductShow= '';
                            if(!empty($value['Order']['product'])){
                                foreach($value['Order']['product'] as $product){
                                    $listProductShow .= $product['name'].' : '.number_format($product['price']).'đ : '.$product['quantily'].' ';
                                }
                            }
                            $data[]= array( 
                                $value['Order']['dateCreate']['text'],
                                $value['Order']['code'],
                                'C'.$listAgency[$value['Order']['idAgency']]['Agency']['level'].'.'.$listAgency[$value['Order']['idAgency']]['Agency']['fullName'].' - '.$listAgency[$value['Order']['idAgency']]['Agency']['phone'].' ('.$listAgency[$value['Order']['idAgency']]['Agency']['code'].')',
                                number_format($value['Order']['price']),
                                $listProductShow,
                                $statusOrder[$value['Order']['status']]['name']
                            );
                        }
                    }
                    $exportsController = new ExportsController();
                    $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data,'Danh-sach-don-hang')));
                }

                $listData= $modelOrder->getPage($page, $limit , $conditions, $order, $fields );

                $listAgency= array();
                if($listData){
                    foreach($listData as $key=>$data){
                        if(empty($listAgency[$data['Order']['idAgency']])){
                            $listAgency[$data['Order']['idAgency']]= $modelAgency->getAgency($data['Order']['idAgency'],array('code','level','phone','fullName'));
                        }
                    }
                }

                $totalData= $modelOrder->find('count',array('conditions' => $conditions));
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
                setVariable('listAgency',$listAgency);
                setVariable('statusOrder',$statusOrder);

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
                setVariable('listWarehous',$modelOption->getOption('listWarehouseGavi'));
            }else{
                $modelOrder->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOrder->redirect($urlHomes.'admin?status=-2');
        }
    } 

    function cancelOrderAdmin($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        global $contactSite;
        global $smtpSite;
        $metaTitleMantan= 'Admin từ chối đơn hàng';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) && in_array('cancelOrderAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelOrder= new Order();
                $modelLog= new Log();
                $modelAgency= new Agency();
                $modelHistory= new History();
                $modelEmail= new Email();

                if(!empty($_GET['id'])){
                    $order= $modelOrder->getOrder($_GET['id']);
                    if($order && $order['Order']['status']==1){
                        $save['$set']['status']= 3;
                        $save['$set']['note']= $_GET['note'];
                        $dk= array('_id'=> new MongoId($_GET['id']));
                        if($modelOrder->updateAll($save,$dk)){
                            $saveLog['Log']['time']= time();
                            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' từ chối đơn hàng có ID là '.$_GET['id'];
                            $modelLog->save($saveLog); // lưu lịch sử từ chối đơn hàng

                            $saveAgency['$inc']['wallet.purchaseFund']= $order['Order']['price'];
                            $saveAgency['$inc']['wallet.order']= 0-$order['Order']['price'];
                            $conditionsAgency= array('_id'=>new MongoId($order['Order']['idAgency']));
                            $modelAgency->updateAll($saveAgency,$conditionsAgency); // cập nhập số dư tài khoản

                            // Lưu lịch sử giao dịch
                            $saveHistory['History']['mess']= 'Hệ thống hoàn lại '.number_format($order['Order']['price']).'đ tiền hàng từ tài khoản tiền hàng chờ xử lý sang tài khoản chính do đơn hàng '.$order['Order']['code'].' của bạn bị từ chối';
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $order['Order']['price'];
                            $saveHistory['History']['idAgency']= $order['Order']['idAgency'];
                            $saveHistory['History']['codeAgency']= $order['Order']['codeAgency'];
                            $saveHistory['History']['typeExchange']= 9; // hoàn tiền
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);

                            // Gửi email thông báo cho đại lý
                            $agency= $modelAgency->getAgency($order['Order']['idAgency']);
                            if(!empty($agency['Agency']['email'])){
                                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                                $to = array($agency['Agency']['email']);
                                $cc = array();
                                $bcc = array();
                                $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo từ chối đơn hàng';


                                $content = 'Xin chào '.$agency['Agency']['fullName'].'<br/>';
                                $content.= 'Đơn hàng '.$order['Order']['code'].' của bạn đã bị từ chối, vui lòng liên hệ Gavi để biết thông tin chi tiết';

                                $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);
                            }

                            // Gửi thông báo vào hộp thư
                            $saveEmail['Email']['subject']= 'Thông báo từ chối đơn hàng '.$order['Order']['code'];
                            $saveEmail['Email']['content']= 'Đơn hàng '.$order['Order']['code'].' của bạn đã bị từ chối, vui lòng liên hệ Gavi để biết thông tin chi tiết';
                            $saveEmail['Email']['time']= time();
                            $saveEmail['Email']['timeUpdate']= time();
                            $saveEmail['Email']['type']= 'system';
                            $saveEmail['Email']['codeAgency']= $agency['Agency']['code'];
                            $saveEmail['Email']['idAgency']= $agency['Agency']['id'];
                            $saveEmail['Email']['phoneAgency']= $agency['Agency']['phone'];
                            $saveEmail['Email']['nameFrom']= 'Hệ thống';
                            $saveEmail['Email']['listView']= array();
                            $modelEmail->save($saveEmail);

                            $modelOption->redirect($urlHomes.'listOrderAdmin?status=cancelOrderAdminDone');
                        }else{
                            $modelOption->redirect($urlHomes.'listOrderAdmin?status=cancelOrderAdminFail');
                        }
                    }else{
                        $modelOption->redirect($urlHomes.'listOrderAdmin?status=cancelOrderAdminFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listOrderAdmin');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function printOrderAdmin($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        global $contactSite;
        global $smtpSite;
        $metaTitleMantan= 'Admin in đơn hàng';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) && in_array('printOrderAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelOrder= new Order();
                $modelLog= new Log();
                $modelAgency= new Agency();
                $modelHistory= new History();
                $modelEmail= new Email();

                if(!empty($_GET['id'])){
                    $order= $modelOrder->getOrder($_GET['id']);
                    if($order){
                    	$agency= $modelAgency->getAgency($order['Order']['idAgency'],array('code','level','phone','fullName'));

                        setVariable('order',$order);
                        setVariable('agency',$agency);
                    }else{
                        $modelOption->redirect($urlHomes.'listOrderAdmin');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listOrderAdmin');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function activeOrderAdmin($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        global $contactSite;
        global $smtpSite;
        global $productBonus;
        $metaTitleMantan= 'Admin duyệt đơn hàng';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) && in_array('activeOrderAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelOrder= new Order();
                $modelLog= new Log();
                $modelAgency= new Agency();
                $modelWarehouse= new Warehouse();
                $modelHistory= new History();
                $modelEmail= new Email();
                $modelImport= new Import();
                $today= getdate();

                if(!empty($dataSend['idOrder'])){
                    $order= $modelOrder->getOrder($dataSend['idOrder']);
                    if($order && $order['Order']['status']==1){
                        $checkImport= true;
                        if(!empty($order['Order']['product'])){
                            foreach($order['Order']['product'] as $product){
                                $listImport[$product['id']]= $modelImport->getListImportByProduct($product['id'],$dataSend['idWarehous']);
                                $countImport= 0;
                                if(!empty($listImport[$product['id']])){
                                    foreach($listImport[$product['id']] as $import){
                                        $countImport += $import['Import']['quantityNow'];
                                    }
                                }
                                if($countImport<$product['quantily']){
                                    $checkImport= false;
                                    break;
                                }
                            }
                        }
                    
                        if($checkImport){
                            $save['$set']['status']= 2;
                            $dk= array('_id'=> new MongoId($dataSend['idOrder']));
                            if($modelOrder->updateAll($save,$dk)){
                                // lưu lịch sử duyệt đơn hàng
                                $saveLog['Log']['time']= time();
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' đã duyệt đơn hàng có ID là '.$dataSend['idOrder'];
                                $modelLog->save($saveLog); 

                                // Gửi email thông báo cho đại lý
                                $agency= $modelAgency->getAgency($order['Order']['idAgency']);
                                if(!empty($agency['Agency']['email'])){
                                    $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                                    $to = array($agency['Agency']['email']);
                                    $cc = array();
                                    $bcc = array();
                                    $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo duyệt đơn hàng';


                                    $content = 'Xin chào '.$agency['Agency']['fullName'].'<br/>';
                                    $content.= 'Đơn hàng '.$order['Order']['code'].' của bạn đã được duyệt, vui lòng liên hệ Gavi để biết thông tin chi tiết';

                                    $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);
                                }

                                // Gửi thông báo vào hộp thư
                                $saveEmail['Email']['subject']= 'Thông báo duyệt đơn hàng '.$order['Order']['code'];
                                $saveEmail['Email']['content']= 'Đơn hàng '.$order['Order']['code'].' của bạn đã được duyệt, vui lòng liên hệ Gavi để biết thông tin chi tiết';
                                $saveEmail['Email']['time']= time();
                                $saveEmail['Email']['timeUpdate']= time();
                                $saveEmail['Email']['type']= 'system';
                                $saveEmail['Email']['codeAgency']= $agency['Agency']['code'];
                                $saveEmail['Email']['idAgency']= $agency['Agency']['id'];
                                $saveEmail['Email']['phoneAgency']= $agency['Agency']['phone'];
                                $saveEmail['Email']['nameFrom']= 'Hệ thống';
                                $saveEmail['Email']['listView']= array();
                                $modelEmail->save($saveEmail);

                                // cộng hàng vào kho ảo của đại lý
                                $saveWarehouse= $modelWarehouse->getWarehouseByAgency($agency['Agency']['id'],$dataSend['idWarehous']);
                                $saveWarehouse['Warehouse']['idAgency']= $agency['Agency']['id'];
                                $saveWarehouse['Warehouse']['codeAgency']= $agency['Agency']['code'];
                                $saveWarehouse['Warehouse']['idWarehous']= $dataSend['idWarehous'];

                                $totalProduct= 0;
                                $totalProductBonus= 0;
                                if(!empty($order['Order']['product'])){
                                    foreach($order['Order']['product'] as $product){
                                        // trừ số lượng hàng trong kho thật của cty
                                        if(!empty($listImport[$product['id']])){
                                            $quantilyProduct= $product['quantily'];
                                            foreach($listImport[$product['id']] as $import){
                                                if($quantilyProduct>0){
                                                    if($import['Import']['quantityNow']>=$quantilyProduct){
                                                        $import['Import']['quantityNow'] -= $quantilyProduct;
                                                        $quantilyProduct= 0;
                                                    }else{
                                                        $quantilyProduct -= $import['Import']['quantityNow'];
                                                        $import['Import']['quantityNow']= 0;
                                                    }

                                                    $modelImport->create();
                                                    $modelImport->save($import);
                                                }
                                            }
                                        }

                                        $totalProduct += $product['quantily'];
                                        if($product['price']>0){
                                            $totalProductBonus += $product['quantily'];
                                        }
                                        if(!isset($saveWarehouse['Warehouse']['product'][$product['id']]['quantily'])){
                                            $saveWarehouse['Warehouse']['product'][$product['id']]['quantily']= 0;
                                        }

                                        if(!isset($saveWarehouse['Warehouse']['product'][$product['id']]['price'])){
                                        	$saveWarehouse['Warehouse']['product'][$product['id']]['price']= array();
                                        }

                                        $saveWarehouse['Warehouse']['product'][$product['id']]['id']= $product['id'];
                                        $saveWarehouse['Warehouse']['product'][$product['id']]['name']= $product['name'];
                                        $saveWarehouse['Warehouse']['product'][$product['id']]['quantily'] += $product['quantily'];
                                        $saveWarehouse['Warehouse']['product'][$product['id']]['price'][] = array('quantily'=>$product['quantily'],'price'=>$product['price']);

                                        $saveAgency['$inc']['product.'.$product['id']]= $product['quantily'];
                                    }
                                }

                                $modelWarehouse->save($saveWarehouse);

                                // cập nhập số dư tài khoản và cộng hàng vào tài khoản của đại lý
                                $saveAgency['$inc']['wallet.order']= 0-$order['Order']['price'];
                                //$saveAgency['$inc']['wallet.purchaseFund']= 0-$order['Order']['price']; // trừ tiền trong quỹ mua hàng
                                $conditionsAgency= array('_id'=>new MongoId($order['Order']['idAgency']));
                                $modelAgency->updateAll($saveAgency,$conditionsAgency); 

                                // Lưu lịch sử giao dịch
                                $saveHistory['History']['mess']= 'Hệ thống trừ  '.number_format($order['Order']['price']).'đ trong tài khoản tiền hàng chờ xử lý do đơn hàng '.$order['Order']['code'].' của bạn đã được duyệt';
                                $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                $saveHistory['History']['time']['time']= time();
                                $saveHistory['History']['price']= $order['Order']['price'];
                                $saveHistory['History']['idAgency']= $order['Order']['idAgency'];
                                $saveHistory['History']['codeAgency']= $order['Order']['codeAgency'];
                                $saveHistory['History']['typeExchange']= 7; // mua hàng
                                $modelHistory->create();
                                $modelHistory->save($saveHistory);

                                // tính thưởng cho đại lý cho ngang cấp
                                if(!empty($agency['Agency']['idAgencyFather'])){
                                    $agencyFather= $modelAgency->getAgency($agency['Agency']['idAgencyFather']);
                                    if($agency['Agency']['level']==$agencyFather['Agency']['level']){
                                        $saveAgency= array();
                                        //$saveAgency['$inc']['wallet.waitingBonus']= $totalProduct*$productBonus;
                                        $saveAgency['$inc']['wallet.active']= $totalProductBonus*$productBonus;
                                        $saveAgency['$inc']['walletStatic.productBonus.'.$today['year'].'.'.$today['mon'] ]= $totalProductBonus*$productBonus;
                                        $conditionsAgency= array('_id'=>new MongoId($agencyFather['Agency']['id']));
                                        $modelAgency->create();
                                        $modelAgency->updateAll($saveAgency,$conditionsAgency); 

                                        // Lưu lịch sử giao dịch
                                        $saveHistory= array();
                                        $saveHistory['History']['mess']= 'Hệ thống cộng '.number_format($saveAgency['$inc']['wallet.active']).'đ tiền hàng vào tài khoản chờ xử lý do đại lý '.$agency['Agency']['code'].' trực thuộc bạn, có level ngang cấp với bạn, mua thành công đơn hàng '.$order['Order']['code'];
                                        $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                        $saveHistory['History']['time']['time']= time();
                                        $saveHistory['History']['price']= $saveAgency['$inc']['wallet.active'];
                                        $saveHistory['History']['idAgency']= $agencyFather['Agency']['id'];
                                        $saveHistory['History']['codeAgency']= $agencyFather['Agency']['code'];
                                        $saveHistory['History']['typeExchange']= 8; // mua hàng
                                        $modelHistory->create();
                                        $modelHistory->save($saveHistory);
                                    }
                                }

                                $modelOption->redirect($urlHomes.'listOrderAdmin?status=activeOrderAdminDone');
                            }else{
                                $modelOption->redirect($urlHomes.'listOrderAdmin?status=activeOrderAdminFail');
                            }
                        }else{
                            $modelOption->redirect($urlHomes.'listOrderAdmin?status=activeOrderAdminFailByImport');
                        }
                    }else{
                        $modelOption->redirect($urlHomes.'listOrderAdmin?status=activeOrderAdminFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listOrderAdmin');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    // ------------------------------------------------------------------------------------------------
	function listOrderBuy($input)
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
            $modelOrder= new Order();
            $mess= '';

            if(!empty($_GET['code'])){
                $conditions['code']= strtoupper($_GET['code']);
            }

            if(!empty($_GET['idStatus'])){
                $conditions['status']= (int) $_GET['idStatus'];
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
            
            $listData= $modelOrder->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelOrder->find('count',array('conditions' => $conditions));
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

            setVariable('statusOrder',getStatusOrder());
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function listOrderSell($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;

        if(!empty($_SESSION['infoAgency'])){
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array('toAgency'=>$_SESSION['infoAgency']['Agency']['id']);
            $order = array('created'=>'DESC');
            $fields= array();
            $modelOrder= new Order();
            $mess= '';
            if(!empty($_GET['status']) && $_GET['status']=='errorProduct'){
                $mess= 'Sản phẩm '.@$_GET['name'].' được duyệt bán không có trong kho của bạn! yêu cầu bạn đặt mua '.@$_GET['name'].'';
            }

            if(!empty($_GET['code'])){
                $conditions['code']= strtoupper($_GET['code']);
            }

            if(!empty($_GET['idStatus'])){
                $conditions['status']= (int) $_GET['idStatus'];
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

            if(!empty($_GET['codeAgency'])){
                $conditions['codeAgency']= strtoupper($_GET['codeAgency']);
            }

            if(!empty($_GET['phoneAgency'])){
                $conditions['phoneAgency']= $_GET['phoneAgency'];
            }
            
            $listData= $modelOrder->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelOrder->find('count',array('conditions' => $conditions));
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

            setVariable('statusOrder',getStatusOrder());
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function addOrder($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $contactSite;
        global $smtpSite;

        if(!empty($_SESSION['infoAgency'])){
            $modelProduct= new Product();
            $modelAgency= new Agency();
            $modelOrder= new Order();
            $modelHistory= new History();
            $modelEmail= new Email();

            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id'],array('wallet','code','product','idAgencyFather','codeAgencyFather','level','phone'));
            if(!empty($agency['Agency']['idAgencyFather'])){
                $agencyFather= $modelAgency->getAgency($agency['Agency']['idAgencyFather'],array('idAgencyFather','codeAgencyFather','level','code','phone'));
            }else{
                $agencyFather= array();
                $agencyFather['Agency']['level']= -1;
            }

            $listProduct= $modelProduct->find('all',array('conditions'=>array('status'=>'active')));
            $mess= '';
            $listAgency= getListAgency();
            if(!empty($_GET['status'])){
                if($_GET['status']=='emptyQuantity'){
                    $mess= 'Bạn không được để trống số lượng hàng hóa cần mua';
                }
            }

            if($isRequestPost){
            	$dataSend = $input['request']->data;
                $dataSend['price']= (int) str_replace('.', '', $dataSend['price']);
            	if($dataSend['price']<=($agency['Agency']['wallet']['purchaseFund']+$agency['Agency']['wallet']['active'])){
                    if($dataSend['price']>=$listAgency[$agency['Agency']['level']]['money_product']){
                        $checkQuantity= false;
    	            	if(!empty($listProduct)){
    	            		foreach($listProduct as $product){
    	            			if(!empty($dataSend['number'][$product['Product']['id']])){
                                    $checkQuantity= true;
    	            				$save['Order']['product'][$product['Product']['id']]= array('name'=>$product['Product']['name'],
    	            																			'id'=>$product['Product']['id'],
    	            																			'quantily'=>(int) $dataSend['number'][$product['Product']['id']],
    	            																			'price'=>$product['Product']['priceAgency'][$_SESSION['infoAgency']['Agency']['level']],
                                                                                                //'image'=>$product['Product']['image'],
    	            																			);
    	            			}
    	            		}
    	            	}

                        if(!$checkQuantity) $modelOption->redirect($urlHomes.'addOrder?status=emptyQuantity');

    	            	$save['Order']['codeAgency']= $agency['Agency']['code'];
                        $save['Order']['idAgency']= $agency['Agency']['id'];
                        $save['Order']['phoneAgency']= $agency['Agency']['phone'];

                        // tính id cha
                        $checkIdFather= getIdAgencyFatherOrder($agency['Agency']['level'],$agency['Agency']['idAgencyFather']);
                        if(!empty($checkIdFather)){
                            $checkFather= $modelAgency->getAgency($checkIdFather,array('code','phone'));
                            $save['Order']['toAgency']= $checkFather['Agency']['id'];
                            $save['Order']['toCodeAgency']= $checkFather['Agency']['code'];
                        }else{
                            $save['Order']['toAgency']= '';
                            $save['Order']['toCodeAgency']= '';
                        }

                        $save['Order']['price']= (int) $dataSend['price'];
                        $save['Order']['status']= 1; // đơn hàng mới
                        $save['Order']['note']= ''; // đơn hàng mới
                        $save['Order']['dateCreate']['time']= time(); 
    	            	$save['Order']['dateCreate']['text']= date('H:i:s d/m/Y',$save['Order']['dateCreate']['time']); 

                        $code= $modelOption->getOption('codeOrderGavi');
                        $code['Option']['value']['count']= (isset($code['Option']['value']['count']))?$code['Option']['value']['count']+1:1;
                        $save['Order']['code']= 'DH'.$code['Option']['value']['count'];
                        $modelOption->saveOption('codeOrderGavi',$code['Option']['value']);

    	            	$modelOrder->save($save); // lưu đơn hàng mới

                        if($agency['Agency']['wallet']['purchaseFund']>=$save['Order']['price']){
        	            	$saveAgency['$inc']['wallet.purchaseFund']= 0-$save['Order']['price'];
                        }else{
                            $saveAgency['$set']['wallet.purchaseFund']= 0;
                            $saveAgency['$inc']['wallet.active']= $agency['Agency']['wallet']['purchaseFund']-$save['Order']['price'];
                        }

    	            	$saveAgency['$inc']['wallet.order']= $save['Order']['price'];
    	            	$conditionsAgency= array('_id'=>new MongoId($_SESSION['infoAgency']['Agency']['id']));
    	            	$modelAgency->updateAll($saveAgency,$conditionsAgency); // cập nhập số dư tài khoản

                        // Lưu lịch sử giao dịch
                        $saveHistory['History']['mess']= 'Hệ thống chuyển  '.number_format($save['Order']['price']).'đ trong tài khoản chính sang tài khoản tiền hàng chờ xử lý trong khi đợi duyệt đơn hàng '.$save['Order']['code'];
                        $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                        $saveHistory['History']['time']['time']= time();
                        $saveHistory['History']['price']= $save['Order']['price'];
                        $saveHistory['History']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                        $saveHistory['History']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                        $saveHistory['History']['typeExchange']= 7; // mua hàng
                        $modelHistory->create();
                        $modelHistory->save($saveHistory);

    	            	$agency['Agency']['wallet']['purchaseFund'] -= $save['Order']['price'];
                        if(empty($agency['Agency']['wallet']['order'])){
                            $agency['Agency']['wallet']['order']= $save['Order']['price'];
                        }else{
        	            	$agency['Agency']['wallet']['order'] += $save['Order']['price'];
                        }

                        // Gửi email thông báo cho admin
                        $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                        $to = array($contactSite['Option']['value']['email']);
                        $cc = array();
                        $bcc = array();
                        if(!empty($order['Order']['toAgency'])){
                            $agencyFather= $modelAgency->getAgency($order['Order']['toAgency']);
                            if(!empty($agencyFather['Agency']['email'])){
                                $bcc[]= $agencyFather['Agency']['email'];
                            }
                        }

                        $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo có đơn hàng mới';

                        $content = 'Hệ thống nhận được đơn hàng '.$save['Order']['code'].' của đại lý '.$agency['Agency']['code'];

                        $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);

    	            	$mess= 'Tạo đơn hàng thành công có mã là: '.$save['Order']['code'];

                        // Gửi thông báo vào hộp thư
                        $saveEmail['Email']['subject']= 'Thông báo khởi tạo thành công đơn hàng '.$save['Order']['code'];
                        $saveEmail['Email']['content']= 'Hệ thống đã khởi tạo thành công đơn hàng của bạn, mã đơn hàng là '.$save['Order']['code'];
                        $saveEmail['Email']['time']= time();
                        $saveEmail['Email']['timeUpdate']= time();
                        $saveEmail['Email']['type']= 'system';
                        $saveEmail['Email']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                        $saveEmail['Email']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                        $saveEmail['Email']['phoneAgency']= $_SESSION['infoAgency']['Agency']['phone'];
                        $saveEmail['Email']['nameFrom']= 'Hệ thống';
                        $saveEmail['Email']['listView']= array();
                        $modelEmail->create();
                        $modelEmail->save($saveEmail);

                        if(!empty($save['Order']['toAgency'])){
                            $saveEmail['Email']['subject']= 'Thông báo có đơn hàng mới, mã đơn '.$save['Order']['code'];
                            $saveEmail['Email']['content']= 'Bạn có đơn hàng mua mới, mã đơn hàng là '.$save['Order']['code'].', mã đại lý '.$_SESSION['infoAgency']['Agency']['code'].', điện thoại '.$_SESSION['infoAgency']['Agency']['phone'].', giá trị đơn hàng là '.number_format($dataSend['price']).'đ';
                            $saveEmail['Email']['time']= time();
                            $saveEmail['Email']['timeUpdate']= time();
                            $saveEmail['Email']['type']= 'system';
                            $saveEmail['Email']['codeAgency']= @$agencyFather['Agency']['code'];
                            $saveEmail['Email']['idAgency']= @$agencyFather['Agency']['id'];
                            $saveEmail['Email']['phoneAgency']= @$agencyFather['Agency']['phone'];
                            $saveEmail['Email']['nameFrom']= 'Hệ thống';
                            $saveEmail['Email']['listView']= array();
                            $modelEmail->create();
                            $modelEmail->save($saveEmail);
                        }else{
                            $saveEmail['Email']['subject']= 'Thông báo có đơn hàng mới, mã đơn '.$save['Order']['code'];
                            $saveEmail['Email']['content']= 'Bạn có đơn hàng mua mới, mã đơn hàng là '.$save['Order']['code'].', mã đại lý '.$_SESSION['infoAgency']['Agency']['code'].', điện thoại '.$_SESSION['infoAgency']['Agency']['phone'].', giá trị đơn hàng là '.number_format($dataSend['price']).'đ';
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
                        }
                    }else{
                        $mess= 'Đơn hàng của bạn chưa đạt hạn mức tối thiểu, bạn cần mua ít nhất '.number_format($listAgency[$agency['Agency']['level']]['money_product']).'đ';
                    }
	            }else{
	            	$mess= 'Số dư tài khoản không đủ để đặt mua đơn hàng';
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

    function cancelOrderAgency($input)
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
            $modelOrder= new Order();
            $modelLog= new Log();
            $modelAgency= new Agency();
            $modelHistory= new History();
            $modelEmail= new Email();

            if(!empty($_GET['id'])){
                $order= $modelOrder->getOrder($_GET['id']);
                if($order && $order['Order']['status']==1){
                    $save['$set']['status']= 3;
                    $dk= array('_id'=> new MongoId($_GET['id']));
                    if($modelOrder->updateAll($save,$dk)){

                        $saveAgency['$inc']['wallet.purchaseFund']= $order['Order']['price'];
                        $saveAgency['$inc']['wallet.order']= 0-$order['Order']['price'];
                        $conditionsAgency= array('_id'=>new MongoId($order['Order']['idAgency']));
                        $modelAgency->updateAll($saveAgency,$conditionsAgency); // cập nhập số dư tài khoản

                        // Lưu lịch sử giao dịch
                        $saveHistory['History']['mess']= 'Hệ thống hoàn lại '.number_format($order['Order']['price']).'đ tiền hàng từ tài khoản tiền hàng chờ xử lý sang tài khoản chính do đơn hàng '.$order['Order']['code'].' của bạn bị từ chối';
                        $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                        $saveHistory['History']['time']['time']= time();
                        $saveHistory['History']['price']= $order['Order']['price'];
                        $saveHistory['History']['idAgency']= $order['Order']['idAgency'];
                        $saveHistory['History']['codeAgency']= $order['Order']['codeAgency'];
                        $saveHistory['History']['typeExchange']= 9; // hoàn tiền
                        $modelHistory->create();
                        $modelHistory->save($saveHistory);

                        // Gửi email thông báo cho admin
                        $agency= $modelAgency->getAgency($order['Order']['idAgency']);
                        $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                        $to = array($contactSite['Option']['value']['email']);
                        $cc = array();
                        $bcc = array();
                        $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo đại lý hủy đơn hàng';

                        $content= 'Đại lý '.$order['Order']['codeAgency'].' đã hủy đơn hàng '.$order['Order']['code'];

                        $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);

                        // Gửi thông báo vào hộp thư
                        $saveEmail['Email']['subject']= 'Thông báo đại lý hủy đơn hàng, mã đơn '.$order['Order']['code'];
                        $saveEmail['Email']['content']= 'Đại lý '.$order['Order']['codeAgency'].' đã hủy đơn hàng '.$order['Order']['code'];
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

                        $modelOption->redirect($urlHomes.'listOrderBuy?status=cancelOrderAgencyDone');
                    }else{
                        $modelOption->redirect($urlHomes.'listOrderBuy?status=cancelOrderAgencyFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listOrderBuy?status=cancelOrderAgencyFail');
                }
            }else{
                $modelOption->redirect($urlHomes.'listOrderBuy');
            }
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function refuseOrderAgency($input)
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
            $modelOrder= new Order();
            $modelLog= new Log();
            $modelAgency= new Agency();
            $modelHistory= new History();
            $modelEmail= new Email();

            if(!empty($_GET['id'])){
                $order= $modelOrder->getOrder($_GET['id']);
                if($order && $order['Order']['status']==1){
                    $save['$set']['status']= 3;
                    $save['$set']['note']= $_GET['note'];
                    $dk= array('_id'=> new MongoId($_GET['id']));
                    if($modelOrder->updateAll($save,$dk)){

                        $saveAgency['$inc']['wallet.purchaseFund']= $order['Order']['price'];
                        $saveAgency['$inc']['wallet.order']= 0-$order['Order']['price'];
                        $conditionsAgency= array('_id'=>new MongoId($order['Order']['idAgency']));
                        $modelAgency->updateAll($saveAgency,$conditionsAgency); // cập nhập số dư tài khoản

                        // Lưu lịch sử giao dịch
                        $saveHistory['History']['mess']= 'Hệ thống hoàn lại '.number_format($order['Order']['price']).'đ tiền hàng từ tài khoản tiền hàng chờ xử lý sang tài khoản chính do đơn hàng '.$order['Order']['code'].' của bạn bị từ chối';
                        $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                        $saveHistory['History']['time']['time']= time();
                        $saveHistory['History']['price']= $order['Order']['price'];
                        $saveHistory['History']['idAgency']= $order['Order']['idAgency'];
                        $saveHistory['History']['codeAgency']= $order['Order']['codeAgency'];
                        $saveHistory['History']['typeExchange']= 9; // hoàn tiền
                        $modelHistory->create();
                        $modelHistory->save($saveHistory);

                        // Gửi email thông báo cho admin
                        $agency= $modelAgency->getAgency($order['Order']['idAgency']);
                        $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                        $to = array($contactSite['Option']['value']['email']);
                        $cc = array();
                        $bcc = array();
                        if(!empty($agency['Agency']['email'])) $bcc[]= $agency['Agency']['email'];
                        $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo từ chối hàng đại lý cấp dưới';

                        $content= 'Đại lý '.$_SESSION['infoAgency']['Agency']['code'].' đã từ chối đơn hàng của đại lý '.$order['Order']['codeAgency'].', mã đơn hàng '.$order['Order']['code'];

                        $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);

                        // Gửi thông báo vào hộp thư
                        $saveEmail['Email']['subject']= 'Thông báo khởi tạo thành công đơn hàng '.$save['Order']['code'];
                        $saveEmail['Email']['content']= 'Hệ thống đã khởi tạo thành công đơn hàng của bạn, mã đơn hàng là '.$save['Order']['code'];
                        $saveEmail['Email']['time']= time();
                        $saveEmail['Email']['timeUpdate']= time();
                        $saveEmail['Email']['type']= 'system';
                        $saveEmail['Email']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                        $saveEmail['Email']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                        $saveEmail['Email']['phoneAgency']= $_SESSION['infoAgency']['Agency']['phone'];
                        $saveEmail['Email']['nameFrom']= 'Hệ thống';
                        $saveEmail['Email']['listView']= array();
                        $modelEmail->save($saveEmail);

                        $modelOption->redirect($urlHomes.'listOrderSell?status=refuseOrderAgencyDone');
                    }else{
                        $modelOption->redirect($urlHomes.'listOrderSell?status=refuseOrderAgencyFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listOrderSell?status=refuseOrderAgencyFail');
                }
            }else{
                $modelOption->redirect($urlHomes.'listOrderSell');
            }
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function activeOrderAgency($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;
        global $contactSite;
        global $smtpSite;
        global $productBonus;

        if(!empty($_SESSION['infoAgency'])){
            $dataSend= $input['request']->data;
            $mess= '';
            $modelOrder= new Order();
            $modelLog= new Log();
            $modelAgency= new Agency();
            $modelWarehouse= new Warehouse();
            $modelHistory= new History();
            $today= getdate();

            if(!empty($_GET['id'])){
                $order= $modelOrder->getOrder($_GET['id']);
                if($order && $order['Order']['status']==1){
                    // kiểm tra kho hàng của đại lý bán
                    $agencyTo= $modelAgency->getAgency($order['Order']['toAgency'],array('email','fullName','product','idAgencyFather','level','codeAgencyFather','code'));
                    $save['$set']['productAgency.start']= $agencyTo['Agency']['product'];
                    if(!empty($order['Order']['product'])){
                        foreach($order['Order']['product'] as $product){
                            if(empty($agencyTo['Agency']['product'][$product['id']]) || $agencyTo['Agency']['product'][$product['id']]<$product['quantily']){
                                $modelOption->redirect($urlHomes.'listOrderSell?status=errorProduct&name='.$product['name']);
                            }else{
                                $agencyTo['Agency']['product'][$product['id']] -= $product['quantily'];
                                $saveAgency['$inc']['product.'.$product['id']]= $product['quantily'];
                            }
                        }
                    }
                    $save['$set']['productAgency.end']= $agencyTo['Agency']['product'];
                    $save['$set']['status']= 2;
                    $dk= array('_id'=> new MongoId($_GET['id']));
                    if($modelOrder->updateAll($save,$dk)){
                        // Gửi email thông báo cho đại lý
                        $agency= $modelAgency->getAgency($order['Order']['idAgency']);
                        if(!empty($agency['Agency']['email'])){
                            $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                            $to = array($agency['Agency']['email'],$contactSite['Option']['value']['email']);
                            $cc = array();
                            $bcc = array();
                            $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo duyệt đơn hàng của đại lý';


                            $content = 'Xin chào '.$agency['Agency']['fullName'].'<br/>';
                            $content.= 'Đơn hàng '.$order['Order']['code'].' của bạn đã được duyệt';

                            $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);
                        }

                        // update số lượng hàng hóa của đại lý bán
                        $saveAgencyTo['$set']['product']= $agencyTo['Agency']['product'];
                        $conditionsAgencyTo= array('_id'=> new MongoId($agencyTo['Agency']['id']));
                        $modelAgency->create();
                        $modelAgency->updateAll($saveAgencyTo,$conditionsAgencyTo);

                        // trừ số lượng sản phẩm trong kho ảo của đại lý bán
                        $totalProduct= 0;
                        $totalProductBonus= 0;
                        $profit= 0;

                        if(!empty($order['Order']['product'])){
                            foreach($order['Order']['product'] as $product){
                                $totalProduct += $product['quantily'];
                                if($product['price']>0){
                                    $totalProductBonus += $product['quantily'];
                                }
                                $conditionsWarehous= array('idAgency'=>$order['Order']['toAgency'], 'product.'.$product['id'].'.quantily'=>array('$gte'=>0));
                                $listWarehousAgency= $modelWarehouse->find('all', array('conditions'=>$conditionsWarehous) );

                                if($listWarehousAgency){
                                    foreach($listWarehousAgency as $warehousAgency){
                                        $saveWarehouse= array();
                                        $saveWarehouseSell= array();

                                        if($warehousAgency['Warehouse']['product'][$product['id']]['quantily']>=$product['quantily']){
                                            // trừ bên đại lý bán
                                            $saveWarehouse['$inc']['product.'.$product['id'].'.quantily']= 0-$product['quantily'];
                                            $dkWarehouse= array('_id'=> new MongoId($warehousAgency['Warehouse']['id']));

                                            // tính lợi nhuận của bên đại lý bán
                                            $numberProductWarehous= $product['quantily'];
                                            $listPrice= $warehousAgency['Warehouse']['product'][$product['id']]['price'];
                                            foreach($listPrice as $key=>$productPrice){
                                            	if($numberProductWarehous>0){
	                                            	if($productPrice['quantily']>$numberProductWarehous){
	                                            		$warehousAgency['Warehouse']['product'][$product['id']]['price'][$key]['quantily'] -= $numberProductWarehous;
	                                            		$profit= ($product['price']-$productPrice['price'])*$numberProductWarehous;
	                                            		$numberProductWarehous= 0;
	                                            	}elseif($productPrice['quantily']=$numberProductWarehous){
	                                            		$profit= ($product['price']-$productPrice['price'])*$numberProductWarehous;
	                                            		unset($warehousAgency['Warehouse']['product'][$product['id']]['price'][$key]);
	                                            		$numberProductWarehous= 0;
	                                            	}elseif($productPrice['quantily']<$numberProductWarehous){
	                                            		$profit= ($product['price']-$productPrice['price'])*$productPrice['quantily'];
	                                            		unset($warehousAgency['Warehouse']['product'][$product['id']]['price'][$key]);
	                                            		$numberProductWarehous -= $productPrice['quantily'];
	                                            	}
	                                            }
                                            }

                                            $saveWarehouse['$set']['product.'.$product['id'].'.price']= $warehousAgency['Warehouse']['product'][$product['id']]['price'];
                                            $modelWarehouse->create();
                                            $modelWarehouse->updateAll($saveWarehouse,$dkWarehouse);

                                            // cộng bên đại lý mua
                                            $dkWarehouse= array('idAgency'=>$order['Order']['idAgency'],'idWarehous'=>$warehousAgency['Warehouse']['idWarehous']);
                                            $warehousAgencySell= $modelWarehouse->find('first',array('conditions'=>$dkWarehouse));

                                            $warehousAgencySell['Warehouse']['idAgency']= $order['Order']['idAgency'];
                                            $warehousAgencySell['Warehouse']['codeAgency']= $order['Order']['codeAgency'];
                                            $warehousAgencySell['Warehouse']['idWarehous']= $warehousAgency['Warehouse']['idWarehous'];
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['id']= $product['id'];
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['name']= $product['name'];
                                            if(empty($warehousAgencySell['Warehouse']['product'][$product['id']]['quantily'])) $warehousAgencySell['Warehouse']['product'][$product['id']]['quantily']= 0;
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['quantily'] += $product['quantily'];
                                            if(!isset($warehousAgencySell['Warehouse']['product'][$product['id']]['price'])) $warehousAgencySell['Warehouse']['product'][$product['id']]['price']= array();
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['price'][] = array('quantily'=>$product['quantily'],'price'=>$product['price']);
                                            $modelWarehouse->create();
                                            $modelWarehouse->save($warehousAgencySell);

                                            break;
                                        }else{
                                            // trừ bên bán
                                            $product['quantily'] -= $warehousAgency['Warehouse']['product'][$product['id']]['quantily'];
                                            $saveWarehouse['$set']['product.'.$product['id'].'.quantily']= 0;
                                            $dkWarehouse= array('_id'=> new MongoId($warehousAgency['Warehouse']['id']));

                                            // tính lợi nhuận của bên đại lý bán
                                            $numberProductWarehous= $warehousAgency['Warehouse']['product'][$product['id']]['quantily'];
                                            $listPrice= $warehousAgency['Warehouse']['product'][$product['id']]['price'];
                                            foreach($listPrice as $key=>$productPrice){
                                            	if($numberProductWarehous>0){
	                                            	if($productPrice['quantily']>$numberProductWarehous){
	                                            		$warehousAgency['Warehouse']['product'][$product['id']]['price'][$key]['quantily'] -= $numberProductWarehous;
	                                            		$profit += ($product['price']-$productPrice['price'])*$numberProductWarehous;
	                                            		$numberProductWarehous= 0;
	                                            	}elseif($productPrice['quantily']=$numberProductWarehous){
	                                            		$profit += ($product['price']-$productPrice['price'])*$numberProductWarehous;
	                                            		unset($warehousAgency['Warehouse']['product'][$product['id']]['price'][$key]);
	                                            		$numberProductWarehous= 0;
	                                            	}elseif($productPrice['quantily']<$numberProductWarehous){
	                                            		$profit += ($product['price']-$productPrice['price'])*$productPrice['quantily'];
	                                            		unset($warehousAgency['Warehouse']['product'][$product['id']]['price'][$key]);
	                                            		$numberProductWarehous -= $productPrice['quantily'];
	                                            	}
	                                            }
                                            }

                                            $saveWarehouse['$set']['product.'.$product['id'].'.price']= $warehousAgency['Warehouse']['product'][$product['id']]['price'];
                                            $modelWarehouse->create();
                                            $modelWarehouse->updateAll($saveWarehouse,$dkWarehouse);

                                            // cộng bên đại lý mua
                                            $dkWarehouse= array('idAgency'=>$order['Order']['idAgency'],'idWarehous'=>$warehousAgency['Warehouse']['idWarehous']);
                                            $warehousAgencySell= $modelWarehouse->find('first',array('conditions'=>$dkWarehouse));

                                            $warehousAgencySell['Warehouse']['idAgency']= $order['Order']['idAgency'];
                                            $warehousAgencySell['Warehouse']['codeAgency']= $order['Order']['codeAgency'];
                                            $warehousAgencySell['Warehouse']['idWarehous']= $warehousAgency['Warehouse']['idWarehous'];
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['id']= $product['id'];
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['name']= $product['name'];
                                            if(empty($warehousAgencySell['Warehouse']['product'][$product['id']]['quantily'])) $warehousAgencySell['Warehouse']['product'][$product['id']]['quantily']= 0;
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['quantily'] += $warehousAgency['Warehouse']['product'][$product['id']]['quantily'];
                                            if(!isset($warehousAgencySell['Warehouse']['product'][$product['id']]['price'])) $warehousAgencySell['Warehouse']['product'][$product['id']]['price']= array();
                                            $warehousAgencySell['Warehouse']['product'][$product['id']]['price'][] = array('quantily'=>$warehousAgency['Warehouse']['product'][$product['id']]['quantily'],'price'=>$product['price']);
                                            $modelWarehouse->create();
                                            $modelWarehouse->save($warehousAgencySell);
                                        }
                                    }
                                }
                            }
                        }

                        // cập nhập số dư tài khoản vào tài khoản của đại lý mua
                        $saveAgency['$inc']['wallet.order']= 0-$order['Order']['price'];
                        //$saveAgency['$inc']['wallet.purchaseFund']= 0-$order['Order']['price'];
                        $conditionsAgency= array('_id'=>new MongoId($order['Order']['idAgency']));
                        $modelAgency->create();
                        $modelAgency->updateAll($saveAgency,$conditionsAgency); 

                        // Lưu lịch sử giao dịch
                        $saveHistory['History']['mess']= 'Hệ thống trừ  '.number_format($order['Order']['price']).'đ trong tài khoản tiền hàng chờ xử lý do đơn hàng '.$order['Order']['code'].' của bạn đã được duyệt';
                        $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                        $saveHistory['History']['time']['time']= time();
                        $saveHistory['History']['price']= $order['Order']['price'];
                        $saveHistory['History']['idAgency']= $order['Order']['idAgency'];
                        $saveHistory['History']['codeAgency']= $order['Order']['codeAgency'];
                        $saveHistory['History']['typeExchange']= 7; // mua hàng
                        $modelHistory->create();
                        $modelHistory->save($saveHistory);

                        // cập nhập số dư tài khoản vào tài khoản của đại lý bán
                        $saveAgency= array();
                        //$saveAgency['$inc']['wallet.waitingOrder']= $order['Order']['price']; // tiền bán hàng chờ duyệt
                        $saveAgency['$inc']['wallet.active']= $order['Order']['price']; // tiền được rút
                        $saveAgency['$inc']['walletStatic.order.'.$today['year'].'.'.$today['mon'] ]= $order['Order']['price'];
                        $saveAgency['$inc']['walletStatic.profit.'.$today['year'].'.'.$today['mon'] ]= $profit;
                        $conditionsAgency= array('_id'=>new MongoId($order['Order']['toAgency']));
                        $modelAgency->create();
                        $modelAgency->updateAll($saveAgency,$conditionsAgency); 

                        // Lưu lịch sử giao dịch
                        $saveHistory['History']['mess']= 'Hệ thống cộng '.number_format($order['Order']['price']).'đ tiền hàng vào tài khoản chờ xử lý do đơn hàng bạn đã bán thành công đơn hàng '.$order['Order']['code'].' cho đại lý '.$order['Order']['codeAgency'].', đơn hàng này bạn lãi '.number_format($profit).'đ';
                        $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                        $saveHistory['History']['time']['time']= time();
                        $saveHistory['History']['price']= $order['Order']['price'];
                        $saveHistory['History']['idAgency']= $order['Order']['toAgency'];
                        $saveHistory['History']['codeAgency']= $order['Order']['toCodeAgency'];
                        $saveHistory['History']['typeExchange']= 6; // mua hàng
                        $modelHistory->create();
                        $modelHistory->save($saveHistory);

                        // tính thưởng cho đại lý cho ngang cấp
                        $agencyFather= $modelAgency->getAgency($agency['Agency']['idAgencyFather']);
                        if($agency['Agency']['level']==$agencyFather['Agency']['level']){
                            $saveAgency= array();
                            //$saveAgency['$inc']['wallet.waitingBonus']= $totalProduct*$productBonus;
                            $saveAgency['$inc']['wallet.active']= $totalProductBonus*$productBonus;
                            $saveAgency['$inc']['walletStatic.productBonus.'.$today['year'].'.'.$today['mon'] ]= $totalProductBonus*$productBonus;
                            $conditionsAgency= array('_id'=>new MongoId($agencyFather['Agency']['id']));
                            $modelAgency->create();
                            $modelAgency->updateAll($saveAgency,$conditionsAgency); 

                            // Lưu lịch sử giao dịch
                            $saveHistory['History']['mess']= 'Hệ thống cộng '.number_format($saveAgency['$inc']['wallet.active']).'đ tiền hàng vào tài khoản chờ xử lý do đại lý '.$agency['Agency']['code'].' trực thuộc bạn, có level ngang cấp với bạn, mua thành công đơn hàng '.$order['Order']['code'];
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $saveAgency['$inc']['wallet.active'];
                            $saveHistory['History']['idAgency']= $agencyFather['Agency']['id'];
                            $saveHistory['History']['codeAgency']= $agencyFather['Agency']['code'];
                            $saveHistory['History']['typeExchange']= 8; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);
                        }
                        

                        $modelOption->redirect($urlHomes.'listOrderSell?status=activeOrderAgencyDone');
                    }else{
                        $modelOption->redirect($urlHomes.'listOrderSell?status=activeOrderAgencyFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listOrderSell?status=activeOrderAgencyFail');
                }
            }else{
                $modelOption->redirect($urlHomes.'listOrderSell');
            }
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }
?>