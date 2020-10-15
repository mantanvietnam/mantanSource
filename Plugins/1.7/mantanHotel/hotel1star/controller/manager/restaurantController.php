<?php

// Duong dan trang chu
global $urlHomeManager;
global $urlHomes;
$urlHomeManager = $urlHomes . 'homeManager';

// Danh sach tang
function managerListRestaurantFloor() {
    $modelRestaurantFloor = new RestaurantFloor();
    global $urlHomes;
    if (checkLoginManager()) {
        $listData = $modelRestaurantFloor->getAllByHotel($_SESSION['idHotel']);
        //debug ($listData);
        setVariable('listData', $listData);
    } else {
        $modelRestaurantFloor->redirect($urlHomes);
    }
}

// Them tang
function managerAddRestaurantFloor() {

    global $urlHomes;
    global $isRequestPost;
    $modelRestaurantFloor = new RestaurantFloor();

    if (checkLoginManager()) {
        $mess = '';
        if (isset($_GET['redirect'])) {
            switch ($_GET['redirect']) {
                case 'managerProcessOrder': $mess = 'Bạn phải tạo tầng trước khi xử lý yêu cầu đặt bàn';
                    break;
                case 'managerHotelDiagram': $mess = 'Bạn phải tạo tầng trước khi xem sơ đồ nhà hàng';
                    break;
            }
        }
        setVariable('mess', $mess);

        if ($isRequestPost) {
            if (!empty($_POST['id'])) {
                $floor = $modelRestaurantFloor->updateRestaurantFloor($_POST['color'], $_POST['name'], $_POST['note'], $_POST['id']);
            } else {
                $floor = $modelRestaurantFloor->saveRestaurantFloor($_POST['color'], $_POST['name'], $_POST['note'], $_SESSION['idHotel'], $_SESSION['infoManager']['Manager']['id'], $_POST['id']);
                $modelTable = new Table();
                $listTable = $modelTable->creatTableFloor($floor['RestaurantFloor']['id'], $floor['RestaurantFloor']['name'], $floor['RestaurantFloor']['hotel'], $floor['RestaurantFloor']['manager'], $_POST['tables']);
                $modelRestaurantFloor->addTable($floor['RestaurantFloor']['id'], $listTable);
            }
            $modelRestaurantFloor->redirect($urlHomes . 'managerListRestaurantFloor');
        } elseif (isset($_GET['idRestaurantFloor']) && ($_GET['idRestaurantFloor']) != '') {
            $data = $modelRestaurantFloor->getRestaurantFloor($_GET['idRestaurantFloor']);
            setVariable('data', $data);
        }
    } else {
        $modelRestaurantFloor->redirect($urlHomes);
    }
}

// Xoa tang
function managerDeleteRestaurantFloor() {
    $modelRestaurantFloor = new RestaurantFloor();
    global $urlHomes;
    if (checkLoginManager()) {
        $data = $modelRestaurantFloor->getRestaurantFloor($_POST['idDelete']);

        if ($data['RestaurantFloor']['manager'] == $_SESSION['infoManager']['Manager']['id'] && $data['RestaurantFloor']['hotel'] == $_SESSION['idHotel']) {
            //debug ($data);
            $modelTable = new Table();
            foreach ($data['RestaurantFloor']['listTables'] as $idtable)
                $modelTable->delete($idtable);
            $modelRestaurantFloor->delete($_POST['idDelete']);
        }
    } else {
        $modelRestaurantFloor->redirect($urlHomes);
    }
}

