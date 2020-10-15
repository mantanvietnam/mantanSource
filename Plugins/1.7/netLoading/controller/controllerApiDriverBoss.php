<?php
function updateInfoDriverAPI($input)
{
    $modelCustomer= new Customer();
    $modelDriver= new Driver();
    $modelHistory= new History();

    $dataSend = $input['request']->data;
    $dataUser = $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    if($dataUser){
        $dataUser['Customer']['fullName'] = $dataSend['fullName'];
        $dataUser['Customer']['email'] = $dataSend['email'];
        $dataUser['Customer']['fax'] = $dataSend['fax'];
        $dataUser['Customer']['company']['name'] = $dataSend['nameCompany'];
        $dataUser['Customer']['company']['address'] = $dataSend['addressCompany'];
        $dataUser['Customer']['company']['tax'] = $dataSend['taxCompany'];
        $dataUser['Customer']['company']['gps'] = $dataSend['gpsCompany'];

        // cap nhap toa do nha xe cho lai xe
        $dk= array('idUser'=>$dataUser['Customer']['id']);
        $saveDriver['$set']['gpsCityEnd']= $dataSend['gpsCompany'];

        // cap nhap toa do nha xe cho xe trong hang
        $dk2= array('idDriverBoss'=>$dataUser['Customer']['id']);
        $saveHistory['$set']['gpsCityEnd']= $dataSend['gpsCompany'];
        

        if($modelCustomer->save($dataUser)){
            $modelHistory->updateAll($saveHistory,$dk2);
            $modelDriver->updateAll($saveDriver,$dk);

            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);

}

function checkRegisterDriverAPI($input)
{
    $modelCustomer= new Customer();
    $listData = array();
    $dataSend= $input['request']->data;
    global $contactSite;

    if(!empty($dataSend['fullName']) &&
        !empty($dataSend['email']) &&
        !empty($dataSend['fone']) &&
        !empty($dataSend['pass']) &&
        !empty($dataSend['passAgain']) &&
        !empty($dataSend['addressCompany']) &&
        !empty($dataSend['gpsCompany'])
    ){
        $today= getdate();

        if($dataSend['pass'] != $dataSend['passAgain']){
            $return= array('code'=>2);
        }else{
            //$checkAccEmail= $modelCustomer->getCustomerByEmail($dataSend['email']);
            $checkAccFone= $modelCustomer->getCustomerByFone($dataSend['fone']);

            if(empty($checkAccFone['Customer']['updateDriver'])){
	            if(!$checkAccFone) {
	                $checkAccFone['Customer']['fullName']= $dataSend['fullName'];
	                $checkAccFone['Customer']['email']= $dataSend['email'];
	                $checkAccFone['Customer']['fone']= $dataSend['fone'];
	                $checkAccFone['Customer']['pass']= md5($dataSend['pass']);
	                $checkAccFone['Customer']['chuxe']= false;
	            }

	            $checkAccFone['Customer']['company']['address'] = $dataSend['addressCompany'];
                $checkAccFone['Customer']['company']['gps'] = $dataSend['gpsCompany'];
                $checkAccFone['Customer']['updateDriver']= 'pending';

	            $modelCustomer->save($checkAccFone);
	            $return= array('code'=>0);

                // Gửi email thông báo
                $from=array($contactSite['Option']['value']['email']);
                $to=array($contactSite['Option']['value']['email'],$dataSend['email']);
                $cc=array();
                $bcc=array();
                $subject='[Netloading] Đăng ký tài khoản nhà xe';
                $content= ' <p>Xin chào '.$dataSend['fullName'].' !</p>

                            <p>Chúc mừng bạn đã đăng ký thành công tài khoản Chủ xe trên hệ thống Netloading, thông tin tài khoản như sau:</p>

                            <ul>
                                <li>App chủ xe: <a href=""></a></li>
                                <li>Tài khoản: '.$dataSend['fone'].'</li>
                                <li>Mật khẩu: '.$dataSend['pass'].'</li>
                                <li>Trạng thái: Chờ xét duyệt</li>
                            </ul>

                            ' . getSignatureEmail();

                $modelCustomer->sendMail($from,$to,$cc,$bcc,$subject,$content);
                $return= array('code'=>0);
        	}else{
        		$return= array('code'=>1);
        	}
        }
    }else{
        $return= array('code'=>3);
    }

    echo json_encode($return);
}

function checkLoginDriverAPI($input)
{
    $modelCustomer= new Customer();
    $listData = array();
    $dataSend= $input['request']->data;

    if(!empty($dataSend['account']) && !empty($dataSend['pass'])){
    	//$conditions= array('chuxe'=>true);
        $conditions= array();
    	$fields= null;

        $userByAccount  = $modelCustomer->checkLoginByAccount($dataSend['account'],$dataSend['pass'],$fields,$conditions);
        $userByFone     = $modelCustomer->checkLoginByFone($dataSend['account'],$dataSend['pass'],$fields,$conditions);
        $accessToken = getGUID();
        if($userByAccount){
            if($userByAccount['Customer']['chuxe']){
                $userByAccount['Customer']['accessToken']= $accessToken;
                $return= array('code'=>0,'user'=>$userByAccount['Customer']);
                $modelCustomer->save($userByAccount);
            }else{
                $return= array('code'=>2,'user'=>array());
            }
        }
        elseif($userByFone){
            if($userByFone['Customer']['chuxe']){
                $userByFone['Customer']['accessToken']= $accessToken;
                $return= array('code'=>0,'user'=>$userByFone['Customer']);
                $modelCustomer->save($userByFone);
            }else{
                $return= array('code'=>2,'user'=>array());
            }
        }else{
            $return= array('code'=>1,'user'=>array());
        }
    }else{
        $return= array('code'=>1,'user'=>array());
    }

    echo json_encode($return);
}
// Quan ly xe oto
function getListCarAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelCar= new Car();
        $idUser= $dataUser['Customer']['id'];
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('idUser'=>$idUser, 'lock'=>array('$ne'=>true));
        $order = array('created' => 'desc');
        $fields= null;

        $listData= $modelCar->getPage($page, $limit , $conditions, $order, $fields );
        $return= array('code'=>1,'listData'=>$listData);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function saveCarAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelCar= new Car();
    $today= getdate();
    $modelCustomer= new Customer();
    $modelCarempty= new Carempty();

    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        if(!empty($dataSend['idCar'])){
            $save= $modelCar->getCar($dataSend['idCar']);
            $save['Car']['status']= $dataSend['status'];

            // update lại nhóm xe ở xe có sẵn
            $dk= array('idCar'=>$dataSend['idCar']);
            $listTypeCar= getListTypeCar();
            $updateCarempty['$set']['groupCar']= $listTypeCar[$dataSend['typeCar']]['group'];
            $modelCarempty->updateAll($updateCarempty,$dk);

        }else{
            $save['Car']['time']= $today[0];
            $save['Car']['lock']= false;
            $save['Car']['status']= true;
        }

        $save['Car']['typeCar']= (int)$dataSend['typeCar'];
        $save['Car']['weight']= (int)$dataSend['weight'];
        $save['Car']['typeWeight']= (int)$dataSend['typeWeight'];
        $save['Car']['volume']= (int)$dataSend['volume'];
        $save['Car']['typeVolume']= (int)$dataSend['typeVolume'];
        $save['Car']['numberCar']= $dataSend['numberCar'];
        $save['Car']['info']= $dataSend['info'];
        $save['Car']['idUser']= $dataUser['Customer']['id'];

        if($modelCar->save($save)){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function cancelCarAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelCar= new Car();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $save['$set']['lock']= true;
        $id= new MongoId($dataSend['idCar']);
        $dk= array('_id'=>$id,'idUser'=>$dataUser['Customer']['id']);
        if($modelCar->updateAll($save,$dk) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Quan ly tai xe
function getListDriverAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelDriver= new Driver();
        $idUser= $dataUser['Customer']['id'];
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('idUser'=>$idUser, 'lock'=>array('$ne'=>true));
        $order = array('created' => 'desc');
        $fields= null;

        $listData= $modelDriver->getPage($page, $limit , $conditions, $order, $fields );
        $return= array('code'=>1,'listData'=>$listData);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function saveDriverAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelDriver= new Driver();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $checkAccFone= null;
    
    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        if(!empty($dataSend['idDriver'])){
            $save= $modelDriver->getDriver($dataSend['idDriver']);
        }else{
            $save['Driver']['time']= $today[0];
            $save['Driver']['lock']= false;
            $save['Driver']['gpsCityEnd']= $dataUser['Customer']['company']['gps'];

            $checkAccFone= $modelDriver->checkExistAccount($dataSend['fone']);
            if($checkAccFone){
                $return= array('code'=>1);
            }
        }

        if(!$checkAccFone){
            $save['Driver']['status']= (boolean)$dataSend['status'];
            $save['Driver']['fullName']= $dataSend['fullName'];
            $save['Driver']['fone']= $dataSend['fone'];
            $save['Driver']['address']= $dataSend['address'];
            $save['Driver']['idUser']= $dataUser['Customer']['id'];
            $save['Driver']['pass']= md5($dataSend['pass']);

            if($modelDriver->save($save)){
                $return= array('code'=>0);
            }else{
                $return= array('code'=>1);
            }
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function deleteDriverAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelDriver= new Driver();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $save['$set']['lock']= true;
        $id= new MongoId($dataSend['idDriver']);
        $dk= array('_id'=>$id,'idUser'=>$dataUser['Customer']['id']);
        if($modelDriver->updateAll($save,$dk) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Lấy danh sách tất cả các yêu cầu
function getAllRequestAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
	$today= getdate();
    $today0= mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        // trạng thái chưa khóa, status là pending, chủ xe chưa đấu giá, thời gian chạy sau thời gian hiện tại, chưa có chủ xe nào được chọn
        $conditions = array('lock'=>array('$ne'=>true),
							'status'=>'pending', 
							'auction.'.$dataUser['Customer']['id']=>array('$exists'=>false),
                            'idDriverBossWin'=>array('$exists'=>false),
							'timeStart'=>array('$gte'=>$today0)
							);
        $order = array('created' => 'desc');
        $fields= null;

        $return= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );
        $return= array('code'=>1,'listData'=>$return);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Lấy danh sách yêu cầu chủ xe đã đấu giá
function getListRequestPendingDriverAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        // điều kiện: chưa khóa, trạng thái là pending, đã từng đấu giá
        $conditions = array('lock'=>array('$ne'=>true),'status'=>'pending','auction.'.$dataUser['Customer']['id']=>array('$ne'=>null));
        $order = array('created' => 'desc');
        $fields= null;

        $return= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );
        $return= array('code'=>1,'listData'=>$return);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Lấy danh sách yêu cầu chờ chủ xe chấp nhận
function getListRequestCaremptyAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        // điều kiện: chưa khóa, trạng thái là pendingDriver, đã từng đấu giá, idDriverBossWin là id của chủ xe
        $conditions = array('lock'=>array('$ne'=>true),'idDriverBossWin'=>$dataUser['Customer']['id'],'status'=>'pendingDriver','auction.'.$dataUser['Customer']['id']=>array('$ne'=>null));
        $order = array('created' => 'desc');
        $fields= null;

        $return= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );
        $return= array('code'=>1,'listData'=>$return);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Lấy danh sách yêu cầu chủ xe đấu giá thất bại
function getListRequestFailDriverAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        // điều kiện: đã khóa, đã từng đấu giá, idDriverBossWin khác với id chủ xe
        $conditions = array('lock'=>true,
                            'auction.'.$dataUser['Customer']['id']=>array('$ne'=>null),
                            'auction.'.$dataUser['Customer']['id'].'.delete'=>array('$ne'=>true),
                            'idDriverBossWin'=>array('$ne'=>$dataUser['Customer']['id']),
                            );
        $order = array('created' => 'desc');
        $fields= null;

        $return= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );
        $return= array('code'=>1,'listData'=>$return);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Xóa yêu cầu đấu giá thất bại của chủ xe
function saveDeleteRequestFailDriverAPI($input)
{
    $return= array('code'=>2);

    $dataSend= $input['request']->data;
    $modelRequest= new Request();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){

        $save['$set']['auction.'.$dataUser['Customer']['id'].'.delete']= true;
        $id= new MongoId($dataSend['idRequest']);
        $dk= array('_id'=>$id);

        if($modelRequest->updateAll($save,$dk) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function saveAuctionRequestAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelRequest= new Request();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        $request= $modelRequest->getRequest($dataSend['idRequest']);

        $request['Request']['auction'][$dataUser['Customer']['id']]= array('idUser'=>$dataUser['Customer']['id'],
                                                                        'nameDriver'=>$dataUser['Customer']['company']['name'],
                                                                        'price'=>(int) $dataSend['price'],
                                                                        'time'=> $today[0],
                                                                        'note'=> $dataSend['note'],
                                                                        'idCar'=> $dataSend['idCar'],
                                                                        'typeMoney'=>(int) $dataSend['typeMoney']
                                                                    );
        
        $arrayCheck= array();
        $auction= $request['Request']['auction'];
        foreach($request['Request']['auction'] as $key=>$value){
            $arrayCheck[$key]= $value['price'];
        }
        asort($arrayCheck);

        $number= 0;
        $request['Request']['auction']= array();
        foreach($arrayCheck as $key=>$value){
            $number++;
            if($number==1){
                $request['Request']['priceAuctionMin']= $value;
            }
            $request['Request']['auction'][$key]= $auction[$key];
            $request['Request']['auction'][$key]['number']= $number;
        }

        if($modelRequest->save($request) ){
            $return= array('code'=>0);
            //$request= $modelRequest->getRequest($dataSend['idRequest']);
            $chuhang= $modelCustomer->getCustomer($request['Request']['idUser'],array('tokenDevice'));

            // gui thong bao cho chu hang
            $data= array('functionCall'=>'saveAuctionRequestAPI','idRequest'=>$dataSend['idRequest'],'title'=>'Đấu giá mới cho mặt hàng '.$request['Request']['productName'].': '.number_format($dataSend['price']).'đ');
            $target= array($chuhang['Customer']['tokenDevice']);
            sendMessageNotifi($data,$target);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Chấp nhận yêu cầu từ xe có sẵn
function saveRequestForCaremptyAPI($input)
{
    global $contactSite;

    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);
    $return= array('code'=>1);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $modelOrder= new Order();
        $modelTransfer= new Transfer();

        $request= $modelRequest->getRequest($dataSend['idRequest']);
        if($request){
            $today= getdate();
            $save['Order']['_id']= new MongoId();
            $save['Order']['time']= $today[0];
            $save['Order']['idUser']= $request['Request']['idUser'];
            $save['Order']['idDriverBoss']= $dataUser['Customer']['id'];
            $save['Order']['idDriver']= $dataSend['idDriver'];

            $save['Order']['idRequest']= $request['Request']['id'];
            $save['Order']['cityStart']= $request['Request']['cityStart'];
            $save['Order']['districtStart']= $request['Request']['districtStart'];
            $save['Order']['addressStart']= $request['Request']['addressStart'];
            $save['Order']['cityEnd']= $request['Request']['cityEnd'];
            $save['Order']['districtEnd']= $request['Request']['districtEnd'];
            $save['Order']['addressEnd']= $request['Request']['addressEnd'];
            $save['Order']['productName']= $request['Request']['productName'];
            $save['Order']['timeStart']= $request['Request']['timeStart'];
            $save['Order']['timeEnd']= $request['Request']['timeEnd'];
            $save['Order']['weigh']= $request['Request']['weigh'];
            $save['Order']['volume']= $request['Request']['volume'];
            $save['Order']['typeWeigh']= $request['Request']['typeWeigh'];
            $save['Order']['typeVolume']= $request['Request']['typeVolume'];
            $save['Order']['typeMoney']= $request['Request']['auction'][$dataUser['Customer']['id']]['typeMoney'];
            $save['Order']['description']= $request['Request']['description'];
            $save['Order']['price']= $request['Request']['priceDone'];
            $save['Order']['idCar']= $request['Request']['auction'][$dataUser['Customer']['id']]['idCar'];

            $idOrderNew= (string) $save['Order']['_id'];

            $modelOrder->save($save);

            $saveRequest['$set']['lock']= true;
            $saveRequest['$set']['status']= 'complete';
            $saveRequest['$set']['idDriverBossWin']= $dataUser['Customer']['id'];

            $id= new MongoId($dataSend['idRequest']);
            $dk= array('_id'=>$id);
            $modelRequest->updateAll($saveRequest,$dk);

            $return= array('code'=>0,'idOrder'=>$idOrderNew);

            // trừ tiền và lưu lịch sử giao dịch
            $updateUser['$inc']['coin']= 0-0.1*$request['Request']['priceDone'];
            $dkUser= array('_id'=>new MongoId($dataUser['Customer']['id']));
            $modelCustomer->updateAll($updateUser,$dkUser);

            $saveTransfer['Transfer']['content']= 'Trừ '.number_format(0.1*$request['Request']['priceDone']).'đ sau khi giao dịch thành công mặt hàng '.$request['Request']['productName'].' có id yêu cầu là: '.$request['Request']['id'].' và id đơn hàng là: '.$idOrderNew;
            $saveTransfer['Transfer']['time']= $today[0];
            $saveTransfer['Transfer']['idUser']= $dataUser['Customer']['id'];
            $modelTransfer->save($saveTransfer);

            // Gui email thong bao cho chu hang
            $infoCustomer= $modelCustomer->getCustomer($request['Request']['idUser'],array('fullName','email','tokenDevice','fone'));

            $from=array($contactSite['Option']['value']['email']);
            $to=array($infoCustomer['Customer']['email']);
            $cc=array();
            $bcc=array();
            $subject='[Netloading] Kết quả đấu giá mặt hàng '.$request['Request']['productName'];
            $content= ' <p>Xin chào '.$infoCustomer['Customer']['fullName'].' !</p>

                        <p>Mặt hàng chở '.$request['Request']['productName'].' của bạn đã được chủ xe '.$dataUser['Customer']['fullName'].' chấp nhận, thông tin đơn hàng như sau:</p>

                        <ul>
                            <li>Nơi gửi: '.$request['Request']['addressStart'].'</li>
                            <li>Nơi nhận: '.$request['Request']['addressEnd'].'</li>
                            <li>Người gửi: '.$infoCustomer['Customer']['fullName'].'</li>
                            <li>Điện thoại: '.$infoCustomer['Customer']['fone'].'</li>
                            <li>Tên hàng hóa: '.$request['Request']['productName'].'</li>
                            <li>Ngày đóng hàng: '.date('d/m/Y',$request['Request']['timeStart']).'</li>
                            <li>Ngày nhận hàng: '.date('d/m/Y',$request['Request']['timeEnd']).'</li>
                            <li>Khối lượng: '.number_format($request['Request']['weigh']).'</li>
                            <li>Thể tích: '.number_format($request['Request']['volume']).'</li>
                            <li>Mô tả thêm: '.$request['Request']['description'].'</li>
                            <li>Giá vận chuyển: '.number_format($request['Request']['priceGood']).'đ</li>
                        </ul>' . getSignatureEmail();

            $modelRequest->sendMail($from,$to,$cc,$bcc,$subject,$content);

            // gui thong bao cho chu hang
            $data= array('functionCall'=>'saveRequestForCaremptyAPI','idOrder'=>$idOrderNew,'title'=>'Yêu cầu chở '.$request['Request']['productName'].' thành công');
            $target= array($infoCustomer['Customer']['tokenDevice']);
            sendMessageNotifi($data,$target);
        }else{
            $return= array('code'=>3);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// Lấy danh sách đơn hàng đấu giá thành công
function getListOrderDriverAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelOrder= new Order();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('lock'=>array('$ne'=>true),'idDriverBoss'=>$dataUser['Customer']['id']);
        $order = array('created' => 'desc');
        $fields= null;

        $data= $modelOrder->getPage($page, $limit, $conditions, $order,$fields);

        $return= array('code'=>0,'listData'=>$data);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

/*
function saveDriverToOrderAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelOrder= new Order();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        $save['$set']['idDriver']= $dataSend['idDriver'];
        $id= new MongoId($dataSend['idOrder']);
        $dk= array('_id'=>$id);
        if($modelOrder->updateAll($save,$dk) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}
*/

// chủ xe lưu thông tin xe sẵn có
function saveCarEmptyAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelCarempty= new Carempty();
    $modelCustomer= new Customer();
    $modelCar= new Car();

    $today= getdate();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        $listTypeCar= getListTypeCar();
        $infoCar= $modelCar->getCar($dataSend['idCar']);

        if($infoCar){
            if(!empty($dataSend['idCarEmpty'])){
                $save= $modelCarempty->getCarempty($dataSend['idCarEmpty']);
            }else{
                $save['Carempty']['time']= $today[0];
                $save['Carempty']['lock']= false;
            }

            $timeStart= explode('-', $dataSend['timeStart']);
            $timeStart= mktime(0,0,0,$timeStart[1],$timeStart[0],$timeStart[2]);

            $timeEnd= explode('-', $dataSend['timeEnd']);
            $timeEnd= mktime(23,59,59,$timeEnd[1],$timeEnd[0],$timeEnd[2]);

            $save['Carempty']['idUser']= $dataUser['Customer']['id'];

            $save['Carempty']['cityStart']= (int)$dataSend['cityStart'];
            $save['Carempty']['districtStart']= (int)$dataSend['districtStart'];
            $save['Carempty']['cityEnd']= (int)$dataSend['cityEnd'];
            $save['Carempty']['districtEnd']= (int)$dataSend['districtEnd'];

            $save['Carempty']['idCar']= $dataSend['idCar'];
            $save['Carempty']['price']= (int) $dataSend['price'];
            $save['Carempty']['note']= $dataSend['note'];
            $save['Carempty']['typeMoney']= (int) $dataSend['typeMoney'];
            $save['Carempty']['groupCar']= $listTypeCar[$infoCar['Car']['typeCar'] ]['group'];


            $save['Carempty']['timeStart']= $timeStart;
            $save['Carempty']['timeEnd']= $timeEnd;

            if($modelCarempty->save($save)){
                $return= array('code'=>0);
            }else{
                $return= array('code'=>1);
            }
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

// chủ xe khóa thông tin xe sẵn có
function deleteCarEmptyAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelCarempty= new Carempty();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])  && $dataUser['Customer']['chuxe']){
        $save['$set']['lock']= true;
        $id= new MongoId($dataSend['idCarEmpty']);
        $dk= array('_id'=>$id,'idUser'=>$dataUser['Customer']['id']);
        if($modelCarempty->updateAll($save,$dk) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getListCarEmptyDriverAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelCarempty= new Carempty();
        $idUser= $dataUser['Customer']['id'];
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('idUser'=>$idUser, 'lock'=>array('$ne'=>true));
        $order = array('created' => 'desc');
        $fields= null;

        $listData= $modelCarempty->getPage($page, $limit , $conditions, $order, $fields );
        $return= array('code'=>1,'listData'=>$listData);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function saveStatusOrderAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelOrder= new Order();
    $today= getdate();
    $modelCustomer= new Customer();
    $modelRequest= new Request();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        // status: process, done, cancel
        $save['$set']['status']= $dataSend['status'];

        if($dataSend['status']=='cancel' || $dataSend['status']=='done'){
            $save['$set']['lock']= true;
        }

        $id= new MongoId($dataSend['idOrder']);
        $dk= array('_id'=>$id,'idDriverBoss'=>$dataUser['Customer']['id']);
        if($modelOrder->updateAll($save,$dk) ){
            $return= array('code'=>0);

            // gui thong bao cho chu hang
            $status= '';
            switch ($dataSend['status']) {
                case 'cancel':
                    $status= 'Hủy bỏ';
                    break;
                case 'done':
                    $status= 'Hoàn thành';
                    break;
                case 'process':
                    $status= 'Bắt đầu chuyển';
                    break;
                
            }

            $order= $modelOrder->getOrder($dataSend['idOrder']);
            $chuhang= $modelCustomer->getCustomer($order['Order']['idUser'],array('tokenDevice'));
            $refreshRequest= false;

            // Khôi phục lại yêu cầu
            $request= $modelRequest->getRequest($order['Order']['idRequest']);
            if($request && $today[0]<=$request['Request']['timeStart']){
                //trạng thái chưa khóa, status là pending, chủ xe chưa đấu giá, thời gian chạy sau thời gian hiện tại, chưa có chủ xe nào được chọn
                $updateRequest['$set']['lock']= false;
                $updateRequest['$set']['status']= 'pending';
                $updateRequest['$unset']['idDriverBossWin']= true;

                $dk= array('_id'=>new MongoId($order['Order']['idRequest']));
                if($modelRequest->updateAll($updateRequest,$dk)){
                    $refreshRequest= true;
                }
            }

            // gui thong bao cho chu hang
            $data= array('functionCall'=>'saveStatusOrderAPI','title'=>'Chủ xe vừa cập nhật trạng thái đơn hàng vận chuyển '.$order['Order']['productName'].': '.$status,'idOrder'=>$dataSend['idOrder'],'idRequest'=>$order['Order']['idRequest'],'refreshRequest'=>$refreshRequest,'status'=>$dataSend['status']);
            $target= array($chuhang['Customer']['tokenDevice']);
            sendMessageNotifi($data,$target);

        }else{
            $return= array('code'=>2);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function saveHistoryDriverAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelHistory= new History();
    $today= getdate();
    $modelCustomer= new Customer();
    $modelDriver= new Driver();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken']) && $dataUser['Customer']['chuxe']){
        $modelHistory->create();
        $update['$set']['idCar']= null;
        $update['$set']['time']= null;
        $update['$set']['statusCar']= null;
        $update['$set']['note']= null;
        $update['$set']['gpsCityEnd']= null;
        $update['$set']['latGPS']= null;
        $update['$set']['longGPS']= null;
        $update['$set']['distance']= null;
        $update['$set']['timeUpdate']= null;
        $modelHistory->updateAll($update,array('idCar'=>$dataSend['idCar']));
        $modelHistory->create();

        $infoDriver= $modelDriver->getDriver($dataSend['idDriverStaff']);
        $save= $modelHistory->getHistoryByDriver($dataSend['idDriverStaff']);
        $today= getdate();
        $save['History']['time']= $today[0];

        $save['History']['idCar']= $dataSend['idCar'];
        $save['History']['statusCar']= (boolean) $dataSend['statusCar'];
        $save['History']['idDriverStaff']= $dataSend['idDriverStaff'];
        $save['History']['note']= $dataSend['note'];
        $save['History']['idDriverBoss']= $dataUser['Customer']['id'];
        $save['History']['gpsCityEnd']= $dataUser['Customer']['company']['gps'];
        $save['History']['latGPS']= @$infoDriver['Driver']['latGPS'];
        $save['History']['longGPS']= @$infoDriver['Driver']['longGPS'];
        $save['History']['distance']= @$infoDriver['Driver']['distance'];
        $save['History']['timeUpdate']= @$infoDriver['Driver']['timeUpdate'];

        if($modelHistory->save($save) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getInfoHistoryAPI($input)
{
    $return= array('code'=>1);
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $modelHistory= new History();

    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $data= $modelHistory->getHistory($dataSend['idHistory']);

        $return= array('code'=>0,'data'=>$data);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}
    
function getListHistoryDriverAPI($input)
{
    $return= array('code'=>0);
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $modelDriver= new Driver();
    $modelCar= new Car();

    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelHistory= new History();
        $idUser= $dataUser['Customer']['id'];
        $page=1;
        $limit= null;
        $conditions = array('idDriverBoss'=>$idUser, 'idCar'=>array('$ne'=>null));
        $order = array('created' => 'desc');
        $fields= array('idCar','statusCar','idDriverStaff','note','gpsCityEnd','latGPS','longGPS');

        $listData= $modelHistory->getPage($page, $limit , $conditions, $order, $fields );
        /*
        if($listData){
            foreach($listData as $key=>$info){
                $listData[$key]['History']['infoDriver']= $modelDriver->getDriver($info['History']['idDriverStaff']);
                $listData[$key]['History']['infoCar']= $modelCar->getCar($info['History']['idCar']);
            }
        }
        */

        $return= array('code'=>1,'listData'=>$listData);
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function deleteHistoryAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelHistory= new History();
    $today= getdate();
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])  && $dataUser['Customer']['chuxe']){
        $save['$set']['idCar']= null;

        $id= new MongoId($dataSend['idHistory']);
        $dk= array('_id'=>$id,'idDriverBoss'=>$dataUser['Customer']['id']);
        if($modelHistory->updateAll($save,$dk) ){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }

    echo json_encode($return);
}

function getListAllRequestAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $modelRequest= new Request();
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('lock'=>array('$ne'=>true),'cityStart'=>(int)$dataSend['cityStart'],'cityEnd'=>(int)$dataSend['cityEnd']);
        $order = array('created' => 'desc');
        $fields= array('cityStart','cityEnd','productName','time','districtStart','districtEnd','lock','timeStart');

        $listData= $modelRequest->getPage($page, $limit , $conditions, $order, $fields );
        
        $return= array('code'=>1,'listData'=>$listData);
    }else{
        $return= array('code'=>-1);
    }
    echo json_encode($return);
}

function checkLoginStatusStaffAPI($input)
{
    $return= array();
    $dataSend= $input['request']->data;
    $modelCustomer= new Customer();
    $modelDriver= new Driver();

    $dataUser= $modelCustomer->checkLoginByToken($dataSend['accessToken']);

    if(!empty($dataUser['Customer']['accessToken'])){
        $driver= $modelDriver->getDriver($dataSend['idDriver']);

        if(isset($driver['Driver']['accessToken'])){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }else{
        $return= array('code'=>-1);
    }
    echo json_encode($return);
}

?>