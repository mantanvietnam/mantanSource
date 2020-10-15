<?php
function checkRegisterUserAPI($input)
{
    $modelUser= new Userhotel();
    $listData = array();
    $dataSend= $input['request']->data;
    global $contactSite;

    if(!empty($dataSend['fullname']) &&
        !empty($dataSend['email']) &&
        !empty($dataSend['phone']) &&
        !empty($dataSend['password']) &&
        !empty($dataSend['passwordAgain']) &&
        !empty($dataSend['sex']) &&
        !empty($dataSend['username']) &&
        !empty($dataSend['address']) 
    ){
        $today= getdate();

        if($dataSend['password'] != $dataSend['passwordAgain']){
            $return= array('code'=>2);
        }else{
            $data= $modelUser->getUserCode($dataSend['username']);

            if(!$data) {
                $data['User']['fullname'] = $dataSend['fullname'];
	            $data['User']['user'] = $dataSend['username'];
	            $data['User']['email'] = $dataSend['email'];
	            $data['User']['sex'] = $dataSend['sex'];
	            $data['User']['phone'] = $dataSend['phone'];
	            $data['User']['address'] = $dataSend['address'];
	            $data['User']['password'] = md5($dataSend['password']);

                $modelUser->save($data);
                $return= array('code'=>0);

                // Gửi email thông báo
                $from=array($contactSite['Option']['value']['email']);
                $to=array($contactSite['Option']['value']['email'],$dataSend['email']);
                $cc=array();
                $bcc=array();
                $subject='[ManMo] Đăng ký tài khoản thành công';
                $content= ' <p>Xin chào '.$dataSend['fullname'].' !</p>

                            <p>Chúc mừng bạn đã đăng ký thành công tài khoản trên hệ thống ManMo, thông tin tài khoản như sau:</p>

                            <ul>
                                <li>App android: <a href="https://play.google.com/store/apps/details?id=vn.manmo">https://play.google.com/store/apps/details?id=vn.manmo</a></li>
                                <li>App iOS: <a href="https://itunes.apple.com/us/app/manmo/id1279288541">https://itunes.apple.com/us/app/manmo/id1279288541</a></li>
                                <li>Website: <a href="https://manmo.vn">https://manmo.vn</a></li>
                                <li>Tài khoản: '.$dataSend['username'].'</li>
                                <li>Mật khẩu: '.$dataSend['password'].'</li>
                                <li>Email: '.$dataSend['email'].'</li>
                            </ul>

                            ' . getSignatureEmail();

                $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
            }else{
                $return= array('code'=>1);
            }
        }
    }else{
        $return= array('code'=>3);
    }

    echo json_encode($return);
}

