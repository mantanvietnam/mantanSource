<?php

/**
 * Thêm đặt phòng
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerCheckin($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkLoginManager()) {
        // Lay thong tin phong
        $modelRoom = new Room();
        $dataRoom = $modelRoom->getRoom($_GET['idroom']);
        // Lay danh sach loai phong
        $modelTypeRoom = new TypeRoom();
        $typeRoom = $modelTypeRoom->getTypeRoom($dataRoom['Room']['typeRoom']);
        $today = getdate();
        if ($isRequestPost) {
            $modelRoom = new Room();
            $dataSend = arrayMap($input['request']->data);
            //debug ($dataSend);
            $dateCheckin = strtotime(str_replace("/", "-", $dataSend['date_checkin']) . ' ' . $dataSend['time_checkin']);
            //debug ($dataSend['date_checkout_foresee']);
            if ($dataSend['date_checkout_foresee'] != '')
                $dateCheckoutForesee = strtotime(str_replace("/", "-", $dataSend['date_checkout_foresee']) . ' ' . $dataSend['time_checkout_foresee']);
            else
                $dateCheckoutForesee = null;
            //debug ($dateCheckoutForesee);
            if ($dateCheckoutForesee != null && $dateCheckin >= $dateCheckoutForesee) {
                $mess = 'Thời gian checkout phải lớn hơn thời gian checkin. Mời nhập lại!';
                setVariable('mess', $mess);
            } else {
                $save['price'] = (int) $dataSend['price'];

                $save['dateCheckin'] = $dateCheckin;
                $save['dateCheckoutForesee'] = $dateCheckoutForesee;
                $save['prepay'] = (int) $dataSend['prepay'];
                $save['type_register'] = $dataSend['type_register'];
                $save['number_people'] = (int) $dataSend['number_people'];
                $save['note'] = $dataSend['note'];
                $save['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                $save['idHotel'] = $_SESSION['idHotel'];
                $save['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                $save['typeDate'] = $dataSend['typeDate'];;
                $save['promotion'] = (int) $dataSend['promotion'];
                $save['khachDoan'] = $dataSend['khachDoan'];
                $save['agency'] = $dataSend['agency'];
                $save['paymentCycle']['number'] = $dataSend['paymentCycle'];

                switch($dataSend['paymentCycle']){
                    case '1': $save['paymentCycle']['time']= $dateCheckoutForesee;break;
                    case '2': $save['paymentCycle']['time']= $dateCheckin+86400;break;
                    case '3': $save['paymentCycle']['time']= $dateCheckin+604800;break;
                    case '4': $save['paymentCycle']['time']= strtotime("+1 months",$dateCheckin);break;
                    case '5': $save['paymentCycle']['time']= strtotime("+3 months",$dateCheckin);break;
                    case '6': $save['paymentCycle']['time']= strtotime("+6 months",$dateCheckin);break;
                    case '7': $save['paymentCycle']['time']= strtotime("+1 year",$dateCheckin);break;
                }

                // Thong tin khach 
                if($dataSend['khachDoan']=='co'){
                    if(isset($dataSend['idRoomDoan'])){
                        if($dataSend['idRoomDoan']=='new'){
                            $save['Custom']['truongDoan'] = true;
                            $save['Custom']['color'] = $dataSend['color'];
                        }else{
                            $infoTruongDoan= explode('-', $dataSend['idRoomDoan']);
                            $save['Custom']['idRoomDoan'] = $infoTruongDoan[0];
                            $save['Custom']['color'] = $infoTruongDoan[1];
                        }
                    }   


                }

                $save['Custom']['id'] = $dataSend['idUser'];
                $save['Custom']['cus_name'] = !empty($dataSend['cus_name']) ? $dataSend['cus_name'] : 'Khách lẻ';
                $save['Custom']['email'] = !empty($dataSend['email']) ? $dataSend['email'] : '';
                $save['Custom']['cmnd'] = !empty($dataSend['cmnd']) ? $dataSend['cmnd'] : '';
                $save['Custom']['address'] = !empty($dataSend['cus_address']) ? $dataSend['cus_address'] : '';
                $save['Custom']['phone'] = $dataSend['phone'];
                $save['Custom']['nationality'] = $dataSend['nationality'];
                $save['Custom']['birthday'] = $dataSend['birthday'];
                $save['Custom']['user'] = $dataSend['user'];
                if (!empty($dataSend['bienSoXe'])) {
                    $save['Custom']['bienSoXe'] = $dataSend['bienSoXe'];
                } else {
                    $save['Custom']['bienSoXe'] = '';
                }

                if(!empty($dataSend['birthday'])){
                    $birthday= explode('/', $dataSend['birthday']);
                    $save['Custom']['birthdayTime']= mktime(0,0,0,$birthday[1],$birthday[0],$birthday[2]);
                }else{
                    $save['Custom']['birthdayTime']= null;
                }


                //$save['Custom']['birthday'] = $dataSend['birthday'];
                //$save['Custom']['info_deal'] = $dataSend['info_deal'];
                //$save['Custom']['note'] = $dataSend['cus_note'];
                //debug ($dataSend['idUser']);
                if ($save['Custom']['id'] == '' && $save['Custom']['cmnd']!='') {
                    $modelCustom = new Custom();
                    $infoCustom = $modelCustom->getCusByCmnd($save['Custom']['cmnd']);
                    $save['Custom']['id']= (!empty($infoCustom['Custom']['id']))?$infoCustom['Custom']['id']:new MongoId();

                    $modelCustom->save($save);
                    //$save['Custom']['id'] = $modelCustom->getLastInsertID();
                }

                // Thong tin hang hoa
                if (!empty($typeRoom['TypeRoom']['hang_hoa'])) {
                    foreach ($typeRoom['TypeRoom']['hang_hoa'] as $key => $value) {
                        $save['hang_hoa'][$key] = 0;
                    }
                }
                
                $return = $modelRoom->checkInRoom($save, $dataSend['idroom']);

                if ($return) {
                    // Tao phieu thu tam ung
                    if($dataSend['prepay']>0){
                        $modelCollectionBill = new CollectionBill();
                        $save = array();
                        $save['CollectionBill']['time'] = $today[0];
                        $save['CollectionBill']['coin'] = (int) $dataSend['prepay'];
                        $save['CollectionBill']['nguoi_nop'] = $save['Custom']['cus_name'];
                        $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                        $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                        $save['CollectionBill']['note'] = 'Tạm ứng tiền phòng ' . $dataRoom['Room']['name'];
                        $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
                        $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                        $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
    
                        $modelCollectionBill->save($save);
                    }
                   
                    $modelRoom->redirect($urlPlugins . 'managerHotelDiagram?checkin=1');
                } else {
                    $modelRoom->redirect($urlPlugins . 'managerHotelDiagram?checkin=-1');
                }
            }
        }
        setVariable('dataRoom', $dataRoom);
        setVariable('typeRoom', $typeRoom);
        setVariable('today', $today);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// Load thong tin khach hang bang Ajax
function ajaxCusForCheckIn() {
    global $isRequestPost;
    $modelCustom = new Custom();
    if (checkLoginManager()) {
        if ($isRequestPost) {
            $data = $modelCustom->getCusByCmnd($_POST['cmnd']);
            //debug ($data);
            //debug ($_POST['cmnd']);
            setVariable('data', $data);
        }
    } else {
        //$modelUser->redirect($urlHomes);
    }
}

/*
// Load thong tin gia phong bang Ajax
function ajaxPriceCheckIn() {
    global $isRequestPost;
    if (checkLoginManager()) {
        if ($isRequestPost) {
            $modelTypeRoom = new TypeRoom();
            $modelPromotion = new Promotion();

            $typeRoom = $modelTypeRoom->getTypeRoom($_POST['typeRoom']);
            $data = $typeRoom['TypeRoom']['ngay_thuong'];

            switch ($_POST['typeCheckin']) {
                case 'gia_theo_gio':
                    $gia_theo_gio = array_values($data['gia_theo_gio']);
                    $data = $gia_theo_gio[0];
                    break;
                case 'gia_qua_dem':
                    $data = $data['gia_qua_dem'];
                    break;
                case 'gia_theo_ngay':
                    $data = $data['gia_ngay'];
                    break;
            }

            $promotion = $modelPromotion->checkPromotion($_SESSION['idHotel'], $_POST['typeRoom']);
           
            if($promotion<=100){
                $promotion= round($data*$promotion/100);
            }

            setVariable('data', $data);
            setVariable('promotion', $promotion);
        }
    } else {
        //$modelUser->redirect($urlHomes);
    }
}
*/
// Load thong tin gia phong bang Ajax
function ajaxPriceCheckIn() {
    global $isRequestPost;
    if (checkLoginManager()) {
        if ($isRequestPost) {
            $modelHoliday = new Holiday();
            $modelTypeRoom = new TypeRoom();
            $modelPromotion = new Promotion();

            $typeRoom = $modelTypeRoom->getTypeRoom($_POST['typeRoom']);
            $checkin = strtotime(str_replace("/", "-", $_POST['date_checkin']) . ' ' . $_POST['time_checkin']);
            $convertCheckin = getdate($checkin);
            $weekday = $convertCheckin['weekday'];
            $data = '';
            //debug ($modelHoliday->checkToday($checkin));
            $typeDate = 'ngay_thuong';

            if ($modelHoliday->checkToday($checkin, $_SESSION['idHotel'])) {
                $typeDate = 'ngay_le';
                $data = $typeRoom['TypeRoom']['ngay_le'];
            } elseif ($weekday == 'Saturday' || $weekday == 'Sunday') {
                $typeDate = 'ngay_cuoi_tuan';
                $data = $typeRoom['TypeRoom']['ngay_cuoi_tuan'];
            } else {
                $typeDate = 'ngay_thuong';
                $data = $typeRoom['TypeRoom']['ngay_thuong'];
            }

            switch ($_POST['typeCheckin']) {
                case 'gia_theo_gio':
                    $gia_theo_gio = array_values($data['gia_theo_gio']);
                    $data = $gia_theo_gio[0];
                    break;
                case 'gia_qua_dem':
                    $data = $data['gia_qua_dem'];
                    break;
                case 'gia_theo_ngay':
                    $data = $data['gia_ngay'];
                    break;
                case 'gia_thang':
                    $data = $typeRoom['TypeRoom']['gia_thang'];
                    break;
                case 'gia_nam':
                    $data = $typeRoom['TypeRoom']['gia_nam'];
                    break;
            }

            $promotion = $modelPromotion->checkPromotion($_SESSION['idHotel'], $_POST['typeRoom']);

            setVariable('data', $data);
            setVariable('typeDateCheck', $typeDate);
            setVariable('promotion', $promotion);
        }
    } else {
        //$modelUser->redirect($urlHomes);
    }
}