//managerRestaurantDiagram
function managerRestaurantDiagram() {
    $modelRestaurantFloor = new RestaurantFloor();
    global $urlHomes;
    if (checkLoginManager()) {
        // Lay danh sach tang
        $modelRestaurantFloor = new RestaurantFloor();
        $listRestaurantFloor = $modelRestaurantFloor->getAllByHotel($_SESSION['idHotel']);

        if (empty($listRestaurantFloor)) {
            $modelRestaurantFloor->redirect($urlHomes . 'managerAddRestaurantFloor?redirect=managerHotelDiagram');
        }

        // Lay danh sach phong
        $modelTable = new Table();
        $listTables = array();
        $totalEmpty = 0;
        $totalUse = 0;
//        $totalWaiting = 0;
        $totalUnClear = 0;
//        $totalKhachDoan = 0;

        $modelOrder = new Order();
        $today = getdate();
        $timeStart = mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);
        $timeEnd = mktime(23, 59, 59, $today['mon'], $today['mday'], $today['year']);

        $conditionsOrder['idHotel'] = $_SESSION['idHotel'];
        $conditionsOrder['status'] = 1;
        $conditionsOrder['time_start'] = array('$gte' => $timeStart, '$lte' => $timeEnd);

        foreach ($listRestaurantFloor as $floor) {
            $listTables[$floor['RestaurantFloor']['id']] = array();
            foreach ($floor['RestaurantFloor']['listTables'] as $idtable) {
                $dataTable = $modelTable->getTableUse($idtable);

                if ($dataTable) {

                    if (isset($dataTable['Table']['clear']) && $dataTable['Table']['clear'] == FALSE) {
                        $totalUnClear++;
                    } elseif (!empty($dataTable['Table']['checkin'])) {
                        $totalUse++;
                    } else {
                        $totalEmpty++;
                    }

                    $conditionsOrder['listTables'] = $dataTable['Table']['id'];
//                    $countWaiting = $modelOrder->find('count', array('conditions' => $conditionsOrder));

//                    if ($countWaiting > 0) {
//                        $totalWaiting++;
//                        $dataTable['Table']['waiting'] = true;
//                    } else {
//                        $dataTable['Table']['waiting'] = false;
//                    }

                    array_push($listTables[$floor['RestaurantFloor']['id']], $dataTable);
                }
            }
        }
        setVariable('listRestaurantFloor', $listRestaurantFloor);

        setVariable('listTables', $listTables);
        setVariable('totalEmpty', $totalEmpty);
        setVariable('totalUse', $totalUse);
        setVariable('totalUnClear', $totalUnClear);
//        setVariable('totalWaiting', $totalWaiting);
    } else {
        $modelRestaurantFloor->redirect($urlHomes);
    }
}

// Thêm bàn
function managerAddTableRestaurant() {
    $modelTable = new Table();
    global $urlHomes;
    if (checkLoginManager()) {


        // Lay danh sach tang
        $modelRestaurantFloor = new RestaurantFloor();
        $listRestaurantFloor = $modelRestaurantFloor->getAllByHotel($_SESSION['idHotel']);

        if (empty($listRestaurantFloor)) {
            $modelTable->redirect($urlHomes . 'managerAddRestaurantFloor');
        }
        //debug ($listRestaurantFloor);
        setVariable('listRestaurantFloor', $listRestaurantFloor);
        global $isRequestPost;
        if ($isRequestPost) {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $modelTable->updateTable($_POST['name'], $_POST['id']);
                $modelTable->redirect($urlHomes . 'managerRestaurantDiagram');
            } else {
                $return = $modelTable->creatTable($_POST['floor'], $_POST['name'], $_SESSION['idHotel'], $_SESSION['infoManager']['Manager']['id']);
                $modelRestaurantFloor->addTable($_POST['floor'], array($return));
                $modelTable->redirect($urlHomes . 'managerRestaurantDiagram');
            }
        } elseif (isset($_GET['idtable']) && ($_GET['idtable']) != '') {
            $data = $modelTable->getTable($_GET['idtable']);
            setVariable('data', $data);
        }
    } else {
        $modelTable->redirect($urlHomes);
    }
}

function managerDeleteTableRestaurant() {
    $modelRestaurantFloor = new RestaurantFloor();
    $modelTable = new Table();
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {
        $data = $modelTable->getTable($_POST['idtable'], $_SESSION['infoManager']['Manager']['id'], $_SESSION['idHotel']);
        if ($data) {
            $modelRestaurantFloor->deleteTable($data['Table']['floor'], $data['Table']['id']);
            $modelTable->deleteTable($_POST['idtable']);
            //$modelTable->redirect($urlHomes.'managerHotelDiagram');
        } else {
            //$modelTable->redirect($urlHomeManager);
        }
    } else {
        //$modelRestaurantFloor->redirect($urlHomes);
    }
}

function managerClearTableRestaurant() {
    $modelTable = new Table();
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {

        $data = $modelTable->getTable($_POST['idtable'], $_SESSION['infoManager']['Manager']['id'], $_SESSION['idHotel']);
        if ($data) {

            $saveTable['$set']['clear'] = true;
            $idtable = new MongoId($_POST['idtable']);
            $modelTable->updateAll($saveTable, array('_id' => $idtable));
        } else {
//            $modelTable->redirect($urlHomeManager);
        }
    } else {
        //$modelRestaurantFloor->redirect($urlHomes);
    }
}