function changePassUserAPI($input){
    $modelUser= new Userhotel();
    $dataSend = $input['request']->data;
    $dataUser= $modelUser->checkLoginByToken($dataSend['accessToken']);
 
    if(!empty($dataUser['User']['accessToken']) ){
        if($dataUser['User']['password'] == md5($dataSend['oldPass'])&& $dataSend['pass'] = $dataSend['RePass']){
            $dataUser['User']['password'] = md5($dataSend['pass']);
            if($modelUser->save($dataUser)){
                $return = array('code'=>0);
            }else{
                $return = array('code'=>1);
            }
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function getInfoUserAPI($input){
    $modelUser= new Userhotel();
    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    $return = array('code'=>0);

    if(!empty($dataUser['User']['accessToken'])){
        $data= $modelUser->getUser($dataSend['idUser']);

        $return = array('code'=>1,'data'=>$data);
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function updateInfoUserAPI($input)
{
    global $urlHomes;

    $modelUser= new Userhotel();
    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $dataUser['User']['fullname'] = $dataSend['fullname'];
        $dataUser['User']['email'] = $dataSend['email'];
        $dataUser['User']['sex'] = $dataSend['sex'];
        $dataUser['User']['phone'] = $dataSend['phone'];
        $dataUser['User']['address'] = $dataSend['address'];

        if($modelUser->save($dataUser)){
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);

}

function checkLoginUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelHotel= new Hotel();
    $modelRoom = new Room();

    $listData = array();
    $dataSend= $input['request']->data;

    if(!empty($dataSend['user']) && !empty($dataSend['pass'])){
        $userByFone  = $modelUser->checkLoginByUser($dataSend['user'],md5($dataSend['pass']));
        $accessToken = getGUID();
        if($userByFone){
            $room= $modelRoom->getRoomByUser($dataSend['user'],array('hotel','name') ); 
            if($room){
                $hotel= $modelHotel->getHotel($room['Room']['hotel'],array('name','phone'));
                if($hotel){
                    $userByFone['User']['Room']= array('name'=>$room['Room']['name'],'id'=>$room['Room']['id']);
                    $userByFone['User']['Hotel']= array('name'=>$hotel['Hotel']['name'],'id'=>$hotel['Hotel']['id'],'phone'=>$hotel['Hotel']['phone']);
                }
            }

            $userByFone['User']['accessToken']= $accessToken;
            $return= array('code'=>0,'user'=>$userByFone['User']);
            $modelUser->save($userByFone);
        }else{
            $return= array('code'=>1,'user'=>array());
        }
    }else{
        $return= array('code'=>2,'user'=>array());
    }

    echo json_encode($return);
}

// gửi yêu cầu cấp mã lấy lại mật khẩu
function sendCodePassNewUserAPI($input)
{
    $modelUser= new Userhotel();
    global $contactSite;

    $dataSend= $input['request']->data;
    $data= $modelUser->getByUser($dataSend['user']);
    $return= array('code'=>1);

    if($data['User']['email']){
        $data['User']['codeForgetPass']= rand(100000,999999);
        $modelUser->save($data);
        
        // Gửi email thông báo
        $from=array($contactSite['Option']['value']['email']);
        $to=array($data['User']['email']);
        $cc=array();
        $bcc=array();
        $subject='[ManMo] Mã cấp lại mật khẩu';
        $content= ' <p>Xin chào '.$data['User']['fullname'].' !</p>

                    <p>Bạn vui lòng nhập mã sau để lấy lại mật khẩu: <b>'.$data['User']['codeForgetPass'].'</b></p>
                    ' . getSignatureEmail();

        $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
        $return= array('code'=>0);
    }

    echo json_encode($return);
}

// gửi yêu cầu lấy lại mật khẩu
function sendPassNewUserAPI($input)
{
    $modelUser= new Userhotel();
    global $contactSite;

    $dataSend= $input['request']->data;
    $data= $modelUser->getByUser($dataSend['user']);
    $return= array('code'=>1);

    if($data['User']['email'] && isset($data['User']['codeForgetPass']) && $data['User']['codeForgetPass']==$dataSend['codeForgetPass']){
        $newPass= rand(100000,999999);
        $save['$set']['password']= md5($newPass);
        $save['$unset']['codeForgetPass']= true;
        $dk= array('_id'=>new MongoId($data['User']['id']));
        if($modelUser->updateAll($save,$dk)){
            // Gửi email thông báo
            $from=array($contactSite['Option']['value']['email']);
            $to=array($data['User']['email']);
            $cc=array();
            $bcc=array();
            $subject='[ManMo] Mã cấp lại mật khẩu';
            $content= ' <p>Xin chào '.$data['User']['fullname'].' !</p>

                        <p>Mật khẩu mới của bạn là: <b>'.$newPass.'</b></p>
                        ' . getSignatureEmail();

            $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        }
    }

    echo json_encode($return);
}

function saveTokenDeviceUserAPI($input)
{
    $modelUser= new Userhotel();
    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $save['$set']['tokenDevice']= $dataSend['tokenDevice'];
        $id= new MongoId($dataUser['User']['id']);
        $dk= array('_id'=>$id);

        if($modelUser->updateAll($save,$dk)){
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function checkLogoutUserAPI($input)
{
    $modelUser= new Userhotel();
    $dataSend= $input['request']->data;
    $return= array('code'=>0);

    $dataUser['$unset']['accessToken']= true;
    $dataUser['$unset']['tokenDevice']= true;
    
    $dk= array('accessToken'=>$dataSend['accessToken']);
    if($modelUser->updateAll($dataUser,$dk)){
        $return= array('code'=>0);
    }else{
        $return= array('code'=>1);
    } 

    echo json_encode($return);
}

function saveReportUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelReport = new Report();
    $modelHotel= new Hotel();

    global $contactSite;
    global $smtpSite;

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $today= getdate();

        $save['Report']['idHotel']= $dataSend['idHotel'];
        $save['Report']['idRoom']= $dataSend['idRoom'];
        $save['Report']['content']= $dataSend['content'];
        $save['Report']['time']= $today[0];
        $save['Report']['status']= 'new';
        $save['Report']['idUser']= $dataUser['User']['id'];
        $save['Report']['user']= $dataUser['User']['user'];

        if($modelReport->save($save)){
            $return = array('code'=>0);
            $hotel= $modelHotel->getHotel($dataSend['idHotel'],array('email') );
            if(!empty($hotel['Hotel']['email'])){
                // send email for user and admin
                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                $to = array(trim($hotel['Hotel']['email']) );
                $cc = array();
                $bcc = array();
                $subject = '[' . $smtpSite['Option']['value']['show'] . '] Báo hỏng mới từ khách hàng';

                // create content email

                $content = 'Bạn nhận được báo hỏng mới từ khách hàng, nội dung như sau:<br/><br/>'.$dataSend['content'];
                
                $modelReport->sendMail($from, $to, $cc, $bcc, $subject, $content);
            }
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function deleteReportUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelReport = new Report();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $idDelete= new MongoId($dataSend['idReport']);

        if($modelReport->delete($idDelete)){
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function getListReportUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelReport = new Report();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    $return = array('code'=>0);

    if(!empty($dataUser['User']['accessToken'])){
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('idUser'=>$dataUser['User']['id'],'idHotel'=>$dataSend['idHotel']);
        $order = array('created' => 'desc');
        $fields= array();

        $data= $modelReport->getPage($page, $limit , $conditions, $order, $fields );

        $return = array('code'=>1,'data'=>$data);
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function getInfoRoomUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelRoom = new Room();
    $modelTypeRoom = new TypeRoom();
    $modelMerchandise = new Merchandise();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    $return = array('code'=>0);

    if(!empty($dataUser['User']['accessToken'])){
        $idRoom = $dataSend['idRoom'];
        $dataRoom = $modelRoom->getRoom($idRoom);
        $typeRoom = $modelTypeRoom->getTypeRoom($dataRoom['Room']['typeRoom']);
        
        // tinh thoi gian da o
        $today = getdate();
        $dateCheckin = getdate($dataRoom['Room']['checkin']['dateCheckin']);
        $textUse = '';
        $timeUse = $today[0] - $dataRoom['Room']['checkin']['dateCheckin'];
        $surplus = $timeUse % 86400;
        $dateUser = ($timeUse - $surplus) / 86400;
        if ($dateUser > 0) {
            $textUse.= $dateUser . ' ngày ';
        }

        $timeUse = $surplus;
        $surplus = $timeUse % 3600;
        $hourUse = ($timeUse - $surplus) / 3600;
        if ($hourUse > 0) {
            $textUse.= $hourUse . ' giờ ';
        }

        $timeUse = $surplus;
        $surplus = $timeUse % 60;
        $minuteUse = ($timeUse - $surplus) / 60;
        if ($minuteUse > 0) {
            $textUse.= $minuteUse . ' phút ';
        }


        // load thong tin hang hoa
        $priceMerchandise = 0;
        if (!empty($dataRoom['Room']['checkin']['hang_hoa'])) {
            foreach ($dataRoom['Room']['checkin']['hang_hoa'] as $hang_hoa => $number) {
                $merchandise = $modelMerchandise->getMerchandise($hang_hoa);
                if ($merchandise) {
                    $priceMerchandise+= $merchandise['Merchandise']['price'] * $dataRoom['Room']['checkin']['hang_hoa'][$hang_hoa];
                    $dataRoom['Room']['checkin']['hang_hoa'][$hang_hoa] = array(
                        'name' => $merchandise['Merchandise']['name'],
                        'price' => $merchandise['Merchandise']['price'],
                        'number' => $number,
                    );
                }
            }
        }

        // tinh gia phong
        $priceRoom = 0;
        $type_date = $dataRoom['Room']['checkin']['typeDate'];
        if ($minuteUse > 0) {
            $hourUse++;
            $minuteUse = 0;
        }
        
        $type_register = $dataRoom['Room']['checkin']['type_register'];
        // nếu ở theo năm
        if($type_register=='gia_nam'){
            $priceDate= $dataRoom['Room']['checkin']['price']/365;
            $priceRoom= round($priceDate*$dateUser,0);
        }
        // nếu ở theo tháng
        elseif($type_register=='gia_thang'){
            $priceDate= $dataRoom['Room']['checkin']['price']/30;
            $priceRoom= round($priceDate*$dateUser,0);
        }
        // neu o qua 24h
        elseif ($dateUser > 0) {
            $type_register = 'gia_theo_ngay';
            if(!isset($typeRoom['TypeRoom'][$type_date]['gia_ngay'])) $typeRoom['TypeRoom'][$type_date]['gia_ngay']= 0;
            $priceRoom = $dateUser * $typeRoom['TypeRoom'][$type_date]['gia_ngay'];
            // neu ton tai gia cho gio phu troi
            if (isset($typeRoom['TypeRoom'][$type_date]['phu_troi_checkout_ngay'][$hourUse])) {
                $priceRoom+= $typeRoom['TypeRoom'][$type_date]['phu_troi_checkout_ngay'][$hourUse];
            } else {
                $priceRoom+= $typeRoom['TypeRoom'][$type_date]['gia_ngay'];
            }
        }
        // Chua o het 24h nhung bi qua ngay thi chuyen sang phuong thuc tinh qua dem
        elseif ($dateCheckin['mday'] != $today['mday'] || $today['hours'] > $typeRoom['TypeRoom'][$type_date]['gio_qua_dem_start']) {
            $type_register = 'gia_qua_dem';
            $priceRoom = $typeRoom['TypeRoom'][$type_date]['gia_qua_dem'];

            if ($dateCheckin['mday'] != $today['mday'] && $today['hours'] > $typeRoom['TypeRoom'][$type_date]['gio_qua_dem_end']) {
                $gio_phu_troi = $today['hours'] - $typeRoom['TypeRoom'][$type_date]['gio_qua_dem_end'];
                // neu ton tai gia cho gio phu troi qua dem
                if (isset($typeRoom['TypeRoom'][$type_date]['phu_troi_checkout_dem'][$gio_phu_troi])) {
                    $priceRoom+= $typeRoom['TypeRoom'][$type_date]['phu_troi_checkout_dem'][$gio_phu_troi];
                } else {
                    $type_register = 'gia_theo_ngay';
                    $priceRoom = $typeRoom['TypeRoom'][$type_date]['gia_ngay'];
                }
            }
        }
        // thoi gian o trong cung 1 ngay
        else {
            switch ($type_register) {
                case 'gia_qua_dem': $priceRoom = $typeRoom['TypeRoom'][$type_date]['gia_qua_dem'];
                    break;
                case 'gia_theo_ngay': $priceRoom = $typeRoom['TypeRoom'][$type_date]['gia_ngay'];
                    break;
                case 'gia_theo_gio': if (isset($typeRoom['TypeRoom'][$type_date]['gia_theo_gio'][$hourUse])) {
                        $priceRoom = $typeRoom['TypeRoom'][$type_date]['gia_theo_gio'][$hourUse];
                    } else {
                        $type_register = 'gia_theo_ngay';
                        $priceRoom = $typeRoom['TypeRoom'][$type_date]['gia_ngay'];
                    }
            }
        }
        
        // phi them nguoi phu troi
        if ($dataRoom['Room']['checkin']['number_people'] > $typeRoom['TypeRoom']['so_nguoi']) {
            $pricePeople = ($dataRoom['Room']['checkin']['number_people'] - $typeRoom['TypeRoom']['so_nguoi']) * $typeRoom['TypeRoom'][$type_date]['phu_troi_them_khach'];
        } else {
            $pricePeople = 0;
        }

        // phi giam tru
        if ($dataRoom['Room']['checkin']['promotion'] > 100) {
            $giam_tru = $dataRoom['Room']['checkin']['promotion'];
        } else {
            $giam_tru = round(($dataRoom['Room']['checkin']['promotion'] / 100) * $priceRoom);
        }

        // Tien can thanh toan
        $pricePay = ($priceRoom + $pricePeople + $priceMerchandise) - ($dataRoom['Room']['checkin']['prepay'] + $giam_tru);

        $return = array('code'=>1,'data'=>array('textUse'=>$textUse,
                                                'type_register'=>$type_register,
                                                'priceRoom'=>$priceRoom,
                                                'priceMerchandise'=>$priceMerchandise,
                                                'pricePay'=>$pricePay,
                                                'pricePeople'=>$pricePeople,
                                                'giam_tru'=>$giam_tru,
                                                'typeRoom'=>$typeRoom['TypeRoom']['roomtype'],
                                                'dataRoom'=>$dataRoom

            ) );


    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function saveClearRoomUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelRoom = new Room();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $saveRoom['$set']['clear']= false;
        $dk= array('_id' => new MongoId($dataSend['idRoom']));


        if($modelRoom->updateAll($saveRoom, $dk)){
            $return = array('code'=>0);
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function getCategoryServiceAPI($input)
{
    $modelUser= new Userhotel();
    $modelMerchandiseGroup = new MerchandiseGroup();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $conditions['idHotel'] = $dataSend['idHotel'];
        $listData= $modelMerchandiseGroup->find('all',array('conditions'=>$conditions));

        $return = array('code'=>1,'listData'=>$listData);
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function getListServiceByCategoryAPI($input)
{
    $modelUser= new Userhotel();
    $modelMerchandise = new Merchandise();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $page = (int) $dataSend['page'];
        if ($page <= 0) $page = 1;
        $limit= 15;
        $conditions['idHotel'] = $dataSend['idHotel'];
        $conditions['type_merchandise']= $dataSend['idMerchandiseGroup'];

        $listData= $modelMerchandise->getPage($page, $limit,$conditions);

        $return = array('code'=>1,'listData'=>$listData);
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function saveNotificationUserAPI($input)
{
    global $contactSite;
    global $smtpSite;

    $modelUser= new Userhotel();
    $modelNotification = new Notification();
    $modelHotel= new Hotel();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    if(!empty($dataUser['User']['accessToken'])){
        $today= getdate();

        $save['Notification']['idHotel']= $dataSend['idHotel'];
        $save['Notification']['idRoom']= $dataSend['idRoom'];
        $save['Notification']['content']= $dataSend['content'];
        $save['Notification']['time']= $today[0];
        $save['Notification']['idUser']= $dataUser['User']['id'];
        $save['Notification']['user']= $dataUser['User']['user'];
        $save['Notification']['phone']= $dataSend['phone'];
        $save['Notification']['to']= 'manager';

        if($modelNotification->save($save)){
            $return = array('code'=>0);
            $hotel= $modelHotel->getHotel($dataSend['idHotel'],array('email') );
            if(!empty($hotel['Hotel']['email'])){
                // send email for user and admin
                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                $to = array(trim($hotel['Hotel']['email']) );
                $cc = array();
                $bcc = array();
                $subject = '[' . $smtpSite['Option']['value']['show'] . '] Thông báo mới từ khách hàng';

                // create content email

                $content = 'Bạn nhận được thông báo mới từ khách hàng, nội dung như sau:<br/><br/>'.$dataSend['content'];
                
                $modelNotification->sendMail($from, $to, $cc, $bcc, $subject, $content);
            }
        }else{
            $return = array('code'=>1);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function getListRequestUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelNotification = new Notification();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    $return = array('code'=>0);

    if(!empty($dataUser['User']['accessToken'])){
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('idUser'=>$dataUser['User']['id'],'idHotel'=>$dataSend['idHotel'],'to'=>'manager');
        $order = array('created' => 'desc');
        $fields= array();

        $data= $modelNotification->getPage($page, $limit , $conditions, $order, $fields );

        $return = array('code'=>1,'data'=>$data);
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function getListNotificationUserAPI($input)
{
    $modelUser= new Userhotel();
    $modelNotification = new Notification();

    $dataSend = $input['request']->data;
    $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    $return = array('code'=>0);

    if(!empty($dataUser['User']['accessToken'])){
        $page = (!empty($dataSend['page']))?(int)$dataSend['page']:1;
        if($page<1) $page=1;
        $limit= 15;
        $conditions = array('idHotel'=>$dataSend['idHotel'],'to'=>'customer');
        $order = array('created' => 'desc');
        $fields= array();

        $conditions['$or'][0]['idUser']= $dataUser['User']['id'];
        $conditions['$or'][1]['idRoom']= "";

        $data= $modelNotification->getPage($page, $limit , $conditions, $order, $fields );

        $return = array('code'=>1,'data'=>$data);
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

?>