// Huy checkin
function managerCancelCheckin() {
    if (checkLoginManager()) {
        $idroom = $_POST['idroom'];
        $modelRoom = new Room();
        $dataRoom = $modelRoom->getRoom($idroom);
        //debug ($dataRoom);
        if (isset($dataRoom['Room']['checkin'])) {
            $array = $dataRoom['Room']['checkin'];
            $array['idRoom'] = $idroom;
            $array['cancel'] = 1;
            $array['note_cancel'] = $_POST['note'];

            $save['Book'] = $array;
            $modelBook = new Book();
            $modelBook->save($save);
        }

        $idroom = new MongoId($idroom);
        $modelRoom->updateAll(array('$unset' => array('checkin' => '')), array('_id' => $idroom));
    }
}

// Khach tra phong - Checkout
function managerCheckout() {
    global $urlHomes;
    global $modelUser;
    if (checkLoginManager()) {
        // Lay thong tin phong
        $modelRoom = new Room();
        $modelMerchandise = new Merchandise();

        $dataRoom = $modelRoom->getRoom($_GET['idroom']);
        // Lay danh sach loai phong
        $modelTypeRoom = new TypeRoom();
        $typeRoom = $modelTypeRoom->getTypeRoom($dataRoom['Room']['typeRoom']);
        $today = getdate();
        $dateCheckin = getdate($dataRoom['Room']['checkin']['dateCheckin']);

        // tinh thoi gian da o
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
                    $dataRoom['Room']['checkin']['hang_hoa'][$hang_hoa] = array('name' => $merchandise['Merchandise']['name'],
                                                                                'price' => $merchandise['Merchandise']['price'],
                                                                                'number' => $dataRoom['Room']['checkin']['hang_hoa'][$hang_hoa],
                                                                                'idMerchandiseGroup'=> $merchandise['Merchandise']['type_merchandise'],
                                                                                'code'=> $merchandise['Merchandise']['code']
                                                                            );
                }
            }
        }

        // tinh gia phong
        $priceRoom = 0;
        //$type_date = $dataRoom['Room']['checkin']['typeDate'];
        $type_date= $dataRoom['Room']['checkin']['typeDate'];
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
            if(!isset($typeRoom['TypeRoom'][$type_date]['gia_ngay'])) $typeRoom['TypeRoom'][$type_date]['gia_ngay']=0;
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

        $_SESSION['infoCheckout'] = array(
            'dataRoom' => $dataRoom,
            'typeRoom' => $typeRoom,
            'today' => $today,
            'textUse' => $textUse,
            'type_register' => $type_register,
            'priceRoom' => $priceRoom,
            'priceMerchandise' => $priceMerchandise,
            'pricePay' => $pricePay,
            'pricePeople' => $pricePeople,
            'idroom' => $_GET['idroom']
        );

        setVariable('dataRoom', $dataRoom);
        setVariable('typeRoom', $typeRoom);
        setVariable('today', $today);
        setVariable('textUse', $textUse);
        setVariable('type_register', $type_register);
        setVariable('priceRoom', $priceRoom);
        setVariable('priceMerchandise', $priceMerchandise);
        setVariable('pricePay', $pricePay);
        setVariable('pricePeople', $pricePeople);
        setVariable('giam_tru', $giam_tru);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

