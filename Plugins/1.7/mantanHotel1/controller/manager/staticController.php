<?php
    function managerLiabilitie()
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
            $modelBook = new Book();
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0) $page = 1;
            $limit = 15;
            $conditions['statusPay'] = 'cong_no';
            $conditions['dataRoom.Room.hotel'] = $_SESSION['idHotel'];
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['today.0']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['today.0']['$lte']= $dateEnd;
            }
            
            $listData= $modelBook->getPage($page, $limit, $conditions );
            
            $totalData = $modelBook->find('count', array('conditions' => $conditions));

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
                $listDataAll= $modelBook->getPage(1, null, $conditions );
                if (!empty($listDataAll)) {
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCheckin = getdate($tin['Book']['dataRoom']['Room']['checkin']['dateCheckin']);
                        $dateCheckout = $tin['Book']['today'];
                        
                        $data[]= array( $stt,
                                        $tin['Book']['dataRoom']['Room']['checkin']['Custom']['cmnd'],
                                        $tin['Book']['dataRoom']['Room']['checkin']['Custom']['cus_name'],
                                        $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'] . ' - ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'],
                                        $tin['Book']['dataRoom']['Room']['name'],
                                        number_format($tin['Book']['pricePay']),
                                        $tin['Book']['dataRoom']['Room']['checkin']['Custom']['address'],
                                        $tin['Book']['dataRoom']['Room']['checkin']['Custom']['email'],
                                        $tin['Book']['dataRoom']['Room']['checkin']['Custom']['phone'],
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
  
    function managerEditLiabilitie() {
        global $isRequestPost;
        global $urlHomes;
        global $urlPlugins;
        global $modelUser;
        global $isRequestPost;
        if (checkLoginManager()) {
            $modelBook = new Book();
            $modelRevenue = new Revenue();
            
            $liabilitie= $modelBook->getBook($_GET['id']);
            
            if(!$liabilitie){
                $modelBook->redirect($urlHomes);
            }
    
            setVariable('dataRoom', $liabilitie['Book']['dataRoom']);
            setVariable('typeRoom', $liabilitie['Book']['typeRoom']);
            setVariable('today', $liabilitie['Book']['today']);
            setVariable('textUse', $liabilitie['Book']['textUse']);
            setVariable('type_register', $liabilitie['Book']['type_register']);
            setVariable('priceRoom', $liabilitie['Book']['priceRoom']);
            setVariable('priceMerchandise', $liabilitie['Book']['priceMerchandise']);
            setVariable('pricePay', $liabilitie['Book']['pricePay']);
            setVariable('giam_tru', $liabilitie['Book']['giam_tru']);
            setVariable('prepay', $liabilitie['Book']['prepay']);
            setVariable('statusPaySelect', $liabilitie['Book']['statusPay']);
            setVariable('note', $liabilitie['Book']['note']);
            setVariable('pricePeople', $liabilitie['Book']['pricePeople']);
            
            if($isRequestPost){
                $liabilitie['Book']['statusPay']= $_POST['statusPay'];
                $modelBook->save($liabilitie);
                
                if($_POST['statusPay']=='da_thanh_toan'){
                    $modelRevenue->updateCoin($liabilitie['Book']['dataRoom']['Room']['manager'],$liabilitie['Book']['dataRoom']['Room']['hotel'],$liabilitie['Book']['pricePay']);
                
                    // Tao phieu thu tien phong
                    if($liabilitie['Book']['priceRoom']>0){
                        $save = array();
                        $save['CollectionBill']['time'] = $liabilitie['Book']['today'][0];
                        $save['CollectionBill']['coin'] = (int) $liabilitie['Book']['priceRoom'];
                        $save['CollectionBill']['nguoi_nop'] = $liabilitie['Book']['dataRoom']['Room']['checkin']['Custom']['cus_name'];
                        $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                        $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                        $save['CollectionBill']['note'] = 'Thanh toán tiền phòng ' . $liabilitie['Book']['dataRoom']['Room']['name'];
                        $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
                        $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                        $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                        $save['CollectionBill']['hinhThucThu'] = $liabilitie['Book']['hinhThucThu'];
                        
                        $modelCollectionBill->create();
                        $modelCollectionBill->save($save);
                    }
                    
                    // Tao phieu thu hang hoa dich vu
                    if($liabilitie['Book']['priceMerchandise']>0){
                        $save = array();
                        $save['CollectionBill']['time'] = $liabilitie['Book']['today'][0];
                        $save['CollectionBill']['coin'] = (int) $liabilitie['Book']['priceMerchandise'];
                        $save['CollectionBill']['nguoi_nop'] = $liabilitie['Book']['dataRoom']['Room']['checkin']['Custom']['cus_name'];
                        $save['CollectionBill']['typeCollectionBill'] = 'tien_mat';
                        $save['CollectionBill']['nguoi_nhan'] = $_SESSION['infoManager']['Manager']['fullname'];
                        $save['CollectionBill']['note'] = 'Thanh toán tiền hàng hóa dịch vụ cho phòng ' . $liabilitie['Book']['dataRoom']['Room']['name'];
                        $save['CollectionBill']['idHotel'] = $_SESSION['idHotel'];
                        $save['CollectionBill']['idStaff'] = $_SESSION['infoManager']['Manager']['idStaff'];
                        $save['CollectionBill']['idManager'] = $_SESSION['infoManager']['Manager']['id'];
                        $save['CollectionBill']['hinhThucThu'] = $liabilitie['Book']['hinhThucThu'];
                        
                        $modelCollectionBill->create();
                        $modelCollectionBill->save($save);
                    }
                }
                
                $modelBook->redirect($urlHomes.'managerLiabilitie?redirect=managerEditLiabilitie');
            }
            
        } else {
            $modelUser->redirect($urlHomes);
        }
    }
    
    function managerRevenueMerchandise($input)
    {
        global $modelOption;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $mess= '';
            $modelMerchandiseStatic = new MerchandiseStatic();
            
            $modelStaff = new Staff();
            $conditionsStaff['idHotel'] = $_SESSION['idHotel'];
            $listStaff = $modelStaff->getPage(1, null, $conditionsStaff);
            
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0)
                $page = 1;
            $limit = 15;
            $conditions = array();
            if(!empty($_SESSION['idHotel'])){
                $conditions['idHotel']= $_SESSION['idHotel'];
            }
            
            if(!empty($_GET['idNhomHangHoa'])){
                $conditions['idMerchandiseGroup']= $_GET['idNhomHangHoa'];
            }
            
            if(!empty($_GET['code'])){
                $conditions['code']= $_GET['code'];
            }
            
            if(!empty($_GET['idStaff'])){
                $conditions['idStaff']= $_GET['idStaff'];
            }
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['time.0']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['time.0']['$lte']= $dateEnd;
            }
            
            $listData = $modelMerchandiseStatic->getPage($page, $limit,$conditions);
            
            $conditionsGroup= array();
            $conditionsGroup['idHotel']= $_SESSION['idHotel'];
            $modelMerchandiseGroup = new MerchandiseGroup();
            $listMerchandiseGroup = $modelMerchandiseGroup->getPage(1, null,$conditionsGroup);
    
            $totalData = $modelMerchandiseStatic->find('count', array('conditions' => $conditions));
    
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
            setVariable('mess', $mess);
            setVariable('listMerchandiseGroup', $listMerchandiseGroup);
            setVariable('listStaff', $listStaff);
    
            setVariable('page', $page);
            setVariable('totalPage', $totalPage);
            setVariable('back', $back);
            setVariable('next', $next);
            setVariable('urlPage', $urlPage);
            
            if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
                $table = array(
                    array('label' => __('STT'), 'width' => 5),
                    array('label' => __('Ngày bán'), 'width' => 15),
                    array('label' => __('Tên HH - DV'),'width' => 30, 'filter' => true, 'wrap' => true),
                    array('label' => __('Mã HH - DV'), 'width' => 30, 'filter' => true, 'wrap' => true),
                    array('label' => __('Nhóm HH - DV'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Số lượng'), 'width' => 10, 'filter' => true),
                    array('label' => __('Giá bán'), 'width' => 10, 'filter' => true),
                );
                
                $data= array();
                $listDataAll= $modelMerchandiseStatic->getPage(1, null,$conditions);
                if (!empty($listDataAll)) {
                    $listNameGroup= array();
                    foreach ($listMerchandiseGroup as $data) {
                        $listNameGroup[$data['MerchandiseGroup']['id']]= $data['MerchandiseGroup']['name'];
                    }
                    
                    $data= array();    
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCreate= $tin['MerchandiseStatic']['time'];
                        $data[]= array( $stt,
                                        $dateCreate['hours'] . ':' . $dateCreate['minutes'] . ' ' . $dateCreate['mday'] . '/' . $dateCreate['mon'] . '/' . $dateCreate['year'],
                                        $tin['MerchandiseStatic']['name'],
                                        $tin['MerchandiseStatic']['code'],
                                        $listNameGroup[$tin['MerchandiseStatic']['idMerchandiseGroup']],
                                        $tin['MerchandiseStatic']['number'],
                                        number_format($tin['MerchandiseStatic']['price']),
                                        );
                    }
                    
                }
                //debug($data);
                $exportsController = new ExportsController;
                $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
            }
        } else {
            $modelOption->redirect($urlHomes);
        }
    }
    
    function managerRevenue()
    {
        global $modelOption;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $listData= array();
            $modelBook = new Book();
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0) $page = 1;
            $limit = 15;
            $conditions['statusPay'] = 'da_thanh_toan';
            
            $conditions['dataRoom.Room.hotel'] = $_SESSION['idHotel'];
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['today.0']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['today.0']['$lte']= $dateEnd;
            }
            
            if(!empty($_GET['idStaff'])){
                $conditions['dataRoom.Room.checkin.idStaff'] = $_GET['idStaff'];
            }
            if(!empty($_GET['cmnd'])){
                $conditions['dataRoom.Room.checkin.Custom.cmnd'] = $_GET['cmnd'];
            }
               
            
            $listData= $modelBook->getPage($page, $limit, $conditions );

            $totalData = $modelBook->find('count', array('conditions' => $conditions));

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
                    array('label' => __('Phòng'),'width' => 17, 'filter' => true, 'wrap' => true),
                    array('label' => __('Tên khách hàng'), 'width' => 15, 'filter' => true, 'wrap' => true),
                    array('label' => __('Thời gian checkin'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Thời gian checkout'), 'width' => 15, 'filter' => true),
                    array('label' => __('Tổng tiền'), 'width' => 20, 'filter' => true),
                    array('label' => __('Tiền phòng'), 'width' => 20,  'wrap' => true),
                    array('label' => __('Tiền hàng hóa'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Tiền phụ trội'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Tiền giảm trừ'),'width' => 20, 'filter' => true, 'wrap' => true)
                );
                
                $data= array();
                $listDataAll= $modelBook->getPage(1, null, $conditions );
                
                if (!empty($listDataAll)) {
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCheckin = getdate($tin['Book']['dataRoom']['Room']['checkin']['dateCheckin']);
                        $dateCheckout = $tin['Book']['today'];
                        
                        $data[]= array( $stt,
                                        $tin['Book']['dataRoom']['Room']['name'],
                                        $tin['Book']['dataRoom']['Room']['checkin']['Custom']['cus_name'],
                                        $dateCheckin['hours'] . ':' . $dateCheckin['minutes'] . ' ' . $dateCheckin['mday'] . '/' . $dateCheckin['mon'] . '/' . $dateCheckin['year'],
                                        $dateCheckout['hours'] . ':' . $dateCheckout['minutes'] . ' ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'],
                                        number_format($tin['Book']['pricePay']),
                                        number_format($tin['Book']['priceRoom']),
                                        number_format($tin['Book']['priceMerchandise']),
                                        number_format($tin['Book']['prepay']),
                                        number_format($tin['Book']['giam_tru'])
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
   
 
    function managerListDebtbill()
    {
        global $modelOption;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $modelCustom= new Custom();
            $modelBook= new Book();
            $dataCustom=$modelCustom->getCustom($_GET['id']);
            $conditions['dataRoom.Room.checkin.Custom.id']=$dataCustom['Custom']['id'];
            $listData=$modelBook->getPage(1, null, $conditions);
            //debug ($listData);
            setVariable('listData', $listData);
            setVariable('dataCustom', $dataCustom);
        } else {
            $modelOption->redirect($urlHomes);
        }
    }
    
    function managerLiabilitieBill()
    {
        global $modelOption;
        global $isRequestPost;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $today= getdate();
            $modelBill = new Bill();
            
            $mess= '';
            
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0) $page = 1;
            $limit = 15;
            $conditions['idHotel'] = $_SESSION['idHotel'];
            $conditions['typeBill'] = 'cong_no';
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['time']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['time']['$lte']= $dateEnd;
            }
            
            $listData= $modelBill->getPage($page, $limit, $conditions );
            
            $totalData = $modelBill->find('count', array('conditions' => $conditions));

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
            
            if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
                $table = array(
                    array('label' => __('STT'), 'width' => 5),
                    array('label' => __('Ngày tạo'),'width' => 17, 'filter' => true, 'wrap' => true),
                    array('label' => __('Số tiền'), 'width' => 15, 'filter' => true, 'wrap' => true),
                    array('label' => __('Người nhận'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Hình thức chi'), 'width' => 15, 'filter' => true),
                    array('label' => __('Người chi'), 'width' => 20, 'filter' => true),
                    array('label' => __('Ghi chú'), 'width' => 45,  'wrap' => true)
                );
                
                $data= array();
                $listDataAll= $modelBill->getPage(1, null, $conditions);
                if (!empty($listDataAll)) {
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCreate = getdate($tin['Bill']['time']);
                        
                        $data[]= array( $stt,
                                        $dateCreate['hours'] . ':' . $dateCreate['minutes'] . ' ' . $dateCreate['mday'] . '/' . $dateCreate['mon'] . '/' . $dateCreate['year'],
                                        number_format($tin['Bill']['coin']),
                                        $tin['Bill']['nguoi_nhan'],
                                        $typeBill[$tin['Bill']['typeBill']],
                                        $tin['Bill']['nguoi_chi'],
                                        $tin['Bill']['note']
                                        );
                    }
                    
                }
                
                $exportsController = new ExportsController;
                $exportsController->requestAction('/exports/excel', array('pass' => array($table,$data)));
            }
            
        }else {
            $modelOption->redirect($urlHomes);
        }
    }

    function managerRevenueAgency($input)
    {
        global $modelOption;
        global $urlHomes;
        global $urlNow;
    
        if (checkLoginManager()) {
            $listData= array();
            $modelAgency = new Agency();
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            if ($page <= 0) $page = 1;
            $limit = 15;
            
            $conditions['idHotel'] = $_SESSION['idHotel'];
            
            if (!empty($_GET['dateStart'])){
                $dateStart = strtotime(str_replace("/", "-", $_GET['dateStart']) . ' 0:0:0');
                $conditions['timeCheckout.0']['$gte']= $dateStart;
            }
            
            if(!empty($_GET['dateEnd'])){
                $dateEnd = strtotime(str_replace("/", "-", $_GET['dateEnd']) . ' 23:59:59');
                $conditions['timeCheckout.0']['$lte']= $dateEnd;
            }
            
            if(!empty($_GET['emailAgency'])){
                $conditions['emailAgency'] = $_GET['emailAgency'];
            }
               
            
            $listData= $modelAgency->getPage($page, $limit, $conditions );

            $totalData = $modelAgency->find('count', array('conditions' => $conditions));

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
            
            
            if(isset($_GET['action']) && $_GET['action']=='Xuất Excel'){
                $table = array(
                    array('label' => __('STT'), 'width' => 5),
                    array('label' => __('Phòng'),'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Tên khách hàng'), 'width' => 20, 'filter' => true, 'wrap' => true),
                    array('label' => __('Đại lý'),'width' => 30, 'filter' => true, 'wrap' => true),
                    array('label' => __('Thời gian checkout'), 'width' => 15, 'filter' => true),
                    array('label' => __('Tổng tiền'), 'width' => 20, 'filter' => true),
                );
                
                $data= array();
                $listDataAll= $modelAgency->getPage(1, null, $conditions );
                
                if (!empty($listDataAll)) {
                    foreach ($listDataAll as $key => $tin) {
                        $stt= $key+1;
                        $dateCheckout = $tin['Agency']['timeCheckout'];
                        
                        $data[]= array( $stt,
                                        $tin['Agency']['nameRoom'],
                                        $tin['Agency']['nameCustom'],
                                        $tin['Agency']['emailAgency'],
                                        $dateCheckout['hours'] . ':' . $dateCheckout['minutes'] . ' ' . $dateCheckout['mday'] . '/' . $dateCheckout['mon'] . '/' . $dateCheckout['year'],
                                        number_format($tin['Book']['pricePay'])
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