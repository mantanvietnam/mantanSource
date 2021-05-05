<?php
    function activeRequestUpdateLevel($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Nâng cấp đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('activeRequestUpdateLevel', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelAgency= new Agency();
                $modelLog= new Log();
                $modelStaff= new Staff();
                $modelLevel= new Level();
                $modelHistory= new History();
            
                if(!empty($_GET['id'])){
                    $request= $modelLevel->getLevel($_GET['id']);
                    $agency= $modelAgency->getAgency($request['Level']['idAgency']);
                    if($request && $agency && $agency['Agency']['status']=='active'){
                        $idAgencyFather= getLevelAgencyFather((int) $request['Level']['levelNew'],$agency['Agency']['idAgencyFather']);
                        if(!empty($idAgencyFather)){
                            $agencyFather= $modelAgency->getAgency($idAgencyFather);
                            $save['$set']['codeAgencyFather']= $agencyFather['Agency']['code'];
                            $save['$set']['idAgencyFather']= $agencyFather['Agency']['id'];
                            $save['$set']['phoneAgencyFather']= $agencyFather['Agency']['phone'];
                        }else{
                            $save['$set']['codeAgencyFather']= '';
                            $save['$set']['idAgencyFather']= '';
                            $save['$set']['phoneAgencyFather']= '';
                        }

                        $save['$set']['level']= (int) $request['Level']['levelNew'];
                        // tính tiền đặt cọc
                        $getListAgency= getListAgency();
                        $moneyDepositPlus= $getListAgency[$request['Level']['levelNew']]['money_deposit']-$agency['Agency']['wallet']['deposit'];

                        $save['$inc']['wallet.deposit']= (int) $moneyDepositPlus;
                        if($agency['Agency']['wallet']['purchaseFund']>=$moneyDepositPlus){
                            $save['$inc']['wallet.purchaseFund']= 0 - $moneyDepositPlus;
                        }else{
                            $save['$set']['wallet.purchaseFund']= 0;
                            $save['$inc']['wallet.active']= $agency['Agency']['wallet']['purchaseFund']-$moneyDepositPlus;
                        }
                        // Lưu lịch sử giao dịch
                        $saveHistory['History']['mess']= 'Hệ thống chuyển  '.number_format($moneyDepositPlus).'đ trong quỹ mua hàng sang tài khoản đặt cọc sau khi nâng lên '.$getListAgency[$request['Level']['levelNew']]['name'];
                        $saveHistory['History']['time']['text']= date('H:i:s d/m/Y');
                        $saveHistory['History']['time']['time']= time();
                        $saveHistory['History']['price']= $moneyDepositPlus;
                        $saveHistory['History']['idAgency']= $agency['Agency']['id'];
                        $saveHistory['History']['codeAgency']= $agency['Agency']['code'];
                        $saveHistory['History']['typeExchange']= 11; // nâng cấp đại lý
                        $modelHistory->create();
                        $modelHistory->save($saveHistory);
                        

                        $dk= array('_id'=> new MongoId($request['Level']['idAgency']));
                        if($modelAgency->updateAll($save,$dk)){
                            // lưu lịch sử nâng cấp
                            $saveLog['Log']['time']= time();
                            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' nâng cấp đại lý có ID là '.$request['Level']['idAgency'];
                            $modelLog->save($saveLog);

                            // cập nhập yêu cầu nâng cấp
                            $request['Level']['status']= 'done';
                            $modelLevel->save($request);

                            $modelOption->redirect($urlHomes.'requestUpdateLevel?status=activeRequestUpdateLevelDone');
                        }else{
                            $modelOption->redirect($urlHomes.'requestUpdateLevel?status=activeRequestUpdateLevelFail');
                        }
                    }else{
                        $modelOption->redirect($urlHomes.'requestUpdateLevel');
                    }

                }else{
                    $modelOption->redirect($urlHomes.'requestUpdateLevel');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function cancelRequestUpdateLevel($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Nâng cấp đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('cancelRequestUpdateLevel', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelAgency= new Agency();
                $modelLog= new Log();
                $modelStaff= new Staff();
                $modelLevel= new Level();

            
                if(!empty($_GET['id'])){
                    // cập nhập yêu cầu nâng cấp
                    $saveRequest['$set']['status']= 'cancel';
                    $saveRequest['$set']['note']= @$_GET['note'];
                    $dkRequest= array('_id'=> new MongoId($_GET['id']) );
                    $modelLevel->updateAll($saveRequest,$dkRequest);
                    $modelOption->redirect($urlHomes.'requestUpdateLevel?status=cancelRequestUpdateLevelDone');

                }else{
                    $modelOption->redirect($urlHomes.'requestUpdateLevel');
                }
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }
    
    function requestUpdateLevel($input)
    {
        global $urlHomes;
        global $isRequestPost;
        global $contactSite;
        global $urlNow;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách yêu cầu nâng cấp đại lý';

        $dataSend = $input['request']->data;
        $modelLevel= new Level();
        $modelAgency= new Agency();
        $mess= '';
        $data= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('requestUpdateLevel', $_SESSION['infoStaff']['Staff']['permission']))){

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

                if(!empty($_GET['phoneAgency'])){
                    $conditions['phoneAgency']= strtoupper($_GET['phoneAgency']);
                }

                if(!empty($_GET['idStatus'])){
                    $conditions['status']= $_GET['idStatus'];
                }

                $listData= $modelLevel->getPage($page, $limit , $conditions, $order, $fields );

                $listAgency= array();
                if($listData){
                    foreach($listData as $key=>$data){
                        if(empty($listAgency[$data['Level']['idAgency']])){
                            $listAgency[$data['Level']['idAgency']]= $modelAgency->getAgency($data['Level']['idAgency'],array('code','level','phone','fullName'));
                        }
                    }
                }

                $totalData= $modelLevel->find('count',array('conditions' => $conditions));
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
                setVariable('getListAgency',getListAgency());

                setVariable('page',$page);
                setVariable('totalPage',$totalPage);
                setVariable('back',$back);
                setVariable('next',$next);
                setVariable('urlPage',$urlPage);
                setVariable('mess',$mess);
            }else{
                $modelLevel->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelLevel->redirect($urlHomes.'admin?status=-2');
        }
    } 

	function listAgency($input)
	{
		global $modelOption;
        global $urlHomes;

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('listAgency', $_SESSION['infoStaff']['Staff']['permission']))){
            	$modelAgency= new Agency();
                $listData= $modelAgency->find('all',array('fields'=>array('fullName','code','idAgencyFather','phone','level'),'conditions'=>array('idAgencyFather'=>'','status'=>'active','fullName'=>array('$ne'=>''))));

                $listData= getTreeAgency($listData);

                setVariable('listData',$listData);
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes);
        }
	}

    function searchAgencyAjax($input)
    {
        global $modelOption;
        global $urlHomes;
        $return= array();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('changeAgency', $_SESSION['infoStaff']['Staff']['permission']))){
                if(!empty($_GET['term'])){
                    $modelAgency= new Agency();
                    $dataSend= arrayMap($input['request']->data);
                    $conditions['slug']=array('$regex' => createSlugMantan(trim($_GET['term'])));
                    $conditions['status']= 'active';

                    $data= $modelAgency->find('first',array('conditions'=>$conditions));
                    if($data){
                        $return[]= array(   'id'=>$data['Agency']['id'],
                                            'label'=>'C'.$data['Agency']['level'].'.'.$data['Agency']['fullName'].' - '.$data['Agency']['phone'].' ('.$data['Agency']['code'].')',
                                            'value'=>$data['Agency']['code']
                                        );
                    }
                }
            }
        }

        echo json_encode($return);
    }

    function addAgency($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        $metaTitleMantan= 'Thông tin đại lý';

        $modelAgency= new Agency();
        $modelLog= new Log();
        $modelProduct= new Product();
        $modelWarehouse= new Warehouse();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('addAgency', $_SESSION['infoStaff']['Staff']['permission']))){

                $mess= '';
                $data= array();
                $listBank= getListBank();
                $listProduct= $modelProduct->find('all',array('conditions'=>array('status'=>'active')));

                if ($isRequestPost) {
                    $dataSend= arrayMap($input['request']->data);
                    
                    if(!empty(trim($dataSend['fullName'])) && !empty(trim($dataSend['phone']))){
                        $agencyFather= array();
                        $agencyIntroduce= array();
                        $checkUserPhone= $modelAgency->getAgencyByPhone(trim($dataSend['phone']),array('code'));

                        if(empty($checkUserPhone)){
	                        if(!empty($dataSend['codeAgencyFather'])){
	                            $agencyFather= $modelAgency->getAgencyByCode($dataSend['codeAgencyFather']);

	                            if(empty($agencyFather)){
	                                $modelOption->redirect($urlHomes.'addAgency?error=codeAgencyFather');
	                            }
	                        }

	                        if(!empty($dataSend['codeAgencyIntroduce'])){
	                            $agencyIntroduce= $modelAgency->getAgencyByCode($dataSend['codeAgencyIntroduce']);

	                            if(empty($agencyIntroduce)){
	                                $modelOption->redirect($urlHomes.'addAgency?error=codeAgencyIntroduce');
	                            }
	                        }

	                        $data['Agency']['status']= 'active';
	                        $code= $modelOption->getOption('codeAgencyGavi');
	                        $code['Option']['value']['count']= (isset($code['Option']['value']['count']))?$code['Option']['value']['count']+1:1;
	                        $data['Agency']['code']= 'DL'.$code['Option']['value']['count'];
	                        $data['Agency']['pass']= md5($dataSend['pass']);
	                        $data['Agency']['level']= (int) $dataSend['level']; //cộng tác viên
	                        $data['Agency']['wallet']['active']= 0; // tiền khả dụng
	                        $data['Agency']['wallet']['request']= 0; // tiền tạm giữ chờ rút
                            $data['Agency']['wallet']['deposit']= (int) str_replace('.', '', $dataSend['moneyDeposit']); // tiền đặt cọc đại lý

                            // tiền ra
                            $data['Agency']['wallet']['order']= 0; // tiền đặt cọc mua hàng chờ duyệt
                            $data['Agency']['wallet']['qrcode']= 0; // tiền đặt cọc tạo mã qr chờ duyệt
                            $data['Agency']['wallet']['penalties']= 0; // tiền phạt chờ duyệt
                            $data['Agency']['wallet']['ship']= 0; // tiền vận chuyển hàng chờ duyệt

                            // tiền vào
                            $data['Agency']['wallet']['waitingOrder']= 0; // tiền bán hàng chờ duyệt
                            $data['Agency']['wallet']['waitingBonus']= 0; // tiền thưởngban bán hàng đại lý chờ duyệt
                            $data['Agency']['wallet']['waitingQRBonus']= 0; // tiền thưởng giới thiệu đại lý chờ duyệt
	                        $data['Agency']['wallet']['waitingShip']= 0; // tiền đại lý nhờ thu hộ khi giao hàng chờ duyệt
	                        
                            
                            $data['Agency']['wallet']['recharge']= 0; // tiền nạp vào tài khoản
	                        $data['Agency']['wallet']['purchaseFund']= (int) str_replace('.', '', $dataSend['moneyActive']); // qũy mua= Tiền ĐL nộp vào Công ty - Tiền mua hàng thành công

	                        $modelOption->saveOption('codeAgencyGavi',$code['Option']['value']);

	                        $data['Agency']['codeAgencyFather']= (!empty($agencyFather['Agency']['code']))?$agencyFather['Agency']['code']:'';
	                        $data['Agency']['idAgencyFather']= (!empty($agencyFather['Agency']['id']))?$agencyFather['Agency']['id']:'';

	                        $data['Agency']['codeAgencyIntroduce']= (!empty($agencyIntroduce['Agency']['code']))?$agencyIntroduce['Agency']['code']:'';
	                        $data['Agency']['idAgencyIntroduce']= (!empty($agencyIntroduce['Agency']['id']))?$agencyIntroduce['Agency']['id']:'';

	                        $data['Agency']['slug']= createSlugMantan($dataSend['fullName'].' '.$data['Agency']['code'].' '.$dataSend['phone'].' '.$dataSend['cmnd'].' '.$dataSend['email']);
	                        $data['Agency']['fullName']= trim($dataSend['fullName']);
	                        $data['Agency']['email']= trim($dataSend['email']);
	                        $data['Agency']['phone']= trim($dataSend['phone']);
	                        $data['Agency']['cmnd']= trim($dataSend['cmnd']);
	                        $data['Agency']['address']= trim($dataSend['address']);
	                        $data['Agency']['note']= trim($dataSend['note']);
                            $data['Agency']['avatar']= trim($dataSend['avatar']);
                            $data['Agency']['contractNumber']= trim($dataSend['contractNumber']);
	                        $data['Agency']['contractFile']= trim($dataSend['contractFile']);
	                        $data['Agency']['idCity']= (int) $dataSend['idCity'];

	                        $data['Agency']['dateStart']['text']= $dataSend['dateStart'];
	                        $dateStart= explode('/', $dataSend['dateStart']);
	                        $data['Agency']['dateStart']['time']= mktime(0,0,0,$dateStart[1],$dateStart[0],$dateStart[2]);

	                        $numberBank= 0;
	                        $data['Agency']['bank']= array();
	                        for($i=1;$i<=3;$i++){
	                            if(!empty($dataSend['bankAccount'][$i]) && !empty($dataSend['bankNumber'][$i]) && !empty($dataSend['bankName'][$i]) && !empty($dataSend['bankBranch'][$i])){
	                                $numberBank++;
	                                $data['Agency']['bank'][$numberBank]['bankAccount']= $dataSend['bankAccount'][$i];
	                                $data['Agency']['bank'][$numberBank]['bankNumber']= $dataSend['bankNumber'][$i];
	                                $data['Agency']['bank'][$numberBank]['bankID']= $dataSend['bankName'][$i];
	                                $data['Agency']['bank'][$numberBank]['bankName']= $listBank[$dataSend['bankName'][$i]]['name'];
	                                $data['Agency']['bank'][$numberBank]['bankBranch']= $dataSend['bankBranch'][$i];
	                            }
	                        }

	                        $numberBank= 0;
	                        $data['Agency']['addressTo']= array();
	                        for($i=1;$i<=5;$i++){
	                            if(!empty($dataSend['addressName'][$i]) && !empty($dataSend['addressPhone'][$i]) && !empty($dataSend['addressAdd'][$i])){
	                                $numberBank++;
	                                $data['Agency']['addressTo'][$numberBank]['name']= $dataSend['addressName'][$i];
	                                $data['Agency']['addressTo'][$numberBank]['phone']= $dataSend['addressPhone'][$i];
	                                $data['Agency']['addressTo'][$numberBank]['address']= $dataSend['addressAdd'][$i];
	                            }
	                        }

	                        if($modelAgency->save($data)){
	                            $mess= 'Lưu thành công';
	                            $idAgency= $modelAgency->getLastInsertId();

	                            $saveLog['Log']['time']= time();
	                            $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' tạo tài khoản đại lý mới có mã: '.$data['Agency']['code'];
	                            $modelLog->save($saveLog);

	                            // cộng hàng vào kho ảo của đại lý
	                            $saveWarehouse= array();
	                            $saveWarehouse['Warehouse']['idAgency']= $idAgency;
	                            $saveWarehouse['Warehouse']['codeAgency']= $data['Agency']['code'];
	                            $saveWarehouse['Warehouse']['idWarehous']= $dataSend['idWarehous'];

	                            if(!empty($listProduct)){
	                                foreach($listProduct as $product){
	                                    if(!empty($dataSend['product'][$product['Product']['id']])){
	                                        $numberProduct= (int) str_replace('.', '', $dataSend['product'][$product['Product']['id']]);

	                                        $saveWarehouse['Warehouse']['product'][$product['Product']['id']]['id']= $product['Product']['id'];
	                                        $saveWarehouse['Warehouse']['product'][$product['Product']['id']]['name']= $product['Product']['name'];
	                                        $saveWarehouse['Warehouse']['product'][$product['Product']['id']]['quantily'] = $numberProduct;
	                                        $saveWarehouse['Warehouse']['product'][$product['Product']['id']]['price']= array(array('quantily'=>$numberProduct,'price'=>$product['Product']['priceAgency'][$dataSend['level']]));

	                                        $saveAgency['$inc']['product.'.$product['Product']['id']]= $numberProduct;
	                                    }
	                                }
	                            }

	                            $modelWarehouse->save($saveWarehouse);

	                            // cập nhập số hàng hóa vào tài khoản của đại lý
	                            if(!empty($saveAgency)){
	                                $conditionsAgency= array('_id'=>new MongoId($idAgency));
	                                $modelAgency->create();
	                                $modelAgency->updateAll($saveAgency,$conditionsAgency); 
	                            }
	                        }else{
	                            $mess= 'Lưu thất bại';
	                        }
	                    }else{
	                    	$mess= 'Số điện thoại này đã được sử dụng';
	                    }
                    }else{
                        $mess= 'Bạn không được để trống tên đại lý hoặc số điện thoại';
                    }
                }   
                setVariable('mess',$mess);
                setVariable('listCity',getListCity());
                setVariable('listTypeAgency',getListAgency());
                setVariable('listBank',$listBank);
                setVariable('listProduct',$listProduct);
                setVariable('listWarehous',$modelOption->getOption('listWarehouseGavi'));
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }

    function editAgency($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        $metaTitleMantan= 'Thông tin đại lý';

        $modelAgency= new Agency();
        $modelLog= new Log();

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('editAgency', $_SESSION['infoStaff']['Staff']['permission']))){
                if(!empty($_GET['id'])){
                    $mess= '';
                    $data= $modelAgency->getAgency($_GET['id']);
                    $listBank= getListBank();

                    if ($isRequestPost) {
                        $dataSend= arrayMap($input['request']->data);
                        
                        if(!empty(trim($dataSend['fullName']))){

                            if(!empty($dataSend['pass'])){
                                $data['Agency']['pass']= md5($dataSend['pass']);
                            }

                            $data['Agency']['slug']= createSlugMantan($dataSend['fullName'].' '.$data['Agency']['code'].' '.$data['Agency']['phone'].' '.$dataSend['cmnd'].' '.$dataSend['email']);
                            $data['Agency']['fullName']= trim($dataSend['fullName']);
                            $data['Agency']['email']= trim($dataSend['email']);
                            //$data['Agency']['phone']= trim($dataSend['phone']);
                            $data['Agency']['cmnd']= trim($dataSend['cmnd']);
                            $data['Agency']['address']= trim($dataSend['address']);
                            $data['Agency']['note']= trim($dataSend['note']);
                            $data['Agency']['avatar']= trim($dataSend['avatar']);
                            $data['Agency']['idCity']= (int) $dataSend['idCity'];
                            $data['Agency']['contractNumber']= trim($dataSend['contractNumber']);
                            $data['Agency']['contractFile']= trim($dataSend['contractFile']);

                            $numberBank= 0;
                            $data['Agency']['bank']= array();
                            for($i=1;$i<=3;$i++){
                                if(!empty($dataSend['bankAccount'][$i]) && !empty($dataSend['bankNumber'][$i]) && !empty($dataSend['bankName'][$i]) && !empty($dataSend['bankBranch'][$i])){
                                    $numberBank++;
                                    $data['Agency']['bank'][$numberBank]['bankAccount']= $dataSend['bankAccount'][$i];
                                    $data['Agency']['bank'][$numberBank]['bankNumber']= $dataSend['bankNumber'][$i];
                                    $data['Agency']['bank'][$numberBank]['bankID']= $dataSend['bankName'][$i];
                                    $data['Agency']['bank'][$numberBank]['bankName']= $listBank[$dataSend['bankName'][$i]]['name'];
                                    $data['Agency']['bank'][$numberBank]['bankBranch']= $dataSend['bankBranch'][$i];
                                }
                            }

                            $numberBank= 0;
                            $data['Agency']['addressTo']= array();
                            for($i=1;$i<=5;$i++){
                                if(!empty($dataSend['addressName'][$i]) && !empty($dataSend['addressPhone'][$i]) && !empty($dataSend['addressAdd'][$i])){
                                    $numberBank++;
                                    $data['Agency']['addressTo'][$numberBank]['name']= $dataSend['addressName'][$i];
                                    $data['Agency']['addressTo'][$numberBank]['phone']= $dataSend['addressPhone'][$i];
                                    $data['Agency']['addressTo'][$numberBank]['address']= $dataSend['addressAdd'][$i];
                                }
                            }

                            if($modelAgency->save($data)){
                                $mess= 'Lưu thành công';

                                $saveLog['Log']['time']= time();
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' sửa tài khoản đại lý có mã: '.$data['Agency']['code'];
                                $modelLog->save($saveLog);
                            }else{
                                $mess= 'Lưu thất bại';
                            }
                        }else{
                            $mess= 'Bạn không được để trống tên đại lý';
                        }
                    }   
                    setVariable('mess',$mess);
                    setVariable('data',$data);
                    setVariable('listCity',getListCity());
                    setVariable('listBank',$listBank);
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

    function getAgencyAPI($input)
    {
        $modelAgency= new Agency();
        $dataSend= arrayMap($input['request']->data);
        $agency= array();
        $listAgency= array();
        if(!empty($dataSend['idAgency'])){
            $listAgency= getListAgency();
            $listCity= getListCity();

            $agency= $modelAgency->getAgency($dataSend['idAgency']);
            $agency['Agency']['level']= $listAgency[$agency['Agency']['level']]['name'];
            $agency['Agency']['idCity']= $listCity[$agency['Agency']['idCity']]['name'];
            $agency['Agency']['wallet']['activeNumber']= number_format(@$agency['Agency']['wallet']['deposit']+@$agency['Agency']['wallet']['purchaseFund']+$agency['Agency']['wallet']['active']-@$agency['Agency']['wallet']['penalties']);


            //$listAgency= $modelAgency->find('all',array('fields'=>array('fullName','code'),'conditions'=>array('idAgencyFather'=>$dataSend['idAgency'],'status'=>'active')));
        }
        echo json_encode(array('agency'=>$agency));
    }

    function lockAgency($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Khóa đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('lockAgency', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelAgency= new Agency();
                $modelLog= new Log();
                $modelStaff= new Staff();

                if($isRequestPost && !empty($dataSend['id']) && !empty($dataSend['pass'])){
                    $userByFone  = $modelStaff->checkLogin($_SESSION['infoStaff']['Staff']['code'],$dataSend['pass']);
                    if($userByFone){
                        $listAgency= $modelAgency->find('all',array('fields'=>array('fullName','code'),'conditions'=>array('idAgencyFather'=>$dataSend['id'],'status'=>'active')));
                        if($listAgency){
                            $modelOption->redirect($urlHomes.'listAgency?status=deleteAgencyFail2');
                        }else{
                            $save['$set']['status']= 'lock';
                            $dk= array('_id'=> new MongoId($dataSend['id']));
                            if($modelAgency->updateAll($save,$dk)){
                                // lưu lịch sử tạo sản phẩm
                                $saveLog['Log']['time']= time();
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' khóa đại lý có ID là '.$dataSend['id'];
                                $modelLog->save($saveLog);

                                $modelOption->redirect($urlHomes.'listAgency?status=deleteAgencyDone');
                            }else{
                                $modelOption->redirect($urlHomes.'listAgency?status=deleteAgencyFail');
                            }
                        }
                    }else{
                        $modelOption->redirect($urlHomes.'listAgency?status=deleteAgencyFailPass');
                    }

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

    function changeAgency($input)
    {
        global $modelOption;
        global $urlHomes;
        global $isRequestPost;
        global $metaTitleMantan;
        global $urlNow;
        $metaTitleMantan= 'Điều chuyển đại lý';

        if(!empty($_SESSION['infoStaff'])){
            if((isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin') || (isset($_SESSION['infoStaff']['Staff']['permission']) &&in_array('changeAgency', $_SESSION['infoStaff']['Staff']['permission']))){
                $dataSend= $input['request']->data;
                $mess= '';
                $modelAgency= new Agency();
                $modelLog= new Log();
                $modelHistoryagency= new Historyagency();
                $modelStaff= new Staff();

                if($isRequestPost){
                    $userByFone  = $modelStaff->checkLogin($_SESSION['infoStaff']['Staff']['code'],$dataSend['pass']);
                    if($userByFone){
                        $agencyFrom= $modelAgency->getAgencyByCode($dataSend['codeAgencyFrom'],array('code','level','phone','status'));

                        if(!empty($dataSend['codeAgencyTo'])){
                            $agencyTo= $modelAgency->getAgencyByCode($dataSend['codeAgencyTo'],array('code','level','phone','status'));

                            if($agencyTo && $agencyFrom){
                                if($agencyTo['Agency']['status']=='active' && $agencyFrom['Agency']['status']=='active'){
                                    if($agencyTo['Agency']['level']<=$agencyFrom['Agency']['level']){
                                        $saveAgencyFrom['$set']['codeAgencyFather']= $agencyTo['Agency']['code'];
                                        $saveAgencyFrom['$set']['idAgencyFather']= $agencyTo['Agency']['id'];
                                    }else{
                                        $mess= 'Chuyển đại lý thất bại do cấp độ đại lý '.$agencyTo['Agency']['code'].' thấp hơn cấp độ đại lý '.$agencyFrom['Agency']['code'];
                                    }
                                }else{
                                    $mess= 'Tài khoản của một trong hai đại lý đang bị khóa nên không thực hiện điều chuyển được';
                                }
                            }else{
                                $mess= 'Tài khoản của một trong hai đại lý không tồn tại nên không thực hiện điều chuyển được';
                            }

                        }else{
                            $saveAgencyFrom['$set']['codeAgencyFather']= '';
                            $saveAgencyFrom['$set']['idAgencyFather']= '';
                        }

                        if(!empty($saveAgencyFrom)){
                            $conditionsAgencyFrom= array('code'=>strtoupper(trim($dataSend['codeAgencyFrom'])));
                            if($modelAgency->updateAll($saveAgencyFrom,$conditionsAgencyFrom)){
                               
                                // lưu lịch sử tạo sản phẩm
                                $nameAgencyTo= (!empty($agencyTo))?$agencyTo['Agency']['phone'].' - '.$agencyTo['Agency']['code']:'Công ty';
                                $saveLog['Log']['time']= time();
                                $saveLog['Log']['content']= $_SESSION['infoStaff']['Staff']['code'].' chuyển đại lý '.$dataSend['codeAgencyFrom'].' về cho '.$nameAgencyTo;
                                $modelLog->save($saveLog);

                                $saveLogHistory['Historyagency']['time']= time();
                                $saveLogHistory['Historyagency']['idAgency']= @$agencyFrom['Agency']['id'];
                                $saveLogHistory['Historyagency']['codeAgency']= @$agencyFrom['Agency']['code'];
                                $saveLogHistory['Historyagency']['phoneAgency']= @$agencyFrom['Agency']['phone'];
                                $saveLogHistory['Historyagency']['content']= 'Thay đổi đại lý cha, đại lý cha mới là '.$nameAgencyTo;
                                $modelHistoryagency->save($saveLogHistory);

                                $mess= 'Chuyển đại lý thành công';
                            }else{
                                $mess= 'Lỗi hệ thống';
                            }
                        }else{
                            if(empty($mess)) $mess= 'Chuyển đại lý thất bại';
                        }
                    }else{
                        $mess= 'Nhập sai mật khẩu admin';
                    }
                }

                setVariable('mess',$mess);
            }else{
                $modelOption->redirect($urlHomes.'dashboard');
            }
        }else{
            $modelOption->redirect($urlHomes.'admin?status=-2');
        }
    }
 // -----------------------------------------------------------------------------------------------------------
    function login($input)
    {
        global $contactSite;
        global $isRequestPost;
        global $urlHomes;

        $modelAgency= new Agency();

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency->redirect($urlHomes.'dashboardAgency');
        }else{
            $mess= '';

            if(!empty($_GET['status'])){
                switch ($_GET['status']) {
                    case 'createDone':$mess= 'Tạo tài khoản thành công, mời bạn đăng nhập';break;
                    case '-2':$mess= 'Bạn đã bị đăng xuất, hãy đăng nhập lại';break;
                }
            }
            
            if(!empty($_GET['forgetPass'])){
                if($_GET['forgetPass']==1){
                    $mess= "Lấy lại mật khẩu thành công";
                }
            }
            if($isRequestPost){
                $dataSend= $input['request']->data;

                if(!empty($dataSend['phone']) && !empty($dataSend['pass'])){
                    $userByFone  = $modelAgency->checkLogin($dataSend['phone'],$dataSend['pass']);

                    if($userByFone){
                        $listAgency= getListAgency();
                        $userByFone['Agency']['nameLevel']= $listAgency[$userByFone['Agency']['level']]['name'];
                        $_SESSION['infoAgency']= $userByFone;
                        $_SESSION['CheckAuthentication']= true;
                        $_SESSION['urlBaseUpload']= '/app/webroot/upload/agency/'.$userByFone['Agency']['code'].'/';

                        $modelAgency->redirect($urlHomes.'dashboardAgency');
                    }else{
                        $mess= 'Sai số điện thoại đại lý hoặc mật khẩu';
                    }
                }else{
                    $mess= 'Không được để trống số điện thoại đại lý hoặc mật khẩu';
                }
            }

            setVariable('mess',$mess);
        }
    } 

    function forgetPassAgency($input)
    {
        global $contactSite;
        global $isRequestPost;
        global $urlHomes;

        $modelAgency= new Agency();

        if(!empty($_SESSION['infoAgency'])){
            $modelAgency->redirect($urlHomes.'dashboardAgency');
        }else{
            $mess= '';
            
            if($isRequestPost){
                $dataSend= $input['request']->data;

                if(!empty($dataSend['phone'])){
                    $userByFone  = $modelAgency->getAgencyByPhone($dataSend['phone']);

                    if(!empty($userByFone['Agency']['email'])){
                        $userByFone['Agency']['codeForgetPass']= rand(100000,999999);
                        $modelAgency->save($userByFone);

                        // Gửi email thông báo
                        $from=array($contactSite['Option']['value']['email']);
                        $to=array($userByFone['Agency']['email']);
                        $cc=array();
                        $bcc=array();
                        $subject='[Gavi] Mã cấp lại mật khẩu';
                        $content= ' <p>Xin chào '.$userByFone['Agency']['fullName'].' !</p>
                        <br/>Thông tin đăng nhập của bạn là:<br/>
                        Tên đăng nhập: '.$dataSend['phone'].'<br/>
                        Bạn vui lòng nhập mã sau để lấy lại mật khẩu: <b>'.$userByFone['Agency']['codeForgetPass'].'</b><br>
                        Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a><br/>';

                        $modelAgency->sendMail($from,$to,$cc,$bcc,$subject,$content);

                        $modelAgency->redirect($urlHomes.'forgetPassAgencyProcess?phone='.$dataSend['phone']);
                    }else{
                        $mess= 'Sai số điện thoại đại lý hoặc mật khẩu';
                    }
                }else{
                    $mess= 'Không được để trống số điện thoại đại lý hoặc mật khẩu';
                }
            }

            setVariable('mess',$mess);
        }
    } 

    function forgetPassAgencyProcess($input)
    {
        $modelAgency= new Agency();
        global $contactSite;
        global $urlHomes;
        global $isRequestPost;
        $mess= 'Hệ thống đã gửi mã lấy lại mật khẩu về email, quý khách vui lòng kiểm tra email';

        if($isRequestPost){
            $dataSend= $input['request']->data;
            $data= $modelAgency->getAgencyByPhone($dataSend['phone']);

            if($data['Agency']['email'] && isset($data['Agency']['codeForgetPass']) && $data['Agency']['codeForgetPass']==$dataSend['codeForgetPass']){

                $save['$set']['pass']= md5($dataSend['pass']);
                if (md5($dataSend['codeForgetPass'])!=md5($dataSend['pass'])) {
                    $save['$unset']['codeForgetPass']= true;
                    $dk= array('_id'=>new MongoId($data['Agency']['id']));
                    if($modelAgency->updateAll($save,$dk)){
                        // Gửi email thông báo
                        $from=array($contactSite['Option']['value']['email']);
                        $to=array($data['Agency']['email']);
                        $cc=array();
                        $bcc=array();
                        $subject='[Gavi] Lấy mật khẩu thành công';
                        $content= ' <p>Xin chào '.$data['Agency']['fullName'].' !</p>
                        <br/>Thông tin đăng nhập của bạn là:<br/>
                        Tên đăng nhập: '.$dataSend['phone'].'<br>
                        Mật khẩu mới của bạn là: <b>'.$dataSend['pass'].'</b><br>
                        Link đăng nhập tại: <a href="'.$urlHomes.'login">'.$urlHomes.'login </a>';

                        $modelAgency->sendMail($from,$to,$cc,$bcc,$subject,$content);
                        $modelAgency->redirect($urlHomes.'login?forgetPass=1');
                    }else{
                        $mess= "Lưu thất bại";
                    }
                }else{
                    $mess= "Không nhập mật khẩu mới trùng với mã lấy lại mật khẩu";
                }
            }else{
                $mess= "Sai tài khoản hoặc sai mã xác nhận";
            }
        }

        setVariable('mess',$mess);
    }

    function logoutAgency($input)
    {
        global $urlHomes;
        $modelStaff= new Staff();

        session_destroy();
        $modelStaff->redirect('/login');
    }

    function dashboardAgency($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Trang chủ';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $mess= '';

            if(!empty($_GET['status'])){
                switch ($_GET['status']) {
                    case 'updateLevelDone':$mess= 'Bạn đã gửi yêu cầu nâng cấp đại lý thành công, vui lòng chờ phê duyệt.';break;
                    case 'updateLevelFail':$mess= 'Gửi yêu cầu nâng cấp đại lý thất bại.';break;
                }
            }

            setVariable('mess',$mess);
            setVariable('tabFooter','dashboardAgency');
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function agency($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách đại lý trực thuộc';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $conditions= array('idAgencyFather'=>$_SESSION['infoAgency']['Agency']['id'],'status'=>'active','fullName'=>array('$ne'=>''));

            if(!empty($_GET['phone'])){
                $conditions['phone']= strtoupper($_GET['phone']);
            }

            if(!empty($_GET['level'])){
                $conditions['level']= (int) $_GET['level'];
            }

            if(!empty($_GET['fullName'])){
                $conditions['slug']=array('$regex' => createSlugMantan(trim($_GET['fullName'])));
            }

            $listData= $modelAgency->find('all',array('fields'=>array('fullName','code','avatar','phone','level','dateStart'),'conditions'=>$conditions));

            setVariable('listData',$listData);
            setVariable('listLevelAgency',getListAgency());
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function detailAgency($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Thông tin đại lý';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $modelProduct= new Product();

            if(!empty($_GET['id'])){
                $data= $modelAgency->getAgency($_GET['id']);
                if($data){
                    $listProduct= array();
                    if(!empty($data['Agency']['product'])){
                        foreach($data['Agency']['product'] as $idProduct=>$quantity){
                            $product= $modelProduct->getProduct($idProduct,array('name','code','image','unit'));
                            if($product){
                                $listProduct[]= array(  'name'=>$product['Product']['name'],
                                                        'code'=>$product['Product']['code'],
                                                        'image'=>$product['Product']['image'],
                                                        'unit'=>$product['Product']['unit'],
                                                        'quantity'=>$quantity,
                                                    ); 
                            }
                        }
                    }

                    setVariable('listProduct',$listProduct);
                    setVariable('data',$data);
                    setVariable('listLevelAgency',getListAgency());
                }else{
                    $modelStaff->redirect($urlHomes.'agency');
                }
            }else{
                $modelStaff->redirect($urlHomes.'agency');
            }
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function agencySub($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Danh sách đại lý phân phối';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $conditions= array('idAgencyFather'=>$_SESSION['infoAgency']['Agency']['id'],'status'=>'active','fullName'=>array('$ne'=>''));

            $listData= $modelAgency->find('all',array('fields'=>array('fullName','code','avatar','phone','level','dateStart'),'conditions'=>$conditions));

            $listData= getTreeAgency($listData);

            setVariable('listData',$listData);
            setVariable('listLevelAgency',getListAgency());
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function createAgency($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $isRequestPost;
        $metaTitleMantan= 'Tạo tài khoản đại lý';
        session_destroy();
        
        $modelAgency= new Agency();
        if(!empty($_GET['id']) & !empty($_GET['idQrcode'])){
            $data= $modelAgency->getAgency($_GET['id']);
            $mess= '';

            if($data && $data['Agency']['idQrcode']==$_GET['idQrcode'] && $data['Agency']['fullName']==''){
                setVariable('data',$data);
                setVariable('listCity',getListCity());

                if($isRequestPost){
                    $dataSend= arrayMap($input['request']->data);
                    if(!empty($dataSend['pass']) && $dataSend['pass']==$dataSend['passAgain']){
                        if(!empty(trim($dataSend['fullName'])) && !empty($dataSend['phone'])){
                        	$checkUserPhone= $modelAgency->getAgencyByPhone(trim($dataSend['phone']),array('code'));

                        	if(empty($checkUserPhone)){
	                            $data['Agency']['pass']= md5($dataSend['pass']);
	                            $data['Agency']['slug']= createSlugMantan($dataSend['fullName'].' '.$data['Agency']['code'].' '.$dataSend['phone'].' '.$dataSend['cmnd'].' '.$dataSend['email']);
	                            $data['Agency']['fullName']= trim($dataSend['fullName']);
	                            $data['Agency']['email']= trim($dataSend['email']);
	                            $data['Agency']['phone']= trim($dataSend['phone']);
	                            $data['Agency']['cmnd']= trim($dataSend['cmnd']);
	                            $data['Agency']['address']= trim($dataSend['address']);
	                            $data['Agency']['note']= trim($dataSend['note']);
	                            $data['Agency']['idCity']= (int) $dataSend['idCity'];

	                            if($modelAgency->save($data)){
	                                $modelAgency->redirect($urlHomes.'login?status=createDone&phone='.$data['Agency']['phone']);
	                            }else{
	                                $mess= 'Lưu thất bại';
	                            }
	                        }else{
	                        	$mess= 'Số điện thoại đã được sử dụng, vui lòng nhập số khác';
	                        }
                        }else{
                            $mess= 'Bạn không được để trống tên đại lý hoặc số điện thoại';
                        }
                    }else{
                        $mess= 'Mật khẩu nhập lại không chính xác';
                    }
                }

                setVariable('mess',$mess);
            }else{
                $modelAgency->redirect($urlHomes);
            }
        }else{
            $modelAgency->redirect($urlHomes);
        }
    }

    function account($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Cài đặt tài khoản';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            setVariable('tabFooter','account');
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function shield($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        $metaTitleMantan= 'Chứng nhận đại lý';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $listAgency= getListAgency();
            $im = ImageCreateFromJpeg(__DIR__."/../view/agency/img/shield.jpg"); // Link ảnh gốc
            
            $string = $_SESSION['infoAgency']['Agency']['fullName']; // Dòng chữ muốn in lên hình
            $pxX = 470; // Tạo độ X của chữ
            $pxY = 830; // Tạo độ Y của chữ
            $fontsize = "20"; // Cỡ chữ
            $color = ImageColorAllocate($im, 0, 0, 0); // Màu chữ
            $font = __DIR__."/../view/agency/font/arial.ttf"; // Font chữ
            imagettftext($im, $fontsize, 0, $pxX, $pxY, $color, $font, $string); // hàm viết chữ lên hình ImagettfText(Link ảnh gốc, Font size, độ nghiêng, tạo độ X , tạo độ Y, Màu, Font, Chữ muốn in)

            $string = $listAgency[$_SESSION['infoAgency']['Agency']['level']]['name']; // Dòng chữ muốn in lên hình
            $pxX = 510; // Tạo độ X của chữ
            $pxY = 890; // Tạo độ Y của chữ
            imagettftext($im, $fontsize, 0, $pxX, $pxY, $color, $font, $string); // hàm viết chữ lên hình ImagettfText(Link ảnh gốc, Font size, độ nghiêng, tạo độ X , tạo độ Y, Màu, Font, Chữ muốn in)

            $string = $_SESSION['infoAgency']['Agency']['code']; // Dòng chữ muốn in lên hình
            $pxX = 510; // Tạo độ X của chữ
            $pxY = 935; // Tạo độ Y của chữ
            imagettftext($im, $fontsize, 0, $pxX, $pxY, $color, $font, $string); // hàm viết chữ lên hình ImagettfText(Link ảnh gốc, Font size, độ nghiêng, tạo độ X , tạo độ Y, Màu, Font, Chữ muốn in)

            $string = @$_SESSION['infoAgency']['Agency']['contractNumber']; // Dòng chữ muốn in lên hình
            $pxX = 535; // Tạo độ X của chữ
            $pxY = 985; // Tạo độ Y của chữ
            imagettftext($im, $fontsize, 0, $pxX, $pxY, $color, $font, $string); // hàm viết chữ lên hình ImagettfText(Link ảnh gốc, Font size, độ nghiêng, tạo độ X , tạo độ Y, Màu, Font, Chữ muốn in)

            $string = $_SESSION['infoAgency']['Agency']['fullName']; // Dòng chữ muốn in lên hình
            $pxX = 410; // Tạo độ X của chữ
            $pxY = 1090; // Tạo độ Y của chữ
            imagettftext($im, $fontsize, 0, $pxX, $pxY, $color, $font, $string); // hàm viết chữ lên hình ImagettfText(Link ảnh gốc, Font size, độ nghiêng, tạo độ X , tạo độ Y, Màu, Font, Chữ muốn in)

            imagePng($im,'upload/shield/'.$_SESSION['infoAgency']['Agency']['code'].'.png'); // Tiến hành tạo file ảnh mới có tên 66.png và cho chữ rõ hơn hàm imagejpeg()
            ImageDestroy($im);
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function profile($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $isRequestPost;
        $metaTitleMantan= 'Thông tin tài khoản';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $data= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id']);
            $mess= '';
            $listAgency= getListAgency();

            if($isRequestPost){
                $dataSend= arrayMap($input['request']->data);
                
                if(!empty(trim($dataSend['fullName']))){
                    $data['Agency']['slug']= createSlugMantan($dataSend['fullName'].' '.$data['Agency']['code'].' '.$data['Agency']['phone'].' '.$dataSend['cmnd'].' '.$dataSend['email']);
                    $data['Agency']['fullName']= trim($dataSend['fullName']);
                    $data['Agency']['email']= trim($dataSend['email']);
                    //$data['Agency']['phone']= trim($dataSend['phone']);
                    $data['Agency']['cmnd']= trim($dataSend['cmnd']);
                    $data['Agency']['imageCmnd']= trim($dataSend['imageCmnd']);
                    $data['Agency']['avatar']= trim($dataSend['avatar']);
                    $data['Agency']['address']= trim($dataSend['address']);
                    $data['Agency']['note']= trim($dataSend['note']);
                    $data['Agency']['idCity']= (int) $dataSend['idCity'];

                    if($modelAgency->save($data)){
                        $mess= 'Lưu thông tin thành công';
                    }else{
                        $mess= 'Lưu thất bại';
                    }
                }else{
                    $mess= 'Bạn không được để trống tên đại lý';
                }
            }

            setVariable('data',$data);
            setVariable('mess',$mess);
            setVariable('listCity',getListCity());
            setVariable('listAgency',$listAgency);

            $data['Agency']['nameLevel']= $listAgency[$data['Agency']['level']]['name'];
            $_SESSION['infoAgency']= $data;
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function address($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $isRequestPost;
        $metaTitleMantan= 'Cài đặt địa chỉ';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $data= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id']);
            $mess= '';

            if($isRequestPost){
                $dataSend= arrayMap($input['request']->data);
                
                $numberBank= 0;
                $data['Agency']['addressTo']= array();
                for($i=1;$i<=5;$i++){
                    if(!empty($dataSend['addressName'][$i]) && !empty($dataSend['addressPhone'][$i]) && !empty($dataSend['addressAdd'][$i])){
                        $numberBank++;
                        $data['Agency']['addressTo'][$numberBank]['name']= $dataSend['addressName'][$i];
                        $data['Agency']['addressTo'][$numberBank]['phone']= $dataSend['addressPhone'][$i];
                        $data['Agency']['addressTo'][$numberBank]['address']= $dataSend['addressAdd'][$i];
                    }
                }

                if($modelAgency->save($data)){
                    $mess= 'Lưu thông tin thành công';

                    $_SESSION['infoAgency']['Agency']['addressTo']= $data['Agency']['baddressToank'];
                }else{
                    $mess= 'Lưu thất bại';
                }

                $_SESSION['infoAgency']= $data;
            }

            setVariable('data',$data);
            setVariable('mess',$mess);
            setVariable('listCity',getListCity());

            $_SESSION['infoAgency']= $data;
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function bank($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $isRequestPost;
        $metaTitleMantan= 'Cài đặt tài khoản ngân hàng';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $data= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id']);
            $mess= '';
            $listBank= getListBank();

            if(!empty($_GET['redirect']) && $_GET['redirect']=='pay'){
                $mess= 'Bạn cần điền thông tin tài khoản ngân hàng mới có thể đặt lệnh rút tiền';
            }

            if($isRequestPost){
                $dataSend= arrayMap($input['request']->data);
                
                $numberBank= 0;
                $data['Agency']['bank']= array();
                for($i=1;$i<=3;$i++){
                    if(!empty($dataSend['bankAccount'][$i]) && !empty($dataSend['bankNumber'][$i]) && !empty($dataSend['bankName'][$i]) && !empty($dataSend['bankBranch'][$i])){
                        $numberBank++;
                        $data['Agency']['bank'][$numberBank]['bankAccount']= $dataSend['bankAccount'][$i];
                        $data['Agency']['bank'][$numberBank]['bankNumber']= $dataSend['bankNumber'][$i];
                        $data['Agency']['bank'][$numberBank]['bankID']= $dataSend['bankName'][$i];
                        $data['Agency']['bank'][$numberBank]['bankName']= $listBank[$dataSend['bankName'][$i]]['name'];
                        $data['Agency']['bank'][$numberBank]['bankBranch']= $dataSend['bankBranch'][$i];
                    }
                }

                if($modelAgency->save($data)){
                    $mess= 'Lưu thông tin thành công';

                    $_SESSION['infoAgency']['Agency']['bank']= $data['Agency']['bank'];
                }else{
                    $mess= 'Lưu thất bại';
                }

                $_SESSION['infoAgency']= $data;
            }

            setVariable('data',$data);
            setVariable('mess',$mess);
            setVariable('listBank',$listBank);

            $_SESSION['infoAgency']= $data;
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function changePassword($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $isRequestPost;
        $metaTitleMantan= 'Đổi mật khẩu';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $data= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id']);
            $mess= '';

            if($isRequestPost){
                $dataSend= arrayMap($input['request']->data);
                
                if(!empty($dataSend['pass']) && !empty($dataSend['passAgain'])){
                    if($dataSend['pass']==$dataSend['passAgain']){
                        if(md5($dataSend['passOld'])==$data['Agency']['pass']){
                            $data['Agency']['pass']= md5($dataSend['pass']);

                            if($modelAgency->save($data)){
                                $mess= 'Lưu thông tin thành công';
                            }else{
                                $mess= 'Lưu thất bại';
                            }
                        }else{
                            $mess= 'Mật khẩu cũ không chính xác';
                        }
                    }else{
                        $mess= 'Mật khẩu nhập lại chưa chính xác';
                    }
                }else{
                    $mess= 'Không được để trống mật khẩu';
                }

                $_SESSION['infoAgency']= $data;
            }

            setVariable('mess',$mess);

            $_SESSION['infoAgency']= $data;
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }

    function saveRequestLevel($input)
    {
        global $urlHomes;
        global $metaTitleMantan;
        global $modelOption;
        global $metaTitleMantan;
        global $isRequestPost;
        $metaTitleMantan= 'Lưu yêu cầu lên cấp';

        $modelStaff= new Staff();
        if(!empty($_SESSION['infoAgency'])){
            $modelAgency= new Agency();
            $modelLevel= new Level();

            $agencyFather= array();
            $agency= $modelAgency->getAgency($_SESSION['infoAgency']['Agency']['id']);
            if(!empty($agency['Agency']['idAgencyFather'])){
                $agencyFather= $modelAgency->getAgency($agency['Agency']['idAgencyFather']);
            }
            $mess= '';

            if($isRequestPost){
                $dataSend= arrayMap($input['request']->data);
                
                $checkData= $modelLevel->getLevelByAgency($_SESSION['infoAgency']['Agency']['id']);

                $checkData['Level']['idAgency']= $_SESSION['infoAgency']['Agency']['id'];
                $checkData['Level']['codeAgency']= $_SESSION['infoAgency']['Agency']['code'];
                $checkData['Level']['phoneAgency']= $_SESSION['infoAgency']['Agency']['phone'];
                $checkData['Level']['levelOld']= $_SESSION['infoAgency']['Agency']['level'];
                $checkData['Level']['levelNew']= (int) $dataSend['levelNew'];
                $checkData['Level']['timeCreate']= time();
                $checkData['Level']['status']= 'new';

                if(!empty($agencyFather['Agency']['level']) && $agencyFather['Agency']['level']>=$dataSend['levelNew']){
                    $checkData['Level']['idAgencyFather']= $agencyFather['Agency']['id'];
                    $checkData['Level']['codeAgencyFather']= $agencyFather['Agency']['code'];
                }

                if($modelLevel->save($checkData)){
                    $modelStaff->redirect($urlHomes.'dashboardAgency?status=updateLevelDone');
                }else{
                    $modelStaff->redirect($urlHomes.'dashboardAgency?status=updateLevelFail');
                }
            }
        }else{
            $modelStaff->redirect($urlHomes.'login?status=-2');
        }
    }
?>