// Xac nhan thong tin tra phong cua khach
function managerCheckoutConfirm() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {
        $pricePay = 0;
        $priceMerchandise = 0;
        $priceRoom = (int) $_POST['priceCheckout'];
        $giam_tru = (int) $_POST['giam_tru'];
        $prepay = (int) $_POST['prepay'];
        $pricePeople = (int) $_POST['pricePeople'];
        $_SESSION['infoCheckout']['priceRoom'] = $priceRoom;

        if (!empty($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'])) {
            foreach ($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'] as $key => $value) {
                $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'][$key]['number'] = (int) $_POST['priceMerchandise'][$key];
                $priceMerchandise+= $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'][$key]['number'] * $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'][$key]['price'];
            }
        }

        $pricePay = ($priceRoom + $priceMerchandise + $pricePeople) - ($giam_tru + $prepay);
        if($_POST['hinhThucThu']=='tien_mat'){
            $hinhThucThu = 'Tiền mặt';
        }
        if($_POST['hinhThucThu']=='chuyen_khoan'){
            $hinhThucThu = 'Chuyển khoản';
        }
        if($_POST['hinhThucThu']=='the_tin_dung'){
            $hinhThucThu = 'Thẻ tín dụng';
        }
        if($_POST['hinhThucThu']=='hinh_thuc_khac'){
            $hinhThucThu = 'Hình thức khác';
        }

        $modelFloor = new Floor();
        $modelRoom = new Room();
        $listFloor = $modelFloor->getAllByHotel($_SESSION['idHotel']);
        $listRooms = array();

        foreach ($listFloor as $floor) {
            $listRooms[$floor['Floor']['id']] = array();
            foreach ($floor['Floor']['listRooms'] as $idRoom) {
                $dataRoomFloor = $modelRoom->getRoomUse($idRoom);

                if ($dataRoomFloor) {
                    array_push($listRooms[$floor['Floor']['id']], $dataRoomFloor);
                }
            }
        }

        setVariable('listFloor', $listFloor);
        setVariable('listRooms', $listRooms);
        
        $_SESSION['infoCheckout']['giam_tru'] = $giam_tru;
        $_SESSION['infoCheckout']['prepay'] = $prepay;
        $_SESSION['infoCheckout']['statusPay'] = $_POST['statusPay'];
        $_SESSION['infoCheckout']['hinhThucThu'] = $hinhThucThu;
        $_SESSION['infoCheckout']['note'] = $_POST['note'];
        $_SESSION['infoCheckout']['priceMerchandise'] = $priceMerchandise;
        $_SESSION['infoCheckout']['pricePay'] = $pricePay;
        $_SESSION['infoCheckout']['pricePeople'] = $pricePeople;

        setVariable('dataRoom', $_SESSION['infoCheckout']['dataRoom']);
        setVariable('typeRoom', $_SESSION['infoCheckout']['typeRoom']);
        setVariable('today', $_SESSION['infoCheckout']['today']);
        setVariable('textUse', $_SESSION['infoCheckout']['textUse']);
        setVariable('type_register', $_SESSION['infoCheckout']['type_register']);
        setVariable('priceRoom', $_SESSION['infoCheckout']['priceRoom']);
        setVariable('priceMerchandise', $_SESSION['infoCheckout']['priceMerchandise']);
        setVariable('pricePay', $_SESSION['infoCheckout']['pricePay']);
        setVariable('hinhThucThu', $hinhThucThu);
        setVariable('giam_tru', $giam_tru);
        setVariable('prepay', $prepay);
        setVariable('statusPaySelect', $_POST['statusPay']);
        setVariable('note', $_POST['note']);
        setVariable('pricePeople', $pricePeople);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function managerChangRoom() {
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $modelRoom = new Room();
        $modelRoom->changCheckIn($_POST['fromRoom'], $_POST['toRoom']);
    }
}

