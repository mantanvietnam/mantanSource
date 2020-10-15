<?php
function managerBarDiagram() {
    $modelBarTable= new BarTable();
    global $urlHomes;
    if (checkLoginManager()) {
        // Lay danh sach tang
        $modelBarFloor= new BarFloor();
        $listFloor = $modelBarFloor->getAllByHotel($_SESSION['idHotel']);

        if (empty($listFloor)) {
            $modelBarFloor->redirect($urlHomes . 'managerAddBarFloor?redirect=managerBarDiagram');
        }


        // Lay danh sach ban
        $listTable = array();
        $totalEmpty = 0;
        $totalUse = 0;
        $totalWaiting = 0;
        $totalUnClear = 0;
                
        $conditionsOrder['idHotel'] = $_SESSION['idHotel'];
        $conditionsOrder['status'] = 1;
        foreach ($listFloor as $floor) {
            $listTable[$floor['BarFloor']['id']] = array();
            foreach ($floor['BarFloor']['listTable'] as $idTable) {
                $dataTable= $modelBarTable->getTableUse($idTable);

                if ($dataTable) {
                    if (isset($dataTable['BarTable']['clear']) && $dataTable['BarTable']['clear']==FALSE) {
                        $totalUnClear++;
                    }elseif (!empty($dataTable['BarTable']['checkin'])) {
                        $totalUse++;
                    }else {
                        $totalEmpty++;
                    }
                    $dataTable['BarTable']['waiting']=false; // Dang fix cung
                    array_push($listTable[$floor['BarFloor']['id']], $dataTable);
                }
            }
        }
        setVariable('listFloor', $listFloor);
        setVariable('listTable', $listTable);
        setVariable('totalEmpty', $totalEmpty);
        setVariable('totalUse', $totalUse);
        setVariable('totalUnClear', $totalUnClear);
        setVariable('totalWaiting', $totalWaiting);
        //debug ($listTable);
        /*setVariable('listTypeBarTable', $listTypeBarTable);
        setVariable('listBarTables', $listBarTables);
        setVariable('totalEmpty', $totalEmpty);
        setVariable('totalUse', $totalUse);
        setVariable('totalUnClear', $totalUnClear);
        setVariable('totalWaiting', $totalWaiting);
        setVariable('totalKhachDoan', $totalKhachDoan);*/
    } else {
        $modelBarTable->redirect($urlHomes);
    }
}
function managerCheckinBar()
{
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;

    if (checkLoginManager()) {
        // Lay thong tin ban
        $modelBarTable= new BarTable();
        $dataTable = $modelBarTable->getTable($_GET['idTable']);
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
           

            $return = $modelBarTable->checkInTable($save, $_GET['idTable']);
            /*
            if ($return) {
                // Tao phieu thu tam ung
                if($_POST['prepay']>0){
                    $modelCollectionBill = new CollectionBill();
                    $save = array();
                    $save['CollectionBill']['time'] = $today[0];
                    $save['CollectionBill']['coin'] = (int) $_POST['prepay'];
                    $save['CollectionBill']['nguoi_nop'] = $save['Custom']['cus_name'];
                    $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                    $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                    $save['CollectionBill']['note'] = 'Tạm ứng tiền phòng ' . $dataTable['BarTable']['name'];
                    $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
                    $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                    $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];

                    $modelCollectionBill->save($save);
                }
                */
            $modelBarTable->redirect($urlPlugins . 'managerBarDiagram?checkin=1');
        }
        //debug ($today);
        setVariable('dataTable', $dataTable);
        setVariable('today', $today);
    } else {
        $modelOption->redirect($urlHomes);
    }
}
function managerCancelCheckinBar()
{
    if (checkLoginManager()) {
        $idTable = $_POST['idTable'];
        $modelBarTable= new BarTable();
        $dataTable = $modelBarTable->getTable($idTable);
        //debug ($dataTable);
        if (isset($dataTable['BarTable']['checkin'])) {
            $array = $dataTable['BarTable']['checkin'];
            $array['idTable'] = $idTable;
            $array['cancel'] = 1;
            $array['note_cancel'] = $_POST['note'];

            $save['LogBar'] = $array;
            $modelLogBar = new LogBar();
            $modelLogBar->save($save);
        }
        $idTable = new MongoId($idTable);
        $modelBarTable->updateAll(array('$unset' => array('checkin' => '')), array('_id' => $idTable));
    }
}
function managerChangBarTable() {
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $modelBarTable= new BarTable();
        $modelBarTable->changCheckIn($_POST['fromBarTable'], $_POST['toBarTable']);
    }
}
function managerAddServiceBarTable()
{
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;

    if (checkLoginManager()) {
        $modelBarTable= new BarTable();
        $modelMerchandise = new Merchandise();
        $modelMerchandiseGroup = new MerchandiseGroup();
        $modelMaterials = new Materials();
       
        $numberProduct=1;
        if (!empty($_SESSION['idHotel'])) {
            $conditions['idHotel'] = $_SESSION['idHotel'];
        }

        $idTable = $_GET['idTable'];
        $dataTable = $modelBarTable->getTable($idTable);

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
                    $modelBarTable->updateAll($save, array('_id' => new MongoId($idTable)));
    
                    $modelBarTable->redirect($urlHomes . 'managerBarDiagram');
                }
            }
        }

        setVariable('dataTable', $dataTable);
        setVariable('numberProduct', $numberProduct);
        setVariable('dataMerchandiseGroup', $dataMerchandiseGroup);
    } else {
        $modelUser->redirect($urlHomes);
    }
}
function managerViewBarTableDetail()
{
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;
    if (checkLoginManager()) {
        $modelBarTable= new BarTable();
        $modelMerchandise = new Merchandise();

        $idTable = $_GET['idTable'];
        $dataTable = $modelBarTable->getTable($idTable);
        if (!isset($dataTable['BarTable']['checkin']['cus_name']) || $dataTable['BarTable']['checkin']['cus_name']==""){
            $dataTable['BarTable']['checkin']['cus_name']="Khách lẻ";
        }

        // tinh thoi gian da o
        $today = getdate();
        $dateCheckin = getdate($dataTable['BarTable']['checkin']['dateCheckin']);
        $textUse = '';
        $timeUse = $today[0] - $dataTable['BarTable']['checkin']['dateCheckin'];
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
        if (!empty($dataTable['BarTable']['checkin']['hang_hoa'])) {
            foreach ($dataTable['BarTable']['checkin']['hang_hoa'] as $hang_hoa => $number) {
                $merchandise = $modelMerchandise->getMerchandise($hang_hoa);
                if ($merchandise) {
                    $priceMerchandise+= $merchandise['Merchandise']['price'] * $dataTable['BarTable']['checkin']['hang_hoa'][$hang_hoa];
                    $dataTable['BarTable']['checkin']['hang_hoa'][$hang_hoa] = array(
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
function managerCheckoutBar()
{
    global $urlHomes;
    global $modelUser;
    if (checkLoginManager()) {
        // Lay thong tin phong
        $modelBarTable= new BarTable();
        $modelMerchandise = new Merchandise();

        $dataTable = $modelBarTable->getTable($_GET['idTable']);
         if (!isset($dataTable['BarTable']['checkin']['cus_name']) || $dataTable['BarTable']['checkin']['cus_name']==""){
            $dataTable['BarTable']['checkin']['cus_name']="Khách lẻ";
        }

        // tinh thoi gian da o
        $today = getdate();
        $dateCheckin = getdate($dataTable['BarTable']['checkin']['dateCheckin']);
        $textUse = '';
        $timeUse = $today[0] - $dataTable['BarTable']['checkin']['dateCheckin'];
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
        if (!empty($dataTable['BarTable']['checkin']['hang_hoa'])) {
            foreach ($dataTable['BarTable']['checkin']['hang_hoa'] as $hang_hoa => $number) {
                $merchandise = $modelMerchandise->getMerchandise($hang_hoa);
                if ($merchandise) {
                    $priceMerchandise+= $merchandise['Merchandise']['price'] * $dataTable['BarTable']['checkin']['hang_hoa'][$hang_hoa];
                    $dataTable['BarTable']['checkin']['hang_hoa'][$hang_hoa] = array('name' => $merchandise['Merchandise']['name'],
                                                                                'price' => $merchandise['Merchandise']['price'],
                                                                                'number' => $dataTable['BarTable']['checkin']['hang_hoa'][$hang_hoa],
                                                                                'idMerchandiseGroup'=> $merchandise['Merchandise']['type_merchandise'],
                                                                                'code'=> $merchandise['Merchandise']['code']
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
            'idTable' => $_GET['idTable']
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
function managerCheckoutBarConfirm()
{
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;
    if (checkLoginManager() && $isRequestPost) {
        $pricePay = 0;
        $priceMerchandise = 0;

        if (!empty($_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['hang_hoa'])) {
            foreach ($_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['hang_hoa'] as $key => $value) {
                $_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['hang_hoa'][$key]['number'] = (int) $_POST['priceMerchandise'][$key];
                $priceMerchandise+= $_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['hang_hoa'][$key]['number'] * $_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['hang_hoa'][$key]['price'];
            }
        }

        $pricePay =$priceMerchandise-(int) $_POST['giam_tru'];
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
function managerCheckoutBarProcess()
{
    global $isRequestPost;
    global $urlHomes;
    global $modelUser;
    global $isRequestPost;

    if (checkLoginManager() && $isRequestPost) {
        $modelBarTable= new BarTable();
        $modelLogBar = new LogBar();
        $modelMerchandise = new Merchandise();
        $modelCollectionBill = new CollectionBill();
        $modelRevenue = new Revenue();
        $modelMerchandiseStatic = new MerchandiseStatic();
        $modelHotel= new Hotel();

        $idTable = new MongoId($_SESSION['infoCheckout']['idTable']);
        $saveTable['$unset']['checkin']= '';
        $saveTable['$set']['clear']= false;
        
        $modelBarTable->updateAll($saveTable, array('_id' => $idTable));

        if (!empty($_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['hang_hoa'])) {
            
            foreach ($_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['hang_hoa'] as $hang_hoa => $info) {
                $save['$inc']['quantity'] = 0 - $info['number'];
                $idMerchandise = new MongoId($hang_hoa);
                $modelMerchandise->create();
                $modelMerchandise->updateAll($save, array('_id' => $idMerchandise));
                
                // Luu thong ke hang hoa su dung
                $saveMerchandise['MerchandiseStatic']= $info;
                $saveMerchandise['MerchandiseStatic']['time']= getdate();
                $saveMerchandise['MerchandiseStatic']['BarTable']['id']= $_SESSION['infoCheckout']['dataTable']['BarTable']['id'];
                $saveMerchandise['MerchandiseStatic']['BarTable']['name']= $_SESSION['infoCheckout']['dataTable']['BarTable']['name'];
                $saveMerchandise['MerchandiseStatic']['idHotel']= $_SESSION['idHotel'];
                $saveMerchandise['MerchandiseStatic']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                $saveMerchandise['MerchandiseStatic']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                
                $modelMerchandiseStatic->create();
                $modelMerchandiseStatic->save($saveMerchandise);
            }
            
            
        }
        $_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['idStaffCheckout'] = $_SESSION['infoManager']['Manager']['idStaff'];
        $modelLogBar->save($_SESSION['infoCheckout']);
        
        if ($_SESSION['infoCheckout']['statusPay'] == 'da_thanh_toan') {
            $modelRevenue->updateCoin($_SESSION['infoCheckout']['dataTable']['BarTable']['manager'], $_SESSION['infoCheckout']['dataTable']['BarTable']['hotel'], $_SESSION['infoCheckout']['pricePay']);

            
            // Tao phieu thu hang hoa dich vu
            if($_SESSION['infoCheckout']['priceMerchandise']>0){
                $save = array();
                $save['CollectionBill']['time'] = $_SESSION['infoCheckout']['today'][0];
                $save['CollectionBill']['coin'] = (int) $_SESSION['infoCheckout']['priceMerchandise'];
                $save['CollectionBill']['nguoi_nop'] = $_SESSION['infoCheckout']['dataTable']['BarTable']['checkin']['cus_name'];
                $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                $save['CollectionBill']['note'] = 'Thanh toán tiền hàng hóa dịch vụ quán bar ' . $_SESSION['infoCheckout']['dataTable']['BarTable']['name'].' giảm trừ '.number_format($_SESSION['infoCheckout']['giam_tru']);
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

        //$modelBarTable->redirect($urlHomes . 'managerBarDiagram');
    } else {
        $modelUser->redirect($urlHomes);
    }
}
function managerLiabilitieBar()
{
    global $modelOption;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $mess= '';
            if(isset($_GET['redirect'])){
                switch($_GET['redirect']){
                    case 'managerEditLiabilitie': $mess= 'Chỉnh sửa công nợ thành công';break;
                }
            }
            
            $listData= array();
            $modelLogBar = new LogBar();
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0) $page = 1;
            $limit = 15;
            $conditions['statusPay'] = 'cong_no';
            $conditions['dataTable.BarTable.hotel'] = $_SESSION['idHotel'];
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['today.0']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['today.0']['$lte']= $dateEnd;
            }
            
            $listData= $modelLogBar->getPage($page, $limit, $conditions );
            
            $totalData = $modelLogBar->find('count', array('conditions' => $conditions));

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
    
            setVariable('listData', $listData);
    
            setVariable('page', $page);
            setVariable('totalPage', $totalPage);
            setVariable('back', $back);
            setVariable('next', $next);
            setVariable('urlPage', $urlPage);
            setVariable('mess', $mess);
            /*
            if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
                $table = array(
                    array('label' => __('STT'), 'width' => 5),
                    array('label' => __('CMT'),'width' => 10, 'filter' => true, 'wrap' => true),
                    array('label' => __('Họ tên'), 'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Ngày vào ra'), 'width' => 30,  'wrap' => true),
                    array('label' => __('Phòng'), 'width' => 10,  'wrap' => true),
                    array('label' => __('Số tiền'), 'width' => 10,  'wrap' => true),
                    array('label' => __('Địa chỉ'),'width' => 30, 'filter' => true, 'wrap' => true),
                    array('label' => __('Email'), 'width' => 15, 'filter' => true),
                    array('label' => __('Điện thoại'), 'width' => 10, 'filter' => true),
                );
                
                $data= array();
                $listDataAll= $modelLogBar->getPage(1, null, $conditions );
                if (!empty($listDataAll)) {
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCheckin = getdate($tin['LogBar']['dataTable']['BarTable']['checkin']['dateCheckin']);
                        $dateCheckout = $tin['LogBar']['today'];
                        
                        $data[]= array( $stt,
                                        $tin['LogBar']['dataTable']['BarTable']['checkin']['Custom']['cmnd'],
                                        $tin['LogBar']['dataTable']['BarTable']['checkin']['Custom']['cus_name'],
                                        $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'] . ' - ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'],
                                        $tin['LogBar']['dataTable']['BarTable']['name'],
                                        number_format($tin['LogBar']['pricePay']),
                                        $tin['LogBar']['dataTable']['BarTable']['checkin']['Custom']['address'],
                                        $tin['LogBar']['dataTable']['BarTable']['checkin']['Custom']['email'],
                                        $tin['LogBar']['dataTable']['BarTable']['checkin']['Custom']['phone'],
                                        );
                    }
                    
                }
                
                $exportsController = new ExportsController;
                $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
            }*/
        } else {
            $modelOption->redirect($urlHomes);
        }
}
function managerEditLiabilitieBar()
{
    global $isRequestPost;
        global $urlHomes;
        global $urlPlugins;
        global $modelUser;
        global $isRequestPost;
        if (checkLoginManager()) {
            $modelLogBar = new LogBar();
            $modelRevenue = new Revenue();
            
            $liabilitie= $modelLogBar->getLogBar($_GET['id']);
            
            if(!$liabilitie){
                $modelLogBar->redirect($urlHomes);
            }
    
            setVariable('dataTable', $liabilitie['LogBar']['dataTable']);
            setVariable('today', $liabilitie['LogBar']['today']);
            setVariable('textUse', $liabilitie['LogBar']['textUse']);
            setVariable('priceMerchandise', $liabilitie['LogBar']['priceMerchandise']);
            setVariable('pricePay', $liabilitie['LogBar']['pricePay']);
            setVariable('statusPaySelect', $liabilitie['LogBar']['statusPay']);
            setVariable('note', $liabilitie['LogBar']['note']);            
            if($isRequestPost){
                $liabilitie['LogBar']['statusPay']= $_POST['statusPay'];
                $modelLogBar->save($liabilitie);
                
                if($_POST['statusPay']=='da_thanh_toan'){
                    $modelRevenue->updateCoin($liabilitie['LogBar']['dataTable']['BarTable']['manager'],$liabilitie['LogBar']['dataTable']['BarTable']['hotel'],$liabilitie['LogBar']['pricePay']);
                
                    
                    
                    // Tao phieu thu hang hoa dich vu
                    $modelCollectionBill = new CollectionBill();
                    if($liabilitie['LogBar']['priceMerchandise']>0){
                        $save = array();
                        $save['CollectionBill']['time'] = $liabilitie['LogBar']['today'][0];
                        $save['CollectionBill']['coin'] = (int) $liabilitie['LogBar']['priceMerchandise'];
                        $save['CollectionBill']['nguoi_nop'] = $liabilitie['LogBar']['dataTable']['BarTable']['checkin']['cus_name'];
                        $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                        $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                        $save['CollectionBill']['note'] = 'Thanh toán tiền hàng hóa dịch vụ cho bàn bar ' . $liabilitie['LogBar']['dataTable']['BarTable']['name'];
                        $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
                        $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                        $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                        $save['CollectionBill']['hinhThucThu'] = $liabilitie['LogBar']['hinhThucThu'];
                        
                        $modelCollectionBill->create();
                        $modelCollectionBill->save($save);
                    }
                }
                
                $modelLogBar->redirect($urlHomes.'managerLiabilitieBar?redirect=managerEditLiabilitieBar');
            }
            
        } else {
            $modelUser->redirect($urlHomes);
        }
}
function managerRevenueBar()
    {
        global $modelOption;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $listData= array();
            $modelLogBar = new LogBar();
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0) $page = 1;
            $limit = 15;
            $conditions['statusPay'] = 'da_thanh_toan';
            
            $conditions['dataTable.BarTable.hotel'] = $_SESSION['idHotel'];
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['today.0']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['today.0']['$lte']= $dateEnd;
            }
            
            if(!empty($_GET['idStaff'])){
                $conditions['dataTable.BarTable.checkin.idStaff'] = $_GET['idStaff'];
            }
               
            
            $listData= $modelLogBar->getPage($page, $limit, $conditions );

            $totalData = $modelLogBar->find('count', array('conditions' => $conditions));

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
                $listDataAll= $modelLogBar->getPage(1, null, $conditions );
                
                if (!empty($listDataAll)) {
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCheckin = getdate($tin['LogBar']['dataTable']['BarTable']['checkin']['dateCheckin']);
                        $dateCheckout = $tin['LogBar']['today'];
                        
                        $data[]= array( $stt,
                                        $tin['LogBar']['dataTable']['BarTable']['name'],
                                        $tin['LogBar']['dataTable']['BarTable']['checkin']['cus_name'],
                                        $dateCheckin['hours'] . ':' . $dateCheckin['minutes'] . ' ' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'],
                                        $dateCheckout['hours'] . ':' . $dateCheckout['minutes'] . ' ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'],
                                        number_format($tin['LogBar']['pricePay']),
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