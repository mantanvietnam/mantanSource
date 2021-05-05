<?php
    function notificationPay($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách thông báo nạp tiền';
        

        $dataSend = $input['request']->data;
        $modelNotification= new Notification();
        $mess= '';
        $data= array();
        $listBank= getListBank();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('notificationPay', $_SESSION['infoStaff']['Staff']['permission']))){

                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions=array();
                $conditions = array('status'=>array('$ne'=>'lock'));
                $order = array('created'=>'DESC');
                $fields= array();
                
                if(!empty($_GET['status'])){
                    switch ($_GET['status']) {
                        case 'addMoneyDone': $mess= 'Xử lý yêu cầu nạp tiền thành công';break;
                        case 'addMoneyFail': $mess= 'Xử lý yêu cầu nạp tiền thất bại';break;
                        case 'errorMoney': $mess= 'Số tiền nạp phải lớn hơn 0';break;
                        case 'errorAgency': $mess= 'Không tồn tại tài khoản đại lý này';break;
                    }
                }

                if(!empty($_GET['idStatus'])){
                    $conditions['status']= $_GET['idStatus'];
                }

                $listData= $modelNotification->getPage($page, $limit , $conditions, $order, $fields );

                $totalData= $modelNotification->find('count',array('conditions' => $conditions));
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
            }else{
                $modelNotification->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelNotification->redirect($urlHomes.'admin?status=-2');
        }
    }   

    function hideNotificationPay($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Ẩn thông báo thanh toán';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('hideNotificationPay', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelNotification= new Notification();
                $modelLog= new Log();

                if(!empty($_GET['id'])){
                    $save['$set']['status']= 'cancel';
                    $dk= array('_id'=>new MongoId($_GET['id']));
                    if($modelNotification->updateAll($save,$dk)){
                        // lưu lịch sử tạo sản phẩm
                        $saveLog['Log']['time']= time();
                        $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' ẩn thông báo có ID là '.$_GET['id'];
                        $modelLog->save($saveLog);

                        $modelOption->redirect($urlHomes.'notificationPay?status=deleteNotificationDone');
                    }else{
                        $modelOption->redirect($urlHomes.'notificationPay?status=deleteNotificationFail');
                    }

                }else{
                    $modelOption->redirect($urlHomes.'notificationPay');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function viewRevenueAgencyAdmin($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Xem doanh thu đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewRevenueAgencyAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;

                if(!empty($_GET['id'])){
                    $modelAgency= new Agency();
                    $agency= $modelAgency->getAgency($_GET['id'],array('walletStatic','code','phone'));

                    setVariable('agency',$agency);

                }else{
                    $modelOption->redirect($urlHomes.'listAgency');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function viewWalletAgencyAdmin($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Xem ví đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('viewWalletAgencyAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;

                if(!empty($_GET['id'])){
                    $modelAgency= new Agency();
                    $agency= $modelAgency->getAgency($_GET['id'],array('wallet','code','phone'));

                    setVariable('agency',$agency);

                }else{
                    $modelOption->redirect($urlHomes.'listAgency');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function changeMoneyAgencyAdmin($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Chuyển tiền ví đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('changeMoneyAgencyAdmin', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;

                if(!empty($dataSend['id'])){
                    $modelAgency= new Agency();
                    $agency= $modelAgency->getAgency($dataSend['id']);

                    if($dataSend['type']=='waitingShip'){
                        if(!empty($agency['Agency']['wallet']['waitingShip']) && $dataSend['waitingShip']<=$agency['Agency']['wallet']['waitingShip']){
                            $agency['Agency']['wallet']['active'] += (int) str_replace('.', '', $dataSend['waitingShip']);
                            $agency['Agency']['wallet']['waitingShip'] -= (int) str_replace('.', '', $dataSend['waitingShip']);

                            if($modelAgency->save($agency)){
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingShipDone');
                            }else{
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingShipFail');
                            }
                        }else{
                            $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingShipFail');
                        }
                    }elseif($dataSend['type']=='waitingQRBonus'){
                        if(!empty($agency['Agency']['wallet']['waitingQRBonus']) && $dataSend['waitingQRBonus']<=$agency['Agency']['wallet']['waitingQRBonus']){
                            $agency['Agency']['wallet']['active'] += (int) str_replace('.', '', $dataSend['waitingQRBonus']);
                            $agency['Agency']['wallet']['waitingQRBonus'] -= (int) str_replace('.', '', $dataSend['waitingQRBonus']);

                            if($modelAgency->save($agency)){
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingQRBonusDone');
                            }else{
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingQRBonusFail');
                            }
                        }else{
                            $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingQRBonusFail');
                        }
                    }elseif($dataSend['type']=='waitingBonus'){
                        if(!empty($agency['Agency']['wallet']['waitingBonus']) && $dataSend['waitingBonus']<=$agency['Agency']['wallet']['waitingBonus']){
                            $agency['Agency']['wallet']['active'] += (int) str_replace('.', '', $dataSend['waitingBonus']);
                            $agency['Agency']['wallet']['waitingBonus'] -= (int) str_replace('.', '', $dataSend['waitingBonus']);

                            if($modelAgency->save($agency)){
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingBonusDone');
                            }else{
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingBonusFail');
                            }
                        }else{
                            $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingBonusFail');
                        }
                    }elseif($dataSend['type']=='waitingOrder'){
                        if(!empty($agency['Agency']['wallet']['waitingOrder']) && $dataSend['waitingOrder']<=$agency['Agency']['wallet']['waitingOrder']){
                            $agency['Agency']['wallet']['active'] += (int) str_replace('.', '', $dataSend['waitingOrder']);
                            $agency['Agency']['wallet']['waitingOrder'] -= (int) str_replace('.', '', $dataSend['waitingOrder']);

                            if($modelAgency->save($agency)){
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingOrderDone');
                            }else{
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingOrderFail');
                            }
                        }else{
                            $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=waitingOrderFail');
                        }
                    }elseif($dataSend['type']=='penalties'){
                        if(!empty($agency['Agency']['wallet']['penalties']) && $dataSend['penalties']<=$agency['Agency']['wallet']['penalties']){
                            $agency['Agency']['wallet']['active'] -= (int) str_replace('.', '', $dataSend['penalties']);
                            $agency['Agency']['wallet']['penalties'] -= (int) str_replace('.', '', $dataSend['penalties']);

                            if($modelAgency->save($agency)){
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=penaltiesDone');
                            }else{
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=penaltiesFail');
                            }
                        }else{
                            $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=penaltiesFail');
                        }
                    }elseif($dataSend['type']=='ship'){
                        if(!empty($agency['Agency']['wallet']['ship']) && $dataSend['ship']<=$agency['Agency']['wallet']['ship']){
                            $agency['Agency']['wallet']['active'] -= (int) str_replace('.', '', $dataSend['ship']);
                            $agency['Agency']['wallet']['ship'] -= (int) str_replace('.', '', $dataSend['ship']);

                            if($modelAgency->save($agency)){
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=shipDone');
                            }else{
                                $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=shipFail');
                            }
                        }else{
                            $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id'].'&status=shipFail');
                        }
                    }

                    $modelOption->redirect($urlHomes.'viewWalletAgencyAdmin?id='.$dataSend['id']);

                }else{
                    $modelOption->redirect($urlHomes.'listAgency');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function addMoneyAgency($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Nạp tiền vào tài khoản đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addMoneyAgency', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelAgency= new Agency();
                $modelExchange= new Exchange();
                $modelLog= new Log();
                $modelHistory= new History();

                if($isRequestPost){
                    if(!empty($dataSend['codeAgency'])){
                        $agency= $modelAgency->getAgencyByCode($dataSend['codeAgency']);
                        if($agency){
                            $save['Exchange']['codeAgency']= $agency['Agency']['code'];
                            $save['Exchange']['idAgency']= $agency['Agency']['id'];
                            $save['Exchange']['money']= (int) str_replace('.', '', $dataSend['money']);
                            $save['Exchange']['note']= trim($dataSend['note']);
                            $save['Exchange']['dateProcess']['time']= time();
                            $save['Exchange']['dateProcess']['text']= date('d/m/Y',$save['Exchange']['dateProcess']['time']);
                            $save['Exchange']['typeExchange']= 1; //Đại lý nạp tiền

                            if($save['Exchange']['money']>0){
                                if($modelExchange->save($save)){
                                    // lưu lịch sử tạo sản phẩm
                                    $saveLog['Log']['time']= time();
                                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' nạp tiền cho đại lý có ID là '.$agency['Agency']['id'];
                                    $modelLog->save($saveLog);

                                    $saveAgency['$inc']['wallet.recharge']= $save['Exchange']['money'];
                                    $saveAgency['$inc']['wallet.purchaseFund']= $save['Exchange']['money'];
                                    $conditionsAgency= array('_id'=>new MongoId($agency['Agency']['id']));
                                    $modelAgency->updateAll($saveAgency,$conditionsAgency);

                                    // Lưu lịch sử giao dịch
                                    $saveHistory['History']['mess']= 'Bạn đã nạp thành công '.number_format($save['Exchange']['money']).'đ vào tài khoản khả dụng của bạn';
                                    $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                    $saveHistory['History']['time']['time']= time();
                                    $saveHistory['History']['price']= $save['Exchange']['money'];
                                    $saveHistory['History']['idAgency']= $agency['Agency']['id'];
                                    $saveHistory['History']['codeAgency']= $agency['Agency']['code'];
                                    $saveHistory['History']['typeExchange']= 1; // mua hàng
                                    $modelHistory->create();
                                    $modelHistory->save($saveHistory);

                                    $mess= 'Nạp tiền thành công';
                                }else{
                                    $mess= 'Nạp tiền thất bại do lỗi hệ thống';
                                }
                            }else{
                                $mess= 'Số tiền nạp không được nhỏ hơn 0';
                            }
                        }else{
                            $mess= 'Không tồn tại tài khoản đại lý';
                        }
                    }else{
                        $mess= 'Không được để trống mã đại lý';
                    }
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }

            setVariable('mess',$mess);
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function activeNotificationPay($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Nạp tiền vào tài khoản đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('activeNotificationPay', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelAgency= new Agency();
                $modelExchange= new Exchange();
                $modelLog= new Log();
                $modelHistory= new History();
                $modelNotification= new Notification();

                if(!empty($_GET['id'])){
                    $data= $modelNotification->getNotification($_GET['id']);

                    if($data){
                        $agency= $modelAgency->getAgencyByCode($data['Notification']['codeAgency']);
                        if($agency){
                            $save['Exchange']['codeAgency']= $agency['Agency']['code'];
                            $save['Exchange']['idAgency']= $agency['Agency']['id'];
                            $save['Exchange']['money']= (int) $data['Notification']['money'];
                            $save['Exchange']['note']= '';
                            $save['Exchange']['dateProcess']['time']= time();
                            $save['Exchange']['dateProcess']['text']= date('d/m/Y',$save['Exchange']['dateProcess']['time']);
                            $save['Exchange']['typeExchange']= 1; //Đại lý nạp tiền

                            if($save['Exchange']['money']>0){
                                if($modelExchange->save($save)){
                                    // lưu lịch sử tạo sản phẩm
                                    $saveLog['Log']['time']= time();
                                    $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' nạp tiền cho đại lý có ID là '.$agency['Agency']['id'];
                                    $modelLog->save($saveLog);

                                    $saveAgency['$inc']['wallet.recharge']= $save['Exchange']['money'];
                                    $saveAgency['$inc']['wallet.purchaseFund']= $save['Exchange']['money'];
                                    $conditionsAgency= array('_id'=>new MongoId($agency['Agency']['id']));
                                    $modelAgency->updateAll($saveAgency,$conditionsAgency);

                                    // Lưu lịch sử giao dịch
                                    $saveHistory['History']['mess']= 'Bạn đã nạp thành công '.number_format($save['Exchange']['money']).'đ vào tài khoản khả dụng của bạn';
                                    $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                                    $saveHistory['History']['time']['time']= time();
                                    $saveHistory['History']['price']= $save['Exchange']['money'];
                                    $saveHistory['History']['idAgency']= $agency['Agency']['id'];
                                    $saveHistory['History']['codeAgency']= $agency['Agency']['code'];
                                    $saveHistory['History']['typeExchange']= 1; // mua hàng
                                    $modelHistory->create();
                                    $modelHistory->save($saveHistory);

                                    $data['Notification']['status']= 'done';
                                    $data['Notification']['timeActive']= time();
                                    $data['Notification']['idStaff']= $_SESSION['infoStaff']['Staff']['id'];
                                    $modelNotification->save($data);

                                    //$mess= 'Nạp tiền thành công';
                                    $modelOption->redirect($urlHomes.'notificationPay?status=addMoneyDone');
                                }else{
                                    //$mess= 'Nạp tiền thất bại do lỗi hệ thống';
                                    $modelOption->redirect($urlHomes.'notificationPay?status=addMoneyFail');
                                }
                            }else{
                                //$mess= 'Số tiền nạp không được nhỏ hơn 0';
                                $modelOption->redirect($urlHomes.'notificationPay?status=errorMoney');
                            }
                        }else{
                            //$mess= 'Không tồn tại tài khoản đại lý';
                            $modelOption->redirect($urlHomes.'notificationPay?status=errorAgency');
                        }
                    }else{
                        $modelOption->redirect($urlHomes.'notificationPay');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'notificationPay');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function historyExchange($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách lịch sử giao dịch';
        

        $dataSend = $input['request']->data;
        $modelExchange= new Exchange();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('historyExchange', $_SESSION['infoStaff']['Staff']['permission']))){

                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions=array();
                $conditions = array();
                $order = array('created'=>'DESC');
                $fields= array();
                
                if(!empty($_GET['codeAgency'])){
                    $conditions['codeAgency']= strtoupper($_GET['codeAgency']);
                }

                if(!empty($_GET['idTypeExchange'])){
                    $conditions['typeExchange']= (int) $_GET['idTypeExchange'];
                }
                
                $listData= $modelExchange->getPage($page, $limit , $conditions, $order, $fields );

                $totalData= $modelExchange->find('count',array('conditions' => $conditions));
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
                setVariable('typeExchange',getTypeExchange());

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
            }else{
                $modelExchange->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelExchange->redirect($urlHomes.'admin?status=-2');
        }
    }   

    function drawMoney($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách yêu cầu rút tiền';
        

        $dataSend = $input['request']->data;
        $modelRequest= new Request();
        $modelAgency= new Agency();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('drawMoney', $_SESSION['infoStaff']['Staff']['permission']))){

                $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
                if($page<1) $page=1;
                $limit= 15;
                $conditions=array();
                $order = array('created'=>'DESC');
                $fields= array();
                
                if(!empty($_GET['codeAgency'])){
                    $conditions['codeAgency']= strtoupper($_GET['codeAgency']);
                }
                
                $listData= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );
                $listAgency= array();
                if($listData){
                    foreach($listData as $key=>$data){
                        if(empty($listAgency[$data['Request']['idAgency']])){
                            $listAgency[$data['Request']['idAgency']]= $modelAgency->getAgency($data['Request']['idAgency'],array('code','level','phone','fullName'));
                        }
                    }
                }

                $totalData= $modelRequest->find('count',array('conditions' => $conditions));
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
                setVariable('statusPay',getStatusDefault());

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
            }else{
                $modelRequest->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelRequest->redirect($urlHomes.'admin?status=-2');
        }
    }   

    function updateRequestPay($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Xử lý thông báo yêu cầu rút tiền';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('updateRequestPay', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelRequest= new Request();
                $modelLog= new Log();
                $modelAgency= new Agency();

                if(!empty($_GET['id'])){
                    $save['$set']['status']= (!empty($_GET['status']))?$_GET['status']:'done';
                    $dk= array('_id'=>new MongoId($_GET['id']));
                    if($modelRequest->updateAll($save,$dk)){
                        // lưu lịch sử tạo sản phẩm
                        $saveLog['Log']['time']= time();
                        $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' xử lý yêu cầu rút tiền có ID là '.$_GET['id'];
                        $modelLog->save($saveLog);

                        if($save['$set']['status']=='done'){
                            $request= $modelRequest->getRequest($_GET['id']);

                            $updateAgency['$inc']['wallet.request']= 0-$request['Request']['money'];
                            $dkAgency= array('_id'=> new MongoId($request['Request']['idAgency']) );
                            $modelAgency->updateAll($updateAgency,$dkAgency);
                        }elseif($save['$set']['status']=='cancel'){
                            $request= $modelRequest->getRequest($_GET['id']);

                            $updateAgency['$inc']['wallet.request']= 0-$request['Request']['money'];
                            $updateAgency['$inc']['wallet.active']= $request['Request']['money'];
                            $dkAgency= array('_id'=> new MongoId($request['Request']['idAgency']) );
                            $modelAgency->updateAll($updateAgency,$dkAgency);
                        }

                        $modelOption->redirect($urlHomes.'drawMoney?status=updateRequestPayDone');
                    }else{
                        $modelOption->redirect($urlHomes.'drawMoney?status=updateRequestPayFail');
                    }

                }else{
                    $modelOption->redirect($urlHomes.'drawMoney');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }
    // -----------------------------------------------------------------------------------
	function walletAddMoney($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;

        $modelNotification= new Notification();
        if(!empty($_SESSION['infoAgency'])){
        	$mess= '';
            $listBank= getListBank();
            $today= getdate();
        	if($isRequestPost){
        		$dataSend= $input['request']->data;
                if(is_numeric($dataSend['bankSelect']) || (!empty($dataSend['bankAccount']) && !empty($dataSend['bankNumber']) && !empty($dataSend['bankID']) && !empty($dataSend['bankBranch']))){
            		$save['Notification']['money']= (int) str_replace('.', '', $dataSend['money']);

            		$save['Notification']['date']['text']= $dataSend['date'];
                    $dateStart= explode('/', $dataSend['date']);
                    $save['Notification']['date']['time']= mktime(0,0,0,$dateStart[1],$dateStart[0],$dateStart[2]);

                    $save['Notification']['timeCreate']= time();
                    $save['Notification']['note']= $dataSend['note'];
                    $save['Notification']['status']= 'new';
                    $save['Notification']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                    $save['Notification']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];

                    if(isset($_FILES["file"]) && empty($_FILES["file"]["error"])){
    	                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    	                $filename = $_FILES["file"]["name"];
    	                $filetype = $_FILES["file"]["type"];
    	                $filesize = $_FILES["file"]["size"];

    	                // Verify file extension
    	                $ext = pathinfo($filename, PATHINFO_EXTENSION);

    	                if(!array_key_exists(strtolower($ext), $allowed)) $mess= 'File upload không đúng định dạng ảnh';//$modelCustomer->redirect($urlHomes.'infoCustomer?upload=1'); // sai dinh dang
    	            
    	                // Verify file size - 5MB maximum
    	                $maxsize = 5 * 1024 * 1024;
    	                if($filesize > $maxsize) $mess= 'File ảnh vượt quá giới hạn 5Mb cho phép';//$modelCustomer->redirect($urlHomes.'infoCustomer?upload=2'); // vuot qua gioi han dung luong
    	            
    	                // Verify MYME type of the file
    	                if(in_array($filetype, $allowed)){
    	                    // Check whether file exists before uploading it
                            move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__.'/../../../webroot/upload/agency/' .$_SESSION['infoAgency']['Agency']['code'].'-'. $today[0].'.jpg');
                            $save['Notification']['file']= '/app/webroot/upload/agency/'.$_SESSION['infoAgency']['Agency']['code'].'-'.$today[0].'.jpg';
    	                    
    	                } else{
    	                    //$modelCustomer->redirect($urlHomes.'infoCustomer?upload=4'); // xu ly bi loi, hay lam lai
    	                    $mess= 'Upload ảnh bị lỗi';
    	                }
    	            }

                    if(is_numeric($dataSend['bankSelect'])){
                        $save['Notification']['bank']= $_SESSION['infoAgency']['Agency']['bank'][$dataSend['bankSelect']];
                    }else{
                        $save['Notification']['bank']['bankAccount']= @$dataSend['bankAccount'];
                        $save['Notification']['bank']['bankNumber']= @$dataSend['bankNumber'];
                        $save['Notification']['bank']['bankID']= @$dataSend['bankID'];
                        $save['Notification']['bank']['bankName']= @$listBank[$dataSend['bankID']]['name'];
                        $save['Notification']['bank']['bankBranch']= @$dataSend['bankBranch'];
                    }

                    if(empty($mess) && $modelNotification->save($save)){
                    	$mess= 'Lưu thông báo thành công';
                    }
                }else{
                    $mess= 'Bạn không được để trống thông tin ngân hàng';
                }
        	}
            setVariable('mess',$mess);
        	setVariable('listBank',$listBank);
        }else{
            $modelNotification->redirect($urlHomes.'login?status=-2');
        }
    }

    function wallet($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id'],array('wallet'));

            $_SESSION['infoAgency']['Agency']['wallet']= $agency['Agency']['wallet'];

            setVariable('agency',$agency);
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function revenue($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id'],array('walletStatic'));

            setVariable('agency',$agency);
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function pay($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $modelRequest= new Request();
            $modelHistory= new History();

            if(empty($_SESSION['infoAgency']['Agency']['bank'])){
                $modelOption->redirect($urlHomes.'bank?redirect=pay');
            }

            $mess= '';

            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id'],array('wallet'));

            if($isRequestPost){
                $dataSend= $input['request']->data;

                $save['Request']['money']= (int) str_replace('.', '', $dataSend['money']);

                if($save['Request']['money']<=$agency['Agency']['wallet']['active']){
                    $save['Request']['time']['text']= date('H:i:s d/m/Y');
                    $save['Request']['time']['time']= time();
                    $save['Request']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                    $save['Request']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                    $save['Request']['bank']= @$_SESSION['infoAgency']['Agency']['bank'][$dataSend['bank']];
                    $save['Request']['status']= 'new';

                    $code= $modelOption->getOption('codeRequestGavi');
                    $code['Option']['value']['count']= (isset($code['Option']['value']['count']))?$code['Option']['value']['count']+1:1;
                    $codeRequest= 'RT'.$code['Option']['value']['count'];
                    $modelOption->saveOption('codeRequestGavi',$code['Option']['value']);
                    $save['Request']['code']= $codeRequest;

                    if($modelRequest->save($save)){

                        $saveAgency['$inc']['wallet.active']= 0-$save['Request']['money'];
                        $saveAgency['$inc']['wallet.request']= $save['Request']['money'];

                        $dkAgency= array('_id'=>new MongoId($_SESSION['infoAgency']['Agency']['id']));
                        $modelAgency->create();

                        if($modelAgency->updateAll($saveAgency,$dkAgency)){
                            // Lưu lịch sử giao dịch
                            $saveHistory['History']['mess']= 'Hệ thống chuyển '.number_format($save['Request']['money']).'đ từ tài khoản khả dụng sang tài khoản chờ rút sau khi bạn đặt lệnh rút tiền '.$codeRequest;
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $save['Request']['money'];
                            $saveHistory['History']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                            $saveHistory['History']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                            $saveHistory['History']['typeExchange']= 3; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);

                            $mess= 'Đặt lệnh rút tiền thành công';

                            $agency['Agency']['wallet']['active'] -= $save['Request']['money'];
                            $agency['Agency']['wallet']['request'] += $save['Request']['money'];
                        }
                    }else{
                        $mess= 'Lỗi hệ thống';
                    }
                }else{
                    $mess= 'Số dư khả dụng của bạn không đủ để rút';
                }
            }

            $_SESSION['infoAgency']['Agency']['wallet']= $agency['Agency']['wallet'];

            setVariable('agency',$agency);
            setVariable('mess',$mess);
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function walletHistory($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $modelHistory= new History();
            
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions = array('idAgency'=>$_SESSION['infoAgency']['Agency']['id']);
            $order = array('created'=>'DESC');
            $fields= array();

            if(!empty($_GET['typeExchange'])){
                $conditions['typeExchange']= (int) $_GET['typeExchange'];
            }

            if(!empty($_GET['dateStart'])){
                $dateStart= explode('/', $_GET['dateStart']);
                $date= mktime(0,0,0,$dateStart[1],$dateStart[0],$dateStart[2]);
                $conditions['time.time']['$gte']= $date;
            }

            if(!empty($_GET['dateEnd'])){
                $dateEnd= explode('/', $_GET['dateEnd']);
                $date= mktime(23,59,59,$dateEnd[1],$dateEnd[0],$dateEnd[2]);
                $conditions['time.time']['$lte']= $date;
            }
            
            $listData= $modelHistory->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelHistory->find('count',array('conditions' => $conditions));
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

            setVariable('listTypeExchange',getTypeExchange());
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function walletNotification($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $modelNotification= new Notification();
            
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions=array();
            $conditions = array('idAgency'=>$_SESSION['infoAgency']['Agency']['id']);
            $order = array('created'=>'DESC');
            $fields= array();
            
            if(!empty($_GET['idStatus'])){
                $conditions['status']= $_GET['idStatus'];
            }
            
            $listData= $modelNotification->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelNotification->find('count',array('conditions' => $conditions));
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
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function listPay($input)
    {
        global $urlHomes;
        global $modelOption;
        global $isRequestPost;
        global $urlNow;

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $modelHistory= new History();
            $modelRequest= new Request();
            
            $page = (!empty($_GET['page']))?(int)$_GET['page']:1;
            if($page<1) $page=1;
            $limit= 15;
            $conditions = array('idAgency'=>$_SESSION['infoAgency']['Agency']['id']);
            $order = array('created'=>'DESC');
            $fields= array();
            
            if(!empty($_GET['idStatus'])){
                $conditions['status']= $_GET['idStatus'];
            }

            $listData= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );

            $totalData= $modelRequest->find('count',array('conditions' => $conditions));
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

            setVariable('statusPay',getStatusDefault());
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }

    function deletePay($input)
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
            $modelRequest= new Request();
            $modelLog= new Log();
            $modelAgency= new Agency();
            $modelHistory= new History();
            $modelEmail= new Email();

            if(!empty($_GET['id'])){
                $order= $modelRequest->getRequest($_GET['id']);
                if($order){
                    $save['$set']['status']= 'cancel';
                    $dk= array('_id'=> new MongoId($_GET['id']));
                    if($modelRequest->updateAll($save,$dk)){

                        // Gửi email thông báo cho admin
                        $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                        $to = array($contactSite['Option']['value']['email']);
                        $cc = array();
                        $bcc = array();
                        $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo đại lý hủy yêu cầu rút tiền';

                        $content= 'Đại lý '.$_SESSION['infoAgency']['Agency']['code'].' đã hủy yêu cầu rút tiền '.$order['Request']['code'];

                        $modelAgency->sendMail($from, $to, $cc, $bcc, $subject, $content);

                        // Gửi thông báo vào hộp thư
                        $saveEmail['Email']['subject']= 'Thông báo đại lý hủy yêu cầu rút tiền, mã yêu cầu '.$order['Request']['code'];
                        $saveEmail['Email']['content']= 'Đại lý '.$_SESSION['infoAgency']['Agency']['code'].' đã hủy yêu cầu rút tiền '.$order['Request']['code'];
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

                        // cập nhập số dư tài khoản
                        $saveAgency['$inc']['wallet.active']= $order['Request']['money'];
                        $saveAgency['$inc']['wallet.request']= 0-$order['Request']['money'];

                        $dkAgency= array('_id'=>new MongoId($order['Request']['idAgency']));
                        $modelAgency->create();

                        if($modelAgency->updateAll($saveAgency,$dkAgency)){
                            // Lưu lịch sử giao dịch
                            $saveHistory['History']['mess']= 'Hệ thống hoàn lại '.number_format($order['Request']['money']).'đ từ tài khoản chờ rút sang tài khoản khả dụng sau khi bạn hủy yêu cầu rút tiền '.$order['Request']['code'];
                            $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                            $saveHistory['History']['time']['time']= time();
                            $saveHistory['History']['price']= $order['Request']['money'];
                            $saveHistory['History']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                            $saveHistory['History']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                            $saveHistory['History']['typeExchange']= 3; // mua hàng
                            $modelHistory->create();
                            $modelHistory->save($saveHistory);
                        }

                        $modelOption->redirect($urlHomes.'listPay?status=deletePayDone');
                    }else{
                        $modelOption->redirect($urlHomes.'listPay?status=deletePayFail');
                    }
                }else{
                    $modelOption->redirect($urlHomes.'listPay?status=deletePayFail');
                }
            }else{
                $modelOption->redirect($urlHomes.'listPay');
            }
        }else{
            $modelOption->redirect($urlHomes.'login?status=-2');
        }
    }
?>