// xu ly checkout
function managerCheckoutProcess() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $modelRoom = new Room();
        $modelBook = new Book();
        $modelMerchandise = new Merchandise();
        $modelCollectionBill = new CollectionBill();
        $modelRevenue = new Revenue();
        $modelMerchandiseStatic = new MerchandiseStatic();
        $modelHotel= new Hotel();
        $modelAgency= new Agency();

        $idRoom = new MongoId($_SESSION['infoCheckout']['idroom']);
        $saveRoom['$unset']['checkin']= '';
        $saveRoom['$unset']['changePriceRoom']= '';
        $saveRoom['$set']['clear']= false;
        
        $modelRoom->updateAll($saveRoom, array('_id' => $idRoom));

        $dataHotel = $modelHotel->getHotel($_SESSION['idHotel']);

        // Nếu có sử dụng hàng hóa
        if (!empty($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'])) {
            
            foreach ($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                $save['$inc']['quantity'] = 0 - $info['number'];
                $idMerchandise = new MongoId($hang_hoa);
                $modelMerchandise->create();
                $modelMerchandise->updateAll($save, array('_id' => $idMerchandise));
                
                // Luu thong ke hang hoa su dung
                $saveMerchandise['MerchandiseStatic']= $info;
                $saveMerchandise['MerchandiseStatic']['time']= getdate();
                $saveMerchandise['MerchandiseStatic']['room']['id']= $_SESSION['infoCheckout']['dataRoom']['Room']['id'];
                $saveMerchandise['MerchandiseStatic']['room']['name']= $_SESSION['infoCheckout']['dataRoom']['Room']['name'];
                $saveMerchandise['MerchandiseStatic']['idHotel']= $_SESSION['idHotel'];
                $saveMerchandise['MerchandiseStatic']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                $saveMerchandise['MerchandiseStatic']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                
                $modelMerchandiseStatic->create();
                $modelMerchandiseStatic->save($saveMerchandise);
            }
        }

        // nếu có hàng hóa từ phòng khác chuyển sang
        if(!empty($_SESSION['infoCheckout']['dataRoom']['Room']['changePriceRoom'])){
            foreach($_SESSION['infoCheckout']['dataRoom']['Room']['changePriceRoom'] as $changePriceRoom){
                if(!empty($changePriceRoom['hang_hoa'])){
                    foreach ($changePriceRoom['hang_hoa'] as $hang_hoa => $info) {
                        $save['$inc']['quantity'] = 0 - $info['number'];
                        $idMerchandise = new MongoId($hang_hoa);
                        $modelMerchandise->create();
                        $modelMerchandise->updateAll($save, array('_id' => $idMerchandise));
                        
                        // Luu thong ke hang hoa su dung
                        $saveMerchandise['MerchandiseStatic']= $info;
                        $saveMerchandise['MerchandiseStatic']['time']= getdate();
                        $saveMerchandise['MerchandiseStatic']['room']['id']= $changePriceRoom['idRoom'];
                        $saveMerchandise['MerchandiseStatic']['room']['name']= $changePriceRoom['nameRoom'];
                        $saveMerchandise['MerchandiseStatic']['idHotel']= $_SESSION['idHotel'];
                        $saveMerchandise['MerchandiseStatic']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                        $saveMerchandise['MerchandiseStatic']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                        
                        $modelMerchandiseStatic->create();
                        $modelMerchandiseStatic->save($saveMerchandise);
                    }
                }
            }
        }

        $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['idStaffCheckout'] = $_SESSION['infoManager']['Manager']['idStaff'];
        $modelBook->save($_SESSION['infoCheckout']);
        
        // Tao phieu thu tien phong
        if($_SESSION['infoCheckout']['priceRoom']>0){
            $save = array();
            $save['CollectionBill']['time'] = $_SESSION['infoCheckout']['today'][0];
            $save['CollectionBill']['coin'] = (int) $_SESSION['infoCheckout']['priceRoom'];
            $save['CollectionBill']['nguoi_nop'] = $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['Custom']['cus_name'];
            $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
            $save['CollectionBill']['note'] = 'Thanh toán tiền phòng ' . $_SESSION['infoCheckout']['dataRoom']['Room']['name'];
            $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
            $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            if($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan'){
                $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
            }elseif($_SESSION['infoCheckout']['statusPay'] == 'cong_no'){
                $save['CollectionBill']['typeCollectionBill'] = 'cong_no';
            }
            
            $modelCollectionBill->create();
            $modelCollectionBill->save($save);
        }
        
        // Tao phieu thu hang hoa dich vu
        if($_SESSION['infoCheckout']['priceMerchandise']>0){
            $save = array();
            $save['CollectionBill']['time'] = $_SESSION['infoCheckout']['today'][0];
            $save['CollectionBill']['coin'] = (int) $_SESSION['infoCheckout']['priceMerchandise'];
            $save['CollectionBill']['nguoi_nop'] = $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['Custom']['cus_name'];
            $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
            $save['CollectionBill']['note'] = 'Thanh toán tiền hàng hóa dịch vụ cho phòng ' . $_SESSION['infoCheckout']['dataRoom']['Room']['name'];
            $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
            $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
            
            if($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan'){
                $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
            }elseif($_SESSION['infoCheckout']['statusPay'] == 'cong_no'){
                $save['CollectionBill']['typeCollectionBill'] = 'cong_no';
            }

            $modelCollectionBill->create();
            $modelCollectionBill->save($save);
        }

        // nếu thanh toán tiền mặt
        if ($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan') {
            $modelRevenue->updateCoin($_SESSION['infoCheckout']['dataRoom']['Room']['manager'], $_SESSION['infoCheckout']['dataRoom']['Room']['hotel'], $_SESSION['infoCheckout']['pricePay']);

            // Tinh doanh thu cho nguoi gioi thieu
            if(!empty($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['agency'])){
                $saveAgency['Agency']= array(   'emailAgency'=>$_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['agency'],
                                                'timeCheckout'=>$_SESSION['infoCheckout']['today'],
                                                'pricePay'=>$_SESSION['infoCheckout']['pricePay'],
                                                'nameRoom'=>$_SESSION['infoCheckout']['dataRoom']['Room']['name'],
                                                'nameHotel'=>@$dataHotel['Hotel']['name'],
                                                'nameCustom'=>$_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['Custom']['cus_name'],
                                                'idHotel'=>$_SESSION['idHotel']
                                            );
                $modelAgency->create();
                $modelAgency->save($saveAgency);
            }
        }
        
        setVariable('dataRoom', $_SESSION['infoCheckout']['dataRoom']);
        setVariable('typeRoom', $_SESSION['infoCheckout']['typeRoom']);
        setVariable('today', $_SESSION['infoCheckout']['today']);
        setVariable('textUse', $_SESSION['infoCheckout']['textUse']);
        setVariable('type_register', $_SESSION['infoCheckout']['type_register']);
        setVariable('priceRoom', $_SESSION['infoCheckout']['priceRoom']);
        setVariable('priceMerchandise', $_SESSION['infoCheckout']['priceMerchandise']);
        setVariable('pricePay', $_SESSION['infoCheckout']['pricePay']);
        setVariable('hinhThucThu', $_SESSION['infoCheckout']['hinhThucThu']);
        setVariable('giam_tru', $_SESSION['infoCheckout']['giam_tru']);
        setVariable('prepay', $_SESSION['infoCheckout']['prepay']);
        setVariable('statusPaySelect', $_SESSION['infoCheckout']['statusPay']);
        setVariable('pricePeople', $_SESSION['infoCheckout']['pricePeople']);
        setVariable('dataHotel', $dataHotel);
        
        unset($_SESSION['infoCheckout']);

        //$modelRoom->redirect($urlHomes . 'managerHotelDiagram');
    } else {
        $modelUser->redirect($urlHomes);
    }
}