function managerCheckinRestaurant() {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkLoginManager()) {
        // Lay thong tin ban
        $modelTable = new Table();
        $dataTable = $modelTable->getTable($_GET['idtable']);
        $today = getdate();
        if ($isRequestPost) {
            //debug ($_POST);
            $dateCheckin = strtotime(str_replace("/", "-", $_POST['date_checkin']) . ' ' . $_POST['time_checkin']);
            $save['dateCheckin'] = $dateCheckin;
            $save['number_people'] = (int) $_POST['number_people'];
            $save['cus_name'] = $_POST['cus_name'];
            $save['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
            $save['idHotel'] = $_SESSION['idHotel'];
            $save['idManager'] = $_SESSION['infoManager']['Manager']['id'];

            $return = $modelTable->checkInTable($save, $_GET['idtable']);

            $modelTable->redirect($urlPlugins . 'managerRestaurantDiagram?checkin=1');
        }
        setVariable('dataTable', $dataTable);
        setVariable('today', $today);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function managerCancelCheckinRestaurant() {
    if (checkLoginManager()) {
        $idtable = $_POST['idtable'];
        $modelTable = new Table();
        $dataRoom = $modelTable->getTable($idtable);
        //debug ($dataRoom);
        if (isset($dataRoom['Table']['checkin'])) {
            $array = $dataRoom['Table']['checkin'];
            $array['idtable'] = $idtable;
            $array['cancel'] = 1;
            $array['note_cancel'] = $_POST['note'];

            $save['LogRestaurant'] = $array;
            $modelLogRestaurant = new LogRestaurant();
            $modelLogRestaurant->save($save);
        }
        $idtable = new MongoId($idtable);
        $modelTable->updateAll(array('$unset' => array('checkin' => '')), array('_id' => $idtable));
    }
}

function managerChangTableRestaurant() {
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $modelTable = new Table();
        $modelTable->changCheckIn($_POST['fromRoom'], $_POST['toRoom']);
    }
}

function managerAddServiceTableRestaurant() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;

    if (checkLoginManager()) {
        $modelTable = new Table();
        $modelMerchandise = new Merchandise();
        $modelMerchandiseGroup = new MerchandiseGroup();
        $modelMaterials = new Materials();
        
        $numberProduct=1;
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }

        $idtable = $_GET['idtable'];
        $dataTable = $modelTable->getTable($idtable);

        $dataMerchandiseGroup = $modelMerchandiseGroup->getPage(1, null, $conditions);
        if ($isRequestPost) {
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
                    $modelTable->updateAll($save, array('_id' => new MongoId($idtable)));
    
                    $modelTable->redirect($urlHomes . 'managerRestaurantDiagram');
                }
            }
        }

        setVariable('dataTable', $dataTable);
        setVariable('dataMerchandiseGroup', $dataMerchandiseGroup);
        setVariable('numberProduct', $numberProduct);
        
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function managerViewTableRestaurantDetail() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;
    if (checkLoginManager()) {
        $modelTable = new Table();
        $modelMerchandise = new Merchandise();

        $idtable = $_GET['idtable'];
        $dataTable = $modelTable->getTable($idtable);
        if (!isset($dataTable['Table']['checkin']['cus_name']) || $dataTable['Table']['checkin']['cus_name'] == "") {
            $dataTable['Table']['checkin']['cus_name'] = "Khách lẻ";
        }

        // tinh thoi gian da o
        $today = getdate();
        $dateCheckin = getdate($dataTable['Table']['checkin']['dateCheckin']);
        $textUse = '';
        $timeUse = $today[0] - $dataTable['Table']['checkin']['dateCheckin'];
        $surplus = $timeUse % 86400;
        $dateUser = ($timeUse - $surplus) / 86400;

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
        if (!empty($dataTable['Table']['checkin']['hang_hoa'])) {
            foreach ($dataTable['Table']['checkin']['hang_hoa'] as $hang_hoa => $number) {
                $merchandise = $modelMerchandise->getMerchandise($hang_hoa);
                if ($merchandise) {
                    $priceMerchandise+= $merchandise['Merchandise']['price'] * $dataTable['Table']['checkin']['hang_hoa'][$hang_hoa];
                    $dataTable['Table']['checkin']['hang_hoa'][$hang_hoa] = array(
                        'name' => $merchandise['Merchandise']['name'],
                        'price' => $merchandise['Merchandise']['price'],
                        'number' => $number,
                    );
                }
            }
        }


        // Tien can thanh toan
        $pricePay = $priceMerchandise;

        setVariable('textUse', $textUse);
        setVariable('priceMerchandise', $priceMerchandise);
        setVariable('pricePay', $pricePay);
        setVariable('dataTable', $dataTable);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function managerCheckoutRestaurant() {
    global $urlHomes;
    global $modelUser;
    if (checkLoginManager()) {
        // Lay thong tin phong
        $modelTable = new Table();
        $modelMerchandise = new Merchandise();

        $dataTable = $modelTable->getTable($_GET['idtable']);
        if (!isset($dataTable['Table']['checkin']['cus_name']) || $dataTable['Table']['checkin']['cus_name'] == "") {
            $dataTable['Table']['checkin']['cus_name'] = "Khách lẻ";
        }

        // tinh thoi gian da o
        $today = getdate();
        $dateCheckin = getdate($dataTable['Table']['checkin']['dateCheckin']);
        $textUse = '';
        $timeUse = $today[0] - $dataTable['Table']['checkin']['dateCheckin'];
        $surplus = $timeUse % 86400;
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
        if (!empty($dataTable['Table']['checkin']['hang_hoa'])) {
            foreach ($dataTable['Table']['checkin']['hang_hoa'] as $hang_hoa => $number) {
                $merchandise = $modelMerchandise->getMerchandise($hang_hoa);
                if ($merchandise) {
                    $priceMerchandise+= $merchandise['Merchandise']['price'] * $dataTable['Table']['checkin']['hang_hoa'][$hang_hoa];
                    $dataTable['Table']['checkin']['hang_hoa'][$hang_hoa] = array('name' => $merchandise['Merchandise']['name'],
                        'price' => $merchandise['Merchandise']['price'],
                        'number' => $dataTable['Table']['checkin']['hang_hoa'][$hang_hoa],
                        'idMerchandiseGroup' => $merchandise['Merchandise']['type_merchandise'],
                        'code' => $merchandise['Merchandise']['code']
                    );
                }
            }
        }



        // Tien can thanh toan
        $pricePay = $priceMerchandise;

        $_SESSION['infoCheckout'] = array(
            'dataTable' => $dataTable,
            'today' => $today,
            'textUse' => $textUse,
            'priceMerchandise' => $priceMerchandise,
            'pricePay' => $pricePay,
            'idtable' => $_GET['idtable']
        );

        setVariable('dataTable', $dataTable);
        setVariable('today', $today);
        setVariable('textUse', $textUse);
        setVariable('priceMerchandise', $priceMerchandise);
        setVariable('pricePay', $pricePay);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function managerCheckoutRestaurantConfirm() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {
        $pricePay = 0;
        $priceMerchandise = 0;

        if (!empty($_SESSION['infoCheckout']['dataTable']['Table']['checkin']['hang_hoa'])) {
            foreach ($_SESSION['infoCheckout']['dataTable']['Table']['checkin']['hang_hoa'] as $key => $value) {
                $_SESSION['infoCheckout']['dataTable']['Table']['checkin']['hang_hoa'][$key]['number'] = (int) $_POST['priceMerchandise'][$key];
                $priceMerchandise+= $_SESSION['infoCheckout']['dataTable']['Table']['checkin']['hang_hoa'][$key]['number'] * $_SESSION['infoCheckout']['dataTable']['Table']['checkin']['hang_hoa'][$key]['price'];
            }
        }

        $pricePay = $priceMerchandise-(int) $_POST['giam_tru'];
        if ($_POST['hinhThucThu'] == 'tien_mat') {
            $hinhThucThu = 'Tiền mặt';
        }
        if ($_POST['hinhThucThu'] == 'chuyen_khoan') {
            $hinhThucThu = 'Chuyển khoản';
        }
        if ($_POST['hinhThucThu'] == 'the_tin_dung') {
            $hinhThucThu = 'Thẻ tín dụng';
        }
        if ($_POST['hinhThucThu'] == 'hinh_thuc_khac') {
            $hinhThucThu = 'Hình thức khác';
        }

        $_SESSION['infoCheckout']['statusPay'] = $_POST['statusPay'];
        $_SESSION['infoCheckout']['hinhThucThu'] = $hinhThucThu;
        $_SESSION['infoCheckout']['note'] = $_POST['note'];
        $_SESSION['infoCheckout']['priceMerchandise'] = $priceMerchandise;
        $_SESSION['infoCheckout']['pricePay'] = $pricePay;
        $_SESSION['infoCheckout']['giam_tru'] = (int) $_POST['giam_tru'];

        setVariable('dataTable', $_SESSION['infoCheckout']['dataTable']);
        setVariable('today', $_SESSION['infoCheckout']['today']);
        setVariable('textUse', $_SESSION['infoCheckout']['textUse']);
        setVariable('priceMerchandise', $_SESSION['infoCheckout']['priceMerchandise']);
        setVariable('pricePay', $_SESSION['infoCheckout']['pricePay']);
        setVariable('hinhThucThu', $hinhThucThu);
        setVariable('statusPaySelect', $_POST['statusPay']);
        setVariable('note', $_POST['note']);
        setVariable('giam_tru', $_SESSION['infoCheckout']['giam_tru']);
    } else {
        $modelUser->redirect($urlHomes);
    }
}

function managerCheckoutRestaurantProcess() {
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $modelTable = new Table();
        $modelLogRestaurant = new LogRestaurant();
        $modelMerchandise = new Merchandise();
        $modelCollectionBill = new CollectionBill();
        $modelRevenue = new Revenue();
        $modelMerchandiseStatic = new MerchandiseStatic();
        $modelHotel= new Hotel();

        $idtable = new MongoId($_SESSION['infoCheckout']['idtable']);
        $saveTable['$unset']['checkin'] = '';
        $saveTable['$set']['clear'] = false;

        $modelTable->updateAll($saveTable, array('_id' => $idtable));

        if (!empty($_SESSION['infoCheckout']['dataTable']['Table']['checkin']['hang_hoa'])) {

            foreach ($_SESSION['infoCheckout']['dataTable']['Table']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                $save['$inc']['quantity'] = 0 - $info['number'];
                $idMerchandise = new MongoId($hang_hoa);
                $modelMerchandise->create();
                $modelMerchandise->updateAll($save, array('_id' => $idMerchandise));

                // Luu thong ke hang hoa su dung
                $saveMerchandise['MerchandiseStatic'] = $info;
                $saveMerchandise['MerchandiseStatic']['time'] = getdate();
                $saveMerchandise['MerchandiseStatic']['Table']['id'] = $_SESSION['infoCheckout']['dataTable']['Table']['id'];
                $saveMerchandise['MerchandiseStatic']['Table']['name'] = $_SESSION['infoCheckout']['dataTable']['Table']['name'];
                $saveMerchandise['MerchandiseStatic']['idHotel'] = $_SESSION['idHotel'];
                $saveMerchandise['MerchandiseStatic']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                $saveMerchandise['MerchandiseStatic']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

                $modelMerchandiseStatic->create();
                $modelMerchandiseStatic->save($saveMerchandise);
            }
        }
        $_SESSION['infoCheckout']['dataTable']['Table']['checkin']['idStaffCheckout'] = $_SESSION['infoManager']['Manager']['idStaff'];
        $modelLogRestaurant->save($_SESSION['infoCheckout']);

        if ($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan') {
            $modelRevenue->updateCoin($_SESSION['infoCheckout']['dataTable']['Table']['manager'], $_SESSION['infoCheckout']['dataTable']['Table']['hotel'], $_SESSION['infoCheckout']['pricePay']);


            // Tao phieu thu hang hoa dich vu
            if ($_SESSION['infoCheckout']['priceMerchandise'] > 0) {
                $save = array();
                $save['CollectionBill']['time'] = $_SESSION['infoCheckout']['today'][0];
                $save['CollectionBill']['coin'] = (int) $_SESSION['infoCheckout']['priceMerchandise'];
                $save['CollectionBill']['nguoi_nop'] = $_SESSION['infoCheckout']['dataTable']['Table']['checkin']['cus_name'];
                $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                $save['CollectionBill']['note'] = 'Thanh toán tiền hàng hóa dịch vụ nhà hàng ' . $_SESSION['infoCheckout']['dataTable']['Table']['name'].' giảm trừ '.number_format($_SESSION['infoCheckout']['giam_tru']);
                $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
                $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

                $modelCollectionBill->create();
                $modelCollectionBill->save($save);
            }
        }
        
        $dataHotel = $modelHotel->getHotel($_SESSION['idHotel']);
        
        setVariable('dataTable', $_SESSION['infoCheckout']['dataTable']);
        setVariable('today', $_SESSION['infoCheckout']['today']);
        setVariable('textUse', $_SESSION['infoCheckout']['textUse']);
        setVariable('priceMerchandise', $_SESSION['infoCheckout']['priceMerchandise']);
        setVariable('pricePay', $_SESSION['infoCheckout']['pricePay']);
        setVariable('dataHotel', $dataHotel);
        setVariable('giam_tru', $_SESSION['infoCheckout']['giam_tru']);
        
        unset($_SESSION['infoCheckout']);

        //$modelTable->redirect($urlHomes . 'managerRestaurantDiagram');
    } else {
        $modelUser->redirect($urlHomes);
    }
}
function managerRevenueRestaurant()
    {
        global $modelOption;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $listData= array();
            $modelLogRestaurant = new LogRestaurant();
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0) $page = 1;
            $limit = 15;
            $conditions['statusPay'] = 'da_thanh_toan';
            
            $conditions['dataTable.Table.hotel'] = $_SESSION['idHotel'];
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['today.0']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['today.0']['$lte']= $dateEnd;
            }
            
            if(!empty($_GET['idStaff'])){
                $conditions['dataTable.Table.checkin.idStaff'] = $_GET['idStaff'];
            }
         
            
            $listData= $modelLogRestaurant->getPage($page, $limit, $conditions );

            $totalData = $modelLogRestaurant->find('count', array('conditions' => $conditions));

            $balance = $totalData % $limit;
            $totalPage = ($totalData - $balance) / $limit;
            if ($balance > 0)
                $totalPage+=1;
    
            $back = $page - 1;
            $next = $page + 1;
            if ($back <= 0)
                $back = 1;
            if ($next >= $totalPage)
                $next = $totalPage;
    
            if (isset($_GET['page'])) {
                $urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
                $urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
            } else {
                $urlPage = $urlNow;
            }
            if (strpos($urlPage, '?') !== false) {
                if (count($_GET) > 1) {
                    $urlPage = $urlPage . '&page=';
                } else {
                    $urlPage = $urlPage . 'page=';
                }
            } else {
                $urlPage = $urlPage . '?page=';
            }
            
            $modelStaff = new Staff();
            $conditionsStaff['idHotel']=$_SESSION['idHotel'];

            $listStaff= $modelStaff->getPage($page, $limit=100, $conditionsStaff );

            setVariable('listData', $listData);
            setVariable('listStaff', $listStaff);
    
            setVariable('page', $page);
            setVariable('totalPage', $totalPage);
            setVariable('back', $back);
            setVariable('next', $next);
            setVariable('urlPage', $urlPage);
            
            if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
                $table = array(
                    array('label' => __('STT'), 'width' => 5),
                    array('label' => __('Bàn'),'width' => 17, 'filter' => true, 'wrap' => true),
                    array('label' => __('Tên khách hàng'), 'width' => 15, 'filter' => true, 'wrap' => true),
                    array('label' => __('Thời gian vào'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Thời gian ra'), 'width' => 15, 'filter' => true),
                    array('label' => __('Tổng tiền'), 'width' => 20, 'filter' => true),
                );
                
                $data= array();
                $listDataAll= $modelLogRestaurant->getPage(1, null, $conditions );
                
                if (!empty($listDataAll)) {
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCheckin = getdate($tin['LogRestaurant']['dataTable']['Table']['checkin']['dateCheckin']);
                        $dateCheckout = $tin['LogRestaurant']['today'];
                        
                        $data[]= array( $stt,
                                        $tin['LogRestaurant']['dataTable']['Table']['name'],
                                        $tin['LogRestaurant']['dataTable']['Table']['checkin']['cus_name'],
                                        $dateCheckin['hours'] . ':' . $dateCheckin['minutes'] . ' ' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'],
                                        $dateCheckout['hours'] . ':' . $dateCheckout['minutes'] . ' ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'],
                                        number_format($tin['LogRestaurant']['pricePay']),
                                        );
                    }
                    
                }
                
                $exportsController = new ExportsController;
                $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
            }
        } else {
            $modelOption->redirect($urlHomes);
        }
    }
?>