/**
 * Thông tin chi tiết phòng khi checkin
 * @author SonTT<js.trantrongson@gmail.com>
 */
function managerViewRoomDetail($input) {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    
    if (checkLoginManager()) {
        $modelRoom = new Room();
        $modelTypeRoom = new TypeRoom();
        $modelMerchandise = new Merchandise();

        $idRoom = $_GET['idroom'];
        $dataRoom = $modelRoom->getRoom($idRoom);
        $typeRoom = $modelTypeRoom->getTypeRoom($dataRoom['Room']['typeRoom']);
        $mess= '';
        
        if($isRequestPost){
            $dataSend = arrayMap($input['request']->data);
            // Thong tin khach 
            $dataRoom['Room']['checkin']['Custom']['cus_name']= $dataSend['cus_name'];
            $dataRoom['Room']['checkin']['Custom']['address']= $dataSend['cus_address'];
            $dataRoom['Room']['checkin']['Custom']['phone']= $dataSend['phone'];
            $dataRoom['Room']['checkin']['Custom']['email']= $dataSend['email'];
            $dataRoom['Room']['checkin']['Custom']['nationality']= $dataSend['nationality'];
            $dataRoom['Room']['checkin']['Custom']['bienSoXe']= $dataSend['bienSoXe'];
            $dataRoom['Room']['checkin']['Custom']['user']= $dataSend['user'];
            $dataRoom['Room']['checkin']['note']= $dataSend['note'];
            $dataRoom['Room']['checkin']['agency']= $dataSend['agency'];
            
            $dataRoom['Room']['checkin']['Custom']['birthday']= $dataSend['birthday'];
            $birthday= explode('/', $dataSend['birthday']);
            $dataRoom['Room']['checkin']['Custom']['birthdayTime']= mktime(0,0,0,$birthday[1],$birthday[0],$birthday[2]);

            $modelRoom->save($dataRoom);
            $mess= 'Lưu thông tin thành công';
        }
        
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
      
        setVariable('textUse', $textUse);
        setVariable('type_register', $type_register);
        setVariable('priceRoom', $priceRoom);
        setVariable('priceMerchandise', $priceMerchandise);
        setVariable('pricePay', $pricePay);
        setVariable('pricePeople', $pricePeople);
        setVariable('giam_tru', $giam_tru);
        setVariable('typeRoom', $typeRoom['TypeRoom']['roomtype']);
        setVariable('dataRoom', $dataRoom);
        setVariable('mess', $mess);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function managerAddServiceRoom($input) {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;

    if (checkLoginManager()) {
        $modelRoom = new Room();
        $modelMerchandise = new Merchandise();
        $modelMerchandiseGroup = new MerchandiseGroup();
        $modelMaterials = new Materials();
        $numberProduct=1;
        
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }

        $idRoom = $_GET['idroom'];
        $dataRoom = $modelRoom->getRoom($idRoom);

        $dataMerchandiseGroup = $modelMerchandiseGroup->getPage(1, null, $conditions);
        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);
            if(isset($_POST['numberProduct'])){
                $numberProduct= (int) $_POST['numberProduct'];
            }else{
                if (!empty($_POST['idHangHoa']) && !empty($_POST['soluong'])) {
                    foreach($_POST['idHangHoa'] as $key=>$idHangHoa){
                        if(!empty($idHangHoa) && !empty( $_POST['soluong'][$key])){
                            $save['$inc']['checkin.hang_hoa.' . $idHangHoa] = (int) $_POST['soluong'][$key];
                            
                            $infoMerchandise= $modelMerchandise->getMerchandise($idHangHoa);
                            if(!empty($infoMerchandise['Merchandise']['materials'])){
                                foreach($infoMerchandise['Merchandise']['materials'] as $idMaterials=>$value){
                                    $saveMaterials= array();
                                    $saveMaterials['$inc']['quantity']= (0-$value)*$_POST['soluong'][$key];
                                    
                                    $modelMaterials->create();
                                    $modelMaterials->updateAll($saveMaterials, array('_id' => new MongoId($idMaterials)));
                                }
                            }
                        }
                    }
                    $modelRoom->updateAll($save, array('_id' => new MongoId($idRoom)));
    
                    $modelRoom->redirect($urlHomes . 'managerHotelDiagram');
                }
                
            }
        }

        setVariable('numberProduct', $numberProduct);
        setVariable('dataRoom', $dataRoom);
        setVariable('dataMerchandiseGroup', $dataMerchandiseGroup);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function ajaxListKhachDoan($input)
{
    global $isRequestPost;

    $listTruongDoan= array();
    if (checkLoginManager()) {
        $modelRoom = new Room();
        $dataRoom = $modelRoom->getAllRoomByHotel($_SESSION['idHotel']);

        if(!empty($dataRoom)){
            foreach ($dataRoom as $key => $data) {
                if(isset($data['Room']['checkin']['Custom']['truongDoan']) && $data['Room']['checkin']['Custom']['truongDoan']==true){
                    $data['Room']['checkin']['Custom']['idRoom']= $data['Room']['id'];
                    $listTruongDoan[]= $data['Room']['checkin']['Custom'];
                }
            }
        }
    }

    setVariable('listTruongDoan', $listTruongDoan);
}

function changePriceRoom($input)
{
    global $isRequestPost;
    global $urlHomes;

    $modelRoom = new Room();
    $modelMerchandise = new Merchandise();
    
    if (checkLoginManager()) {
        if($isRequestPost){
            
            $roomFrom= $modelRoom->getRoom($_POST['idRoomFrom']);

            if($roomFrom){
                // load thong tin hang hoa
                if (!empty($roomFrom['Room']['checkin']['hang_hoa'])) {
                    foreach ($roomFrom['Room']['checkin']['hang_hoa'] as $hang_hoa => $number) {
                        $merchandise = $modelMerchandise->getMerchandise($hang_hoa);
                        if ($merchandise) {
                            $roomFrom['Room']['checkin']['hang_hoa'][$hang_hoa] = array('name' => $merchandise['Merchandise']['name'],
                                                                                        'price' => $merchandise['Merchandise']['price'],
                                                                                        'number' => $roomFrom['Room']['checkin']['hang_hoa'][$hang_hoa],
                                                                                        'idMerchandiseGroup'=> $merchandise['Merchandise']['type_merchandise'],
                                                                                        'code'=> $merchandise['Merchandise']['code']
                                                                                    );
                        }
                    }
                }


                $saveRoomTo['$push']['changePriceRoom']= $roomFrom['Room']['checkin'];
                $saveRoomTo['$push']['changePriceRoom']['nameRoom']= $roomFrom['Room']['name'];
                $saveRoomTo['$push']['changePriceRoom']['idRoom']= $roomFrom['Room']['id'];
                $saveRoomTo['$push']['changePriceRoom']['infoPay']= array(  'giam_tru'=>$_SESSION['infoCheckout']['giam_tru'],
                                                                            'prepay'=>$_SESSION['infoCheckout']['prepay'],
                                                                            'priceMerchandise'=>$_SESSION['infoCheckout']['priceMerchandise'],
                                                                            'pricePay'=>$_SESSION['infoCheckout']['pricePay'],
                                                                            'pricePeople'=>$_SESSION['infoCheckout']['pricePeople'],
                                                                            'priceRoom'=>$_SESSION['infoCheckout']['priceRoom'],
                                                                        );


                $dk= array('_id'=> new MongoId($_POST['idRoomTo']));

                $modelRoom->updateAll($saveRoomTo,$dk);
                $modelRoom->create();

                $saveRoomFrom['$unset']['checkin']= "";
                $saveRoomFrom['$set']['clear']= false;
                $dk= array('_id'=> new MongoId($_POST['idRoomFrom']));
                $modelRoom->updateAll($saveRoomFrom,$dk);
            }
        }

        $modelRoom->redirect($urlHomes.'managerHotelDiagram?status=changePriceRoom');
    } else {
        $modelRoom->redirect($urlHomes);
    }
}

// Khach thanh toán tiền trước
function managerPrepay() {
    global $urlHomes;
    global $modelUser;
    if (checkLoginManager()) {
        // Lay thong tin phong
        $modelRoom = new Room();
        $modelMerchandise = new Merchandise();

        $dataRoom = $modelRoom->getRoom($_GET['idroom']);
        // Lay danh sach loai phong
        $modelTypeRoom = new TypeRoom();
        $typeRoom = $modelTypeRoom->getTypeRoom($dataRoom['Room']['typeRoom']);
        $today = getdate();
        $dateCheckin = getdate($dataRoom['Room']['checkin']['dateCheckin']);

        // tinh thoi gian da o
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
                    $dataRoom['Room']['checkin']['hang_hoa'][$hang_hoa] = array('name' => $merchandise['Merchandise']['name'],
                                                                                'price' => $merchandise['Merchandise']['price'],
                                                                                'number' => $dataRoom['Room']['checkin']['hang_hoa'][$hang_hoa],
                                                                                'idMerchandiseGroup'=> $merchandise['Merchandise']['type_merchandise'],
                                                                                'code'=> $merchandise['Merchandise']['code']
                                                                            );
                }
            }
        }

        // tinh gia phong
        $priceRoom = 0;
        //$type_date = $dataRoom['Room']['checkin']['typeDate'];
        $type_date= $dataRoom['Room']['checkin']['typeDate'];
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
            if(!isset($typeRoom['TypeRoom'][$type_date]['gia_ngay'])) $typeRoom['TypeRoom'][$type_date]['gia_ngay']=0;
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

        $_SESSION['infoCheckout'] = array(
            'dataRoom' => $dataRoom,
            'typeRoom' => $typeRoom,
            'today' => $today,
            'textUse' => $textUse,
            'type_register' => $type_register,
            'priceRoom' => $priceRoom,
            'priceMerchandise' => $priceMerchandise,
            'pricePay' => $pricePay,
            'pricePeople' => $pricePeople,
            'idroom' => $_GET['idroom']
        );

        setVariable('dataRoom', $dataRoom);
        setVariable('typeRoom', $typeRoom);
        setVariable('today', $today);
        setVariable('textUse', $textUse);
        setVariable('type_register', $type_register);
        setVariable('priceRoom', $priceRoom);
        setVariable('priceMerchandise', $priceMerchandise);
        setVariable('pricePay', $pricePay);
        setVariable('pricePeople', $pricePeople);
        setVariable('giam_tru', $giam_tru);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

// Xac nhan thong tin tra trước tiền phong cua khach
function managerPrepayConfirm() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {
        $pricePay = 0;
        $priceMerchandise = 0;
        $priceRoom = (int) $_POST['priceCheckout'];
        $giam_tru = (int) $_POST['giam_tru'];
        $prepay = (int) $_POST['prepay'];
        $pricePeople = (int) $_POST['pricePeople'];
        $_SESSION['infoCheckout']['priceRoom'] = $priceRoom;

        if (!empty($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'])) {
            foreach ($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'] as $key => $value) {
                $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'][$key]['number'] = (int) $_POST['priceMerchandise'][$key];
                $priceMerchandise+= $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'][$key]['number'] * $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'][$key]['price'];
            }
        }

        $pricePay = ($priceRoom + $priceMerchandise + $pricePeople) - ($giam_tru + $prepay);
        if($_POST['hinhThucThu']=='tien_mat'){
            $hinhThucThu = 'Tiền mặt';
        }
        if($_POST['hinhThucThu']=='chuyen_khoan'){
            $hinhThucThu = 'Chuyển khoản';
        }
        if($_POST['hinhThucThu']=='the_tin_dung'){
            $hinhThucThu = 'Thẻ tín dụng';
        }
        if($_POST['hinhThucThu']=='hinh_thuc_khac'){
            $hinhThucThu = 'Hình thức khác';
        }

        $modelFloor = new Floor();
        $modelRoom = new Room();
        $listFloor = $modelFloor->getAllByHotel($_SESSION['idHotel']);
        $listRooms = array();

        foreach ($listFloor as $floor) {
            $listRooms[$floor['Floor']['id']] = array();
            foreach ($floor['Floor']['listRooms'] as $idRoom) {
                $dataRoomFloor = $modelRoom->getRoomUse($idRoom);

                if ($dataRoomFloor) {
                    array_push($listRooms[$floor['Floor']['id']], $dataRoomFloor);
                }
            }
        }

        setVariable('listFloor', $listFloor);
        setVariable('listRooms', $listRooms);
        
        $_SESSION['infoCheckout']['giam_tru'] = $giam_tru;
        $_SESSION['infoCheckout']['prepay'] = $prepay;
        $_SESSION['infoCheckout']['statusPay'] = $_POST['statusPay'];
        $_SESSION['infoCheckout']['hinhThucThu'] = $hinhThucThu;
        $_SESSION['infoCheckout']['note'] = $_POST['note'];
        $_SESSION['infoCheckout']['priceMerchandise'] = $priceMerchandise;
        $_SESSION['infoCheckout']['pricePay'] = $pricePay;
        $_SESSION['infoCheckout']['pricePeople'] = $pricePeople;

        setVariable('dataRoom', $_SESSION['infoCheckout']['dataRoom']);
        setVariable('typeRoom', $_SESSION['infoCheckout']['typeRoom']);
        setVariable('today', $_SESSION['infoCheckout']['today']);
        setVariable('textUse', $_SESSION['infoCheckout']['textUse']);
        setVariable('type_register', $_SESSION['infoCheckout']['type_register']);
        setVariable('priceRoom', $_SESSION['infoCheckout']['priceRoom']);
        setVariable('priceMerchandise', $_SESSION['infoCheckout']['priceMerchandise']);
        setVariable('pricePay', $_SESSION['infoCheckout']['pricePay']);
        setVariable('hinhThucThu', $hinhThucThu);
        setVariable('giam_tru', $giam_tru);
        setVariable('prepay', $prepay);
        setVariable('statusPaySelect', $_POST['statusPay']);
        setVariable('note', $_POST['note']);
        setVariable('pricePeople', $pricePeople);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

// xu ly tra truoc
function managerPrepayProcess() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $modelRoom = new Room();
        $modelBook = new Book();
        $modelMerchandise = new Merchandise();
        $modelCollectionBill = new CollectionBill();
        $modelRevenue = new Revenue();
        $modelMerchandiseStatic = new MerchandiseStatic();
        $modelHotel= new Hotel();
        $modelAgency= new Agency();

        $idRoom = new MongoId($_SESSION['infoCheckout']['idroom']);
        $saveRoom['$unset']['checkin']= '';
        $saveRoom['$unset']['changePriceRoom']= '';
        $saveRoom['$set']['clear']= false;
        
        $modelRoom->updateAll($saveRoom, array('_id' => $idRoom));

        $dataHotel = $modelHotel->getHotel($_SESSION['idHotel']);

        // Nếu có sử dụng hàng hóa
        if (!empty($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'])) {
            
            foreach ($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                $save['$inc']['quantity'] = 0 - $info['number'];
                $idMerchandise = new MongoId($hang_hoa);
                $modelMerchandise->create();
                $modelMerchandise->updateAll($save, array('_id' => $idMerchandise));
                
                // Luu thong ke hang hoa su dung
                $saveMerchandise['MerchandiseStatic']= $info;
                $saveMerchandise['MerchandiseStatic']['time']= getdate();
                $saveMerchandise['MerchandiseStatic']['room']['id']= $_SESSION['infoCheckout']['dataRoom']['Room']['id'];
                $saveMerchandise['MerchandiseStatic']['room']['name']= $_SESSION['infoCheckout']['dataRoom']['Room']['name'];
                $saveMerchandise['MerchandiseStatic']['idHotel']= $_SESSION['idHotel'];
                $saveMerchandise['MerchandiseStatic']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                $saveMerchandise['MerchandiseStatic']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                
                $modelMerchandiseStatic->create();
                $modelMerchandiseStatic->save($saveMerchandise);
            }
        }

        // nếu có hàng hóa từ phòng khác chuyển sang
        if(!empty($_SESSION['infoCheckout']['dataRoom']['Room']['changePriceRoom'])){
            foreach($_SESSION['infoCheckout']['dataRoom']['Room']['changePriceRoom'] as $changePriceRoom){
                if(!empty($changePriceRoom['hang_hoa'])){
                    foreach ($changePriceRoom['hang_hoa'] as $hang_hoa => $info) {
                        $save['$inc']['quantity'] = 0 - $info['number'];
                        $idMerchandise = new MongoId($hang_hoa);
                        $modelMerchandise->create();
                        $modelMerchandise->updateAll($save, array('_id' => $idMerchandise));
                        
                        // Luu thong ke hang hoa su dung
                        $saveMerchandise['MerchandiseStatic']= $info;
                        $saveMerchandise['MerchandiseStatic']['time']= getdate();
                        $saveMerchandise['MerchandiseStatic']['room']['id']= $changePriceRoom['idRoom'];
                        $saveMerchandise['MerchandiseStatic']['room']['name']= $changePriceRoom['nameRoom'];
                        $saveMerchandise['MerchandiseStatic']['idHotel']= $_SESSION['idHotel'];
                        $saveMerchandise['MerchandiseStatic']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                        $saveMerchandise['MerchandiseStatic']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                        
                        $modelMerchandiseStatic->create();
                        $modelMerchandiseStatic->save($saveMerchandise);
                    }
                }
            }
        }

        $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['idStaffCheckout'] = $_SESSION['infoManager']['Manager']['idStaff'];
        $modelBook->save($_SESSION['infoCheckout']);
        
        // Tao phieu thu tien phong
        if($_SESSION['infoCheckout']['priceRoom']>0){
            $save = array();
            $save['CollectionBill']['time'] = $_SESSION['infoCheckout']['today'][0];
            $save['CollectionBill']['coin'] = (int) $_SESSION['infoCheckout']['priceRoom'];
            $save['CollectionBill']['nguoi_nop'] = $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['Custom']['cus_name'];
            $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
            $save['CollectionBill']['note'] = 'Thanh toán tiền phòng ' . $_SESSION['infoCheckout']['dataRoom']['Room']['name'];
            $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
            $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            if($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan'){
                $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
            }elseif($_SESSION['infoCheckout']['statusPay'] == 'cong_no'){
                $save['CollectionBill']['typeCollectionBill'] = 'cong_no';
            }
            
            $modelCollectionBill->create();
            $modelCollectionBill->save($save);
        }
        
        // Tao phieu thu hang hoa dich vu
        if($_SESSION['infoCheckout']['priceMerchandise']>0){
            $save = array();
            $save['CollectionBill']['time'] = $_SESSION['infoCheckout']['today'][0];
            $save['CollectionBill']['coin'] = (int) $_SESSION['infoCheckout']['priceMerchandise'];
            $save['CollectionBill']['nguoi_nop'] = $_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['Custom']['cus_name'];
            $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
            $save['CollectionBill']['note'] = 'Thanh toán tiền hàng hóa dịch vụ cho phòng ' . $_SESSION['infoCheckout']['dataRoom']['Room']['name'];
            $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
            $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
            
            if($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan'){
                $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
            }elseif($_SESSION['infoCheckout']['statusPay'] == 'cong_no'){
                $save['CollectionBill']['typeCollectionBill'] = 'cong_no';
            }

            $modelCollectionBill->create();
            $modelCollectionBill->save($save);
        }

        // nếu thanh toán tiền mặt
        if ($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan') {
            $modelRevenue->updateCoin($_SESSION['infoCheckout']['dataRoom']['Room']['manager'], $_SESSION['infoCheckout']['dataRoom']['Room']['hotel'], $_SESSION['infoCheckout']['pricePay']);

            // Tinh doanh thu cho nguoi gioi thieu
            if(!empty($_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['agency'])){
                $saveAgency['Agency']= array(   'emailAgency'=>$_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['agency'],
                                                'timeCheckout'=>$_SESSION['infoCheckout']['today'],
                                                'pricePay'=>$_SESSION['infoCheckout']['pricePay'],
                                                'nameRoom'=>$_SESSION['infoCheckout']['dataRoom']['Room']['name'],
                                                'nameHotel'=>@$dataHotel['Hotel']['name'],
                                                'nameCustom'=>$_SESSION['infoCheckout']['dataRoom']['Room']['checkin']['Custom']['cus_name'],
                                                'idHotel'=>$_SESSION['idHotel']
                                            );
                $modelAgency->create();
                $modelAgency->save($saveAgency);
            }
        }
        
        setVariable('dataRoom', $_SESSION['infoCheckout']['dataRoom']);
        setVariable('typeRoom', $_SESSION['infoCheckout']['typeRoom']);
        setVariable('today', $_SESSION['infoCheckout']['today']);
        setVariable('textUse', $_SESSION['infoCheckout']['textUse']);
        setVariable('type_register', $_SESSION['infoCheckout']['type_register']);
        setVariable('priceRoom', $_SESSION['infoCheckout']['priceRoom']);
        setVariable('priceMerchandise', $_SESSION['infoCheckout']['priceMerchandise']);
        setVariable('pricePay', $_SESSION['infoCheckout']['pricePay']);
        setVariable('hinhThucThu', $_SESSION['infoCheckout']['hinhThucThu']);
        setVariable('giam_tru', $_SESSION['infoCheckout']['giam_tru']);
        setVariable('prepay', $_SESSION['infoCheckout']['prepay']);
        setVariable('statusPaySelect', $_SESSION['infoCheckout']['statusPay']);
        setVariable('pricePeople', $_SESSION['infoCheckout']['pricePeople']);
        setVariable('dataHotel', $dataHotel);
        
        unset($_SESSION['infoCheckout']);

        //$modelRoom->redirect($urlHomes . 'managerHotelDiagram');
    } else {
        $modelUser->redirect($urlHomes);
    }
}

?>